<?php

namespace Database\Seeders;

use App\Models\Group;
use App\Models\Room;
use App\Models\Subject;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory(10)->create();

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        Group::factory(10)->create();
        Room::factory(10)->create();
        Subject::factory(10)->create();

    }
}
