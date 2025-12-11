<?php

namespace App\Http\Controllers;

use App\Http\Resources\GuestResource;
use App\Models\Guest;
use Illuminate\Http\Request;

class GuestController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public $validate = [
        'firstName' => 'required|string|max:255',
        'lastName' => 'required|string|max:255',
        'phoneNumber' => 'required|string|max:255',
        'address' => 'required',
        'booking_id' => 'required|exists:bookings,id',
    ];
    // Összes vendég visszaadása.

    public function index()
    {     // Vendég foglalással együtt: Guest::with('booking')->get();

        $guest = Guest::all();

        return GuestResource::collection($guest);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate($this->validate);

        $guest = Guest::create($validated);

        return response()->json('Sikeres!', 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {

        try {
            return new GuestResource(Guest::findOrFail($id));

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
            $validated = $request->validate($this->validate);

            $guest = Guest::findOrFail($id);

            $guest->update($validated);

            return response()->json('Sikeres update!', 200);

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
            $guest = Guest::findOrFail($id);
            $guest->delete();

            return response()->json(['message' => 'Guest removed from booking']);

        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response([
                'status' => 'ERROR',
                'error' => '404 not found',
            ], 404);

        }
    }
}
