@component('mail::message')
# Message Received

Dear {{ $ticket->user->name }},

Thank you for contacting St. Martha Parish. We have received your message and will respond as soon as possible.

**Your Message Details:**
- Subject: {{ $ticket->subject_type === 'others' ? $ticket->other_subject : ucfirst(str_replace('_', ' ', $ticket->subject_type)) }}
- Message: {{ $ticket->message }}
- Submitted: {{ $ticket->created_at->format('F j, Y, g:i a') }}
- Reference Number: TICKET-{{ str_pad($ticket->id, 6, '0', STR_PAD_LEFT) }}

Please keep this reference number for future correspondence.

For urgent matters, you can contact us directly at:
- Phone: 0917-366-4359
- Email: diocesansaintmartha@gmail.com

Best regards,<br>
St. Martha Parish Team
@endcomponent