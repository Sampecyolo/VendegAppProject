<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BookingResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'roomNumber' => $this->roomNumber,
            'checkIn' => $this->checkIn,
            'checkOut' => $this->checkOut,
            'numberOfGuests' => $this->numberOfGuests,
            'paid' => $this->paid,
            'paymentMethod' => $this->paymentMethod
        ];
    }
}
