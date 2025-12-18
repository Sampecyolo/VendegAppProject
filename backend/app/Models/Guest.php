<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Guest extends Model
{
    protected $fillable = ['first_name', 'last_name', 'email', 'phone_number',
     'country', 'zip_code', 'city','address', 'date_of_birth', 'document_number',
      'nationality', 'notes', 'language', 'source'];



            // Tábla összekötés
   public function bookings() {
    return $this->belongsToMany(Booking::class);
}
}
