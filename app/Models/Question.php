<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'text',
        'type',
        'options',
    ];

    protected $appends = ['full_code'];

    // visible attributes
    protected $visible = [
        'code',
        'full_code',
        'text',
        'type',
        'options',
    ];

    // casts
    protected $casts = [
        'options' => 'array',
        'full_code' => 'string',
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

    public function setOptionsAttribute($value)
    {
        $this->attributes['options'] = json_encode($value);
    }

    public function getFullCodeAttribute($value)
    {
        return $this->section->code . '.' . $this->code;
    }
}
