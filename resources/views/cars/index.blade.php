@extends('layouts.app')

@section('title', 'Available Cars - Car Rental System')

@section('content')
<!-- Modern Hero Section -->
<div class="hero-section">
    <div class="container">
        <div class="row align-items-center min-vh-50">
            <div class="col-lg-8">
                <h1 class="display-3 fw-bold mb-4">
                    <i class="fas fa-car me-3"></i>Premium Car Collection
                </h1>
                <p class="lead mb-4 fs-5">Discover your perfect ride from our curated selection of luxury and economy vehicles.</p>
                <div class="d-flex gap-3">
                    <a href="#search-section" class="btn btn-light btn-lg px-4">
                        <i class="fas fa-search me-2"></i>Find Your Car
                    </a>
                    <a href="#featured-cars" class="btn btn-outline-light btn-lg px-4">
                        <i class="fas fa-star me-2"></i>Featured Cars
                    </a>
                </div>
            </div>
            <div class="col-lg-4 text-center">
                <div class="hero-icon">
                    <i class="fas fa-car-side fa-6x text-white opacity-75"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Enhanced Search and Filter Section -->
<section id="search-section" class="py-5">
    <div class="container">
        <div class="card shadow-lg border-0">
            <div class="card-header bg-transparent border-0 pb-0">
                <h3 class="card-title text-center mb-0">
                    <i class="fas fa-filter me-2 text-primary"></i>Find Your Perfect Car
                </h3>
            </div>
            <div class="card-body p-4">
                <form method="GET" action="{{ route('cars.index') }}" class="needs-validation" novalidate>
                    <div class="row g-4">
                        <div class="col-md-3">
                            <label for="search" class="form-label fw-semibold">
                                <i class="fas fa-search me-1"></i>Search Cars
                            </label>
                            <input type="text" class="form-control" id="search" name="search" 
                                   value="{{ request('search') }}" placeholder="Car name, location, type...">
                        </div>
                        <div class="col-md-2">
                            <label for="type" class="form-label fw-semibold">
                                <i class="fas fa-car me-1"></i>Vehicle Type
                            </label>
                            <select class="form-select" id="type" name="type">
                                <option value="">All Types</option>
                                <option value="sedan" {{ request('type') == 'sedan' ? 'selected' : '' }}>Sedan</option>
                                <option value="suv" {{ request('type') == 'suv' ? 'selected' : '' }}>SUV</option>
                                <option value="hatchback" {{ request('type') == 'hatchback' ? 'selected' : '' }}>Hatchback</option>
                                <option value="coupe" {{ request('type') == 'coupe' ? 'selected' : '' }}>Coupe</option>
                                <option value="convertible" {{ request('type') == 'convertible' ? 'selected' : '' }}>Convertible</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <label for="location" class="form-label fw-semibold">
                                <i class="fas fa-map-marker-alt me-1"></i>Location
                            </label>
                            <input type="text" class="form-control" id="location" name="location" 
                                   value="{{ request('location') }}" placeholder="City, State...">
                        </div>
                        <div class="col-md-2">
                            <label for="min_price" class="form-label fw-semibold">
                                <i class="fas fa-euro-sign me-1"></i>Min Price/Day
                            </label>
                            <input type="number" class="form-control" id="min_price" name="min_price" 
                                   value="{{ request('min_price') }}" placeholder="0" min="0">
                        </div>
                        <div class="col-md-2">
                            <label for="max_price" class="form-label fw-semibold">
                                <i class="fas fa-euro-sign me-1"></i>Max Price/Day
                            </label>
                            <input type="number" class="form-control" id="max_price" name="max_price" 
                                   value="{{ request('max_price') }}" placeholder="1000" min="0">
                        </div>
                        <div class="col-md-1 d-flex align-items-end">
                            <button type="submit" class="btn btn-primary w-100 btn-lg">
                                <i class="fas fa-search"></i>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>

<!-- Enhanced Cars Grid -->
<section id="featured-cars" class="py-5">
    <div class="container">
        <div class="row g-4">
            @forelse($cars as $car)
                <div class="col-lg-4 col-md-6">
                    <div class="car-card h-100">
                        @if($car->image)
                            <div class="car-image-container position-relative overflow-hidden">
                                <img src="{{ Storage::url($car->image) }}" class="card-img-top" alt="{{ $car->name }}" style="height: 220px; object-fit: cover; transition: transform 0.3s ease;">
                                <div class="car-overlay position-absolute top-0 start-0 w-100 h-100 d-flex align-items-center justify-content-center opacity-0" style="background: rgba(0,0,0,0.7); transition: opacity 0.3s ease;">
                                    <a href="{{ route('cars.show', $car) }}" class="btn btn-light btn-lg">
                                        <i class="fas fa-eye me-2"></i>View Details
                                    </a>
                                </div>
                            </div>
                        @else
                            <div class="car-image">
                                <i class="fas fa-car"></i>
                            </div>
                        @endif
                        
                        <div class="card-body d-flex flex-column p-4">
                            <div class="d-flex justify-content-between align-items-start mb-3">
                                <h5 class="card-title fw-bold mb-0 text-truncate">{{ $car->name }}</h5>
                                <span class="badge bg-primary">{{ ucfirst($car->type) }}</span>
                            </div>
                            
                            <div class="mb-3">
                                <p class="text-muted mb-2 d-flex align-items-center">
                                    <i class="fas fa-map-marker-alt me-2 text-primary"></i>{{ $car->location }}
                                </p>
                                <p class="text-muted mb-2 d-flex align-items-center">
                                    <i class="fas fa-user me-2 text-primary"></i>{{ $car->supplier->name }}
                                </p>
                            </div>
                            
                            @if($car->description)
                                <p class="card-text text-muted mb-3">{{ Str::limit($car->description, 100) }}</p>
                            @endif
                            
                            <div class="mt-auto">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div class="price-tag">
                                        €{{ number_format($car->price_per_day, 2) }}/day
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
                        <div class="empty-state">
                            <i class="fas fa-car fa-4x text-muted mb-4"></i>
                            <h4 class="text-muted mb-3">No cars found</h4>
                            <p class="text-muted mb-4">Try adjusting your search criteria to find more vehicles.</p>
                            <a href="{{ route('cars.index') }}" class="btn btn-primary">
                                <i class="fas fa-refresh me-2"></i>Clear Filters
                            </a>
                        </div>
                    </div>
                </div>
            @endforelse
        </div>
        
        <!-- Enhanced Pagination -->
        @if($cars->hasPages())
            <div class="d-flex justify-content-center mt-5">
                <nav aria-label="Cars pagination">
                    {{ $cars->links() }}
                </nav>
            </div>
        @endif
    </div>
</section>

<style>
.car-image-container:hover img {
    transform: scale(1.1);
}

.car-image-container:hover .car-overlay {
    opacity: 1 !important;
}

.min-vh-50 {
    min-height: 50vh;
}

.hero-icon {
    animation: float 3s ease-in-out infinite;
}

@keyframes float {
    0%, 100% { transform: translateY(0px); }
    50% { transform: translateY(-20px); }
}

.empty-state {
    max-width: 400px;
    margin: 0 auto;
}
</style>
@endsection
