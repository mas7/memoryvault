<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\QuizController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')
    ->as('api')
    ->group(function () {
        Route::post('auth/register', [AuthController::class, 'register']);
        Route::post('auth/login', [AuthController::class, 'login']);
    });

Route::prefix('v1')
    ->as('api')
    ->middleware('auth:sanctum')
    ->group(function () {
        Route::resource('questions', QuestionController::class);

        Route::post('quizzes/start', [QuizController::class, 'startQuiz']);
    });
