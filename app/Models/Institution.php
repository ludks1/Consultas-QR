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
        'phone',
        'email',
    ];

    public function buildings()
    {
        return $this->hasMany(Building::class);
    }
}
