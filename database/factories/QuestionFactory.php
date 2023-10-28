<?php

namespace Database\Factories;

use App\Models\Answer;
use App\Models\Question;
use Illuminate\Database\Eloquent\Factories\Factory;

class QuestionFactory extends Factory
{
    protected $model = Question::class;

    public function definition(): array
    {
        return [
            'text' => $this->faker->sentence,
        ];
    }

    public function withAnswers(): Factory
    {
        return $this->afterCreating(function (Question $question) {
            Answer::factory()
                ->state(['question_id' => $question->id])
                ->sequence(
                    ['is_correct' => false],
                    ['is_correct' => false],
                    ['is_correct' => false],
                    ['is_correct' => true],
                )
                ->count(4)
                ->create();
        });
    }
}
