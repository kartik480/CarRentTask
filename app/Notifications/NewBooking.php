<?php

namespace App\Notifications;

use App\Models\Booking;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewBooking extends Notification implements ShouldQueue
{
    use Queueable;

    protected $booking;

    /**
     * Create a new notification instance.
     */
    public function __construct(Booking $booking)
    {
        $this->booking = $booking;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('New Booking Request - Car Rental System')
            ->greeting('Hello ' . $notifiable->name . '!')
            ->line('You have received a new booking request for your car.')
            ->line('Booking Details:')
            ->line('Car: ' . $this->booking->car->name)
            ->line('Customer: ' . $this->booking->customer_name)
            ->line('Email: ' . $this->booking->customer_email)
            ->line('Phone: ' . $this->booking->customer_phone)
            ->line('Start Date: ' . $this->booking->start_date->format('M d, Y'))
            ->line('End Date: ' . $this->booking->end_date->format('M d, Y'))
            ->line('Total Amount: $' . number_format($this->booking->total_amount, 2))
            ->line('Status: ' . ucfirst($this->booking->status))
            ->action('Manage Booking', url('/supplier/bookings'))
            ->line('Please log in to your supplier dashboard to confirm or manage this booking.')
            ->salutation('Best regards, Car Rental System Team');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'booking_id' => $this->booking->id,
            'car_name' => $this->booking->car->name,
            'customer_name' => $this->booking->customer_name,
            'start_date' => $this->booking->start_date->format('Y-m-d'),
            'end_date' => $this->booking->end_date->format('Y-m-d'),
            'total_amount' => $this->booking->total_amount,
        ];
    }
}
