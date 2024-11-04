<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;

    protected $fillable = [
        'institutionId',
        'buildingId',
        'spaceId',
        'name',
        'description',
        'startDate',
        'endDate',
        'startTime',
        'endTime',
    ];

    public function space()
    {
        return $this->belongsTo(Space::class);
    }
}
