<?php

namespace Tests\Feature;

use App\Models\Question;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Plannr\Laravel\FastRefreshDatabase\Traits\FastRefreshDatabase;
use Tests\TestCase;

class QuizControllerTest extends TestCase
{
    use FastRefreshDatabase;

    private User $user;

    public function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();
        Question::factory(4)->withAnswers()->create();
    }

    /** @test */
    public function it_finds_start_quiz_route()
    {
        // Act, Assert
        $this->actingAs($this->user);
        $res = $this->postJson('/api/v1/quizzes/start')
            ->assertOk();

        dd($res->json());
    }
}
