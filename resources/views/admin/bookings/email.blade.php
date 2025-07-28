@extends('layouts.admin')

@section('title', 'Email User - Booking #' . $booking->ticket_number)

@section('content')
<div class="container mx-auto px-4 py-6 font-sans">
    <!-- Back button -->
    <div class="mb-6">
        <a href="{{ route('admin.bookings.show', $booking->id) }}" class="inline-flex items-center px-4 py-2 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm text-gray-700 dark:text-gray-200 hover:bg-gray-50 dark:hover:bg-gray-600 transition-all duration-200">
            <i class="fas fa-arrow-left mr-2"></i> Back to Booking Details
        </a>
    </div>

    <!-- Email Form Card -->
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-md overflow-hidden border border-gray-100 dark:border-gray-700">
        <div class="p-6">
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white mb-6">Email User</h1>
            
            <!-- Booking Information -->
            <div class="mb-6 p-4 bg-gray-50 dark:bg-gray-700 rounded-lg">
                <h2 class="text-lg font-semibold text-gray-800 dark:text-white mb-2">Booking Information</h2>
                <p class="text-gray-600 dark:text-gray-300">Ticket #{{ $booking->ticket_number }}</p>
                <p class="text-gray-600 dark:text-gray-300">Service: {{ ucwords(str_replace('_', ' ', $booking->type)) }}</p>
                <p class="text-gray-600 dark:text-gray-300">User: {{ $booking->user->name }}</p>
            </div>

            <form action="{{ route('admin.bookings.send-email', $booking->id) }}" method="POST">
                @csrf
                
                <!-- Template Selection -->
                <div class="mb-6">
                    <label for="template" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Email Template</label>
                    <select id="template" name="template" class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-emerald-500 focus:ring-emerald-500">
                        <option value="payment_reminder">Payment Reminder</option>
                        <option value="document_ready">Document Ready</option>
                        <option value="booking_confirmed">Booking Confirmed</option>
                        <option value="custom_message">Custom Message</option>
                    </select>
                </div>

                <!-- Subject -->
                <div class="mb-6">
                    <label for="subject" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Subject</label>
                    <input type="text" id="subject" name="subject" class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-emerald-500 focus:ring-emerald-500" required>
                </div>

                <!-- Message -->
                <div class="mb-6">
                    <label for="message" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Message</label>
                    <textarea id="message" name="message" rows="6" class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-emerald-500 focus:ring-emerald-500" required></textarea>
                </div>

                <!-- Submit Button -->
                <div class="flex justify-end">
                    <button type="submit" class="px-6 py-2 bg-emerald-600 text-white rounded-lg hover:bg-emerald-700 transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2">
                        <i class="fas fa-paper-plane mr-2"></i> Send Email
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.getElementById('template').addEventListener('change', function() {
    const template = this.value;
    const subjectField = document.getElementById('subject');
    const messageField = document.getElementById('message');
    
    // Pre-fill subject and message based on template
    switch(template) {
        case 'payment_reminder':
            subjectField.value = 'Payment Reminder for Booking #{{ $booking->ticket_number }}';
            messageField.value = `Dear {{ $booking->user->name }},\n\nThis is a reminder that payment is required for your booking #{{ $booking->ticket_number }}. Please complete the payment to proceed with your request.\n\nBest regards,\nParish Team`;
            break;
        case 'document_ready':
            subjectField.value = 'Your Document is Ready - Booking #{{ $booking->ticket_number }}';
            messageField.value = `Dear {{ $booking->user->name }},\n\nYour requested document for booking #{{ $booking->ticket_number }} is now ready. You may visit the parish office to collect it.\n\nBest regards,\nParish Team`;
            break;
        case 'booking_confirmed':
            subjectField.value = 'Booking Confirmed - #{{ $booking->ticket_number }}';
            messageField.value = `Dear {{ $booking->user->name }},\n\nYour booking #{{ $booking->ticket_number }} has been confirmed. Thank you for choosing our services.\n\nBest regards,\nParish Team`;
            break;
        case 'custom_message':
            subjectField.value = '';
            messageField.value = '';
            break;
    }
});
</script>
@endsection