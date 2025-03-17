<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class ScheduleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'group_id' => \App\Models\Group::factory(),
            'room_id' => \App\Models\Room::factory(),
            'subject_id' => \App\Models\Subject::factory(),
            'teacher_id' => \App\Models\User::factory(),
            'pair'=> $this->faker->randomElement(['1', '2', '3', '4', '5', '6']),
            'week_day' => $this->faker->randomElement(['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday']),
            'date'=> $this->faker->date(),
        ];
    }
}
