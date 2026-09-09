<?php

namespace Tests\Feature;

use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthGateTest extends TestCase
{
    use RefreshDatabase;

    private function makeAdmin(): User
    {
        $role = Role::create(['name' => 'admin']);

        return User::create([
            'role_id'  => $role->id,
            'name'     => 'Admin',
            'email'    => 'admin@test.com',
            'password' => bcrypt('password'),
        ]);
    }

    private function makeClient(): User
    {
        $role = Role::create(['name' => 'client']);

        return User::create([
            'role_id'  => $role->id,
            'name'     => 'Client',
            'email'    => 'client@test.com',
            'password' => bcrypt('password'),
        ]);
    }

    public function test_guest_is_redirected_from_admin_dashboard(): void
    {
        $this->get('/adminbanal')->assertRedirect(route('login'));
    }

    public function test_guest_is_redirected_from_client_portal(): void
    {
        $this->get('/client')->assertRedirect(route('login'));
    }

    public function test_client_cannot_access_admin_dashboard(): void
    {
        $this->actingAs($this->makeClient())
            ->get('/adminbanal')
            ->assertForbidden();
    }

    public function test_admin_cannot_access_client_portal(): void
    {
        $this->actingAs($this->makeAdmin())
            ->get('/client')
            ->assertForbidden();
    }

    public function test_admin_can_access_admin_dashboard(): void
    {
        $this->actingAs($this->makeAdmin())
            ->get('/adminbanal')
            ->assertOk();
    }

    public function test_client_can_access_client_portal(): void
    {
        $this->actingAs($this->makeClient())
            ->get('/client')
            ->assertOk();
    }
}
