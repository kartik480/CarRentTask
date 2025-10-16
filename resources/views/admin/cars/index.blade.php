@extends('layouts.app')

@section('title', 'Manage Cars - Admin Panel')

@section('content')
<!-- Modern Admin Header -->
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-4 pb-3 mb-4 border-bottom">
    <div class="d-flex align-items-center">
        <div class="admin-icon me-3">
            <i class="fas fa-car fa-2x text-primary"></i>
        </div>
        <div>
            <h1 class="h2 mb-0 fw-bold">Car Management</h1>
            <p class="text-muted mb-0">Manage and approve car listings from suppliers</p>
        </div>
    </div>
    <div class="btn-toolbar mb-2 mb-md-0">
        <div class="btn-group me-2">
            <a href="{{ route('admin.cars.create') }}" class="btn btn-primary btn-lg">
                <i class="fas fa-plus me-2"></i>Add New Car
            </a>
        </div>
        <div class="btn-group">
            <button type="button" class="btn btn-outline-secondary dropdown-toggle" data-bs-toggle="dropdown">
                <i class="fas fa-cog me-2"></i>Actions
            </button>
            <ul class="dropdown-menu">
                <li><a class="dropdown-item" href="#"><i class="fas fa-download me-2"></i>Export Data</a></li>
                <li><a class="dropdown-item" href="#"><i class="fas fa-upload me-2"></i>Import Cars</a></li>
                <li><hr class="dropdown-divider"></li>
                <li><a class="dropdown-item" href="#"><i class="fas fa-chart-bar me-2"></i>Analytics</a></li>
            </ul>
        </div>
    </div>
</div>

<!-- Enhanced Stats Cards -->
<div class="row mb-4">
    <div class="col-md-3">
        <div class="stats-card text-center">
            <div class="stats-icon mb-3">
                <i class="fas fa-car fa-2x text-primary"></i>
            </div>
            <div class="stats-number">{{ $cars->total() }}</div>
            <div class="stats-label">Total Cars</div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stats-card text-center">
            <div class="stats-icon mb-3">
                <i class="fas fa-check-circle fa-2x text-success"></i>
            </div>
            <div class="stats-number">{{ $cars->where('status', 'approved')->count() }}</div>
            <div class="stats-label">Approved</div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stats-card text-center">
            <div class="stats-icon mb-3">
                <i class="fas fa-clock fa-2x text-warning"></i>
            </div>
            <div class="stats-number">{{ $cars->where('status', 'pending')->count() }}</div>
            <div class="stats-label">Pending</div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stats-card text-center">
            <div class="stats-icon mb-3">
                <i class="fas fa-times-circle fa-2x text-danger"></i>
            </div>
            <div class="stats-number">{{ $cars->where('status', 'rejected')->count() }}</div>
            <div class="stats-label">Rejected</div>
        </div>
    </div>
</div>

<!-- Enhanced Cars Table -->
<div class="card shadow-lg border-0">
    <div class="card-header bg-transparent border-0 pb-0">
        <div class="d-flex justify-content-between align-items-center">
            <h3 class="card-title mb-0">
                <i class="fas fa-list me-2 text-primary"></i>Car Inventory
            </h3>
            <div class="d-flex gap-2">
                <div class="input-group" style="width: 250px;">
                    <span class="input-group-text"><i class="fas fa-search"></i></span>
                    <input type="text" class="form-control" placeholder="Search cars..." id="searchInput">
                </div>
                <div class="dropdown">
                    <button class="btn btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                        <i class="fas fa-filter me-1"></i>Filter
                    </button>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="#" data-filter="all">All Cars</a></li>
                        <li><a class="dropdown-item" href="#" data-filter="approved">Approved</a></li>
                        <li><a class="dropdown-item" href="#" data-filter="pending">Pending</a></li>
                        <li><a class="dropdown-item" href="#" data-filter="rejected">Rejected</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div class="card-body p-0">
        @if($cars->count() > 0)
            <div class="table-responsive">
                <table class="table table-striped mb-0" id="carsTable">
                    <thead>
                        <tr>
                            <th class="border-0">
                                <i class="fas fa-hashtag me-1"></i>ID
                            </th>
                            <th class="border-0">
                                <i class="fas fa-car me-1"></i>Car Details
                            </th>
                            <th class="border-0">
                                <i class="fas fa-tag me-1"></i>Type
                            </th>
                            <th class="border-0">
                                <i class="fas fa-map-marker-alt me-1"></i>Location
                            </th>
                            <th class="border-0">
                                <i class="fas fa-dollar-sign me-1"></i>Price/Day
                            </th>
                            <th class="border-0">
                                <i class="fas fa-user me-1"></i>Supplier
                            </th>
                            <th class="border-0">
                                <i class="fas fa-info-circle me-1"></i>Status
                            </th>
                            <th class="border-0">
                                <i class="fas fa-check me-1"></i>Available
                            </th>
                            <th class="border-0">
                                <i class="fas fa-cogs me-1"></i>Actions
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($cars as $car)
                        <tr data-status="{{ $car->status }}">
                            <td class="fw-bold">{{ $car->id }}</td>
                            <td>
                                <div class="d-flex align-items-center">
                                    @if($car->image)
                                        <img src="{{ Storage::url($car->image) }}" alt="{{ $car->name }}" 
                                             class="rounded me-3" style="width: 50px; height: 50px; object-fit: cover;">
                                    @else
                                        <div class="bg-primary rounded me-3 d-flex align-items-center justify-content-center" 
                                             style="width: 50px; height: 50px;">
                                            <i class="fas fa-car text-white"></i>
                                        </div>
                                    @endif
                                    <div>
                                        <div class="fw-semibold">{{ $car->name }}</div>
                                        @if($car->description)
                                            <small class="text-muted">{{ Str::limit($car->description, 50) }}</small>
                                        @endif
                                    </div>
                                </div>
                            </td>
                            <td>
                                <span class="badge bg-secondary">{{ ucfirst($car->type) }}</span>
                            </td>
                            <td>
                                <i class="fas fa-map-marker-alt me-1 text-primary"></i>{{ $car->location }}
                            </td>
                            <td class="fw-semibold text-success">
                                ${{ number_format($car->price_per_day, 2) }}
                            </td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="avatar-sm me-2">
                                        <div class="avatar-title bg-primary text-white rounded-circle">
                                            {{ substr($car->supplier->name, 0, 1) }}
                                        </div>
                                    </div>
                                    <span class="fw-medium">{{ $car->supplier->name }}</span>
                                </div>
                            </td>
                            <td>
                                <span class="badge bg-{{ $car->status == 'approved' ? 'success' : ($car->status == 'pending' ? 'warning' : 'danger') }}">
                                    <i class="fas fa-{{ $car->status == 'approved' ? 'check' : ($car->status == 'pending' ? 'clock' : 'times') }} me-1"></i>
                                    {{ ucfirst($car->status) }}
                                </span>
                            </td>
                            <td>
                                <span class="badge bg-{{ $car->is_available ? 'success' : 'secondary' }}">
                                    <i class="fas fa-{{ $car->is_available ? 'check' : 'times' }} me-1"></i>
                                    {{ $car->is_available ? 'Yes' : 'No' }}
                                </span>
                            </td>
                            <td>
                                <div class="btn-group" role="group">
                                    <a href="{{ route('admin.cars.edit', $car) }}" class="btn btn-sm btn-outline-primary" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    @if($car->status == 'pending')
                                        <form method="POST" action="{{ route('admin.cars.approve', $car) }}" class="d-inline">
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-success" title="Approve">
                                                <i class="fas fa-check"></i>
                                            </button>
                                        </form>
                                        <form method="POST" action="{{ route('admin.cars.reject', $car) }}" class="d-inline">
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-danger" title="Reject">
                                                <i class="fas fa-times"></i>
                                            </button>
                                        </form>
                                    @endif
                                    <form method="POST" action="{{ route('admin.cars.delete', $car) }}" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this car?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger" title="Delete">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            
            <!-- Enhanced Pagination -->
            <div class="d-flex justify-content-between align-items-center p-4 border-top">
                <div class="text-muted">
                    Showing {{ $cars->firstItem() }} to {{ $cars->lastItem() }} of {{ $cars->total() }} results
                </div>
                <nav aria-label="Cars pagination">
                    {{ $cars->links() }}
                </nav>
            </div>
        @else
            <div class="text-center py-5">
                <div class="empty-state">
                    <i class="fas fa-car fa-4x text-muted mb-4"></i>
                    <h4 class="text-muted mb-3">No Cars Found</h4>
                    <p class="text-muted mb-4">No cars have been added by suppliers yet.</p>
                    <a href="{{ route('admin.cars.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus me-2"></i>Add First Car
                    </a>
                </div>
            </div>
        @endif
    </div>
</div>

<style>
.admin-icon {
    width: 60px;
    height: 60px;
    background: var(--gradient-primary);
    border-radius: var(--radius-xl);
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
}

.stats-icon {
    width: 60px;
    height: 60px;
    background: rgba(99, 102, 241, 0.1);
    border-radius: var(--radius-xl);
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto;
}

.stats-label {
    color: var(--gray-600);
    font-weight: 500;
    margin-top: 0.5rem;
}

.avatar-sm {
    width: 32px;
    height: 32px;
}

.avatar-title {
    width: 100%;
    height: 100%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 0.875rem;
    font-weight: 600;
}

.empty-state {
    max-width: 400px;
    margin: 0 auto;
}

#searchInput {
    border-radius: var(--radius-lg);
}

.table td {
    vertical-align: middle;
}

.btn-group .btn {
    border-radius: var(--radius-md);
}

.btn-group .btn:not(:last-child) {
    margin-right: 0.25rem;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Search functionality
    const searchInput = document.getElementById('searchInput');
    const table = document.getElementById('carsTable');
    
    if (searchInput && table) {
        searchInput.addEventListener('input', function() {
            const searchTerm = this.value.toLowerCase();
            const rows = table.querySelectorAll('tbody tr');
            
            rows.forEach(row => {
                const text = row.textContent.toLowerCase();
                row.style.display = text.includes(searchTerm) ? '' : 'none';
            });
        });
    }
    
    // Filter functionality
    const filterButtons = document.querySelectorAll('[data-filter]');
    filterButtons.forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            const filter = this.getAttribute('data-filter');
            const rows = table.querySelectorAll('tbody tr');
            
            rows.forEach(row => {
                if (filter === 'all' || row.getAttribute('data-status') === filter) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
            
            // Update active filter button
            filterButtons.forEach(btn => btn.classList.remove('active'));
            this.classList.add('active');
        });
    });
});
</script>
@endsection
