@extends('layouts.app')

@section('title', 'Available Cars - Car Rental System')

@section('content')
<!-- Hero Section -->
<div class="hero-section">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-8">
                <h1 class="display-4 fw-bold mb-3">
                    <i class="fas fa-car me-3"></i>Available Cars
                </h1>
                <p class="lead mb-4">Find your perfect ride from our premium collection of vehicles.</p>
            </div>
            <div class="col-lg-4 text-end">
                <div>
                    <i class="fas fa-star fa-4x text-warning"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Search and Filter Form -->
<div class="card mb-4">
    <div class="card-body">
        <form method="GET" action="{{ route('cars.index') }}">
            <div class="row">
                <div class="col-md-3 mb-3">
                    <label for="search" class="form-label">Search</label>
                    <input type="text" class="form-control" id="search" name="search" 
                           value="{{ request('search') }}" placeholder="Car name, location, type...">
                </div>
                <div class="col-md-2 mb-3">
                    <label for="type" class="form-label">Type</label>
                    <select class="form-select" id="type" name="type">
                        <option value="">All Types</option>
                        <option value="sedan" {{ request('type') == 'sedan' ? 'selected' : '' }}>Sedan</option>
                        <option value="suv" {{ request('type') == 'suv' ? 'selected' : '' }}>SUV</option>
                        <option value="hatchback" {{ request('type') == 'hatchback' ? 'selected' : '' }}>Hatchback</option>
                        <option value="coupe" {{ request('type') == 'coupe' ? 'selected' : '' }}>Coupe</option>
                        <option value="convertible" {{ request('type') == 'convertible' ? 'selected' : '' }}>Convertible</option>
                    </select>
                </div>
                <div class="col-md-2 mb-3">
                    <label for="location" class="form-label">Location</label>
                    <input type="text" class="form-control" id="location" name="location" 
                           value="{{ request('location') }}" placeholder="City, State...">
                </div>
                <div class="col-md-2 mb-3">
                    <label for="min_price" class="form-label">Min Price/Day</label>
                    <input type="number" class="form-control" id="min_price" name="min_price" 
                           value="{{ request('min_price') }}" placeholder="0" min="0">
                </div>
                <div class="col-md-2 mb-3">
                    <label for="max_price" class="form-label">Max Price/Day</label>
                    <input type="number" class="form-control" id="max_price" name="max_price" 
                           value="{{ request('max_price') }}" placeholder="1000" min="0">
                </div>
                <div class="col-md-1 mb-3 d-flex align-items-end">
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="fas fa-search"></i>
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Cars Grid -->
<div class="row g-4">
    @forelse($cars as $car)
        <div class="col-lg-4 col-md-6">
            <div class="car-card h-100">
                @if($car->image)
                    <img src="{{ Storage::url($car->image) }}" class="card-img-top" alt="{{ $car->name }}" style="height: 200px; object-fit: cover;">
                @else
                    <div class="car-image">
                        <i class="fas fa-car"></i>
                    </div>
                @endif
                
                <div class="card-body d-flex flex-column p-4">
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <h5 class="card-title fw-bold mb-0">{{ $car->name }}</h5>
                        <span class="badge bg-primary">{{ ucfirst($car->type) }}</span>
                    </div>
                    
                    <div class="mb-3">
                        <p class="text-muted mb-2">
                            <i class="fas fa-map-marker-alt me-2"></i>{{ $car->location }}
                        </p>
                        <p class="text-muted mb-2">
                            <i class="fas fa-user me-2"></i>{{ $car->supplier->name }}
                        </p>
                    </div>
                    
                    @if($car->description)
                        <p class="card-text text-muted mb-3">{{ Str::limit($car->description, 100) }}</p>
                    @endif
                    
                    <div class="mt-auto">
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="price-tag">
                                ${{ number_format($car->price_per_day, 2) }}/day
                            </div>
                            <a href="{{ route('cars.show', $car) }}" class="btn btn-primary">
                                <i class="fas fa-eye me-2"></i>View Details
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @empty
        <div class="col-12">
            <div class="text-center py-5">
                <div class="car-image mx-auto mb-4" style="width: 200px; height: 200px;">
                    <i class="fas fa-car"></i>
                </div>
                <h4 class="text-muted mb-3">No cars found</h4>
                <p class="text-muted">Try adjusting your search criteria to find more vehicles.</p>
            </div>
        </div>
    @endforelse
</div>

<!-- Pagination -->
@if($cars->hasPages())
    <div class="d-flex justify-content-center">
        {{ $cars->links() }}
    </div>
@endif
@endsection
