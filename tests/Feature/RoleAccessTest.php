<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RoleAccessTest extends TestCase
{
    use RefreshDatabase;

    private function user(string $type): User
    {
        return User::factory()->create(['type' => $type]);
    }

    public function test_plain_user_is_bounced_from_the_dashboard(): void
    {
        $this->actingAs($this->user('user'))
            ->get('/home')
            ->assertRedirect('/');
    }

    public function test_manager_reaches_the_dashboard(): void
    {
        $this->actingAs($this->user('manager'))
            ->get('/home')
            ->assertOk();
    }

    public function test_admin_reaches_the_dashboard(): void
    {
        $this->actingAs($this->user('admin'))
            ->get('/home')
            ->assertOk();
    }

    public function test_manager_cannot_list_users_via_the_api(): void
    {
        $this->actingAs($this->user('manager'), 'api')
            ->getJson('/api/user')
            ->assertForbidden();
    }

    public function test_manager_can_still_read_non_user_resources(): void
    {
        $this->actingAs($this->user('manager'), 'api')
            ->getJson('/api/sliders')
            ->assertOk();
    }

    public function test_admin_can_list_users_via_the_api(): void
    {
        $this->actingAs($this->user('admin'), 'api')
            ->getJson('/api/user')
            ->assertOk();
    }

    public function test_manager_can_update_their_own_profile(): void
    {
        $manager = $this->user('manager');

        $this->actingAs($manager, 'api')
            ->putJson('/api/profile', [
                'name' => 'New Name',
                'email' => $manager->email,
            ])
            ->assertOk();
    }
}
