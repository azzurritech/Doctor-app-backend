<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Doctor extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'specialty_id', 'address', 'experience', 'image', 'latitude', 'longitude'];
    
        public function availabilities()
    {
        return $this->hasMany(Availability::class);
    }

    public function bookings()
    {
        return $this->hasMany(newslots::class);
    }
    
       public function specialty()
    {
         return $this->belongsTo(Specialty::class, 'specialty_id');
    }
}
