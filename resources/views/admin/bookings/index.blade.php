@extends('layouts.app')

@section('title', 'Manage Bookings - Admin Panel')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2"><i class="fas fa-calendar-check"></i> Manage Bookings</h1>
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
                                    <small class="text-muted">{{ $booking->customer_email }}</small>
                                </div>
                            </td>
                            <td>
                                <div>
                                    <strong>{{ $booking->car->name }}</strong><br>
                                    <small class="text-muted">{{ $booking->car->supplier->name }}</small>
                                </div>
                            </td>
                            <td>{{ $booking->start_date->format('M d, Y') }}</td>
                            <td>{{ $booking->end_date->format('M d, Y') }}</td>
                            <td>${{ number_format($booking->total_amount, 2) }}</td>
                            <td>
                                <span class="badge bg-{{ $booking->status == 'confirmed' ? 'success' : ($booking->status == 'pending' ? 'warning' : ($booking->status == 'cancelled' ? 'danger' : 'info')) }}">
                                    {{ ucfirst($booking->status) }}
                                </span>
                            </td>
                            <td>
                                <form method="POST" action="{{ route('admin.bookings.update-status', $booking) }}" class="d-inline booking-status-form">
                                    @csrf
                                    @method('PUT')
                                    <select name="status" class="form-select form-select-sm admin-status-select" data-booking-id="{{ $booking->id }}">
                                        <option value="pending" {{ $booking->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                        <option value="confirmed" {{ $booking->status == 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                                        <option value="cancelled" {{ $booking->status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                                        <option value="completed" {{ $booking->status == 'completed' ? 'selected' : '' }}>Completed</option>
                                    </select>
                                </form>
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
                <i class="fas fa-calendar-check fa-3x text-muted mb-3"></i>
                <h4 class="text-muted">No Bookings Found</h4>
                <p class="text-muted">No bookings have been made yet.</p>
            </div>
        @endif
    </div>
</div>

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Handle admin booking status updates
    const adminStatusSelects = document.querySelectorAll('.admin-status-select');
    
    adminStatusSelects.forEach(select => {
        select.addEventListener('change', function() {
            const form = this.closest('form');
            const bookingId = this.getAttribute('data-booking-id');
            
            // Disable the select and show loading state
            this.disabled = true;
            this.style.opacity = '0.6';
            
            // Submit the form
            form.submit();
        });
    });
});
</script>
@endsection
