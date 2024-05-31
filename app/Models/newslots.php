<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class newslots extends Model
{
    use HasFactory;
    protected $table = 'bookedslots';
 
    public function availability()
    {
        return $this->belongsTo(Availability::class, 'slot_id');
    }

    public function doctor()
    {
        return $this->belongsTo(Doctor::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
