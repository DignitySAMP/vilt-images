<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Image;
use App\Models\Album;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class ImageTest extends TestCase
{
    use RefreshDatabase;

    public function test_image_index_page_displays_public_images(): void
    {
        Image::factory()->count(3)->create(['is_hidden' => 0]);
        Image::factory()->create(['is_hidden' => 1]);

        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertInertia(fn ($page) => 
            $page->component('Image/Index/View')
                ->has('images.data', 3)
        );
    }

    public function test_authenticated_user_can_access_image_create_page(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get('/image/create');

        $response->assertStatus(200);
        $response->assertInertia(fn ($page) => 
            $page->component('Image/Create/View')
        );
    }

    public function test_guest_cannot_access_image_create_page(): void
    {
        $response = $this->get('/image/create');

        $response->assertRedirect('/login');
    }

    public function test_authenticated_user_can_upload_image(): void
    {
        Storage::fake('public');
        $user = User::factory()->create();

        $file = UploadedFile::fake()->image('test.jpg', 800, 600);

        $response = $this->actingAs($user)->post('/image', [
            'uploads' => [
                [
                    'file' => $file,
                    'name' => 'Test Image',
                    'description' => 'Test Description',
                    'is_hidden' => false,
                    'album_id' => null,
                ]
            ]
        ]);

        $response->assertRedirect('/profile');
        $this->assertDatabaseHas('images', [
            'name' => 'Test Image',
            'description' => 'Test Description',
            'publisher_id' => $user->id,
        ]);
    }

    public function test_user_can_view_public_image(): void
    {
        $image = Image::factory()->create(['is_hidden' => 0]);

        $response = $this->get("/image/{$image->id}");

        $response->assertStatus(200);
        $response->assertInertia(fn ($page) => 
            $page->component('Image/Show/View')
                ->has('image')
        );
    }

    public function test_guest_cannot_view_private_image(): void
    {
        $user = User::factory()->create();
        $image = Image::factory()->create([
            'is_hidden' => 1,
            'publisher_id' => $user->id
        ]);

        $response = $this->get("/image/{$image->id}");

        $response->assertStatus(403);
    }

    public function test_owner_can_view_their_private_image(): void
    {
        $user = User::factory()->create();
        $image = Image::factory()->create([
            'is_hidden' => 1,
            'publisher_id' => $user->id
        ]);

        $response = $this->actingAs($user)->get("/image/{$image->id}");

        $response->assertStatus(200);
    }

    public function test_owner_can_edit_their_image(): void
    {
        $user = User::factory()->create();
        $image = Image::factory()->create(['publisher_id' => $user->id]);

        $response = $this->actingAs($user)->get("/image/{$image->id}/edit");

        $response->assertStatus(200);
        $response->assertInertia(fn ($page) => 
            $page->component('Image/Edit/View')
        );
    }

    public function test_non_owner_cannot_edit_image(): void
    {
        $owner = User::factory()->create();
        $otherUser = User::factory()->create();
        $image = Image::factory()->create(['publisher_id' => $owner->id]);

        $response = $this->actingAs($otherUser)->get("/image/{$image->id}/edit");

        $response->assertStatus(403);
    }

    public function test_owner_can_update_their_image(): void
    {
        $user = User::factory()->create();
        $image = Image::factory()->create(['publisher_id' => $user->id]);

        $response = $this->actingAs($user)->patch("/image/{$image->id}", [
            'name' => 'Updated Name',
            'description' => 'Updated Description',
            'is_hidden' => true,
            'album_id' => null,
        ]);

        $response->assertRedirect("/image/{$image->id}");
        $this->assertDatabaseHas('images', [
            'id' => $image->id,
            'name' => 'Updated Name',
            'description' => 'Updated Description',
            'is_hidden' => true,
        ]);
    }

    public function test_owner_can_delete_their_image(): void
    {
        Storage::fake('public');
        $user = User::factory()->create();
        $image = Image::factory()->create(['publisher_id' => $user->id]);

        $response = $this->actingAs($user)->delete("/image/{$image->id}", [
            'confirm_name' => $image->name,
        ]);

        $response->assertRedirect('/profile');
        $this->assertDatabaseMissing('images', ['id' => $image->id]);
    }

    public function test_non_owner_cannot_delete_image(): void
    {
        $owner = User::factory()->create();
        $otherUser = User::factory()->create();
        $image = Image::factory()->create(['publisher_id' => $owner->id]);

        $response = $this->actingAs($otherUser)->delete("/image/{$image->id}", [
            'confirm_name' => $image->name,
        ]);

        $response->assertStatus(403);
    }

    public function test_image_deletion_requires_name_confirmation(): void
    {
        $user = User::factory()->create();
        $image = Image::factory()->create(['publisher_id' => $user->id]);

        $response = $this->actingAs($user)->delete("/image/{$image->id}", [
            'confirm_name' => 'wrong name',
        ]);

        $response->assertSessionHasErrors('confirm_name');
        $this->assertDatabaseHas('images', ['id' => $image->id]);
    }

    public function test_images_can_be_searched_by_name(): void
    {
        Image::factory()->create(['name' => 'Sunset Photo', 'is_hidden' => 0]);
        Image::factory()->create(['name' => 'Mountain View', 'is_hidden' => 0]);

        $response = $this->get('/?search=Sunset&search_type=name');

        $response->assertStatus(200);
        $response->assertInertia(fn ($page) => 
            $page->component('Image/Index/View')
                ->has('images.data', 1)
        );
    }
}

