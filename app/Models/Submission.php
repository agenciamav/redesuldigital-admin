<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Submission extends Model
{
    protected $fillable = [
        'id',
        'quiz_id',
        'name',
        'terms_accepted_at',
        'city',
        'state',
        'duration',
        'progress',
        'started_at',
        'finished_at',
    ];

    protected $visible = [
        'id',
        'quiz_id',
        'name',
        'terms_accepted_at',
        'city',
        'state',
        'duration',
        'progress',
        'started_at',
        'finished_at',
    ];

    public function quiz()
    {
        return $this->belongsTo(Quiz::class);
    }

    public function answers()
    {
        return $this->hasMany(Answer::class)->with('question');
    }
}
