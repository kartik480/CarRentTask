<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCarRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->check() && auth()->user()->isSupplier();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'type' => 'required|string|max:255|in:sedan,suv,hatchback,coupe,convertible,pickup',
            'location' => 'required|string|max:255',
            'price_per_day' => 'required|numeric|min:0|max:1000',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'description' => 'nullable|string|max:1000',
            'is_available' => 'boolean',
        ];
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'name.required' => 'Car name is required.',
            'type.required' => 'Car type is required.',
            'type.in' => 'Please select a valid car type.',
            'location.required' => 'Location is required.',
            'price_per_day.required' => 'Price per day is required.',
            'price_per_day.numeric' => 'Price must be a valid number.',
            'price_per_day.min' => 'Price must be at least €0.',
            'price_per_day.max' => 'Price cannot exceed €1000 per day.',
            'image.image' => 'File must be an image.',
            'image.mimes' => 'Image must be a file of type: jpeg, png, jpg, gif.',
            'image.max' => 'Image size cannot exceed 2MB.',
            'description.max' => 'Description cannot exceed 1000 characters.',
        ];
    }
}
