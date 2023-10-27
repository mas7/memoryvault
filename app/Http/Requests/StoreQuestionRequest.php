<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreQuestionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'text'                  => 'required|string',
            'answers'               => 'required|array|min:1',
            'answers.*'             => 'required|array|min:2',
            'answers.*.text'        => 'required',
            'answers.*.is_correct'  => 'required|boolean',
        ];
    }
}
