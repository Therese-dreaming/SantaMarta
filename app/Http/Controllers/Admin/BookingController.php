<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ServiceBooking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\BookingNotification;

class BookingController extends Controller
{
    /**
     * Show the email form for a booking.
     */
    public function showEmailForm(ServiceBooking $booking)
    {
        return view('admin.bookings.email', compact('booking'));
    }

    /**
     * Send an email to the user regarding their booking.
     */
    public function sendEmail(Request $request, ServiceBooking $booking)
    {
        $request->validate([
            'subject' => 'required|string',
            'message' => 'required|string',
        ]);

        // Send email
        Mail::to($booking->user->email)->send(new BookingNotification(
            $booking,
            $request->subject,
            $request->message
        ));

        return redirect()->back()->with('success', 'Email sent successfully.');
    }
} 