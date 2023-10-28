<?php

namespace Database\Factories;

use App\Models\Answer;
use App\Models\Question;
use Illuminate\Database\Eloquent\Factories\Factory;

class AnswerFactory extends Factory
{
    protected $model = Answer::class;

    public function definition(): array
    {
        return [
            'text'          => $this->faker->sentence,
            'question_id'   => Question::factory(),
            'is_correct'    => $this->faker->randomElement([true, false]),
        ];
    }
}
