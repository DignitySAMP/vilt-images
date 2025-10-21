<?php

namespace App\Http\Controllers;

use App\Models\Image;
use Illuminate\Http\Request;

use Inertia\Inertia;
use Inertia\Response as InertiaResponse;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

use Spatie\LaravelImageOptimizer\Facades\ImageOptimizer;

use Intervention\Image\ImageManager;

class ImageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): InertiaResponse
    {
        return Inertia::render('Image/Index/View', [
            'images' => Image::with('publisher')->paginate(10)
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Image/Create/View');
    }

    /**
     * Store a newly created resource in storage.
     */

    public function store(Request $request)
    {
        $request->validate([
            'files' => 'required|array',
            'files.*' => 'file|image|max:5120',
        ]);
    
        $user_id = Auth::id();
        $dateOfToday = now()->format('Y-m-d');
    
        // ensure that the folder structure exists (uploads/{user_id}/{date_of_today}/thumbnails/)
        $storagePath = "uploads/{$user_id}/{$dateOfToday}";
        if (!Storage::disk('public')->exists("{$storagePath}/thumbnails")) {
            Storage::disk('public')->makeDirectory("{$storagePath}/thumbnails");
        }
    
        foreach ($request->file('files') as $file) {
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
                'publisher_id' => $user_id,
                'description' => pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME),
                'file_name' => $fileName,
                'path' => $storagePath
            ]);
        }
    
        return redirect()->back()->with('success', 'Images uploaded and processed.');
    }
    /**
     * Display the specified resource.
     */
    public function show(Image $image): InertiaResponse
    {
        return Inertia::render('Image/Show/View', [
            'image' => $image->load('publisher', 'album'),
            'related_images' => $image->similar()
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Image $image)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Image $image)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Image $image)
    {
        //
    }
}
