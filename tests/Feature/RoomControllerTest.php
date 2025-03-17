<?php

namespace Tests\Feature\API;

use App\Models\Room;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RoomControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_fetch_rooms()
    {
        Room::factory()->count(3)->create();
        $response = $this->getJson('/api/room');
        $response->assertOk()->assertJsonCount(3, 'data');
    }

    public function test_can_search_rooms()
    {
        Room::factory()->create(['name' => 'Room A']);
        Room::factory()->create(['name' => 'Room B']);
        $response = $this->getJson('/api/room?search=Room A');
        $response->assertOk()->assertJsonCount(1, 'data');
    }

    public function test_can_store_room()
    {
        $data = ['name' => 'New Room'];
        $response = $this->postJson('/api/room', $data);
        $response->assertCreated()->assertJsonFragment($data);
        $this->assertDatabaseHas('rooms', $data);
    }

    public function test_can_show_room()
    {
        $room = Room::factory()->create();
        $response = $this->getJson("/api/room/{$room->id}");
        $response->assertOk()->assertJson(['id' => $room->id, 'name' => $room->name]);
    }

    public function test_can_update_room()
    {
        $room = Room::factory()->create();
        $data = ['name' => 'Updated Room'];
        $response = $this->putJson("/api/room/{$room->id}", $data);
        $response->assertOk()->assertJsonFragment($data);
        $this->assertDatabaseHas('rooms', $data);
    }

    public function test_can_delete_room()
    {
        $room = Room::factory()->create();
        $response = $this->deleteJson("/api/room/{$room->id}");
        $response->assertOk()->assertJson(['message' => 'Deleted successfully']);
        $this->assertDatabaseMissing('rooms', ['id' => $room->id]);
    }
}
