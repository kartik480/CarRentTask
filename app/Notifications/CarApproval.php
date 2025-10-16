<?php

namespace App\Notifications;

use App\Models\Car;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class CarApproval extends Notification implements ShouldQueue
{
    use Queueable;

    protected $car;
    protected $status;

    /**
     * Create a new notification instance.
     */
    public function __construct(Car $car, string $status)
    {
        $this->car = $car;
        $this->status = $status;
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
        $subject = $this->status === 'approved' ? 'Car Approved - Car Rental System' : 'Car Rejected - Car Rental System';
        $greeting = $this->status === 'approved' ? 'Great news!' : 'We regret to inform you';
        
        $message = (new MailMessage)
            ->subject($subject)
            ->greeting($greeting)
            ->line('Your car listing has been ' . $this->status . '.')
            ->line('Car Details:')
            ->line('Name: ' . $this->car->name)
            ->line('Type: ' . $this->car->type)
            ->line('Location: ' . $this->car->location)
            ->line('Price per Day: $' . number_format($this->car->price_per_day, 2));

        if ($this->status === 'approved') {
            $message->line('Your car is now live and available for booking!')
                    ->action('View Your Car', url('/cars/' . $this->car->id))
                    ->line('You can manage your car listings from your supplier dashboard.');
        } else {
            $message->line('Please review your car listing and make necessary changes before resubmitting.')
                    ->action('Edit Your Car', url('/supplier/cars/' . $this->car->id . '/edit'))
                    ->line('If you have any questions, please contact our support team.');
        }

        return $message->salutation('Best regards, Car Rental System Team');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'car_id' => $this->car->id,
            'car_name' => $this->car->name,
            'status' => $this->status,
        ];
    }
}
