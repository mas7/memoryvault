<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class QuizResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id'            => $this->id,
            'user_id'       => $this->user_id,
            'score'         => $this->score,
            'completed_at'  => $this->completed_at,
            'questions'     => QuizQuestionResource::collection($this->questions),
        ];
    }
}
