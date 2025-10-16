<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'car_id',
        'supplier_id',
        'start_date',
        'end_date',
        'total_days',
        'total_amount',
        'total_price',
        'status', // pending, confirmed, cancelled, completed
        'notes',
        'customer_name',
        'customer_email',
        'customer_phone',
    ];

    protected function casts(): array
    {
        return [
            'start_date' => 'date',
            'end_date' => 'date',
            'total_amount' => 'decimal:2',
        ];
    }

    /**
     * Get the user who made the booking
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the car being booked
     */
    public function car()
    {
        return $this->belongsTo(Car::class);
    }

    /**
     * Calculate total amount based on days and price
     */
    public function calculateTotalAmount()
    {
        $days = $this->start_date->diffInDays($this->end_date) + 1;
        return $days * $this->car->price_per_day;
    }

    /**
     * Scope for confirmed bookings
     */
    public function scopeConfirmed($query)
    {
        return $query->where('status', 'confirmed');
    }

    /**
     * Scope for pending bookings
     */
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    /**
     * Scope for active bookings (confirmed or pending)
     */
    public function scopeActive($query)
    {
        return $query->whereIn('status', ['confirmed', 'pending']);
    }
}
