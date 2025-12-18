<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use Illuminate\Http\Request;
use App\Http\Resources\BookingResource;

class BookingController extends Controller
{
    public $validacio =
        [
            'check_in' => 'required|date|after_or_equal:2025-01-01',
            'check_out' => 'required|date',
            'room_number' => 'required|integer',
            'total_price' => 'required|integer',
            'internal_notes' => 'required|string',
            'payment_method' => 'required|string',
        ];

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            //Leellenörzi, hogy jók, és helyes adatok vannak e megadava.
            $booking = Booking::all();
            //Visszaadja az értékeket.
            return response()->json(BookingResource::collection($booking));

        } catch (\Throwable $th) {
            //Visszadja a hibát, ha hiba van.
            return response()->json($th->getMessage(), 422);

        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        try {
            //Leellenörzi, hogy jók, és helyes adatok vannak e megadava.
            $validated = $request->validate($this->validacio);

            //Létrehozza a modellt-foglalást.
            $booking = Booking::create($validated);

            //Válaszol, hogy sikeres művelet, és ad egy 201 es kódot.
            return response()->json($booking, 201);

        } catch (\Throwable $th) {

            //Visszadja a hibát, ha hiba van.
            return response()->json($th->getMessage(), 422);
        }

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try {
            //Lekéri az adatokat.
            $booking = Booking::findOrFail($id);
            //Visszaad csak egy értéket.
            return response()->json($booking->toResource(BookingResource::class));

        } catch (\Throwable $th) {
            //Visszadja a hibát, ha hiba van.
            return response()->json($th->getMessage(), 422);

        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
         try {
            //Ugyan ugy validalja
            $validated = $request->validate($this->validacio);

            //Megkeresi a folalast id-alapján
            $booking = Booking::findOrFail($id);

            //A meglévő lekérdezett foglalást, atírja a kapott, validalt infora.
            $booking->update($validated);

            //Visszaadja, hogy sikeres volt a művelet!
            return response()->json('Sikeres!', 201);


        } catch (\Throwable $th) {

            //Visszaadja a hibát.
            return response()->json($th,404);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Booking::FindOrFail($id)->delete();
        return response()->json('Deleted', 200);
    }
}
