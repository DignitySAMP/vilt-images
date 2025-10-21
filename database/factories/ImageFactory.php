<?php

namespace Database\Factories;

use App\Models\Album;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Image>
 */
class ImageFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [

            'album_id' => Album::inRandomOrder()->first()?->id,
            'publisher_id' => User::inRandomOrder()->first()?->id,
            'description' => fake()->word(),
            'file_name' => fake()->word() . fake()->fileExtension(),
            'path' => fake()->word()
        ];
    }
}
