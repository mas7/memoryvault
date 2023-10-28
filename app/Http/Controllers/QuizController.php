<?php

namespace App\Http\Controllers;

use App\Http\Resources\QuizResource;
use App\Models\Question;
use App\Services\QuizService;
use Illuminate\Http\Request;

class QuizController extends Controller
{

    public function __construct(public QuizService $quizService)
    {
    }

    public function startQuiz(Request $request)
    {
        $quiz = $this->quizService->startQuiz($request->user());

        return response()->json([
            'message'   => 'Quiz created successfully',
            'data'      => QuizResource::make($quiz),
        ]);
    }
}
