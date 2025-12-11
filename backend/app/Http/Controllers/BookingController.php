<?php

namespace App\Http\Controllers;

use App\Http\Resources\BookingResource;
use App\Models\Booking;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    public $validacio = [
        'roomNumber' => 'required|integer',
        'checkIn' => 'required|date',
        'checkOut' => 'required|date',
        'numberOfGuests' => 'required|integer',
        'paid' => 'required|integer',
        'paymentMethod' => 'required|string',

    ];

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $booking = Booking::all();

        return BookingResource::collection($booking);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate($this->validacio);

        $booking = Booking::create($validated);

        return response()->json('Sikeres!', 201);

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {

        try {
            $booking = Booking::findorfail($id);

            return new BookingResource($booking);

        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response([
                'status' => 'ERROR',
                'error' => '404 not found',
            ], 404);

        }

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {

        try {
            $validated = $request->validate($this->validacio);

            $booking = Booking::findOrFail($id);

            $booking->update($validated);

            return response()->json('Sikeres!', 201);

        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response([
                'status' => 'ERROR',
                'error' => '404 not found',
            ], 404);

        }

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {

        try {
            $booking = Booking::findOrFail($id);

            $booking->delete();

            return response()->json('Deleted', 200);

        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response([
                'status' => 'ERROR',
                'error' => '404 not found',
            ], 404);

        }

    }
}
