<?php

namespace Tests\Unit;

use App\Models\Question;
use App\Models\User;
use App\Services\QuizService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Plannr\Laravel\FastRefreshDatabase\Traits\FastRefreshDatabase;
use Tests\TestCase;

class QuizServiceTest extends TestCase
{
    use FastRefreshDatabase;

    private QuizService $service;

    public function setUp(): void
    {
        parent::setUp();
        $this->service = app()->make(QuizService::class);
    }

    /** @test */
    public function it_creates_quiz(): void
    {
        // Arrange
        $user = User::factory()->create();
        Question::factory(4)->withAnswers()->create();

        // Act
        $quiz = $this->service->startQuiz($user);

        // Assert
        $this->assertEquals($user->id, $quiz->user_id);
        $this->assertEquals(0, $quiz->score);
        $this->assertEquals(null, $quiz->completed_at);
        $this->assertEquals($quiz->questions->count(), Question::count());
    }
}
