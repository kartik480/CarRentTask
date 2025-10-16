@extends('layouts.app')

@section('title', $car->name . ' - Car Rental System')

@section('content')
<div class="row">
    <div class="col-lg-8">
        <div class="card">
            @if($car->image)
                <img src="{{ Storage::url($car->image) }}" class="card-img-top" alt="{{ $car->name }}" style="height: 400px; object-fit: cover;">
            @else
                <div class="card-img-top bg-light d-flex align-items-center justify-content-center" style="height: 400px;">
                    <i class="fas fa-car fa-5x text-muted"></i>
                </div>
            @endif
            
            <div class="card-body">
                <h1 class="card-title">{{ $car->name }}</h1>
                <div class="row mb-3">
                    <div class="col-md-6">
                        <p><strong><i class="fas fa-tag"></i> Type:</strong> {{ ucfirst($car->type) }}</p>
                        <p><strong><i class="fas fa-map-marker-alt"></i> Location:</strong> {{ $car->location }}</p>
                    </div>
                    <div class="col-md-6">
                        <p><strong><i class="fas fa-user"></i> Supplier:</strong> {{ $car->supplier->name }}</p>
                        <p><strong><i class="fas fa-dollar-sign"></i> Price:</strong> ${{ number_format($car->price_per_day, 2) }}/day</p>
                    </div>
                </div>
                
                @if($car->description)
                    <h5>Description</h5>
                    <p>{{ $car->description }}</p>
                @endif
            </div>
        </div>
    </div>
    
    <div class="col-lg-4">
        <div class="card">
            <div class="card-header">
                <h5><i class="fas fa-calendar-check"></i> Book This Car</h5>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('cars.book', $car) }}" id="bookingForm">
                    @csrf
                    
                    <div class="mb-3">
                        <label for="start_date" class="form-label">Start Date</label>
                        <input type="date" class="form-control @error('start_date') is-invalid @enderror" 
                               id="start_date" name="start_date" value="{{ old('start_date') }}" required>
                        @error('start_date')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="mb-3">
                        <label for="end_date" class="form-label">End Date</label>
                        <input type="date" class="form-control @error('end_date') is-invalid @enderror" 
                               id="end_date" name="end_date" value="{{ old('end_date') }}" required>
                        @error('end_date')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="mb-3">
                        <button type="button" class="btn btn-outline-primary" id="checkAvailability">
                            <i class="fas fa-search"></i> Check Availability
                        </button>
                    </div>
                    
                    <div id="availabilityResult" class="mb-3" style="display: none;">
                        <div class="alert" id="availabilityAlert"></div>
                        <div id="totalAmount" class="text-center"></div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="customer_name" class="form-label">Full Name</label>
                        <input type="text" class="form-control @error('customer_name') is-invalid @enderror" 
                               id="customer_name" name="customer_name" value="{{ old('customer_name', auth()->user()->name ?? '') }}" required>
                        @error('customer_name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="mb-3">
                        <label for="customer_email" class="form-label">Email</label>
                        <input type="email" class="form-control @error('customer_email') is-invalid @enderror" 
                               id="customer_email" name="customer_email" value="{{ old('customer_email', auth()->user()->email ?? '') }}" required>
                        @error('customer_email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="mb-3">
                        <label for="customer_phone" class="form-label">Phone</label>
                        <input type="text" class="form-control @error('customer_phone') is-invalid @enderror" 
                               id="customer_phone" name="customer_phone" value="{{ old('customer_phone', auth()->user()->phone ?? '') }}" required>
                        @error('customer_phone')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="mb-3">
                        <label for="notes" class="form-label">Special Requests (Optional)</label>
                        <textarea class="form-control @error('notes') is-invalid @enderror" 
                                  id="notes" name="notes" rows="3">{{ old('notes') }}</textarea>
                        @error('notes')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary btn-lg">
                            <i class="fas fa-calendar-check"></i> Book Now
                        </button>
                    </div>
                </form>
            </div>
        </div>
        
        <div class="card mt-3">
            <div class="card-body text-center">
                <h6>Need Help?</h6>
                <p class="text-muted">Contact the supplier directly</p>
                <p><i class="fas fa-envelope"></i> {{ $car->supplier->email }}</p>
                @if($car->supplier->phone)
                    <p><i class="fas fa-phone"></i> {{ $car->supplier->phone }}</p>
                @endif
            </div>
        </div>
    </div>
</div>

<div class="mt-4">
    <a href="{{ route('cars.index') }}" class="btn btn-outline-secondary">
        <i class="fas fa-arrow-left"></i> Back to Cars
    </a>
</div>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const startDateInput = document.getElementById('start_date');
    const endDateInput = document.getElementById('end_date');
    const checkBtn = document.getElementById('checkAvailability');
    const availabilityResult = document.getElementById('availabilityResult');
    const availabilityAlert = document.getElementById('availabilityAlert');
    const totalAmount = document.getElementById('totalAmount');
    
    // Set minimum date to today
    const today = new Date().toISOString().split('T')[0];
    startDateInput.min = today;
    
    startDateInput.addEventListener('change', function() {
        endDateInput.min = this.value;
    });
    
    checkBtn.addEventListener('click', function() {
        const startDate = startDateInput.value;
        const endDate = endDateInput.value;
        
        if (!startDate || !endDate) {
            alert('Please select both start and end dates.');
            return;
        }
        
        if (new Date(startDate) >= new Date(endDate)) {
            alert('End date must be after start date.');
            return;
        }
        
        fetch(`{{ route('cars.check-availability', $car) }}`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({
                start_date: startDate,
                end_date: endDate
            })
        })
        .then(response => response.json())
        .then(data => {
            availabilityResult.style.display = 'block';
            
            if (data.available) {
                availabilityAlert.className = 'alert alert-success';
                availabilityAlert.innerHTML = '<i class="fas fa-check-circle"></i> ' + data.message;
                totalAmount.innerHTML = `<h5>Total: $${data.total_amount.toFixed(2)} for ${data.days} day${data.days > 1 ? 's' : ''}</h5>`;
            } else {
                availabilityAlert.className = 'alert alert-danger';
                availabilityAlert.innerHTML = '<i class="fas fa-times-circle"></i> ' + data.message;
                totalAmount.innerHTML = '';
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Error checking availability. Please try again.');
        });
    });
    
    // Handle booking form submission
    const bookingForm = document.getElementById('bookingForm');
    const bookBtn = document.querySelector('button[type="submit"]');
    
    if (bookingForm && bookBtn) {
        bookingForm.addEventListener('submit', function(e) {
            // Add loading state to the button
            bookBtn.disabled = true;
            bookBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Booking Car...';
            
            // Let the form submit normally
        });
    }
});
</script>
@endsection
