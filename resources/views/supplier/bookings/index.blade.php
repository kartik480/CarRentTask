@extends('layouts.app')

@section('title', 'My Bookings - Supplier Panel')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2"><i class="fas fa-calendar-check"></i> My Bookings</h1>
</div>

<div class="card">
    <div class="card-body">
        @if($bookings->count() > 0)
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>ID</th>
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
                        @foreach($bookings as $booking)
                        <tr>
                            <td>{{ $booking->id }}</td>
                            <td>
                                <div>
                                    <strong>{{ $booking->customer_name }}</strong><br>
                                    <small class="text-muted">{{ $booking->customer_email }}</small><br>
                                    <small class="text-muted">{{ $booking->customer_phone }}</small>
                                </div>
                            </td>
                            <td>{{ $booking->car->name }}</td>
                            <td>{{ $booking->start_date->format('M d, Y') }}</td>
                            <td>{{ $booking->end_date->format('M d, Y') }}</td>
                            <td>${{ number_format($booking->total_amount, 2) }}</td>
                            <td>
                                <span class="badge bg-{{ $booking->status == 'confirmed' ? 'success' : ($booking->status == 'pending' ? 'warning' : ($booking->status == 'cancelled' ? 'danger' : 'info')) }}">
                                    {{ ucfirst($booking->status) }}
                                </span>
                            </td>
                            <td>
                                @if($booking->status == 'pending')
                                    <div class="btn-group" role="group">
                                        <form method="POST" action="{{ route('supplier.bookings.update-status', $booking) }}" class="d-inline booking-status-form">
                                            @csrf
                                            @method('PUT')
                                            <input type="hidden" name="status" value="confirmed">
                                            <button type="submit" class="btn btn-sm btn-success confirm-booking-btn" data-booking-id="{{ $booking->id }}">
                                                <i class="fas fa-check"></i> Confirm
                                            </button>
                                        </form>
                                        <form method="POST" action="{{ route('supplier.bookings.update-status', $booking) }}" class="d-inline booking-status-form">
                                            @csrf
                                            @method('PUT')
                                            <input type="hidden" name="status" value="cancelled">
                                            <button type="submit" class="btn btn-sm btn-danger cancel-booking-btn" data-booking-id="{{ $booking->id }}" onclick="return confirm('Are you sure you want to cancel this booking?')">
                                                <i class="fas fa-times"></i> Cancel
                                            </button>
                                        </form>
                                    </div>
                                @elseif($booking->status == 'confirmed')
                                    <form method="POST" action="{{ route('supplier.bookings.update-status', $booking) }}" class="d-inline booking-status-form">
                                        @csrf
                                        @method('PUT')
                                        <input type="hidden" name="status" value="completed">
                                        <button type="submit" class="btn btn-sm btn-info complete-booking-btn" data-booking-id="{{ $booking->id }}">
                                            <i class="fas fa-flag-checkered"></i> Mark Complete
                                        </button>
                                    </form>
                                @else
                                    <span class="text-muted">No actions available</span>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            
            <div class="d-flex justify-content-center">
                {{ $bookings->links() }}
            </div>
        @else
            <div class="text-center py-5">
                <i class="fas fa-calendar-check fa-4x text-muted mb-3"></i>
                <h4 class="text-muted">No bookings found</h4>
                <p class="text-muted">You don't have any bookings for your cars yet.</p>
                <a href="{{ route('supplier.cars') }}" class="btn btn-primary">
                    <i class="fas fa-car"></i> Manage Your Cars
                </a>
            </div>
        @endif
    </div>
</div>

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Handle booking status update forms
    const bookingForms = document.querySelectorAll('.booking-status-form');
    
    bookingForms.forEach(form => {
        form.addEventListener('submit', function(e) {
            const submitBtn = form.querySelector('button[type="submit"]');
            const bookingId = submitBtn.getAttribute('data-booking-id');
            
            // Disable the button and show loading state
            submitBtn.disabled = true;
            
            // Add loading spinner
            const originalContent = submitBtn.innerHTML;
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-1"></i>Processing...';
            
            // Re-enable button after 5 seconds as fallback
            setTimeout(() => {
                submitBtn.disabled = false;
                submitBtn.innerHTML = originalContent;
            }, 5000);
        });
    });
});
</script>
@endsection
