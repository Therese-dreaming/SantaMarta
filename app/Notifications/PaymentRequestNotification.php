<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\ServiceBooking;

class PaymentRequestNotification extends Notification
{
    use Queueable;

    protected $booking;

    public function __construct(ServiceBooking $booking)
    {
        $this->booking = $booking;
    }

    public function via($notifiable)
    {
        \Log::info('Sending payment request notification to: ' . $notifiable->email);
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Payment Required - ' . $this->booking->ticket_number)
            ->greeting('Hello ' . $notifiable->name . ',')
            ->line('Your service booking has been approved and is now pending payment.')
            ->line('Booking Details:')
            ->line('- Service Type: ' . ucfirst($this->booking->type))
            ->line('- Ticket Number: ' . $this->booking->ticket_number)
            ->line('- Amount Due: ₱' . number_format($this->booking->amount, 2))
            ->line('Please proceed with the payment to confirm your booking.')
            ->action('Make Payment', route('services.payment', $this->booking->id))
            ->line('Thank you for choosing our services!');
    }
}
