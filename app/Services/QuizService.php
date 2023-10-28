<?php

namespace App\Services;

use App\Models\Question;
use App\Models\Quiz;
use App\Models\User;

class QuizService
{
    public function startQuiz(User $user): Quiz
    {
        $quiz = $user->quizzes()->create();

        $this->addQuizQuestions($quiz);

        return $quiz;
    }

    public function addQuizQuestions(Quiz $quiz): void
    {
        $order = 0;
        Question::each(function ($question) use ($quiz, &$order) {
            $quiz->questions()->create([
                'question_id'   => $question->id,
                'order'         => ++$order,
            ]);
        });
    }
}
