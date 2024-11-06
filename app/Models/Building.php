<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Building extends Model
{
    use HasFactory;

    protected $fillable = [
        'institutionId',
        'name',
        'address',
        'numberOfFloors',
    ];

    public function spaces()
    {
        return $this->hasMany(Space::class);
    }

    public function institution()
    {
        return $this->belongsTo(Institution::class);
    }
}
