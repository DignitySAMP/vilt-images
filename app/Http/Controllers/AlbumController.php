<?php

namespace App\Http\Controllers;

use App\Models\Album;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;

use Inertia\Inertia;
use Inertia\Response as InertiaResponse;

use Illuminate\Support\Facades\Auth;

class AlbumController extends Controller
{
    public function index(): InertiaResponse
    {
        return Inertia::render('Album/Index/View', [
            'albums' => Album::with(['user', 'images' => function ($query) {
                $query->limit(1);
            }])->withCount('images')->paginate(10)
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
        ]);

        Album::create([
            'user_id' => Auth::id(),
            'name' => $request->name,
            'description' => $request->description,
        ]);

        return redirect()->route('album.index');
    }

    public function show(Album $album): InertiaResponse
    {
        return Inertia::render('Album/Show/View', [
            'album' => $album->load('user'),
            'images' => $album->images()->with('publisher')->paginate(10)
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
        ]);

        $album->update([
            'name' => $request->name,
            'description' => $request->description,
        ]);

        return redirect()->route('album.show', $album);
    }

    public function destroy(Album $album): RedirectResponse
    {
        $this->authorize('delete', $album);

        dd($album);
    }
}
