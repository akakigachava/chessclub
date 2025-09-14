<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tournament extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'start_date',
        'location',
        'description'
    ];



    public function registrations()
{
    return $this->hasMany(TournamentRegistration::class);
}

public function isUserRegistered($userId)
{
    return $this->registrations()->where('user_id', $userId)->exists();
}

public function getRegistrationCountAttribute()
{
    return $this->registrations()->count();
}
}