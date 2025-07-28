<?php

namespace App\Mail;

use App\Models\ServiceBooking;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class BookingEmail extends Mailable
{
    use SerializesModels;

    public $booking;
    public $emailSubject;
    public $emailMessage;

    public function __construct(ServiceBooking $booking, $subject, $message)
    {
        $this->booking = $booking;
        $this->emailSubject = $subject;
        $this->emailMessage = $message;
    }

    public function build()
    {
        return $this->subject($this->emailSubject)
                    ->markdown('emails.bookings.custom-message');
    }
}