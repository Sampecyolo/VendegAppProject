<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    protected $fillable = [
        'check_in',
        'check_out',
        'room_number',
        'total_price',
        'internal_notes',
        'payment_method',
    ];


    public function guests()
    {
        return $this->belongsToMany(Guest::class);
    }
}
