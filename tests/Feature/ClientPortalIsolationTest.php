<?php

namespace Tests\Feature;

use App\Models\Project;
use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ClientPortalIsolationTest extends TestCase
{
    use RefreshDatabase;

    private function makeClient(string $email): User
    {
        $role = Role::firstOrCreate(['name' => 'client']);

        return User::create([
            'role_id'  => $role->id,
            'name'     => 'Client',
            'email'    => $email,
            'password' => bcrypt('password'),
        ]);
    }

    public function test_client_only_sees_their_own_projects(): void
    {
        $clientA = $this->makeClient('a@test.com');
        $clientB = $this->makeClient('b@test.com');

        Project::create([
            'client_id'        => $clientA->id,
            'name'             => 'Project A',
            'type'             => 'villa',
            'area'             => 200,
            'floors'           => 2,
            'status'           => 'ongoing',
            'progress_percent' => 50,
        ]);

        Project::create([
            'client_id'        => $clientB->id,
            'name'             => 'Project B',
            'type'             => 'office',
            'area'             => 300,
            'floors'           => 1,
            'status'           => 'pending',
            'progress_percent' => 0,
        ]);

        $response = $this->actingAs($clientA)->get('/client');
        $response->assertOk();

        // Project A must be visible, Project B must NOT
        $response->assertSee('Project A');
        $response->assertDontSee('Project B');
    }

    public function test_client_can_submit_a_project_request(): void
    {
        $client = $this->makeClient('req@test.com');

        $this->actingAs($client)
            ->postJson('/client/projects', [
                'name'     => 'My New Villa',
                'type'     => 'villa',
                'area'     => 250,
                'floors'   => 2,
                'location' => 'Cairo',
            ])
            ->assertCreated()
            ->assertJsonFragment(['status' => 'pending']);
    }
}
