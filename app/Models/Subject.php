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
    ];

    protected $casts = [
        'career' => Career::class,
    ];
    public function users()
    {
        return $this->belongsToMany(User::class, 'user_subject');
    }

    public function spaces()
    {
        return $this->belongsToMany(Space::class, 'space_subject');
    }
}
