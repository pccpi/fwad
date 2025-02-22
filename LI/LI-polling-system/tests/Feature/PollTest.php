<?php

test('example', function () {
    $response = $this->get('/');

    $response->assertStatus(200);
});

namespace Tests\Feature;

use App\Models\Poll;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PollTest extends TestCase
{
    use RefreshDatabase;

    public function test_a_user_can_create_a_poll()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->postJson('/api/polls', [
            'question' => 'What is your favorite color?',
            'options' => ['Red', 'Blue', 'Green'],
        ]);

        $response->assertStatus(201);
        $this->assertDatabaseHas('polls', ['question' => 'What is your favorite color?']);
    }
}
