<?php

namespace Tests\Feature\API;

use App\Models\Schedule;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Group;
use App\Models\Subject;
use App\Models\User;
use App\Models\Room;

class ScheduleControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_create_schedule()
    {
        $group = Group::factory()->create();
        $subject = Subject::factory()->create();
        $teacher = User::factory()->create();
        $room = Room::factory()->create();

        $data = [
            'group_id' => $group->id,
            'subject_id' => $subject->id,
            'teacher_id' => $teacher->id,
            'room_id' => $room->id,
            'pair' => 1,
            'week_day' => 'monday', 
            'date' => now()->format('Y-m-d'), 
        ];

        $response = $this->postJson('/api/schedule', $data);

        $response->assertCreated()
            ->assertJsonFragment(['message' => 'Created'])
            ->assertJsonStructure([
                'schedule' => [
                    'id',
                    'group_id',
                    'subject_id',
                    'teacher_id',
                    'room_id',
                    'pair',
                    'week_day',
                    'date'
                ]
            ]);

        $this->assertDatabaseHas('schedules', $data);
    }

    public function test_can_show_schedule()
{

    $subject = Subject::factory()->create(); 
    $user = User::factory()->create();
    $room = Room::factory()->create();
    $group = Group::factory()->create();

  
    $schedule = Schedule::factory()->create([
        'group_id' => $group->id, 
        'room_id' =>$room->id, 
        'subject_id' => $subject->id, 
        'teacher_id' => $user->id, 
        'pair' => 5,
        'week_day' => 'monday',
        'date' => '2012-11-30',
    ]);

    $response = $this->getJson("/api/schedule/{$schedule->id}");

    $response->assertOk()
        ->assertJson([
            'id' => $schedule->id,
            'group_id' => $schedule->group_id,
            'subject_id' => $schedule->subject_id,
            'teacher_id' => $schedule->teacher_id,
            'room_id' => $schedule->room_id,
            'pair' => $schedule->pair,
            'week_day' => $schedule->week_day,
            'date' => $schedule->date,
        ]);
}


    public function test_show_schedule_not_found()
    {
        $response = $this->getJson('/api/schedule/999');

        $response->assertNotFound()
            ->assertJson(['message' => 'Schedule not found']);
    }

    public function test_can_update_schedule()
    {
        $schedule = Schedule::factory()->create();

        $subject = Subject::factory()->create();
        $user = User::factory()->create();
        $room = Room::factory()->create();
        $group = Group::factory()->create();

        $data = [
            'group_id' => $group->id,
            'subject_id' => $subject->id,
            'teacher_id' => $user->id,
            'room_id' => $room->id,
            'pair' => 5,
            'week_day' => 'monday',
            'date' => '2012-11-30',
        ];
        
        $response = $this->putJson("/api/schedule/{$schedule->id}", $data);
        
        $response = $this->putJson("/api/schedule/{$schedule->id}", $data);

        $response->assertOk()
            ->assertJsonFragment(['message' => 'Updated'])
            ->assertJsonStructure([
                'schedule' => [
                    'id',
                    'group_id',
                    'subject_id',
                    'teacher_id',
                    'room_id',
                    'pair',
                    'week_day',
                    'date'
                ]
            ]);
        $this->assertDatabaseHas('schedules', $data);
    }

    public function test_can_delete_schedule()
    {
        $schedule = Schedule::factory()->create();

        $response = $this->deleteJson("/api/schedule/{$schedule->id}");

        $response->assertOk()
            ->assertJson(['message' => 'schedule Deleted']);

        $this->assertDatabaseMissing('schedules', ['id' => $schedule->id]);
    }

    public function test_delete_schedule_not_found()
    {
        $response = $this->deleteJson('/api/schedule/999');

        $response->assertNotFound()
            ->assertJson(['message' => 'Schedule not found']);
    }
}
