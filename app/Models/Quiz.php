<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Quiz extends Model
{
    protected $fillable = [
        'name',
        'description',
    ];

    public function sections ()
    {
        return $this->hasMany(Section::class);
    }

    public function questions()
    {
        return $this->hasManyThrough(Question::class, Section::class);
    }

    public function submissions()
    {
        return $this->hasMany(Submission::class);
    }
}
