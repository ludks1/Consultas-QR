<?php

namespace App\Models;

use App\Enums\SpaceType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;

    protected $fillable = [
        'spaceId',
        'name',
        'description',
        'startDate',
        'endDate',
        'startTime',
        'endTime',
        'type,'
    ];

    protected $casts = [
        'type' => SpaceType::class,
    ];

    public function space()
    {
        return $this->belongsTo(Space::class);
    }
}
