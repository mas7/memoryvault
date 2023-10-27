<?php

namespace Tests\Feature;

use App\Http\Requests\StoreQuestionRequest;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Validator;
use Tests\TestCase;

class QuestionControllerTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_finds_create_question_route(): void
    {
        // Arrange
        $user = User::factory()->create();

        $params = [
            'text' => 'What is 1+1 ?',
            'answers' => [
                [
                    'text' => 2,
                    'is_correct' => false,
                ],
            ]
        ];

        // Act
        $this->actingAs($user);
        $response = $this->postJson('/api/v1/questions', $params);

        // Assert
        $response->assertOk();
    }

    /** @test */
    public function it_passes_validation_rule_to_create_question(): void
    {
        // Arrange
        $params = [
            'text' => 'What is 2+3 ?',
            'answers' => [
                [
                    'text' => 2,
                    'is_correct' => false,
                ],
                [
                    'text' => 5,
                    'is_correct' => true,
                ],
                [
                    'text' => 4,
                    'is_correct' => false,
                ],
                [
                    'text' => 10,
                    'is_correct' => false,
                ],
            ],
        ];

        // Act
        $request = new StoreQuestionRequest();
        $validator = Validator::make($params, $request->rules(), $request->messages());

        // Assert
        $this->assertTrue($validator->passes());
    }

    /** @test */
    public function it_creates_question_successfully(): void
    {
        // Arrange
        $user = User::factory()->create();

        $params = [
            'text' => 'What is 2+3 ?',
            'answers' => [
                [
                    'text' => 2,
                    'is_correct' => false,
                ],
                [
                    'text' => 5,
                    'is_correct' => true,
                ],
                [
                    'text' => 4,
                    'is_correct' => false,
                ],
                [
                    'text' => 10,
                    'is_correct' => false,
                ],
            ],
        ];

        // Act
        $this->actingAs($user);
        $response = $this->postJson('/api/v1/questions', $params);

        // Assert
        $this->assertDatabaseHas('questions', [
            'text' => $params['text']
        ]);

        foreach ($params['answers'] as $answer) {
            $this->assertDatabaseHas('answers', $answer);
        }
    }
}
