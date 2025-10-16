@extends('layouts.app')

@section('title', 'Edit Car - Supplier Panel')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2"><i class="fas fa-edit"></i> Edit Car</h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <a href="{{ route('supplier.cars') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Back to Cars
        </a>
    </div>
</div>

<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Car Information</h5>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('supplier.cars.update', $car) }}" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="name" class="form-label">Car Name</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                   id="name" name="name" value="{{ old('name', $car->name) }}" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label for="type" class="form-label">Car Type</label>
                            <select class="form-select @error('type') is-invalid @enderror" id="type" name="type" required>
                                <option value="">Select Car Type</option>
                                <option value="Sedan" {{ old('type', $car->type) == 'Sedan' ? 'selected' : '' }}>Sedan</option>
                                <option value="SUV" {{ old('type', $car->type) == 'SUV' ? 'selected' : '' }}>SUV</option>
                                <option value="Hatchback" {{ old('type', $car->type) == 'Hatchback' ? 'selected' : '' }}>Hatchback</option>
                                <option value="Coupe" {{ old('type', $car->type) == 'Coupe' ? 'selected' : '' }}>Coupe</option>
                                <option value="Convertible" {{ old('type', $car->type) == 'Convertible' ? 'selected' : '' }}>Convertible</option>
                                <option value="Truck" {{ old('type', $car->type) == 'Truck' ? 'selected' : '' }}>Truck</option>
                                <option value="Van" {{ old('type', $car->type) == 'Van' ? 'selected' : '' }}>Van</option>
                            </select>
                            @error('type')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="location" class="form-label">Location</label>
                            <input type="text" class="form-control @error('location') is-invalid @enderror" 
                                   id="location" name="location" value="{{ old('location', $car->location) }}" required>
                            @error('location')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label for="price_per_day" class="form-label">Price per Day (€)</label>
                            <input type="number" step="0.01" min="0" class="form-control @error('price_per_day') is-invalid @enderror" 
                                   id="price_per_day" name="price_per_day" value="{{ old('price_per_day', $car->price_per_day) }}" required>
                            @error('price_per_day')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="image" class="form-label">Car Image</label>
                        @if($car->image)
                            <div class="mb-2">
                                <img src="{{ asset('storage/' . $car->image) }}" alt="{{ $car->name }}" class="img-thumbnail" style="max-width: 200px;">
                                <div class="form-text">Current image</div>
                            </div>
                        @endif
                        <input type="file" class="form-control @error('image') is-invalid @enderror" 
                               id="image" name="image" accept="image/*">
                        <div class="form-text">Upload a new image to replace the current one (max 2MB)</div>
                        @error('image')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="mb-3">
                        <label for="description" class="form-label">Description</label>
                        <textarea class="form-control @error('description') is-invalid @enderror" 
                                  id="description" name="description" rows="4" placeholder="Describe your car, its features, condition, etc.">{{ old('description', $car->description) }}</textarea>
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="mb-3">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="is_available" 
                                   name="is_available" value="1" {{ old('is_available', $car->is_available) ? 'checked' : '' }}>
                            <label class="form-check-label" for="is_available">
                                Car is available for booking
                            </label>
                        </div>
                    </div>
                    
                    <div class="d-flex justify-content-between">
                        <a href="{{ route('supplier.cars') }}" class="btn btn-secondary">
                            <i class="fas fa-times"></i> Cancel
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Update Car
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
