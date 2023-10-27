<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreQuestionRequest;
use App\Http\Resources\QuestionResource;
use App\Models\Question;
use Illuminate\Http\Request;

class QuestionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    public function store(StoreQuestionRequest $request)
    {
        $data = $request->validated();

        /** @var Question $question */
        $question = Question::create(['text' => $data['text']]);

        foreach ($data['answers'] as $answer) {
            $question->answers()->create($answer);
        }

        return response()->json([
            'message'   => 'Question created successfully',
            'question'  => QuestionResource::make($question)
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
