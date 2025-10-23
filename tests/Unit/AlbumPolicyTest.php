<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Album;
use App\Models\User;
use App\Policies\AlbumPolicy;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AlbumPolicyTest extends TestCase
{
    use RefreshDatabase;

    protected AlbumPolicy $policy;

    protected function setUp(): void
    {
        parent::setUp();
        $this->policy = new AlbumPolicy();
    }

    public function test_guest_can_view_public_album(): void
    {
        $album = Album::factory()->create(['is_hidden' => 0]);

        $this->assertTrue($this->policy->show(null, $album));
    }

    public function test_guest_cannot_view_hidden_album(): void
    {
        $album = Album::factory()->create(['is_hidden' => 1]);

        $this->assertFalse($this->policy->show(null, $album));
    }

    public function test_owner_can_view_their_hidden_album(): void
    {
        $user = User::factory()->create();
        $album = Album::factory()->create([
            'user_id' => $user->id,
            'is_hidden' => 1
        ]);

        $this->assertTrue($this->policy->show($user, $album));
    }

    public function test_non_owner_cannot_view_hidden_album(): void
    {
        $owner = User::factory()->create();
        $otherUser = User::factory()->create();
        $album = Album::factory()->create([
            'user_id' => $owner->id,
            'is_hidden' => 1
        ]);

        $this->assertFalse($this->policy->show($otherUser, $album));
    }

    public function test_only_owner_can_update_album(): void
    {
        $owner = User::factory()->create();
        $otherUser = User::factory()->create();
        $album = Album::factory()->create(['user_id' => $owner->id]);

        $this->assertTrue($this->policy->update($owner, $album));
        $this->assertFalse($this->policy->update($otherUser, $album));
    }

    public function test_only_owner_can_delete_album(): void
    {
        $owner = User::factory()->create();
        $otherUser = User::factory()->create();
        $album = Album::factory()->create(['user_id' => $owner->id]);

        $this->assertTrue($this->policy->delete($owner, $album));
        $this->assertFalse($this->policy->delete($otherUser, $album));
    }
}

