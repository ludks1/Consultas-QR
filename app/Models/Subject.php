<?php

namespace App\Models;

use App\Enums\Career;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'code',
        'description',
        'career',
        'semester',
    ];

    protected $casts = [
        'career' => Career::class,
    ];
    public function users()
    {
        return $this->belongsToMany(User::class);
    }

    public function spaces()
    {
        return $this->belongsToMany(Space::class);
    }
}
