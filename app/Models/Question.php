<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    use HasFactory;

    protected $fillable = [
        'text',
        'type',
        'options',
    ];

    public function quiz()
    {
        return $this->belongsTo(Quiz::class);
    }

    public function section()
    {
        return $this->belongsTo(Section::class);
    }

    public function answers()
    {
        return $this->hasMany(Answer::class);
    }

    public function getOptionsAttribute($value)
    {
        return json_decode($value, true);
    }
}
