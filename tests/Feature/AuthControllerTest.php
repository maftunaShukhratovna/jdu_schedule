<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Laravel\Sanctum\Sanctum;

class AuthControllerTest extends TestCase
{    
    public function it_registers_a_new_user_successfully()
    {
        $response = $this->postJson('/api/register', [
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'password' => 'password123'
        ]);

        $response->assertStatus(201)
                 ->assertJson(['message' => 'User registered successfully']);

        $this->assertDatabaseHas('users', ['email' => 'john@example.com']);
    }

    public function it_does_not_allow_duplicate_email_registration()
    {
        User::factory()->create(['email' => 'john@example.com']);

        $response = $this->postJson('/api/register', [
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'password' => 'password123'
        ]);

        $response->assertStatus(422)
                 ->assertJsonValidationErrors('email');
    }

    public function it_allows_a_user_to_login_with_correct_credentials()
    {
        $user = User::factory()->create([
            'email' => 'test@example.com',
            'password' => bcrypt('password123'),
        ]);

        $response = $this->postJson('/api/login', [
            'email' => 'test@example.com',
            'password' => 'password123'
        ]);

        $response->assertStatus(200)
                 ->assertJsonStructure(['token']);
    }

    public function it_rejects_login_with_incorrect_password()
    {
        $user = User::factory()->create([
            'email' => 'test@example.com',
            'password' => bcrypt('password123'),
        ]);

        $response = $this->postJson('/api/login', [
            'email' => 'test@example.com',
            'password' => 'wrongpassword'
        ]);

        $response->assertStatus(422)
                 ->assertJsonValidationErrors('email');
    }

    public function it_allows_an_authenticated_user_to_logout()
    {
        $user = User::factory()->create();

        Sanctum::actingAs($user);

        $response = $this->postJson('/api/logout');

        $response->assertStatus(200)
                 ->assertJson(['message' => 'Logged out']);
    }
}
