<?php

namespace App\Models;

use App\Enums\SpaceType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Space extends Model
{
    use HasFactory;

    protected $fillable = [
        'institution_id',
        'building_id',
        'floor',
        'name',
        'addressDescription',
        'category',
        'qrCode',
    ];

    protected $casts = [
        'category' => SpaceType::class,
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
