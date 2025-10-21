<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Image;
use App\Models\Album;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $users = [
            User::factory()->create([
                'name' => 'Jonathan Doe',
                'email' => 'test@example.com',
                'password' => Hash::make('test@example.com')
            ]),
            User::factory()->create([
                'name' => 'Bob Smith',
                'email' => 'bob@example.com',
                'password' => Hash::make('password')
            ]),
            User::factory()->create([
                'name' => 'Charlie Davis',
                'email' => 'charlie@example.com',
                'password' => Hash::make('password')
            ])
        ];

        $albums = [
            Album::create(['user_id' => $users[0]->id, 'name' => 'Nature Photography', 'description' => 'Beautiful landscapes and wildlife']),
            Album::create(['user_id' => $users[0]->id, 'name' => 'Urban Exploration', 'description' => 'City streets and architecture']),
            Album::create(['user_id' => $users[1]->id, 'name' => 'Food & Drinks', 'description' => 'Culinary adventures and beverages']),
            Album::create(['user_id' => $users[1]->id, 'name' => 'Travel Memories', 'description' => 'Adventures around the world']),
            Album::create(['user_id' => $users[2]->id, 'name' => 'Abstract Art', 'description' => 'Colorful abstract compositions']),
        ];

        $imageData = [
            ['name' => 'Mountain Sunset', 'width' => 800, 'height' => 600, 'bg' => 'FF6B6B', 'text' => 'FFF'],
            ['name' => 'Ocean Waves', 'width' => 1200, 'height' => 800, 'bg' => '4ECDC4', 'text' => 'FFF'],
            ['name' => 'Forest Path', 'width' => 900, 'height' => 700, 'bg' => '95E1D3', 'text' => '2D3436'],
            ['name' => 'City Skyline', 'width' => 1000, 'height' => 600, 'bg' => '2D3436', 'text' => 'FFF'],
            ['name' => 'Street Art', 'width' => 700, 'height' => 900, 'bg' => 'F38181', 'text' => 'FFF'],
            ['name' => 'Coffee Cup', 'width' => 600, 'height' => 800, 'bg' => '6C5B7B', 'text' => 'FFF'],
            ['name' => 'Fresh Pasta', 'width' => 1100, 'height' => 700, 'bg' => 'FFA07A', 'text' => '2D3436'],
            ['name' => 'Beach Sunset', 'width' => 1300, 'height' => 900, 'bg' => 'FA8072', 'text' => 'FFF'],
            ['name' => 'Mountain Lake', 'width' => 950, 'height' => 650, 'bg' => '87CEEB', 'text' => '2D3436'],
            ['name' => 'Desert Dunes', 'width' => 850, 'height' => 550, 'bg' => 'DEB887', 'text' => '8B4513'],
            ['name' => 'Purple Dreams', 'width' => 700, 'height' => 700, 'bg' => '9B59B6', 'text' => 'FFF'],
            ['name' => 'Golden Hour', 'width' => 1000, 'height' => 800, 'bg' => 'FFD700', 'text' => '2D3436'],
        ];

        foreach ($imageData as $index => $data) {
            $userId = $users[$index % 3]->id;
            $albumId = $albums[$index % 5]->id;
            
            $dateOfToday = now()->subDays(rand(0, 30))->format('Y-m-d');
            $storagePath = "uploads/{$userId}/{$dateOfToday}";
            
            if (!Storage::disk('public')->exists("{$storagePath}/thumbnails")) {
                Storage::disk('public')->makeDirectory("{$storagePath}/thumbnails");
            }

            $fileName = Str::uuid() . '.png';
            
            $imageUrl = "https://placehold.co/{$data['width']}x{$data['height']}/{$data['bg']}/{$data['text']}/png";
            $thumbnailUrl = "https://placehold.co/300x300/{$data['bg']}/{$data['text']}/png";
            
            $imageContent = Http::get($imageUrl)->body();
            $thumbnailContent = Http::get($thumbnailUrl)->body();
            
            Storage::disk('public')->put("{$storagePath}/{$fileName}", $imageContent);
            Storage::disk('public')->put("{$storagePath}/thumbnails/{$fileName}", $thumbnailContent);

            Image::create([
                'album_id' => $albumId,
                'publisher_id' => $userId,
                'description' => $data['name'],
                'file_name' => $fileName,
                'path' => $storagePath
            ]);
        }
    }
}
