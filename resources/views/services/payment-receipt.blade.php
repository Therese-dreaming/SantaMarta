@extends('layouts.user')

@section('title', 'Payment Receipt')

@section('content')
    <div class="container mx-auto px-4 py-8">
        <div class="max-w-3xl mx-auto bg-white dark:bg-gray-800 rounded-lg shadow-sm p-8">
            <!-- Header with Church Logo and Name -->
            <div class="text-center mb-8 border-b pb-6">
                <img src="{{ asset('images/church-logo.png') }}" alt="Church Logo" class="mx-auto h-20 mb-4">
                <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Santa Marta Parish</h1>
                <p class="text-gray-600 dark:text-gray-400">Official Payment Receipt</p>
            </div>

            <!-- Receipt Header -->
            <div class="flex justify-between items-start mb-8">
                <div>
                    <h2 class="text-2xl font-semibold text-gray-800 dark:text-white">Payment Receipt</h2>
                    <p class="text-gray-600 dark:text-gray-400">Transaction ID: {{ $booking->ticket_number }}</p>
                </div>
                <button onclick="window.print()"
                    class="print-hide px-4 py-2 bg-emerald-600 text-white rounded-lg hover:bg-emerald-700 transition-colors duration-150">
                    <i class="fas fa-print mr-2"></i>Print Receipt
                </button>
            </div>

            <!-- Main Content -->
            <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-6 mb-8">
                <div class="grid md:grid-cols-2 gap-8">
                    <!-- Booking Information -->
                    <div class="bg-white dark:bg-gray-800 rounded-lg p-6 shadow-sm">
                        <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-4 flex items-center">
                            <i class="fas fa-calendar-alt mr-2 text-emerald-600"></i>
                            Booking Information
                        </h2>
                        <dl class="space-y-4">
                            <div>
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Service Type</dt>
                                <dd class="text-lg font-medium text-gray-900 dark:text-white">{{ ucfirst($booking->type) }}
                                </dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Schedule</dt>
                                <dd class="text-gray-900 dark:text-white">
                                    {{ Carbon\Carbon::parse($booking->preferred_date)->format('M d, Y') }}
                                    <br>
                                    {{ Carbon\Carbon::parse($booking->preferred_time)->format('g:i A') }}
                                </dd>
                            </div>
                        </dl>
                    </div>

                    <!-- Payment Details -->
                    <div class="bg-white dark:bg-gray-800 rounded-lg p-6 shadow-sm">
                        <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-4 flex items-center">
                            <i class="fas fa-credit-card mr-2 text-emerald-600"></i>
                            Payment Details
                        </h2>
                        <dl class="space-y-4">
                            <div>
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Amount Paid</dt>
                                <dd class="text-3xl font-bold text-emerald-600 dark:text-emerald-400">
                                    ₱{{ number_format($booking->amount, 2) }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Payment Method</dt>
                                <dd class="text-gray-900 dark:text-white flex items-center">
                                    <i
                                        class="fas {{ $booking->payment_method === 'gcash' ? 'fa-mobile-alt' : 'fa-university' }} mr-2"></i>
                                    {{ ucfirst($booking->payment_method) }}
                                </dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Reference Number</dt>
                                <dd class="text-gray-900 dark:text-white font-mono">{{ $booking->payment_reference }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Payment Date</dt>
                                <dd class="text-gray-900 dark:text-white">
                                    {{ Carbon\Carbon::parse($booking->paid_at)->format('M d, Y g:i A') }}
                                </dd>
                            </div>
                        </dl>
                    </div>
                </div>
            </div>

            <!-- Payment Proof -->
            <div class="mb-8">
                <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-4 flex items-center">
                    <i class="fas fa-image mr-2 text-emerald-600"></i>
                    Payment Proof
                </h2>
                <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4">
                    <img src="{{ asset('storage/' . $booking->payment_proof) }}" alt="Payment Proof"
                        class="max-w-full h-auto rounded-lg mx-auto">
                </div>
            </div>

            <!-- Footer -->
            <div class="text-center border-t pt-6">
                <div class="mb-4">
                    <p class="text-emerald-600 dark:text-emerald-400 font-medium">Payment Verified</p>
                </div>
                <p class="text-gray-600 dark:text-gray-400 text-sm">
                    Thank you for your payment. This serves as your official receipt.
                    <br>Please keep this document for your records.
                </p>
                <p class="text-gray-500 dark:text-gray-500 text-xs mt-2">
                    Santa Marta Parish • Diocese of Pasig
                    <br>{{ Carbon\Carbon::now()->format('Y') }} © All rights reserved
                </p>
            </div>
        </div>
    </div>

    <style>
        @media print {
            @page {
                size: A4;
                margin: 0.5in;
            }

            body {
                visibility: hidden;
                print-color-adjust: exact;
                -webkit-print-color-adjust: exact;
            }

            .container {
                visibility: visible;
                position: absolute;
                left: 0;
                top: 0;
                width: 100%;
                padding: 20px;
            }

            /* Hide specific elements */
            header,
            footer,
            nav,
            .print-hide,
            button {
                display: none !important;
            }

            .print-hide {
                display: none !important;
            }

            /* Force background colors in print */
            .bg-gray-50 {
                background-color: #F9FAFB !important;
            }

            .bg-white {
                background-color: #FFFFFF !important;
            }

            .text-emerald-600 {
                color: #059669 !important;
            }

            /* Ensure shadows print */
            .shadow-sm {
                box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05) !important;
            }
        }
    </style>
@endsection
