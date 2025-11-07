<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

use Inertia\Inertia;
use Inertia\Response as InertiaResponse;

use Illuminate\Pagination\LengthAwarePaginator;
use Spatie\LaravelImageOptimizer\Facades\ImageOptimizer;
use Intervention\Image\ImageManager;

use App\Models\Image;
use App\Models\Album;

class ImageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): InertiaResponse
    {
        $query = Image::with('publisher')->visible();

        $this->applySearchFilters($query, $request);

        $images = $this->applySortFilters($query, $request, 10);

        return Inertia::render('Image/Index/View', [
            'images' => $images,
            'filters' => [
                'search' => $request->search,
                'search_type' => $request->search_type,
                'sort' => $request->sort,
            ],
        ]);
    }
    
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Image/Create/View', [
            'albums' => Auth::user()?->albums ?? []
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */

    public function store(Request $request)
    {
        $validated = $request->validate([
            'uploads' => 'required|array',
            'uploads.*.file' => 'required|file|image|max:5120',
            'uploads.*.name' => 'required|string|max:255',
            'uploads.*.description' => 'required|string|max:255',
            'uploads.*.is_hidden' => 'required|boolean',
            'uploads.*.album_id' => 'nullable|exists:albums,id',
        ], [
            'uploads.*.file.required' => 'Please select an image file.',
            'uploads.*.file.image' => 'The file must be an image.',
            'uploads.*.file.max' => 'The image must not exceed 5MB.',
            'uploads.*.name.required' => 'Image name is required.',
            'uploads.*.name.max' => 'Image name must not exceed 255 characters.',
            'uploads.*.description.required' => 'Image description is required.',
            'uploads.*.description.max' => 'Image description must not exceed 255 characters.',
            'uploads.*.album_id.exists' => 'The selected album does not exist.',
        ]);

        $user_id = Auth::id();

        foreach ($validated['uploads'] as $index => $upload) {
            if (!empty($upload['album_id'])) {
                $album = Album::findOrFail($upload['album_id']);
                
                if ($album->user_id !== $user_id) {
                    return back()->withErrors([
                        "uploads.{$index}.album_id" => 'You can only upload to albums you own.'
                    ]);
                }
            }
        }
        $dateOfToday = now()->format('Y-m-d');

        // ensure that the folder structure exists (uploads/{user_id}/{date_of_today}/thumbnails/)
        $storagePath = "uploads/{$user_id}/{$dateOfToday}";
        if (!Storage::disk('public')->exists("{$storagePath}/thumbnails")) {
            Storage::disk('public')->makeDirectory("{$storagePath}/thumbnails");
        }
    
        foreach ($validated['uploads'] as $index => $upload) {
            $file = $request->file("uploads.{$index}.file");
            
            $fileName = Str::uuid() . '.' . $file->getClientOriginalExtension();
    
            // store the image and relative path
            Storage::disk('public')->putFileAs($storagePath, $file, $fileName); 
            $rawImagePath = Storage::disk('public')->path("{$storagePath}/{$fileName}"); // fetch relative path
    
            // optimize raw image using spatie's img optimizer
            ImageOptimizer::optimize($rawImagePath);

            // run Intervention and create a thumbnail for the image
            $image = ImageManager::gd()->read($rawImagePath);
            $image->cover(300, 300);  // https://image.intervention.io/v3/modifying-images/resizing#fitted-image-resizing
            $image->save(Storage::disk('public')->path("{$storagePath}/thumbnails/{$fileName}"));

            Image::create([
                'album_id' => $upload['album_id'],
                'publisher_id' => $user_id,
                'name' => $upload['name'],
                'description' => $upload['description'],
                'is_hidden' => $upload['is_hidden'],
                'file_name' => $fileName,
                'path' => $storagePath
            ]);
        }
    
        return redirect()->route('profile');
    }
    /**
     * Display the specified resource.
     */
    public function show(Image $image): InertiaResponse
    {
        $response = Gate::inspect('show', $image);

        if (! $response->allowed()) {
            abort(403, 'This image, or the album it belongs to, is private.');
        }
        
        return Inertia::render('Image/Show/View', [
            'image' => $image->load('publisher', 'album'),
            'related_images' => $image->similar()
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Image $image): InertiaResponse
    {
        $this->authorize('update', $image);

        return Inertia::render('Image/Edit/View', [
            'image' => $image,
            'albums' => Auth::user()->albums
        ]);
    }

    public function update(Request $request, Image $image): RedirectResponse
    {
        $this->authorize('update', $image);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string|max:255',
            'album_id' => 'nullable|exists:albums,id',
            'is_hidden' => 'nullable|boolean'
        ], [
            'name.required' => 'Image name is required.',
            'name.max' => 'Image name must not exceed 255 characters.',
            'description.required' => 'Image description is required.',
            'description.max' => 'Image description must not exceed 255 characters.',
            'album_id.exists' => 'The selected album does not exist.',
        ]);

        if (!empty($validated['album_id'])) {
            $album = Album::findOrFail($validated['album_id']);
            
            if ($album->user_id !== Auth::id()) {
                return back()->withErrors([
                    'album_id' => 'You can only move images to albums you own.'
                ]);
            }
        }

        $image->update([
            'name' => $validated['name'],
            'description' => $validated['description'],
            'album_id' => $validated['album_id'],
            'is_hidden' => $validated['is_hidden']
        ]);

        return redirect()->route('image.show', $image)->with('success', 'Image updated successfully.');
    }

    public function destroy(Request $request, Image $image): RedirectResponse
    {
        $this->authorize('delete', $image);
       
        $request->validate([
            'confirm_name' => 'required|string|max:255|in:' . $image->name,
        ]);
        
        Storage::disk('public')->delete("{$image->path}/{$image->file_name}");
        Storage::disk('public')->delete("{$image->path}/thumbnails/{$image->file_name}");

        $image->delete();

        return redirect()->route('profile');
    }

    private function applySearchFilters(Builder $query, Request $request): void
    {
        if (! $request->filled('search')) {
            return;
        }

        $searchTerm = $request->string('search')->value();
        $searchType = $request->input('search_type', 'name');

        switch ($searchType) {
            case 'author':
                $query->whereHas('publisher', function (Builder $builder) use ($searchTerm) {
                    $builder->where('name', 'like', "%{$searchTerm}%");
                });
                break;
            case 'name':
                $query->where('name', 'like', "%{$searchTerm}%");
                break;
            case 'description':
                $query->where('description', 'like', "%{$searchTerm}%");
                break;
        }
    }

    private function applySortFilters(Builder $query, Request $request, int $perPage): LengthAwarePaginator
    {
        $sortBy = $request->input('sort', 'latest');

        if (in_array($sortBy, ['largest', 'smallest'])) {
            $allImages = $query->get();

            $sortedImages = $sortBy === 'largest'
                ? $allImages->sortByDesc(fn ($image) => $image->file_size)->values()
                : $allImages->sortBy(fn ($image) => $image->file_size)->values();

            return new LengthAwarePaginator(
                $sortedImages->forPage($request->input('page', 1), $perPage),
                $sortedImages->count(),
                $perPage,
                $request->input('page', 1),
                ['path' => $request->url(), 'query' => $request->query()]
            );
        }

        match ($sortBy) {
            'latest' => $query->orderBy('created_at', 'desc'),
            'oldest' => $query->orderBy('created_at', 'asc'),
            default => $query->orderBy('created_at', 'desc'),
        };

        return $query->paginate($perPage)->withQueryString();
    }
}
