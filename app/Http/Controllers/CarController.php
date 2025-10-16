<?php

namespace App\Http\Controllers;

use App\Models\Car;
use App\Models\Booking;
use App\Notifications\BookingConfirmation;
use Illuminate\Http\Request;

class CarController extends Controller
{
    public function index()
    {
        $cars = Car::approved()
            ->available()
            ->with('supplier')
            ->when(request('search'), function ($query) {
                $query->where('name', 'like', '%' . request('search') . '%')
                      ->orWhere('location', 'like', '%' . request('search') . '%')
                      ->orWhere('type', 'like', '%' . request('search') . '%');
            })
            ->when(request('type'), function ($query) {
                $query->where('type', request('type'));
            })
            ->when(request('location'), function ($query) {
                $query->where('location', 'like', '%' . request('location') . '%');
            })
            ->when(request('min_price'), function ($query) {
                $query->where('price_per_day', '>=', request('min_price'));
            })
            ->when(request('max_price'), function ($query) {
                $query->where('price_per_day', '<=', request('max_price'));
            })
            ->paginate(12);

        return view('cars.index', compact('cars'));
    }

    public function show(Car $car)
    {
        if ($car->status !== 'approved' || !$car->is_available) {
            abort(404);
        }

        $car->load('supplier');
        return view('cars.show', compact('car'));
    }

    public function book(Request $request, Car $car)
    {
        if ($car->status !== 'approved' || !$car->is_available) {
            return redirect()->back()->with('error', 'This car is not available for booking.');
        }

        $request->validate([
            'start_date' => 'required|date|after_or_equal:today',
            'end_date' => 'required|date|after:start_date',
            'customer_name' => 'required|string|max:255',
            'customer_email' => 'required|email|max:255',
            'customer_phone' => 'required|string|max:20',
            'notes' => 'nullable|string',
        ]);

        // Check availability
        if (!$car->isAvailableForDates($request->start_date, $request->end_date)) {
            return redirect()->back()->with('error', 'Car is not available for the selected dates.');
        }

        // Calculate total amount
        $startDate = \Carbon\Carbon::parse($request->start_date);
        $endDate = \Carbon\Carbon::parse($request->end_date);
        $days = $startDate->diffInDays($endDate) + 1;
        $totalAmount = $days * $car->price_per_day;

        // Create booking
        $booking = Booking::create([
            'user_id' => auth()->id() ?? null,
            'car_id' => $car->id,
            'supplier_id' => $car->supplier_id,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'total_days' => $days,
            'total_amount' => $totalAmount,
            'total_price' => $totalAmount, // Same as total_amount for now
            'customer_name' => $request->customer_name,
            'customer_email' => $request->customer_email,
            'customer_phone' => $request->customer_phone,
            'notes' => $request->notes,
        ]);

        // Send notification to supplier about new booking
        $car->supplier->notify(new \App\Notifications\NewBooking($booking));

        return redirect()->back()->with('success', 'Booking request submitted successfully. You will be contacted soon.');
    }

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
}
