<?php

namespace Tests\Feature\API;

use App\Models\Subject;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SubjectControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_fetch_subjects()
    {
        Subject::factory()->count(3)->create();
        $response = $this->getJson('/api/subject');
        $response->assertOk()->assertJsonCount(3, 'data');
    }

    public function test_can_search_subjects()
    {
        Subject::factory()->create(['name' => 'Mathematics']);
        Subject::factory()->create(['name' => 'Physics']);
        $response = $this->getJson('/api/subject?search=Mathematics');
        $response->assertOk()->assertJsonCount(1, 'data');
    }

    public function test_can_store_subject()
    {
        $data = ['name' => 'Biology'];
        $response = $this->postJson('/api/subject', $data);
        $response->assertCreated()->assertJsonFragment($data);
        $this->assertDatabaseHas('subjects', $data);
    }

    public function test_can_show_subject()
    {
        $subject = Subject::factory()->create();
        $response = $this->getJson("/api/subject/{$subject->id}");
        $response->assertOk()->assertJson(['id' => $subject->id, 'name' => $subject->name]);
    }

    public function test_can_update_subject()
    {
        $subject = Subject::factory()->create();
        $data = ['name' => 'Updated Subject'];
        $response = $this->putJson("/api/subject/{$subject->id}", $data);
        $response->assertOk()->assertJsonFragment($data);
        $this->assertDatabaseHas('subjects', $data);
    }

    public function test_can_delete_subject()
    {
        $subject = Subject::factory()->create();
        $response = $this->deleteJson("/api/subject/{$subject->id}");
        $response->assertOk()->assertJson(['message' => 'Deleted successfully']);
        $this->assertDatabaseMissing('subjects', ['id' => $subject->id]);
    }
}
