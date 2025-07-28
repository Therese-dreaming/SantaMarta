<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Ticket;
use Illuminate\Http\Request;

class TicketController extends Controller
{
    /**
     * Display a listing of the tickets.
     */
    public function index()
    {
        $tickets = Ticket::with('user')->latest()->paginate(10);
        return view('admin.tickets.index', compact('tickets'));
    }

    /**
     * Display the specified ticket.
     */
    public function show(Ticket $ticket)
    {
        $ticket->load('user');
        return view('admin.tickets.show', compact('ticket'));
    }

    /**
     * Update the specified ticket status.
     */
    public function update(Request $request, Ticket $ticket)
    {
        $validated = $request->validate([
            'status' => 'required|in:open,in_progress,resolved,closed',
            'admin_notes' => 'nullable|string'
        ]);

        $ticket->update($validated);

        return redirect()->route('admin.tickets.show', $ticket)
            ->with('success', 'Ticket status updated successfully.');
    }
} 