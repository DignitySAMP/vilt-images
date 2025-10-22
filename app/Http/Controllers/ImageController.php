<?php

namespace App\Http\Controllers;

use App\Models\Image;
use App\Models\Album;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

use Inertia\Inertia;
use Inertia\Response as InertiaResponse;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

use Spatie\LaravelImageOptimizer\Facades\ImageOptimizer;

use Intervention\Image\ImageManager;
use Illuminate\Pagination\LengthAwarePaginator;

class ImageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): InertiaResponse
    {
        $query = Image::with('publisher')->visible();

        // input-based filtering
        if ($request->filled('search')) {
            $searchTerm = $request->search;
            $searchType = $request->input('search_type', 'name');

            switch ($searchType) {
                case 'author': {
                    $query->whereHas('publisher', function ($q) use ($searchTerm) {
                        $q->where('name', 'like', "%{$searchTerm}%");
                    });
                    break;
                }
                case 'name': $query->where('name', 'like', "%{$searchTerm}%"); break;
                case 'description': $query->where('description', 'like', "%{$searchTerm}%"); break;  
            }
        }

        // sorting dropdown filtering
        $sortBy = $request->input('sort', 'latest');
        
        // because file_size is am accessor, we can't query it into the database. 
        // this will load all results into memory but for the scale of this application, it is acceptable
        if (in_array($sortBy, ['largest', 'smallest'])) {
            $allImages = $query->get();

            if($sortBy === 'largest') {
                $sortedImages = $allImages->sortByDesc(fn($image) => $image->file_size)->values();
            }
            else $sortedImages = $allImages->sortBy(fn($image) => $image->file_size)->values();
            
            $images = new LengthAwarePaginator(
                $sortedImages->forPage($request->input('page', 1), 10),
                $sortedImages->count(),
                10,
                $request->input('page', 1),
                ['path' => $request->url(), 'query' => $request->query()]
            );
        } 
        else {
            switch ($sortBy) {
                case 'latest': $query->orderBy('created_at', 'desc'); break;
                case 'oldest': $query->orderBy('created_at', 'asc'); break;
                default: $query->orderBy('created_at', 'desc');
            }
            $images = $query->paginate(10)->withQueryString();
        }

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

    public function update(Request $request, Image $image)
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

    public function destroy(Request $request, Image $image)
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
}
