<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Image;
use App\Models\Album;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class ProfileTest extends TestCase
{
    use RefreshDatabase;

    public function test_profile_page_is_displayed_for_authenticated_users(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get('/profile');

        $response->assertStatus(200);
        $response->assertInertia(fn ($page) => 
            $page->component('Profile')
        );
    }

    public function test_guests_cannot_access_profile_page(): void
    {
        $response = $this->get('/profile');

        $response->assertRedirect('/login');
    }

    public function test_profile_page_displays_users_images(): void
    {
        $user = User::factory()->create();
        $otherUser = User::factory()->create();
        
        Image::factory()->count(3)->create(['publisher_id' => $user->id]);
        Image::factory()->create(['publisher_id' => $otherUser->id]);

        $response = $this->actingAs($user)->get('/profile');

        $response->assertStatus(200);
        $response->assertInertia(fn ($page) => 
            $page->component('Profile')
                ->has('images.data', 3)
        );
    }

    public function test_user_can_update_profile_information(): void
    {
        $user = User::factory()->create([
            'name' => 'Old Name',
            'email' => 'old@example.com',
        ]);

        $response = $this->actingAs($user)->patch('/profile', [
            'name' => 'New Name',
            'email' => 'new@example.com',
            'new_password' => null,
            'confirm_new_password' => null,
            'current_password' => null,
        ]);

        $response->assertRedirect('/profile');
        $user->refresh();

        $this->assertEquals('New Name', $user->name);
        $this->assertEquals('new@example.com', $user->email);
    }

    public function test_user_can_update_password(): void
    {
        $user = User::factory()->create([
            'password' => bcrypt('oldpassword')
        ]);

        $response = $this->actingAs($user)->patch('/profile', [
            'name' => $user->name,
            'email' => $user->email,
            'new_password' => 'newpassword123',
            'confirm_new_password' => 'newpassword123',
            'current_password' => 'oldpassword',
        ]);

        $response->assertRedirect('/profile');
        $user->refresh();

        $this->assertTrue(Hash::check('newpassword123', $user->password));
    }

    public function test_password_update_requires_current_password(): void
    {
        $user = User::factory()->create([
            'password' => bcrypt('oldpassword')
        ]);

        $response = $this->actingAs($user)->patch('/profile', [
            'name' => $user->name,
            'email' => $user->email,
            'new_password' => 'newpassword123',
            'confirm_new_password' => 'newpassword123',
            'current_password' => 'wrongpassword',
        ]);

        $response->assertSessionHasErrors('current_password');
    }

    public function test_email_must_be_unique(): void
    {
        $user1 = User::factory()->create(['email' => 'user1@example.com']);
        $user2 = User::factory()->create(['email' => 'user2@example.com']);

        $response = $this->actingAs($user2)->patch('/profile', [
            'name' => $user2->name,
            'email' => 'user1@example.com',
            'new_password' => null,
            'confirm_new_password' => null,
            'current_password' => null,
        ]);

        $response->assertSessionHasErrors('email');
    }

    public function test_user_can_delete_account_with_email_confirmation(): void
    {
        Storage::fake('public');
        $user = User::factory()->create(['email' => 'test@example.com']);
        
        // Create some data for the user
        $album = Album::factory()->create(['user_id' => $user->id]);
        Image::factory()->create(['publisher_id' => $user->id, 'album_id' => $album->id]);

        $response = $this->actingAs($user)->delete('/profile', [
            'confirm_email' => 'test@example.com',
        ]);

        $response->assertRedirect('/');
        $this->assertGuest();
        $this->assertDatabaseMissing('users', ['id' => $user->id]);
        $this->assertDatabaseMissing('albums', ['id' => $album->id]);
    }

    public function test_account_deletion_requires_email_confirmation(): void
    {
        $user = User::factory()->create(['email' => 'test@example.com']);

        $response = $this->actingAs($user)->delete('/profile', [
            'confirm_email' => 'wrong@example.com',
        ]);

        $response->assertSessionHasErrors('confirm_email');
        $this->assertDatabaseHas('users', ['id' => $user->id]);
    }

    public function test_profile_images_can_be_filtered_by_search(): void
    {
        $user = User::factory()->create();
        Image::factory()->create([
            'publisher_id' => $user->id,
            'name' => 'Beach Sunset'
        ]);
        Image::factory()->create([
            'publisher_id' => $user->id,
            'name' => 'Mountain View'
        ]);

        $response = $this->actingAs($user)->get('/profile?search=Beach&search_type=name');

        $response->assertStatus(200);
        $response->assertInertia(fn ($page) => 
            $page->component('Profile')
                ->has('images.data', 1)
        );
    }
}

