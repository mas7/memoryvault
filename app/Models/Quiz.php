<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Quiz extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'score',
        'completed_at'
    ];

    public function questions(): HasMany
    {
        return $this->hasMany(QuizQuestion::class);
    }
}
