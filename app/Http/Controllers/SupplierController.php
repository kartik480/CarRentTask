<?php

namespace App\Http\Controllers;

use App\Models\Car;
use App\Models\Booking;
use App\Notifications\BookingConfirmation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SupplierController extends Controller
{
    public function dashboard()
    {
        $supplier = auth()->user();
        $totalCars = $supplier->cars()->count();
        $totalBookings = Booking::whereHas('car', function ($query) use ($supplier) {
            $query->where('supplier_id', $supplier->id);
        })->count();
        $pendingCars = $supplier->cars()->where('status', 'pending')->count();
        $recentBookings = Booking::whereHas('car', function ($query) use ($supplier) {
            $query->where('supplier_id', $supplier->id);
        })->with(['user', 'car'])->latest()->take(5)->get();

        return view('supplier.dashboard', compact(
            'totalCars',
            'totalBookings',
            'pendingCars',
            'recentBookings'
        ));
    }

    public function cars()
    {
        $cars = auth()->user()->cars()->paginate(10);
        return view('supplier.cars.index', compact('cars'));
    }

    public function createCar()
    {
        return view('supplier.cars.create');
    }

    public function storeCar(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'price_per_day' => 'required|numeric|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'description' => 'nullable|string',
        ]);

        $data = $request->only(['name', 'type', 'location', 'price_per_day', 'description']);
        $data['supplier_id'] = auth()->id();

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('cars', 'public');
        }

        Car::create($data);

        return redirect()->route('supplier.cars')->with('success', 'Car added successfully.');
    }

    public function editCar(Car $car)
    {
        // Ensure supplier can only edit their own cars
        if ($car->supplier_id !== auth()->id()) {
            abort(403);
        }

        return view('supplier.cars.edit', compact('car'));
    }

    public function updateCar(Request $request, Car $car)
    {
        // Ensure supplier can only edit their own cars
        if ($car->supplier_id !== auth()->id()) {
            abort(403);
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'price_per_day' => 'required|numeric|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'description' => 'nullable|string',
            'is_available' => 'boolean',
        ]);

        $data = $request->only(['name', 'type', 'location', 'price_per_day', 'description', 'is_available']);

        if ($request->hasFile('image')) {
            // Delete old image
            if ($car->image) {
                Storage::disk('public')->delete($car->image);
            }
            $data['image'] = $request->file('image')->store('cars', 'public');
        }

        $car->update($data);

        return redirect()->route('supplier.cars')->with('success', 'Car updated successfully.');
    }

    public function deleteCar(Car $car)
    {
        // Ensure supplier can only delete their own cars
        if ($car->supplier_id !== auth()->id()) {
            abort(403);
        }

        // Delete image if exists
        if ($car->image) {
            Storage::disk('public')->delete($car->image);
        }

        $car->delete();
        return redirect()->route('supplier.cars')->with('success', 'Car deleted successfully.');
    }

    public function bookings()
    {
        $supplier = auth()->user();
        $bookings = Booking::whereHas('car', function ($query) use ($supplier) {
            $query->where('supplier_id', $supplier->id);
        })->with(['user', 'car'])->paginate(10);

        return view('supplier.bookings.index', compact('bookings'));
    }

    public function updateBookingStatus(Request $request, Booking $booking)
    {
        // Ensure supplier can only update bookings for their cars
        if ($booking->car->supplier_id !== auth()->id()) {
            abort(403);
        }

        $request->validate([
            'status' => 'required|in:pending,confirmed,cancelled,completed'
        ]);

        $oldStatus = $booking->status;
        $booking->update(['status' => $request->status]);
        
        // Send notification if booking is confirmed
        if ($request->status === 'confirmed' && $oldStatus !== 'confirmed') {
            // Create a temporary user object for notification
            $customer = new \App\Models\User();
            $customer->email = $booking->customer_email;
            $customer->name = $booking->customer_name;
            
            $customer->notify(new BookingConfirmation($booking));
        }
        
        return redirect()->back()->with('success', 'Booking status updated successfully.');
    }

    public function availabilityCalendar()
    {
        $supplier = auth()->user();
        $cars = $supplier->cars()->approved()->get();
        
        return view('supplier.availability.calendar', compact('cars'));
    }

    public function getAvailabilityData(Request $request)
    {
        $request->validate([
            'car_id' => 'required|exists:cars,id',
            'month' => 'required|integer|min:1|max:12',
            'year' => 'required|integer|min:2020|max:2030'
        ]);

        $car = Car::findOrFail($request->car_id);
        
        // Ensure supplier can only check availability for their own cars
        if ($car->supplier_id !== auth()->id()) {
            abort(403);
        }

        $startDate = \Carbon\Carbon::create($request->year, $request->month, 1)->startOfMonth();
        $endDate = $startDate->copy()->endOfMonth();

        $bookings = $car->bookings()
            ->whereBetween('start_date', [$startDate, $endDate])
            ->orWhereBetween('end_date', [$startDate, $endDate])
            ->orWhere(function ($query) use ($startDate, $endDate) {
                $query->where('start_date', '<=', $startDate)
                      ->where('end_date', '>=', $endDate);
            })
            ->whereIn('status', ['confirmed', 'pending'])
            ->get();

        $availability = [];
        $current = $startDate->copy();
        
        while ($current->lte($endDate)) {
            $isAvailable = true;
            $bookingInfo = null;
            
            foreach ($bookings as $booking) {
                if ($current->between($booking->start_date, $booking->end_date)) {
                    $isAvailable = false;
                    $bookingInfo = [
                        'id' => $booking->id,
                        'customer' => $booking->customer_name,
                        'status' => $booking->status
                    ];
                    break;
                }
            }
            
            $availability[] = [
                'date' => $current->format('Y-m-d'),
                'available' => $isAvailable,
                'booking' => $bookingInfo
            ];
            
            $current->addDay();
        }

        return response()->json($availability);
    }
}
