<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\ServiceBooking;

class ServiceBookingNotification extends Notification
{
    use Queueable;

    protected $booking;

    public function __construct(ServiceBooking $booking)
    {
        $this->booking = $booking;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Service Booking Confirmation - ' . $this->booking->ticket_number)
            ->greeting('Hello ' . $notifiable->name . ',')
            ->line('Your service booking has been successfully placed.')
            ->line('Service Details:')
            ->line('- Service Type: ' . ucfirst($this->booking->type))
            ->line('- Ticket Number: ' . $this->booking->ticket_number)
            ->line('- Preferred Date: ' . $this->booking->preferred_date)
            ->line('- Preferred Time: ' . $this->booking->preferred_time)
            ->line('- Status: Pending')
            ->line('Please wait for our staff to review your documents and booking details.')
            ->action('View Booking Details', route('services.my-bookings'))
            ->line('Thank you for choosing our services!');
    }
}
