<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Image;
use App\Models\Album;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => Hash::make('test@example.com')
        ]);

        Album::factory(3)->create();
        Image::factory(15)->create();
    }
}
