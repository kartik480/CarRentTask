@extends('layouts.app')

@section('title', 'Admin Dashboard - Car Rental System')

@section('content')
<!-- Hero Section -->
<div class="hero-section">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-8">
                <h1 class="display-4 fw-bold mb-3">
                    <i class="fas fa-tachometer-alt me-3"></i>Admin Dashboard
                </h1>
                <p class="lead mb-4">Welcome back! Here's what's happening with your car rental system.</p>
            </div>
            <div class="col-lg-4 text-end">
                <div class="pulse-animation">
                    <i class="fas fa-chart-line fa-4x opacity-75"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Stats Cards -->
<div class="row g-4 mb-5">
    <div class="col-xl-3 col-md-6">
        <div class="stats-card">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h6 class="text-muted mb-2">Total Cars</h6>
                    <div class="stats-number">{{ $totalCars }}</div>
                </div>
                <div class="text-primary">
                    <i class="fas fa-car fa-3x opacity-75"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6">
        <div class="stats-card">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h6 class="text-muted mb-2">Total Bookings</h6>
                    <div class="stats-number">{{ $totalBookings }}</div>
                </div>
                <div class="text-success">
                    <i class="fas fa-calendar-check fa-3x opacity-75"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6">
        <div class="stats-card">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h6 class="text-muted mb-2">Total Suppliers</h6>
                    <div class="stats-number">{{ $totalSuppliers }}</div>
                </div>
                <div class="text-info">
                    <i class="fas fa-users fa-3x opacity-75"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6">
        <div class="stats-card">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h6 class="text-muted mb-2">Pending Cars</h6>
                    <div class="stats-number">{{ $pendingCars }}</div>
                </div>
                <div class="text-warning">
                    <i class="fas fa-clock fa-3x opacity-75"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Quick Actions -->
<div class="row mb-5">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0"><i class="fas fa-bolt me-2"></i>Quick Actions</h5>
            </div>
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-md-3">
                        <a href="{{ route('admin.suppliers') }}" class="btn btn-primary w-100 h-100 d-flex flex-column align-items-center justify-content-center py-4">
                            <i class="fas fa-users fa-2x mb-2"></i>
                            <span>Manage Suppliers</span>
                        </a>
                    </div>
                    <div class="col-md-3">
                        <a href="{{ route('admin.cars') }}" class="btn btn-success w-100 h-100 d-flex flex-column align-items-center justify-content-center py-4">
                            <i class="fas fa-car fa-2x mb-2"></i>
                            <span>Manage Cars</span>
                        </a>
                    </div>
                    <div class="col-md-3">
                        <a href="{{ route('admin.bookings') }}" class="btn btn-info w-100 h-100 d-flex flex-column align-items-center justify-content-center py-4">
                            <i class="fas fa-calendar-check fa-2x mb-2"></i>
                            <span>Manage Bookings</span>
                        </a>
                    </div>
                    <div class="col-md-3">
                        <a href="{{ route('admin.suppliers.create') }}" class="btn btn-warning w-100 h-100 d-flex flex-column align-items-center justify-content-center py-4">
                            <i class="fas fa-user-plus fa-2x mb-2"></i>
                            <span>Add Supplier</span>
                        </a>
                    </div>
                    <div class="col-md-3">
                        <a href="{{ route('admin.cars.create') }}" class="btn btn-info w-100 h-100 d-flex flex-column align-items-center justify-content-center py-4">
                            <i class="fas fa-car-plus fa-2x mb-2"></i>
                            <span>Add Car</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
