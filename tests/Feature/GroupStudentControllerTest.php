<?php

namespace Tests\Feature\API;

use App\Models\Group;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class GroupStudentControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_add_student_to_group()
    {
        $group = Group::factory()->create();
        $user = User::factory()->create();

        $data = [
            'group_id' => $group->id,
            'user_id' => $user->id,
        ];

        $response = $this->postJson('/api/group-student', $data);
        $response->assertOk()->assertJson(['message' => 'Student added to group']);

        $this->assertTrue($group->students()->where('user_id', $user->id)->exists());
    }

    public function test_can_remove_student_from_group()
    {
        $group = Group::factory()->create();
        $user = User::factory()->create();

        $group->students()->attach($user->id);

        $data = [
            'group_id' => $group->id,
        ];

        $response = $this->deleteJson("/api/group-student/{$user->id}", $data);
        $response->assertOk()->assertJson(['message' => 'Student removed from group']);

        $this->assertFalse($group->students()->where('user_id', $user->id)->exists());
    }
}
