<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

use Inertia\Inertia;
use Inertia\Response as InertiaResponse;

use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Validation\Rule;

class ProfileController extends Controller
{
    public function index(Request $request): InertiaResponse
    {
        $query = Auth::user()->images()->with('album');

        $this->applySearchFilters($query, $request);

        $images = $this->applySortFilters($query, $request, 8);

        return Inertia::render('Auth/Profile/View', [
            'images' => $images,
            'filters' => [
                'search' => $request->search,
                'search_type' => $request->search_type,
                'sort' => $request->sort,
            ],
        ]);
    }

    private function applySearchFilters(Builder|Relation $query, Request $request): void
    {
        if (! $request->filled('search')) {
            return;
        }

        $searchTerm = $request->string('search')->value();
        $searchType = $request->input('search_type', 'name');

        switch ($searchType) {
            case 'album':
                $query->whereHas('album', function (Builder $builder) use ($searchTerm) {
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

    private function applySortFilters(Builder|Relation $query, Request $request, int $perPage): LengthAwarePaginator
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

    public function update(Request $request): RedirectResponse
    {
        $user = Auth::user();

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('users')->ignore($user->id)
            ],
            'new_password' => 'nullable|string|min:8|confirmed:confirm_new_password',
            'confirm_new_password' => 'nullable|string',
            'current_password' => 'required_with:new_password|current_password',
        ]);

        $user->name = $validated['name'];
        $user->email = $validated['email'];

        if (!empty($validated['new_password'])) {
            $user->password = bcrypt($validated['new_password']);
        }

        $user->save();

        return redirect()->route('profile')->with('success', 'Profile updated successfully.');
    }

    public function destroy(Request $request): RedirectResponse
    {
        $user = Auth::user();

        $request->validate([
            'confirm_email' => 'required|email|in:' . $user->email,
        ]);

        // delete albums and images
        $user->albums()->delete();
        $user->images()->delete();

        // purge entire user folder from storage
        Storage::disk('public')->deleteDirectory("uploads/{$user->id}");

        // destroy session and delete user
        Auth::logout();
        $user->delete();

        return redirect()->route('home');
    }
}
