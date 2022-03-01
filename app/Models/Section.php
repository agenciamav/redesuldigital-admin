<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Section extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'quiz_id',
        'letter',
        'description',
    ];

    public function quiz()
    {
        return $this->belongsTo(Quiz::class);
    }

    public function questions()
    {
        return $this->hasMany(Question::class);
    }
}
