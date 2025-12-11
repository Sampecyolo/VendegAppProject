<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Guest extends Model
{
    protected $fillable = ['firstName', 'lastName', 'phoneNumber', 'address', 'booking_id'];

    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }
}
