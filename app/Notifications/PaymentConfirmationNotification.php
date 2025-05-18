<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\ServiceBooking;

class PaymentConfirmationNotification extends Notification
{
    use Queueable;

    protected $booking;

    public function __construct(ServiceBooking $booking)
    {
        $this->booking = $booking;
    }

    public function via($notifiable)
    {
        \Log::info('Sending payment confirmation notification to: ' . $notifiable->email);
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Payment Receipt - ' . $this->booking->ticket_number)
            ->greeting('Hello ' . $notifiable->name . ',')
            ->line('Thank you for your payment. Here is your payment receipt:')
            ->line('Payment Details:')
            ->line('- Service Type: ' . ucfirst($this->booking->type))
            ->line('- Ticket Number: ' . $this->booking->ticket_number)
            ->line('- Amount Paid: ₱' . number_format($this->booking->amount, 2))
            ->line('- Payment Method: ' . ucfirst($this->booking->payment_method))
            ->line('- Reference Number: ' . $this->booking->payment_reference)
            ->line('- Payment Date: ' . $this->booking->paid_at->format('F d, Y g:i A'))
            ->line('Your payment is now being verified by our staff. We will notify you once it has been confirmed.')
            ->action('View Payment Receipt', route('services.payment.receipt', $this->booking->id))
            ->line('Thank you for choosing our services!');
    }
}
