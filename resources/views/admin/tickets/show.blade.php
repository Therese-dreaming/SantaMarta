@extends('layouts.admin')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="mb-6">
        <h1 class="text-3xl font-bold text-gray-800">Ticket Details</h1>
        <p class="text-gray-600">Ticket #{{ $ticket->id }}</p>
    </div>

    <div class="bg-white rounded-lg shadow-md p-6">
        <!-- Ticket Information -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
            <div>
                <h2 class="text-xl font-semibold mb-4">User Information</h2>
                <div class="space-y-2">
                    <p><span class="font-medium">Name:</span> {{ $ticket->user->name }}</p>
                    <p><span class="font-medium">Email:</span> {{ $ticket->user->email }}</p>
                    <p><span class="font-medium">Created:</span> {{ $ticket->created_at->format('F j, Y g:i A') }}</p>
                </div>
            </div>
            <div>
                <h2 class="text-xl font-semibold mb-4">Ticket Status</h2>
                <form action="{{ route('admin.tickets.update', $ticket) }}" method="POST" class="space-y-4">
                    @csrf
                    @method('PUT')
                    <div>
                        <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
                        <select name="status" id="status" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-[#0d5c2f] focus:ring-[#0d5c2f]">
                            <option value="open" {{ $ticket->status === 'open' ? 'selected' : '' }}>Open</option>
                            <option value="in_progress" {{ $ticket->status === 'in_progress' ? 'selected' : '' }}>In Progress</option>
                            <option value="resolved" {{ $ticket->status === 'resolved' ? 'selected' : '' }}>Resolved</option>
                            <option value="closed" {{ $ticket->status === 'closed' ? 'selected' : '' }}>Closed</option>
                        </select>
                    </div>
                    <div>
                        <label for="admin_notes" class="block text-sm font-medium text-gray-700">Admin Notes</label>
                        <textarea name="admin_notes" id="admin_notes" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-[#0d5c2f] focus:ring-[#0d5c2f]">{{ $ticket->admin_notes }}</textarea>
                    </div>
                    <button type="submit" class="bg-[#0d5c2f] text-white px-4 py-2 rounded-md hover:bg-[#0d5c2f]/90">
                        Update Status
                    </button>
                </form>
            </div>
        </div>

        <!-- Message Content -->
        <div class="mt-8">
            <h2 class="text-xl font-semibold mb-4">Message</h2>
            <div class="bg-gray-50 rounded-lg p-4">
                <p class="mb-4"><span class="font-medium">Subject:</span> 
                    @if($ticket->subject_type === 'others')
                        {{ $ticket->other_subject }}
                    @else
                        {{ str_replace('_', ' ', ucfirst($ticket->subject_type)) }}
                    @endif
                </p>
                <div class="prose max-w-none">
                    {{ $ticket->message }}
                </div>
            </div>
        </div>
    </div>

    <div class="mt-6">
        <a href="{{ route('admin.tickets.index') }}" class="text-[#0d5c2f] hover:underline">
            <i class="fas fa-arrow-left mr-2"></i>Back to Tickets
        </a>
    </div>
</div>
@endsection 