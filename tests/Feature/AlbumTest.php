<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Album;
use App\Models\Image;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Storage;

class AlbumTest extends TestCase
{
    use RefreshDatabase;

    public function test_album_index_page_displays_public_albums(): void
    {
        Album::factory()->count(3)->create(['is_hidden' => 0]);
        Album::factory()->create(['is_hidden' => 1]);

        $response = $this->get('/albums');

        $response->assertStatus(200);
        $response->assertInertia(fn ($page) => 
            $page->component('Album/Index/View')
                ->has('albums.data', 3)
        );
    }

    public function test_authenticated_user_can_view_owned_albums(): void
    {
        $user = User::factory()->create();
        Album::factory()->count(2)->create(['user_id' => $user->id]);
        Album::factory()->create(); // another user's album

        $response = $this->actingAs($user)->get('/albums?owned_albums=1');

        $response->assertStatus(200);
        $response->assertInertia(fn ($page) => 
            $page->component('Album/Index/View')
                ->has('albums.data', 2)
        );
    }

    public function test_authenticated_user_can_access_album_create_page(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get('/album/create');

        $response->assertStatus(200);
        $response->assertInertia(fn ($page) => 
            $page->component('Album/Create/View')
        );
    }

    public function test_guest_cannot_access_album_create_page(): void
    {
        $response = $this->get('/album/create');

        $response->assertRedirect('/login');
    }

    public function test_authenticated_user_can_create_album(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post('/album', [
            'name' => 'My Album',
            'description' => 'Album Description',
            'is_hidden' => false,
        ]);

        $response->assertRedirect('/albums');
        $this->assertDatabaseHas('albums', [
            'name' => 'My Album',
            'description' => 'Album Description',
            'user_id' => $user->id,
            'is_hidden' => false,
        ]);
    }

    public function test_user_can_view_public_album(): void
    {
        $album = Album::factory()->create(['is_hidden' => 0]);

        $response = $this->get("/album/{$album->id}");

        $response->assertStatus(200);
        $response->assertInertia(fn ($page) => 
            $page->component('Album/Show/View')
        );
    }

    public function test_guest_cannot_view_private_album(): void
    {
        $user = User::factory()->create();
        $album = Album::factory()->create([
            'is_hidden' => 1,
            'user_id' => $user->id
        ]);

        $response = $this->get("/album/{$album->id}");

        $response->assertStatus(403);
    }

    public function test_owner_can_view_their_private_album(): void
    {
        $user = User::factory()->create();
        $album = Album::factory()->create([
            'is_hidden' => 1,
            'user_id' => $user->id
        ]);

        $response = $this->actingAs($user)->get("/album/{$album->id}");

        $response->assertStatus(200);
    }

    public function test_owner_can_edit_their_album(): void
    {
        $user = User::factory()->create();
        $album = Album::factory()->create(['user_id' => $user->id]);

        $response = $this->actingAs($user)->get("/album/{$album->id}/edit");

        $response->assertStatus(200);
        $response->assertInertia(fn ($page) => 
            $page->component('Album/Edit/View')
        );
    }

    public function test_non_owner_cannot_edit_album(): void
    {
        $owner = User::factory()->create();
        $otherUser = User::factory()->create();
        $album = Album::factory()->create(['user_id' => $owner->id]);

        $response = $this->actingAs($otherUser)->get("/album/{$album->id}/edit");

        $response->assertStatus(403);
    }

    public function test_owner_can_update_their_album(): void
    {
        $user = User::factory()->create();
        $album = Album::factory()->create(['user_id' => $user->id]);

        $response = $this->actingAs($user)->patch("/album/{$album->id}", [
            'name' => 'Updated Album Name',
            'description' => 'Updated Description',
            'is_hidden' => true,
        ]);

        $response->assertRedirect("/album/{$album->id}");
        $this->assertDatabaseHas('albums', [
            'id' => $album->id,
            'name' => 'Updated Album Name',
            'description' => 'Updated Description',
            'is_hidden' => true,
        ]);
    }

    public function test_owner_can_delete_their_album_with_confirmation(): void
    {
        Storage::fake('public');
        $user = User::factory()->create();
        $album = Album::factory()->create(['user_id' => $user->id]);
        
        // Create images in the album
        Image::factory()->count(2)->create(['album_id' => $album->id]);

        $response = $this->actingAs($user)->delete("/album/{$album->id}", [
            'confirm_name' => $album->name,
        ]);

        $response->assertRedirect('/profile');
        $this->assertDatabaseMissing('albums', ['id' => $album->id]);
        $this->assertDatabaseMissing('images', ['album_id' => $album->id]);
    }

    public function test_album_deletion_requires_name_confirmation(): void
    {
        $user = User::factory()->create();
        $album = Album::factory()->create(['user_id' => $user->id]);

        $response = $this->actingAs($user)->delete("/album/{$album->id}", [
            'confirm_name' => 'wrong name',
        ]);

        $response->assertSessionHasErrors('confirm_name');
        $this->assertDatabaseHas('albums', ['id' => $album->id]);
    }

    public function test_albums_can_be_searched_by_name(): void
    {
        Album::factory()->create(['name' => 'Vacation Photos', 'is_hidden' => 0]);
        Album::factory()->create(['name' => 'Family Album', 'is_hidden' => 0]);

        $response = $this->get('/albums?search=Vacation&search_type=name');

        $response->assertStatus(200);
        $response->assertInertia(fn ($page) => 
            $page->component('Album/Index/View')
                ->has('albums.data', 1)
        );
    }

    public function test_albums_can_be_sorted_by_most_images(): void
    {
        $album1 = Album::factory()->create(['is_hidden' => 0]);
        $album2 = Album::factory()->create(['is_hidden' => 0]);
        
        Image::factory()->count(5)->create(['album_id' => $album1->id, 'is_hidden' => 0]);
        Image::factory()->count(2)->create(['album_id' => $album2->id, 'is_hidden' => 0]);

        $response = $this->get('/albums?sort=most_images');

        $response->assertStatus(200);
    }
}

