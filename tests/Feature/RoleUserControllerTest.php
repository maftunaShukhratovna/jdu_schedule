<?php

namespace Tests\Feature\API;

use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RoleUserControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_fetch_users_with_roles()
    {
        $user = User::factory()->create();
        $role = Role::factory()->create();
        $user->roles()->attach($role->id);

        $response = $this->getJson('/api/role-user');

        $response->assertOk()
            ->assertJsonFragment([
                'id' => $user->id,
                'name' => $user->name,
            ])
            ->assertJsonStructure([
                '*' => ['id', 'name', 'roles']
            ]);
    }

    public function test_can_assign_role_to_user()
    {
        $user = User::factory()->create();
        $role = Role::factory()->create();

        $data = [
            'user_id' => $user->id,
            'role_id' => $role->id,
        ];

        $response = $this->postJson('/api/role-user', $data);
        $response->assertOk()->assertJson(['message' => 'Role assigned to user successfully.']);

        $this->assertTrue($user->roles()->where('role_id', $role->id)->exists());
    }


    public function test_can_remove_role_from_user()
    {
        $user = User::factory()->create();
        $role = Role::factory()->create();

        $user->roles()->attach($role->id);

        $data = [
            'role_id' => $role->id,
        ];

        $response = $this->deleteJson("/api/role-user/{$user->id}", $data);
        $response->assertOk()->assertJson(['message' => 'User role removed successfully.']);

        $this->assertFalse($user->roles()->where('role_id', $role->id)->exists());
    }
}
