<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Availability extends Model
{
    use HasFactory;
    protected $table = 'slots';
    protected $fillable = [
    
        'starttime',
        'endtime',
    ];
    
     public function doctor()
    {
        return $this->belongsTo(Doctor::class);
    }

    public function booked()
    {
        return $this->hasMany(newslots::class);
    }
}


 