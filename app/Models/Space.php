<?php

namespace App\Models;

use App\Enums\SpaceType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Space extends Model
{
    use HasFactory;

    protected $fillable = [
        'buildingId',
        'floor',
        'name',
        'addressDescription',
        'type',
        'qrCode',
        'capacity',
    ];

    protected $casts = [
        'type' => SpaceType::class,
    ];

    public function building()
    {
        return $this->belongsTo(Building::class);
    }

    public function subjects()
    {
        return $this->belongsToMany(Subject::class, 'space_subject');
    }

    public function events(){
        if(in_array($this->category, [SpaceType::AUDITORIUM, SpaceType::COURT])){
            return $this->hasMany(Event::class);
        }
        return null;
    }
}
