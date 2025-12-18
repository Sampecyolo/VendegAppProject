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
            'checkIn' => $this->check_in,
            'checkOut' => $this->check_out,
            'roomNumber' => $this->room_number,
            'totalPrice' => $this->total_price,
            'internalNotes' => $this->internal_notes,
            'paymentMethod' => $this->payment_method
        ];
    }
}
