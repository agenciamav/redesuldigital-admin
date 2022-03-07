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

    protected $appends = ['full_code', 'section_code'];

    // visible attributes
    protected $visible = [
        'code',
        'text',
        'type',
        'options',
        'full_code',
        'section_code'
    ];

    // casts
    protected $casts = [
        'options' => 'array',
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

    public function getSectionCodeAttribute($value)
    {
        return $this->section->code;
    }

    public function getFullCodeAttribute($value)
    {
        return $this->section->code . '.' . $this->code;
    }
}
