<?php

namespace App\Http\Controllers;

use App\Models\Car;
use App\Models\Booking;
use App\Models\User;
use App\Notifications\CarApproval;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function dashboard()
    {
        $totalCars = Car::count();
        $totalBookings = Booking::count();
        $totalSuppliers = User::where('role', 'supplier')->count();
        $pendingCars = Car::where('status', 'pending')->count();
        $recentBookings = Booking::with(['user', 'car'])->latest()->take(5)->get();
        $recentCars = Car::with('supplier')->latest()->take(5)->get();

        return view('admin.dashboard', compact(
            'totalCars',
            'totalBookings',
            'totalSuppliers',
            'pendingCars',
            'recentBookings',
            'recentCars'
        ));
    }

    public function suppliers()
    {
        $suppliers = User::where('role', 'supplier')->withCount('cars')->paginate(10);
        return view('admin.suppliers.index', compact('suppliers'));
    }

    public function createSupplier()
    {
        return view('admin.suppliers.create');
    }

    public function storeSupplier(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'supplier',
            'phone' => $request->phone,
            'address' => $request->address,
        ]);

        return redirect()->route('admin.suppliers')->with('success', 'Supplier created successfully.');
    }

    public function editSupplier(User $supplier)
    {
        return view('admin.suppliers.edit', compact('supplier'));
    }

    public function updateSupplier(Request $request, User $supplier)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $supplier->id,
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string',
        ]);

        $supplier->update($request->only(['name', 'email', 'phone', 'address']));

        return redirect()->route('admin.suppliers')->with('success', 'Supplier updated successfully.');
    }

    public function deleteSupplier(User $supplier)
    {
        $supplier->delete();
        return redirect()->route('admin.suppliers')->with('success', 'Supplier deleted successfully.');
    }

    public function cars()
    {
        $cars = Car::with('supplier')->paginate(10);
        return view('admin.cars.index', compact('cars'));
    }

    public function createCar()
    {
        $suppliers = User::where('role', 'supplier')->get();
        return view('admin.cars.create', compact('suppliers'));
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
            'supplier_id' => 'required|exists:users,id',
        ]);

        $data = $request->only(['name', 'type', 'location', 'price_per_day', 'description', 'supplier_id']);
        $data['status'] = 'approved'; // Admin-created cars are automatically approved

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('cars', 'public');
        }

        Car::create($data);

        return redirect()->route('admin.cars')->with('success', 'Car created successfully.');
    }

    public function editCar(Car $car)
    {
        $suppliers = User::where('role', 'supplier')->get();
        return view('admin.cars.edit', compact('car', 'suppliers'));
    }

    public function updateCar(Request $request, Car $car)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'price_per_day' => 'required|numeric|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'description' => 'nullable|string',
            'supplier_id' => 'required|exists:users,id',
            'status' => 'required|in:pending,approved,rejected',
            'is_available' => 'boolean',
        ]);

        $data = $request->only(['name', 'type', 'location', 'price_per_day', 'description', 'supplier_id', 'status', 'is_available']);

        if ($request->hasFile('image')) {
            // Delete old image
            if ($car->image) {
                \Storage::disk('public')->delete($car->image);
            }
            $data['image'] = $request->file('image')->store('cars', 'public');
        }

        $car->update($data);

        return redirect()->route('admin.cars')->with('success', 'Car updated successfully.');
    }

    public function deleteCar(Car $car)
    {
        // Delete image if exists
        if ($car->image) {
            \Storage::disk('public')->delete($car->image);
        }

        $car->delete();
        return redirect()->route('admin.cars')->with('success', 'Car deleted successfully.');
    }

    public function approveCar(Car $car)
    {
        $car->update(['status' => 'approved']);
        
        // Send notification to supplier
        $car->supplier->notify(new CarApproval($car, 'approved'));
        
        return redirect()->back()->with('success', 'Car approved successfully.');
    }

    public function rejectCar(Car $car)
    {
        $car->update(['status' => 'rejected']);
        
        // Send notification to supplier
        $car->supplier->notify(new CarApproval($car, 'rejected'));
        
        return redirect()->back()->with('success', 'Car rejected successfully.');
    }

    public function bookings()
    {
        $bookings = Booking::with(['user', 'car'])->paginate(10);
        return view('admin.bookings.index', compact('bookings'));
    }

    public function updateBookingStatus(Request $request, Booking $booking)
    {
        $request->validate([
            'status' => 'required|in:pending,confirmed,cancelled,completed'
        ]);

        $booking->update(['status' => $request->status]);
        return redirect()->back()->with('success', 'Booking status updated successfully.');
    }
}
