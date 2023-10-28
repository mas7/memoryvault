<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class QuizQuestionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'        => $this->id,
            'quiz_id'   => $this->quiz_id,
            'order'     => $this->order,
            'answer_id' => $this->answer_id,
            'question'  => QuestionResource::make($this->question),
        ];
    }
}
