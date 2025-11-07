<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

use Inertia\Inertia;
use Inertia\Response as InertiaResponse;

use App\Models\Album;

class AlbumController extends Controller
{
    public function index(Request $request): mixed
    {
        $query = Album::with(['user', 'images' => function ($query) {
            $query->visible()->limit(1);
        }]);

        if ($request->boolean('owned_albums')) {
            if(!Auth::check()) {
                return redirect(route('login'));
            }
            $query->where('user_id', Auth::id());
        } 
        else $query->visible();

        $this->applySearchFilters($query, $request);

        return Inertia::render('Album/Index/View', [
            'albums' => $this->applySortFilters($query, $request, 10),
            'showOwnedAlbums' => $request->boolean('owned_albums'),
            'filters' => [
                'search' => $request->search,
                'search_type' => $request->search_type,
                'sort' => $request->sort,
            ],
        ]);
    }

    public function create(): InertiaResponse
    {
        return Inertia::render('Album/Create/View');
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string|max:255',
            'is_hidden' => 'nullable|boolean',
        ], [
            'name.required' => 'Album name is required.',
            'name.max' => 'Album name must not exceed 255 characters.',
            'description.required' => 'Album description is required.',
            'description.max' => 'Album description must not exceed 255 characters.',
        ]);

        Album::create([
            'user_id' => Auth::id(),
            'name' => $request->name,
            'description' => $request->description,
            'is_hidden' => $request->is_hidden ?? false,
        ]);

        return redirect()->route('album.index');
    }

    public function show(Album $album): InertiaResponse
    {
        $response = Gate::inspect('show', $album);

        if (! $response->allowed()) {
            abort(403, 'This album is private.');
        }

        $user = auth()->user();
    
        $images = $album->images()
            ->with('publisher')
            ->where(function ($query) use ($user) {
                $query->where('is_hidden', 0); // only show visible images
    
                if ($user) { // if user is authenticated and owns the image, include it
                    $query->orWhere('publisher_id', $user->id);
                }
            });
    
        return Inertia::render('Album/Show/View', [
            'album' => $album->load('user'),
            'images' => $images->paginate(10),
        ]);
    }
    

    public function edit(Album $album): InertiaResponse
    {
        $this->authorize('update', $album);

        return Inertia::render('Album/Edit/View', [
            'album' => $album
        ]);
    }

    public function update(Request $request, Album $album): RedirectResponse
    {
        $this->authorize('update', $album);

        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string|max:255',
            'is_hidden' => 'nullable|boolean'
        ], [
            'name.required' => 'Album name is required.',
            'name.max' => 'Album name must not exceed 255 characters.',
            'description.required' => 'Album description is required.',
            'description.max' => 'Album description must not exceed 255 characters.',
        ]);

        $album->update([
            'name' => $request->name,
            'description' => $request->description,
            'is_hidden' => $request->is_hidden
        ]);

        return redirect()->route('album.show', $album);
    }

    public function destroy(Request $request, Album $album): RedirectResponse
    {
        $this->authorize('delete', $album);

        $request->validate([
            'confirm_name' => 'required|string|max:255|in:' . $album->name,
        ]);

        // delete all images in the album
        foreach ($album->images as $image) {
            Storage::disk('public')->delete("{$image->path}/{$image->file_name}");
            Storage::disk('public')->delete("{$image->path}/thumbnails/{$image->file_name}");
        }

        $album->images()->delete();
        $album->delete();

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
                $query->whereHas('user', function (Builder $builder) use ($searchTerm) {
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

    private function applySortFilters(Builder $query, Request $request, int $perPage): mixed
    {
        $sortBy = $request->input('sort', 'latest');

        match ($sortBy) {
            'latest' => $query->orderBy('created_at', 'desc'),
            'oldest' => $query->orderBy('created_at', 'asc'),
            'most_images' => $query->withCount('images')->orderBy('images_count', 'desc'),
            'fewest_images' => $query->withCount('images')->orderBy('images_count', 'asc'),
            default => $query->orderBy('created_at', 'desc'),
        };

        return $query->withCount('images')->paginate($perPage)->withQueryString();
    }
}
