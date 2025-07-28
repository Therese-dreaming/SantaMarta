@component('mail::message')
# New Ticket Received

Dear Admin,

A new ticket has been submitted with the following details:

**Ticket Details:**
- From: {{ $ticket->user->name }}
- Email: {{ $ticket->user->email }}
- Subject: {{ $ticket->subject_type === 'others' ? $ticket->other_subject : ucfirst(str_replace('_', ' ', $ticket->subject_type)) }}
- Message: {{ $ticket->message }}
- Status: {{ ucfirst($ticket->status) }}
- Submitted: {{ $ticket->created_at->format('F j, Y, g:i a') }}

@component('mail::button', ['url' => route('admin.tickets.show', $ticket->id)])
View Ticket
@endcomponent

Best regards,<br>
{{ config('app.name') }}
@endcomponent