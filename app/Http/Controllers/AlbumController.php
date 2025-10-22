<?php

namespace App\Http\Controllers;

use App\Models\Album;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Gate;

use Inertia\Inertia;
use Inertia\Response as InertiaResponse;

use Illuminate\Support\Facades\Auth;

class AlbumController extends Controller
{
    public function index(): InertiaResponse
    {
        return Inertia::render('Album/Index/View', [
            'albums' => Album::with([ 'user',  'images' => function ($query) {
                $query->visible()->limit(1);
            }])->visible()->withCount('images')->paginate(10),
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

    public function destroy(Album $album): RedirectResponse
    {
        $this->authorize('delete', $album);

        dd($album);
    }
}
