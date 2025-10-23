<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\User;
use App\Models\Image;
use App\Models\Album;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_have_images(): void
    {
        $user = User::factory()->create();
        $images = Image::factory()->count(3)->create(['publisher_id' => $user->id]);

        $this->assertCount(3, $user->images);
        $this->assertTrue($user->images->contains($images->first()));
    }

    public function test_user_can_have_albums(): void
    {
        $user = User::factory()->create();
        $albums = Album::factory()->count(2)->create(['user_id' => $user->id]);

        $this->assertCount(2, $user->albums);
        $this->assertTrue($user->albums->contains($albums->first()));
    }

    public function test_user_password_is_hashed(): void
    {
        $user = User::factory()->create(['password' => 'password123']);

        $this->assertNotEquals('password123', $user->password);
        $this->assertTrue(password_verify('password123', $user->password));
    }

    public function test_user_has_fillable_attributes(): void
    {
        $user = User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        $this->assertEquals('Test User', $user->name);
        $this->assertEquals('test@example.com', $user->email);
    }
}

