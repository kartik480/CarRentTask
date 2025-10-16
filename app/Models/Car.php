<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Car extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'type',
        'location',
        'price_per_day',
        'image',
        'description',
        'is_available',
        'supplier_id',
        'status', // pending, approved, rejected
    ];

    protected function casts(): array
    {
        return [
            'price_per_day' => 'decimal:2',
            'is_available' => 'boolean',
        ];
    }

    /**
     * Get the supplier that owns the car
     */
    public function supplier()
    {
        return $this->belongsTo(User::class, 'supplier_id');
    }

    /**
     * Get bookings for this car
     */
    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    /**
     * Check if car is available for booking on specific dates
     */
    public function isAvailableForDates($startDate, $endDate)
    {
        return !$this->bookings()
            ->where(function ($query) use ($startDate, $endDate) {
                $query->whereBetween('start_date', [$startDate, $endDate])
                    ->orWhereBetween('end_date', [$startDate, $endDate])
                    ->orWhere(function ($q) use ($startDate, $endDate) {
                        $q->where('start_date', '<=', $startDate)
                          ->where('end_date', '>=', $endDate);
                    });
            })
            ->whereIn('status', ['confirmed', 'pending'])
            ->exists();
    }

    /**
     * Scope for approved cars
     */
    public function scopeApproved($query)
    {
        return $query->where('status', 'approved');
    }

    /**
     * Scope for available cars
     */
    public function scopeAvailable($query)
    {
        return $query->where('is_available', true);
    }
}
