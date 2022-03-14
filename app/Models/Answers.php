<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Answers extends Model
{
    protected $fillable = [
        'data',
        'quiz_id',
        'APS',
        'city',
        'state',
        'duration',
        'progress',
        'started_at',
        'finished_at',
    ];

    protected $visible = [
        'data',
        'quiz_id',
        'APS',
        'city',
        'state',
        'duration',
        'progress',
        'started_at',
        'finished_at',
    ];

    protected $casts = [
        'data' => 'array',
    ];

    public function quiz()
    {
        return $this->belongsTo(Quiz::class);
    }

    public function getDataAttribute($value)
    {
        return json_decode($value);
    }

    public function setDataAttribute($value)
    {
        $this->attributes['data'] = json_encode($value);
    }
}
