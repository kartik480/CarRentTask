@extends('layouts.app')

@section('title', 'My Cars - Supplier Panel')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2"><i class="fas fa-car"></i> My Cars</h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <a href="{{ route('supplier.cars.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Add New Car
        </a>
    </div>
</div>

<div class="card">
    <div class="card-body">
        @if($cars->count() > 0)
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Image</th>
                            <th>Car Name</th>
                            <th>Type</th>
                            <th>Location</th>
                            <th>Price/Day</th>
                            <th>Status</th>
                            <th>Available</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($cars as $car)
                        <tr>
                            <td>{{ $car->id }}</td>
                            <td>
                                @if($car->image)
                                    <img src="{{ asset('storage/' . $car->image) }}" alt="{{ $car->name }}" class="img-thumbnail" style="width: 50px; height: 50px;">
                                @else
                                    <i class="fas fa-car fa-2x text-muted"></i>
                                @endif
                            </td>
                            <td>{{ $car->name }}</td>
                            <td>{{ $car->type }}</td>
                            <td>{{ $car->location }}</td>
                            <td>${{ number_format($car->price_per_day, 2) }}</td>
                            <td>
                                <span class="badge bg-{{ $car->status == 'approved' ? 'success' : ($car->status == 'pending' ? 'warning' : 'danger') }}">
                                    {{ ucfirst($car->status) }}
                                </span>
                            </td>
                            <td>
                                <span class="badge bg-{{ $car->is_available ? 'success' : 'secondary' }}">
                                    {{ $car->is_available ? 'Available' : 'Unavailable' }}
                                </span>
                            </td>
                            <td>
                                <div class="btn-group" role="group">
                                    <a href="{{ route('supplier.cars.edit', $car) }}" class="btn btn-sm btn-outline-primary">
                                        <i class="fas fa-edit"></i> Edit
                                    </a>
                                    <form method="POST" action="{{ route('supplier.cars.delete', $car) }}" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this car?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger">
                                            <i class="fas fa-trash"></i> Delete
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            
            <div class="d-flex justify-content-center">
                {{ $cars->links() }}
            </div>
        @else
            <div class="text-center py-5">
                <i class="fas fa-car fa-4x text-muted mb-3"></i>
                <h4 class="text-muted">No cars found</h4>
                <p class="text-muted">You haven't added any cars yet.</p>
                <a href="{{ route('supplier.cars.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus"></i> Add Your First Car
                </a>
            </div>
        @endif
    </div>
</div>
@endsection
