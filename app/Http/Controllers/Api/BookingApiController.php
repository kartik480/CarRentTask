<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\BookingResource;
use App\Models\Booking;
use Illuminate\Http\Request;

class BookingApiController extends Controller
{
    /**
     * Display a listing of user's bookings
     */
    public function index(Request $request)
    {
        $bookings = auth()->user()->bookings()
            ->with('car')
            ->when($request->status, function ($query) use ($request) {
                $query->where('status', $request->status);
            })
            ->orderBy('created_at', 'desc')
            ->paginate($request->per_page ?? 10);

        return BookingResource::collection($bookings);
    }

    /**
     * Display the specified booking
     */
    public function show(Booking $booking)
    {
        // Ensure user can only view their own bookings
        if ($booking->user_id !== auth()->id()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $booking->load(['car.supplier']);
        return new BookingResource($booking);
    }

    /**
     * Cancel a booking
     */
    public function cancel(Booking $booking)
    {
        // Ensure user can only cancel their own bookings
        if ($booking->user_id !== auth()->id()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        if (!in_array($booking->status, ['pending', 'confirmed'])) {
            return response()->json(['message' => 'This booking cannot be cancelled.'], 400);
        }

        $booking->update(['status' => 'cancelled']);
        
        return response()->json([
            'message' => 'Booking cancelled successfully.',
            'booking' => new BookingResource($booking->load('car'))
        ]);
    }
}
