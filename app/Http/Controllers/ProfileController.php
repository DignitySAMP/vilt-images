<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Inertia\Inertia;
use Inertia\Response as InertiaResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Pagination\LengthAwarePaginator;

class ProfileController extends Controller
{
    public function index(Request $request): InertiaResponse
    {
        $user = Auth::user();
        
        $query = $user->images()->with('album');

        // input-based filtering
        if ($request->filled('search')) {
            $searchTerm = $request->search;
            $searchType = $request->input('search_type', 'name');

            switch ($searchType) {
                case 'album': {
                    $query->whereHas('album', function ($q) use ($searchTerm) {
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
                $sortedImages->forPage($request->input('page', 1), 8),
                $sortedImages->count(),
                8,
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

            $images = $query->paginate(8)->withQueryString();
        }

        return Inertia::render('Profile', [
            'images' => $images,
            'filters' => [
                'search' => $request->search,
                'search_type' => $request->search_type,
                'sort' => $request->sort,
            ],
        ]);
    }
