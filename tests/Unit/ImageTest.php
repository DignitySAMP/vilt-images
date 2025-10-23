<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Image;
use App\Models\Album;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Storage;

class ImageTest extends TestCase
{
    use RefreshDatabase;

    public function test_image_belongs_to_publisher(): void
    {
        $user = User::factory()->create();
        $image = Image::factory()->create(['publisher_id' => $user->id]);

        $this->assertInstanceOf(User::class, $image->publisher);
        $this->assertEquals($user->id, $image->publisher->id);
    }

    public function test_image_can_belong_to_album(): void
    {
        $album = Album::factory()->create();
        $image = Image::factory()->create(['album_id' => $album->id]);

        $this->assertInstanceOf(Album::class, $image->album);
        $this->assertEquals($album->id, $image->album->id);
    }

    public function test_image_can_be_without_album(): void
    {
        $image = Image::factory()->create(['album_id' => null]);

        $this->assertNull($image->album);
    }

    public function test_visible_scope_excludes_hidden_images(): void
    {
        $user = User::factory()->create();
        Image::factory()->create(['is_hidden' => 0, 'publisher_id' => $user->id]);
        Image::factory()->create(['is_hidden' => 1, 'publisher_id' => $user->id]);

        $visibleImages = Image::visible()->get();

        $this->assertCount(1, $visibleImages);
        $this->assertEquals(0, $visibleImages->first()->is_hidden);
    }

    public function test_visible_scope_excludes_images_in_hidden_albums(): void
    {
        $user = User::factory()->create();
        $publicAlbum = Album::factory()->create(['is_hidden' => 0, 'user_id' => $user->id]);
        $hiddenAlbum = Album::factory()->create(['is_hidden' => 1, 'user_id' => $user->id]);

        Image::factory()->create(['album_id' => $publicAlbum->id, 'is_hidden' => 0]);
        Image::factory()->create(['album_id' => $hiddenAlbum->id, 'is_hidden' => 0]);

        $visibleImages = Image::visible()->get();

        $this->assertCount(1, $visibleImages);
        $this->assertEquals($publicAlbum->id, $visibleImages->first()->album_id);
    }

    public function test_image_url_attribute_returns_correct_path(): void
    {
        Storage::fake('public');
        
        $image = Image::factory()->create([
            'path' => 'uploads/1/2025-01-01',
            'file_name' => 'test.jpg'
        ]);

        $expectedUrl = Storage::disk('public')->url('uploads/1/2025-01-01/test.jpg');
        $this->assertEquals($expectedUrl, $image->url);
    }

    public function test_image_thumbnail_url_attribute_returns_correct_path(): void
    {
        Storage::fake('public');
        
        $image = Image::factory()->create([
            'path' => 'uploads/1/2025-01-01',
            'file_name' => 'test.jpg'
        ]);

        $expectedUrl = Storage::disk('public')->url('uploads/1/2025-01-01/thumbnails/test.jpg');
        $this->assertEquals($expectedUrl, $image->thumbnail_url);
    }

    public function test_similar_images_excludes_current_image(): void
    {
        $user = User::factory()->create();
        $album = Album::factory()->create(['user_id' => $user->id]);
        
        $image1 = Image::factory()->create([
            'album_id' => $album->id,
            'publisher_id' => $user->id,
            'is_hidden' => 0
        ]);
        
        Image::factory()->count(3)->create([
            'album_id' => $album->id,
            'publisher_id' => $user->id,
            'is_hidden' => 0
        ]);

        $similar = $image1->similar();

        $this->assertFalse($similar->contains('id', $image1->id));
    }
}

