<?php

namespace Tests\Feature\API;

use App\Models\Group;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class GroupControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_fetch_groups()
    {
        Group::factory()->count(3)->create();
        $response = $this->getJson('/api/group');
        $response->assertOk()->assertJsonCount(3, 'data');
    }

    public function test_can_search_groups()
    {
        Group::factory()->create(['name' => 'Laravel']);
        Group::factory()->create(['name' => 'React']);
        $response = $this->getJson('/api/group?search=Laravel');
        $response->assertOk()->assertJsonCount(1, 'data');
    }

    public function test_can_store_group()
    {
        $data = ['name' => 'New Group'];
        $response = $this->postJson('/api/group', $data);
        $response->assertCreated()->assertJsonFragment($data);
        $this->assertDatabaseHas('groups', $data);
    }

    public function test_can_show_group()
    {
        $group = Group::factory()->create();
        $response = $this->getJson("/api/group/{$group->id}");
        $response->assertOk()->assertJson(['id' => $group->id, 'name' => $group->name]);
    }

    public function test_can_update_group()
    {
        $group = Group::factory()->create();
        $data = ['name' => 'Updated Name'];
        $response = $this->putJson("/api/group/{$group->id}", $data);
        $response->assertOk()->assertJsonFragment($data);
        $this->assertDatabaseHas('groups', $data);
    }

    public function test_can_delete_group()
    {
        $group = Group::factory()->create();
        $response = $this->deleteJson("/api/group/{$group->id}");
        $response->assertOk()->assertJson(['message' => 'Deleted successfully']);
        $this->assertDatabaseMissing('groups', ['id' => $group->id]);
    }
}
