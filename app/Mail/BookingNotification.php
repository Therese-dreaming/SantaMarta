<?php

namespace App\Mail;

use App\Models\ServiceBooking;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class BookingNotification extends Mailable
{
    use Queueable, SerializesModels;

    public $booking;
    public $emailSubject;
    public $emailMessage;

    /**
     * Create a new message instance.
     */
    public function __construct(ServiceBooking $booking, string $subject, string $message)
    {
        $this->booking = $booking;
        $this->emailSubject = $subject;
        $this->emailMessage = $message;
    }

    /**
     * Build the message.
     */
    public function build()
    {
        return $this->subject($this->emailSubject)
                    ->markdown('emails.bookings.notification', [
                        'booking' => $this->booking,
                        'message' => $this->emailMessage
                    ]);
    }
} 