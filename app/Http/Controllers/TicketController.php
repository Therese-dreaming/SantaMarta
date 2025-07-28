<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\TicketCreated;
use App\Mail\TicketConfirmation; // Add this import

class TicketController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'subject_type' => 'required',
            'other_subject' => 'required_if:subject_type,others',
            'message' => 'required'
        ]);

        $ticket = Ticket::create([
            'user_id' => auth()->id(),
            'subject_type' => $request->subject_type,
            'other_subject' => $request->other_subject,
            'message' => $request->message,
            'status' => 'open'
        ]);

        // Send email to admin
        Mail::to('diocesansaintmartha@gmail.com')
            ->send(new TicketCreated($ticket));

        // Send confirmation email to user
        Mail::to($ticket->user->email)
            ->send(new TicketConfirmation($ticket));

        return redirect()->back()->with('success', 'Your message has been sent successfully!');
    }
}