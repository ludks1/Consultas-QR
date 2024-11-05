<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Institution extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'address',
        'logo',
    ];

    public function buildings()
    {
        return $this->hasMany(Building::class);
    }
    public function spaces()
    {
        return $this->hasManyThrough(Space::class, Building::class);
    }
}
