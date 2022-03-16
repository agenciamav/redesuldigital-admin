<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Answer extends Model
{
    protected $fillable = [
        'answer',
        'question_id',
        'submission_id',
    ];

    // belongs to submission
    public function submission()
    {
        return $this->belongsTo(Submission::class);
    }

    // belongs to question
    public function question()
    {
        return $this->belongsTo(Question::class);
    }
}
