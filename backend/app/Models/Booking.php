<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    protected $fillable = [
        'roomNumber',
        'checkIn',
        'checkOut',
        'numberOfGuests',
        'paid',
        'paymentMethod',
    ];

    public function guest(){
        return $this->hasMany(Guest::class);
    }
}
