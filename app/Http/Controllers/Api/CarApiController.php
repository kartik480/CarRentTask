<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CarResource;
use App\Http\Resources\BookingResource;
use App\Models\Car;
use App\Models\Booking;
use App\Http\Requests\StoreBookingRequest;
use Illuminate\Http\Request;

class CarApiController extends Controller
{
    /**
     * Display a listing of cars
     */
    public function index(Request $request)
    {
        $cars = Car::approved()
            ->available()
            ->with('supplier')
            ->when($request->search, function ($query) use ($request) {
                $query->where('name', 'like', '%' . $request->search . '%')
                      ->orWhere('location', 'like', '%' . $request->search . '%')
                      ->orWhere('type', 'like', '%' . $request->search . '%');
            })
            ->when($request->type, function ($query) use ($request) {
                $query->where('type', $request->type);
            })
            ->when($request->location, function ($query) use ($request) {
                $query->where('location', 'like', '%' . $request->location . '%');
            })
            ->when($request->min_price, function ($query) use ($request) {
                $query->where('price_per_day', '>=', $request->min_price);
            })
            ->when($request->max_price, function ($query) use ($request) {
                $query->where('price_per_day', '<=', $request->max_price);
            })
            ->paginate($request->per_page ?? 12);

        return CarResource::collection($cars);
    }

    /**
     * Display the specified car
     */
    public function show(Car $car)
    {
        if ($car->status !== 'approved' || !$car->is_available) {
            return response()->json(['message' => 'Car not found or not available'], 404);
        }

        $car->load('supplier');
        return new CarResource($car);
    }

    /**
     * Check car availability
     */
    public function checkAvailability(Request $request, Car $car)
    {
        $request->validate([
            'start_date' => 'required|date|after_or_equal:today',
            'end_date' => 'required|date|after:start_date',
        ]);

        $isAvailable = $car->isAvailableForDates($request->start_date, $request->end_date);
        $days = \Carbon\Carbon::parse($request->start_date)->diffInDays(\Carbon\Carbon::parse($request->end_date)) + 1;
        $totalAmount = $days * $car->price_per_day;

        return response()->json([
            'available' => $isAvailable,
            'days' => $days,
            'total_amount' => $totalAmount,
            'message' => $isAvailable ? 'Car is available for the selected dates.' : 'Car is not available for the selected dates.'
        ]);
    }

    /**
     * Book a car
     */
    public function book(StoreBookingRequest $request, Car $car)
    {
        if ($car->status !== 'approved' || !$car->is_available) {
            return response()->json(['message' => 'This car is not available for booking.'], 400);
        }

        // Check availability
        if (!$car->isAvailableForDates($request->start_date, $request->end_date)) {
            return response()->json(['message' => 'Car is not available for the selected dates.'], 400);
        }

        // Calculate total amount
        $startDate = \Carbon\Carbon::parse($request->start_date);
        $endDate = \Carbon\Carbon::parse($request->end_date);
        $days = $startDate->diffInDays($endDate) + 1;
        $totalAmount = $days * $car->price_per_day;

        // Create booking
        $booking = Booking::create([
            'user_id' => auth()->id(),
            'car_id' => $car->id,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'total_amount' => $totalAmount,
            'customer_name' => $request->customer_name,
            'customer_email' => $request->customer_email,
            'customer_phone' => $request->customer_phone,
            'notes' => $request->notes,
        ]);

        return response()->json([
            'message' => 'Booking request submitted successfully.',
            'booking' => new BookingResource($booking->load('car'))
        ], 201);
    }
}
