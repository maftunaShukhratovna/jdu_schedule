<?php

namespace Tests\Feature\API;

use App\Models\Group;
use App\Models\Subject;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class GroupSubjectControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_add_subject_to_group()
    {
        $group = Group::factory()->create();
        $subject = Subject::factory()->create();

        $data = [
            'group_id' => $group->id,
            'subject_id' => $subject->id,
        ];

        $response = $this->postJson('/api/group-subject', $data);
        $response->assertOk()->assertJson(['message' => 'Subject added to group']);

        $this->assertTrue($group->subjects()->where('subject_id', $subject->id)->exists());
    }

    public function test_can_remove_subject_from_group()
    {
        $group = Group::factory()->create();
        $subject = Subject::factory()->create();

        $group->subjects()->attach($subject->id);

        $data = [
            'group_id' => $group->id,
        ];

        $response = $this->deleteJson("/api/group-subject/{$subject->id}", $data);
        $response->assertOk()->assertJson(['message' => 'Subject removed from group']);

        $this->assertFalse($group->subjects()->where('subject_id', $subject->id)->exists());
    }
}
