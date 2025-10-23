<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Album;
use App\Models\User;
use App\Models\Image;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AlbumTest extends TestCase
{
    use RefreshDatabase;

    public function test_album_belongs_to_user(): void
    {
        $user = User::factory()->create();
        $album = Album::factory()->create(['user_id' => $user->id]);

        $this->assertInstanceOf(User::class, $album->user);
        $this->assertEquals($user->id, $album->user->id);
    }

    public function test_album_has_many_images(): void
    {
        $album = Album::factory()->create();
        $images = Image::factory()->count(5)->create(['album_id' => $album->id]);

        $this->assertCount(5, $album->images);
        $this->assertTrue($album->images->contains($images->first()));
    }

    public function test_visible_scope_only_shows_public_albums(): void
    {
        $user = User::factory()->create();
        Album::factory()->create(['is_hidden' => 0, 'user_id' => $user->id]);
        Album::factory()->create(['is_hidden' => 1, 'user_id' => $user->id]);

        $visibleAlbums = Album::visible()->get();

        $this->assertCount(1, $visibleAlbums);
        $this->assertEquals(0, $visibleAlbums->first()->is_hidden);
    }

    public function test_album_has_fillable_attributes(): void
    {
        $user = User::factory()->create();
        $album = Album::factory()->create([
            'user_id' => $user->id,
            'name' => 'Test Album',
            'description' => 'Test Description',
            'is_hidden' => 0
        ]);

        $this->assertEquals('Test Album', $album->name);
        $this->assertEquals('Test Description', $album->description);
        $this->assertEquals(0, $album->is_hidden);
    }
}

