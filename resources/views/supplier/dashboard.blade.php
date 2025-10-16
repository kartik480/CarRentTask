@extends('layouts.app')

@section('title', 'Supplier Dashboard - Car Rental System')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2"><i class="fas fa-tachometer-alt"></i> Supplier Dashboard</h1>
</div>

<div class="row">
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-primary shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">My Cars</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalCars }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-car fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-success shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Total Bookings</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalBookings }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-calendar-check fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-warning shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Pending Cars</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $pendingCars }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-clock fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-info shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Available Cars</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ auth()->user()->cars()->where('is_available', true)->count() }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-check-circle fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-12">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Recent Bookings for My Cars</h6>
            </div>
            <div class="card-body">
                @if($recentBookings->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Customer</th>
                                    <th>Car</th>
                                    <th>Start Date</th>
                                    <th>End Date</th>
                                    <th>Total Amount</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($recentBookings as $booking)
                                <tr>
                                    <td>{{ $booking->customer_name }}</td>
                                    <td>{{ $booking->car->name }}</td>
                                    <td>{{ $booking->start_date->format('M d, Y') }}</td>
                                    <td>{{ $booking->end_date->format('M d, Y') }}</td>
                                    <td>€{{ number_format($booking->total_amount, 2) }}</td>
                                    <td>
                                        <span class="badge bg-{{ $booking->status == 'confirmed' ? 'success' : ($booking->status == 'pending' ? 'warning' : 'secondary') }}">
                                            {{ ucfirst($booking->status) }}
                                        </span>
                                    </td>
                                    <td>
                                        @if($booking->status == 'pending')
                                            <form method="POST" action="{{ route('supplier.bookings.update-status', $booking) }}" class="d-inline">
                                                @csrf
                                                @method('PUT')
                                                <input type="hidden" name="status" value="confirmed">
                                                <button type="submit" class="btn btn-sm btn-success">Confirm</button>
                                            </form>
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <p class="text-muted">No recent bookings found.</p>
                @endif
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Quick Actions</h6>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-3 mb-3">
                        <a href="{{ route('supplier.cars') }}" class="btn btn-primary btn-block">
                            <i class="fas fa-car"></i> Manage My Cars
                        </a>
                    </div>
                    <div class="col-md-3 mb-3">
                        <a href="{{ route('supplier.cars.create') }}" class="btn btn-success btn-block">
                            <i class="fas fa-plus"></i> Add New Car
                        </a>
                    </div>
                    <div class="col-md-3 mb-3">
                        <a href="{{ route('supplier.bookings') }}" class="btn btn-info btn-block">
                            <i class="fas fa-calendar-check"></i> View Bookings
                        </a>
                    </div>
                    <div class="col-md-3 mb-3">
                        <a href="{{ route('supplier.availability.calendar') }}" class="btn btn-warning btn-block">
                            <i class="fas fa-calendar-alt"></i> Availability Calendar
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
