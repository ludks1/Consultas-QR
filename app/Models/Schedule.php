<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    use HasFactory;

    protected $fillable = [
        'spaceId',
        'subjectId',
        'day',
        'startIime',
        'endIime',
    ];

    public function space()
    {
        return $this->belongsTo(Space::class);
    }

    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }
}
