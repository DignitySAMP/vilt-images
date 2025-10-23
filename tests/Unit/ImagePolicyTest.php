<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Image;
use App\Models\Album;
use App\Models\User;
use App\Policies\ImagePolicy;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ImagePolicyTest extends TestCase
{
    use RefreshDatabase;

    protected ImagePolicy $policy;

    protected function setUp(): void
    {
        parent::setUp();
        $this->policy = new ImagePolicy();
    }

    public function test_guest_can_view_public_image(): void
    {
        $image = Image::factory()->create(['is_hidden' => 0, 'album_id' => null]);

        $this->assertTrue($this->policy->show(null, $image));
    }

    public function test_guest_cannot_view_hidden_image(): void
    {
        $image = Image::factory()->create(['is_hidden' => 1]);

        $this->assertFalse($this->policy->show(null, $image));
    }

    public function test_owner_can_view_their_hidden_image(): void
    {
        $user = User::factory()->create();
        $image = Image::factory()->create([
            'publisher_id' => $user->id,
            'is_hidden' => 1
        ]);

        $this->assertTrue($this->policy->show($user, $image));
    }

    public function test_non_owner_cannot_view_hidden_image(): void
    {
        $owner = User::factory()->create();
        $otherUser = User::factory()->create();
        $image = Image::factory()->create([
            'publisher_id' => $owner->id,
            'is_hidden' => 1
        ]);

        $this->assertFalse($this->policy->show($otherUser, $image));
    }

    public function test_guest_cannot_view_image_in_hidden_album(): void
    {
        $user = User::factory()->create();
        $album = Album::factory()->create(['is_hidden' => 1, 'user_id' => $user->id]);
        $image = Image::factory()->create([
            'album_id' => $album->id,
            'is_hidden' => 0
        ]);

        $this->assertFalse($this->policy->show(null, $image));
    }

    public function test_album_owner_can_view_image_in_their_hidden_album(): void
    {
        $user = User::factory()->create();
        $album = Album::factory()->create(['is_hidden' => 1, 'user_id' => $user->id]);
        $image = Image::factory()->create([
            'album_id' => $album->id,
            'is_hidden' => 0,
            'publisher_id' => $user->id
        ]);

        $this->assertTrue($this->policy->show($user, $image));
    }

    public function test_only_owner_can_update_image(): void
    {
        $owner = User::factory()->create();
        $otherUser = User::factory()->create();
        $image = Image::factory()->create(['publisher_id' => $owner->id]);

        $this->assertTrue($this->policy->update($owner, $image));
        $this->assertFalse($this->policy->update($otherUser, $image));
    }

    public function test_only_owner_can_delete_image(): void
    {
        $owner = User::factory()->create();
        $otherUser = User::factory()->create();
        $image = Image::factory()->create(['publisher_id' => $owner->id]);

        $this->assertTrue($this->policy->delete($owner, $image));
        $this->assertFalse($this->policy->delete($otherUser, $image));
    }
}

