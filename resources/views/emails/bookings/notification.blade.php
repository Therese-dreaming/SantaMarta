@component('mail::message')
# {{ $emailSubject }}

{!! nl2br(e($message)) !!}

## Booking Details
- Ticket Number: {{ $booking->ticket_number }}
- Service: {{ ucwords(str_replace('_', ' ', $booking->type)) }}
- Status: {{ ucwords(str_replace('_', ' ', $booking->status)) }}
- Date: {{ \Carbon\Carbon::parse($booking->preferred_date)->format('F d, Y') }}
- Time: {{ \Carbon\Carbon::parse($booking->preferred_time)->format('g:i A') }}

@component('mail::button', ['url' => route('services.my-bookings')])
View Booking Details
@endcomponent

Best regards,<br>
{{ config('app.name') }}
@endcomponent 