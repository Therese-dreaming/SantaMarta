@extends('layouts.admin')

@section('title', 'Booking Details - #' . $booking->ticket_number)

@section('content')
<div class="container mx-auto px-4 py-6 font-sans">
    <!-- Back button with improved styling -->
    <div class="mb-6 flex justify-between items-center">
        <a href="{{ route('admin.bookings') }}" class="inline-flex items-center px-4 py-2 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm text-gray-700 dark:text-gray-200 hover:bg-gray-50 dark:hover:bg-gray-600 transition-all duration-200">
            <i class="fas fa-arrow-left mr-2"></i> Back to Bookings List
        </a>
        
        <!-- Admin Actions Dropdown -->
        <div class="relative" x-data="{ open: false }">
            <button @click="open = !open" class="inline-flex items-center px-4 py-2 bg-emerald-600 text-white rounded-lg hover:bg-emerald-700 transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2">
                <i class="fas fa-cog mr-2"></i> Actions
                <svg class="w-5 h-5 ml-2 -mr-1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                </svg>
            </button>
            <div x-show="open" @click.away="open = false" class="absolute right-0 mt-2 w-56 rounded-md shadow-lg bg-white dark:bg-gray-800 ring-1 ring-black ring-opacity-5 divide-y divide-gray-100 dark:divide-gray-700 focus:outline-none z-10" role="menu" aria-orientation="vertical" aria-labelledby="menu-button" tabindex="-1">
                <div class="py-1" role="none">
                    <!-- Conditional Actions -->
                    @if($booking->status === 'pending')
                        <button type="button" onclick="openHoldForPaymentModal({{ $booking->id }})" class="flex w-full items-center px-4 py-2 text-sm text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors">
                            <i class="fas fa-pause-circle mr-2 text-yellow-500"></i>
                            Hold for Payment
                        </button>
                        <button type="button" onclick="openCancelModal({{ $booking->id }})" class="flex w-full items-center px-4 py-2 text-sm text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors">
                            <i class="fas fa-times-circle mr-2 text-red-500"></i>
                            Cancel Booking
                        </button>
                    @endif

                    @if($booking->status === 'payment_on_hold')
                        @if($booking->payment_status === 'paid' && $booking->verification_status === 'pending')
                            <button type="button" onclick="openNewVerificationModal({{ $booking->id }}, '{{ $booking->type }}', {{ $booking->price ?? 0 }}, '{{ $booking->payment_method ?? 'N/A' }}', '{{ $booking->reference_number ?? 'N/A' }}', '{{ $booking->payment_proof ? asset('storage/' . $booking->payment_proof) : '' }}')" class="flex w-full items-center px-4 py-2 text-sm text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors">
                                <i class="fas fa-check-circle mr-2 text-blue-500"></i>
                                Verify Payment
                            </button>
                        @endif
                    @endif

                    @if($booking->payment_status === 'paid' && $booking->verification_status === 'verified' && $booking->status === 'approved')
                        <button type="button" data-booking-id="{{ $booking->id }}" class="release-document-button flex w-full items-center px-4 py-2 text-sm text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors">
                            <i class="fas fa-file-download mr-2 text-blue-500"></i>
                            Release Document
                        </button>
                    @endif

                    @if($booking->payment_status === 'paid' && $booking->verification_status !== 'pending' && $booking->status !== 'approved')
                        <button
                            onclick="openBookingDetailsModal({
                                id: {{ $booking->id }},
                                type: '{{ $booking->type }}',
                                amount: {{ $booking->price }},
                                payment_method: '{{ $booking->payment_method ?? 'N/A' }}',
                                payment_reference: '{{ $booking->reference_number ?? 'N/A' }}',
                                payment_proof_url: '{{ $booking->payment_proof ? asset('storage/' . $booking->payment_proof) : '' }}',
                                verification_status: '{{ $booking->verification_status }}',
                                verified_by_name: '{{ optional($booking->verifiedBy)->name ?? 'N/A' }}',
                                verified_at: '{{ $booking->verified_at }}',
                                verification_notes: '{{ $booking->verification_notes ?? 'No notes' }}'
                            })"
                            class="flex w-full items-center px-4 py-2 text-sm text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors"
                        >
                            <i class="fas fa-eye mr-2 text-gray-500"></i>
                            View Payment Details
                        </button>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Main content card with improved shadow and rounded corners -->
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-md overflow-hidden border border-gray-100 dark:border-gray-700">
        <!-- Header with service type color - Enhanced with larger icon and better spacing -->
        <div class="{{
            $booking->type === 'baptism' ? 'bg-sky-100 text-sky-800 dark:bg-sky-900 dark:text-sky-200' :
            ($booking->type === 'wedding' ? 'bg-rose-100 text-rose-800 dark:bg-rose-900 dark:text-rose-200' :
            ($booking->type === 'mass_intention' ? 'bg-indigo-100 text-indigo-800 dark:bg-indigo-900 dark:text-indigo-200' :
            ($booking->type === 'blessing' ? 'bg-amber-100 text-amber-800 dark:bg-amber-900 dark:text-amber-200' :
            ($booking->type === 'confirmation' ? 'bg-emerald-100 text-emerald-800 dark:bg-emerald-900 dark:text-emerald-200' :
            ($booking->type === 'sick_call' ? 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200' : 'bg-gray-100 text-gray-800 dark:bg-gray-900 dark:text-gray-200'))))) }}
            p-6">
            <div class="flex items-center justify-between">
                <div>
                    <div class="flex items-center">
                        <h1 class="text-2xl font-bold">{{$booking->type === 'mass_intention' ? 'Mass Intention' : ucwords(str_replace('_', ' ', $booking->type))}} Service</h1>
                        <span class="ml-3 px-3 py-1 text-xs font-medium rounded-full {{
                            $booking->status === 'pending' ? 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900/50 dark:text-yellow-300' :
                            ($booking->status === 'payment_on_hold' ? 'bg-blue-100 text-blue-800 dark:bg-blue-900/50 dark:text-blue-300' :
                            ($booking->status === 'approved' ? 'bg-emerald-100 text-emerald-800 dark:bg-emerald-900/50 dark:text-emerald-300' :
                            'bg-red-100 text-red-800 dark:bg-red-900/50 dark:text-red-300'))
                        }}">
                            {{ ucwords(str_replace('_', ' ', $booking->status)) }}
                        </span>
                    </div>
                    <p class="text-lg mt-1">Ticket #{{ $booking->ticket_number }}</p>
                    <p class="text-sm mt-1 text-gray-600 dark:text-gray-400">
                        Requestor:
                        <a href="{{ route('admin.users.show', $booking->user->id) }}" class="font-medium text-gray-900 dark:text-white hover:underline">
                            {{ $booking->user->name }}
                        </a>
                    </p>
                </div>
                <div class="w-16 h-16 rounded-full bg-white/90 dark:bg-gray-800/90 flex items-center justify-center shadow-md {{
                    $booking->type === 'baptism' ? 'text-sky-600 dark:text-sky-400' :
                    ($booking->type === 'wedding' ? 'text-rose-600 dark:text-rose-400' :
                    ($booking->type === 'mass_intention' ? 'text-indigo-600 dark:text-indigo-400' :
                    ($booking->type === 'blessing' ? 'text-amber-600 dark:text-amber-400' :
                    ($booking->type === 'confirmation' ? 'text-emerald-600 dark:text-emerald-400' :
                    ($booking->type === 'sick_call' ? 'text-red-600 dark:text-red-400' : 'text-gray-600 dark:text-gray-400'))))) }}">
                    <i class="fas {{
                        $booking->type === 'baptism' ? 'fa-water' :
                        ($booking->type === 'wedding' ? 'fa-rings-wedding' :
                        ($booking->type === 'mass_intention' ? 'fa-church' :
                        ($booking->type === 'blessing' ? 'fa-hands-praying' :
                        ($booking->type === 'confirmation' ? 'fa-dove' :
                        ($booking->type === 'sick_call' ? 'fa-hospital-user' : 'fa-circle'))))) }} text-3xl"></i>
                </div>
            </div>
        </div>

        <!-- Tabbed interface for better organization -->
        <div class="border-b border-gray-200 dark:border-gray-700">
            <nav class="-mb-px flex space-x-8 px-6" aria-label="Tabs">
                <button id="tab-overview" class="tab-button border-b-2 border-emerald-500 py-4 px-1 text-sm font-medium text-emerald-600 dark:text-emerald-400" aria-current="page">
                    <i class="fas fa-info-circle mr-2"></i>Overview
                </button>
                <button id="tab-details" class="tab-button border-b-2 border-transparent py-4 px-1 text-sm font-medium text-gray-500 hover:text-gray-700 hover:border-gray-300 dark:text-gray-400 dark:hover:text-gray-300 dark:hover:border-gray-600">
                    <i class="fas fa-list-ul mr-2"></i>Service Details
                </button>
                <button id="tab-documents" class="tab-button border-b-2 border-transparent py-4 px-1 text-sm font-medium text-gray-500 hover:text-gray-700 hover:border-gray-300 dark:text-gray-400 dark:hover:text-gray-300 dark:hover:border-gray-600">
                    <i class="fas fa-file-alt mr-2"></i>Documents
                </button>
                <button id="tab-payment" class="tab-button border-b-2 border-transparent py-4 px-1 text-sm font-medium text-gray-500 hover:text-gray-700 hover:border-gray-300 dark:text-gray-400 dark:hover:text-gray-300 dark:hover:border-gray-600">
                    <i class="fas fa-credit-card mr-2"></i>Payment
                </button>
                <!-- Removed the Actions tab since we moved it to the header -->
            </nav>
        </div>

        <!-- Tab content sections -->
        <div class="tab-content">
            <!-- Overview Tab (visible by default) -->
            <div id="content-overview" class="tab-pane">
                <!-- Status Cards - Redesigned as cards in a grid -->
                <div class="p-6 border-b border-gray-200 dark:border-gray-700">
                    <h2 class="text-lg font-semibold text-gray-800 dark:text-white mb-4">Booking Status</h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                        <!-- Status Card -->
                        <div class="bg-white dark:bg-gray-700 rounded-lg shadow-sm border border-gray-200 dark:border-gray-600 p-4">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-sm text-gray-500 dark:text-gray-400">Status</p>
                                    <div class="mt-1 flex items-center">
                                        <span class="h-3 w-3 rounded-full mr-2 {{
                                            $booking->status === 'pending' ? 'bg-yellow-500' :
                                            ($booking->status === 'payment_on_hold' ? 'bg-blue-500' :
                                            ($booking->status === 'approved' ? 'bg-emerald-500' : 'bg-red-500'))
                                        }}"></span>
                                        <p class="text-gray-900 dark:text-white font-medium">
                                            {{ ucwords(str_replace('_', ' ', $booking->status)) }}
                                        </p>
                                    </div>
                                </div>
                                <div class="{{
                                    $booking->status === 'pending' ? 'text-yellow-500' :
                                    ($booking->status === 'payment_on_hold' ? 'text-blue-500' :
                                    ($booking->status === 'approved' ? 'text-emerald-500' : 'text-red-500'))
                                }}">
                                    <i class="fas {{
                                        $booking->status === 'pending' ? 'fa-clock' :
                                        ($booking->status === 'payment_on_hold' ? 'fa-pause-circle' :
                                        ($booking->status === 'approved' ? 'fa-check-circle' : 'fa-times-circle'))
                                    }} text-2xl"></i>
                                </div>
                            </div>
                        </div>

                        <!-- Payment Status Card -->
                        <div class="bg-white dark:bg-gray-700 rounded-lg shadow-sm border border-gray-200 dark:border-gray-600 p-4">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-sm text-gray-500 dark:text-gray-400">Payment</p>
                                    <div class="mt-1 flex items-center">
                                        <span class="h-3 w-3 rounded-full mr-2 {{
                                            $booking->payment_status === 'pending' ? 'bg-yellow-500' :
                                            ($booking->payment_status === 'paid' ? 'bg-emerald-500' : 'bg-gray-500')
                                        }}"></span>
                                        <p class="text-gray-900 dark:text-white font-medium">
                                            {{ $booking->payment_status === 'pending' ? 'Payment Pending' :
                                               ($booking->payment_status === 'paid' ? 'Paid' : 'Not Paid') }}
                                        </p>
                                    </div>
                                </div>
                                <div class="{{
                                    $booking->payment_status === 'pending' ? 'text-yellow-500' :
                                    ($booking->payment_status === 'paid' ? 'text-emerald-500' : 'text-gray-500')
                                }}">
                                    <i class="fas {{
                                        $booking->payment_status === 'pending' ? 'fa-hourglass-half' :
                                        ($booking->payment_status === 'paid' ? 'fa-check-circle' : 'fa-times-circle')
                                    }} text-2xl"></i>
                                </div>
                            </div>
                        </div>

                        <!-- Verification Status Card (if applicable) -->
                        @if($booking->payment_status === 'paid')
                        <div class="bg-white dark:bg-gray-700 rounded-lg shadow-sm border border-gray-200 dark:border-gray-600 p-4">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-sm text-gray-500 dark:text-gray-400">Verification</p>
                                    <div class="mt-1 flex items-center">
                                        <span class="h-3 w-3 rounded-full mr-2 {{
                                            $booking->verification_status === 'pending' ? 'bg-yellow-500' :
                                            ($booking->verification_status === 'verified' ? 'bg-emerald-500' : 'bg-red-500')
                                        }}"></span>
                                        <p class="text-gray-900 dark:text-white font-medium">
                                            {{ ucwords(str_replace('_', ' ', $booking->verification_status)) }}
                                        </p>
                                    </div>
                                </div>
                                <div class="{{
                                    $booking->verification_status === 'pending' ? 'text-yellow-500' :
                                    ($booking->verification_status === 'verified' ? 'text-emerald-500' : 'text-red-500')
                                }}">
                                    <i class="fas {{
                                        $booking->verification_status === 'pending' ? 'fa-clock' :
                                        ($booking->verification_status === 'verified' ? 'fa-check-circle' : 'fa-times-circle')
                                    }} text-2xl"></i>
                                </div>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>

                <!-- Schedule Information - Enhanced with icons and better spacing -->
                <div class="p-6 border-b border-gray-200 dark:border-gray-700">
                    <h2 class="text-lg font-semibold text-gray-800 dark:text-white mb-4">Schedule Information</h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="flex items-start">
                            <div class="flex-shrink-0 h-10 w-10 rounded-full bg-emerald-100 dark:bg-emerald-900/30 flex items-center justify-center text-emerald-600 dark:text-emerald-400 mr-4">
                                <i class="fas fa-calendar-day text-lg"></i>
                            </div>
                            <div>
                                <p class="text-gray-600 dark:text-gray-400 text-sm">Date</p>
                                <p class="text-gray-900 dark:text-white font-medium text-lg">{{ Carbon\Carbon::parse($booking->preferred_date)->format('F d, Y') }}</p>
                            </div>
                        </div>
                        <div class="flex items-start">
                            <div class="flex-shrink-0 h-10 w-10 rounded-full bg-emerald-100 dark:bg-emerald-900/30 flex items-center justify-center text-emerald-600 dark:text-emerald-400 mr-4">
                                <i class="fas fa-clock text-lg"></i>
                            </div>
                            <div>
                                <p class="text-gray-600 dark:text-gray-400 text-sm">Time</p>
                                <p class="text-gray-900 dark:text-white font-medium text-lg">{{ Carbon\Carbon::parse($booking->preferred_time)->format('g:i A') }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Additional Notes (if any) -->
                @if($booking->notes)
                <div class="p-6 border-b border-gray-200 dark:border-gray-700">
                    <div class="flex items-start">
                        <div class="flex-shrink-0 h-10 w-10 rounded-full bg-blue-100 dark:bg-blue-900/30 flex items-center justify-center text-blue-600 dark:text-blue-400 mr-4">
                            <i class="fas fa-sticky-note text-lg"></i>
                        </div>
                        <div>
                            <h2 class="text-lg font-semibold text-gray-800 dark:text-white mb-2">Additional Notes</h2>
                            <div class="bg-gray-50 dark:bg-gray-700/50 p-4 rounded-lg border border-gray-200 dark:border-gray-600">
                                <p class="text-gray-700 dark:text-gray-300">{{ $booking->notes }}</p>
                            </div>
                        </div>
                    </div>
                </div>
                @endif
            </div>

            <!-- Service Details Tab -->
            <div id="content-details" class="tab-pane hidden">
                <div class="p-6 border-b border-gray-200 dark:border-gray-700">
                    <div class="flex items-center mb-6">
                        <div class="flex-shrink-0 h-10 w-10 rounded-full bg-indigo-100 dark:bg-indigo-900/30 flex items-center justify-center text-indigo-600 dark:text-indigo-400 mr-4">
                            <i class="fas {{
                                $booking->type === 'baptism' ? 'fa-water' :
                                ($booking->type === 'wedding' ? 'fa-rings-wedding' :
                                ($booking->type === 'mass_intention' ? 'fa-church' :
                                ($booking->type === 'blessing' ? 'fa-hands-praying' :
                                ($booking->type === 'confirmation' ? 'fa-dove' :
                                ($booking->type === 'sick_call' ? 'fa-hospital-user' : 'fa-circle'))))) }} text-lg"></i>
                        </div>
                        <h2 class="text-lg font-semibold text-gray-800 dark:text-white">Service Details</h2>
                    </div>

                    <!-- Service-specific details with improved layout -->
                    @if($booking->type === 'baptism' && $booking->baptismDetail)
                        <div class="bg-white dark:bg-gray-700 rounded-lg shadow-sm border border-gray-200 dark:border-gray-600 p-5">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Child's Name</p>
                                    <p class="mt-1 text-gray-900 dark:text-white font-medium">{{ $booking->baptismDetail->child_name }}</p>
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Baptism Type</p>
                                    <p class="mt-1 text-gray-900 dark:text-white font-medium">{{ ucfirst($booking->baptismDetail->baptism_type) }}</p>
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Date of Birth</p>
                                    <p class="mt-1 text-gray-900 dark:text-white font-medium">{{ Carbon\Carbon::parse($booking->baptismDetail->date_of_birth)->format('F d, Y') }}</p>
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Place of Birth</p>
                                    <p class="mt-1 text-gray-900 dark:text-white font-medium">{{ $booking->baptismDetail->place_of_birth }}</p>
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Father's Name</p>
                                    <p class="mt-1 text-gray-900 dark:text-white font-medium">{{ $booking->baptismDetail->father_name }}</p>
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Mother's Name</p>
                                    <p class="mt-1 text-gray-900 dark:text-white font-medium">{{ $booking->baptismDetail->mother_name }}</p>
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Nationality</p>
                                    <p class="mt-1 text-gray-900 dark:text-white font-medium">{{ $booking->baptismDetail->nationality }}</p>
                                </div>
                            </div>
                        </div>
                    @elseif($booking->type === 'wedding' && $booking->weddingDetail)
                        <div class="bg-white dark:bg-gray-700 rounded-lg shadow-sm border border-gray-200 dark:border-gray-600 p-5">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Groom's Name</p>
                                    <p class="mt-1 text-gray-900 dark:text-white font-medium">{{ $booking->weddingDetail->groom_name }}</p>
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Groom's Age</p>
                                    <p class="mt-1 text-gray-900 dark:text-white font-medium">{{ $booking->weddingDetail->groom_age }}</p>
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Groom's Religion</p>
                                    <p class="mt-1 text-gray-900 dark:text-white font-medium">{{ $booking->weddingDetail->groom_religion }}</p>
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Bride's Name</p>
                                    <p class="mt-1 text-gray-900 dark:text-white font-medium">{{ $booking->weddingDetail->bride_name }}</p>
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Bride's Age</p>
                                    <p class="mt-1 text-gray-900 dark:text-white font-medium">{{ $booking->weddingDetail->bride_age }}</p>
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Bride's Religion</p>
                                    <p class="mt-1 text-gray-900 dark:text-white font-medium">{{ $booking->weddingDetail->bride_religion }}</p>
                                </div>
                            </div>
                        </div>
                    @elseif($booking->type === 'mass_intention' && $booking->massIntentionDetail)
                        <div class="bg-white dark:bg-gray-700 rounded-lg shadow-sm border border-gray-200 dark:border-gray-600 p-5">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Mass Type</p>
                                    <p class="mt-1 text-gray-900 dark:text-white font-medium">{{ $booking->massIntentionDetail->mass_type }}</p>
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Mass Names</p>
                                    <p class="mt-1 text-gray-900 dark:text-white font-medium">{{ $booking->massIntentionDetail->mass_names }}</p>
                                </div>
                            </div>
                        </div>
                    @elseif($booking->type === 'blessing' && $booking->blessingDetail)
                        <div class="bg-white dark:bg-gray-700 rounded-lg shadow-sm border border-gray-200 dark:border-gray-600 p-5">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Blessing Type</p>
                                    <p class="mt-1 text-gray-900 dark:text-white font-medium">{{ $booking->blessingDetail->blessing_type }}</p>
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Blessing Location</p>
                                    <p class="mt-1 text-gray-900 dark:text-white font-medium">{{ $booking->blessingDetail->blessing_location }}</p>
                                </div>
                            </div>
                        </div>
                    @elseif($booking->type === 'confirmation' && $booking->confirmationDetail)
                        <div class="bg-white dark:bg-gray-700 rounded-lg shadow-sm border border-gray-200 dark:border-gray-600 p-5">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Confirmand's Name</p>
                                    <p class="mt-1 text-gray-900 dark:text-white font-medium">{{ $booking->confirmationDetail->confirmand_name }}</p>
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Date of Birth</p>
                                    <p class="mt-1 text-gray-900 dark:text-white font-medium">{{ Carbon\Carbon::parse($booking->confirmationDetail->confirmand_dob)->format('F d, Y') }}</p>
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Baptism Place</p>
                                    <p class="mt-1 text-gray-900 dark:text-white font-medium">{{ $booking->confirmationDetail->baptism_place }}</p>
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Baptism Date</p>
                                    <p class="mt-1 text-gray-900 dark:text-white font-medium">{{ Carbon\Carbon::parse($booking->confirmationDetail->baptism_date)->format('F d, Y') }}</p>
                                </div>
                            </div>
                        </div>
                    @elseif($booking->type === 'sick_call' && $booking->sickCallDetail)
                        <div class="bg-white dark:bg-gray-700 rounded-lg shadow-sm border border-gray-200 dark:border-gray-600 p-5">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Patient's Name</p>
                                    <p class="mt-1 text-gray-900 dark:text-white font-medium">{{ $booking->sickCallDetail->patient_name }}</p>
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Patient's Address</p>
                                    <p class="mt-1 text-gray-900 dark:text-white font-medium">{{ $booking->sickCallDetail->patient_address }}</p>
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Patient's Condition</p>
                                    <p class="mt-1 text-gray-900 dark:text-white font-medium">{{ $booking->sickCallDetail->patient_condition }}</p>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Documents Tab -->
            <div id="content-documents" class="tab-pane hidden">
                <div class="p-6 border-b border-gray-200 dark:border-gray-700">
                    <div class="flex items-center mb-6">
                        <div class="flex-shrink-0 h-10 w-10 rounded-full bg-amber-100 dark:bg-amber-900/30 flex items-center justify-center text-amber-600 dark:text-amber-400 mr-4">
                            <i class="fas fa-file-alt text-lg"></i>
                        </div>
                        <h2 class="text-lg font-semibold text-gray-800 dark:text-white">Uploaded Documents</h2>
                    </div>

                    @if($booking->documents->count() > 0)
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            @foreach($booking->documents as $document)
                            <div class="flex items-center p-4 bg-white dark:bg-gray-700 rounded-lg shadow-sm border border-gray-200 dark:border-gray-600 hover:shadow-md transition-shadow duration-200">
                                <div class="h-10 w-10 rounded-full bg-amber-100 dark:bg-amber-900/30 flex items-center justify-center text-amber-600 dark:text-amber-400 mr-3">
                                    <i class="fas fa-file-alt"></i>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <p class="text-gray-900 dark:text-white font-medium truncate">{{ ucwords(str_replace('_', ' ', $document->document_type)) }}</p>
                                    <p class="text-sm text-gray-500 dark:text-gray-400">Uploaded {{ $document->created_at->diffForHumans() }}</p>
                                </div>
                                <a href="{{ Storage::url($document->file_path) }}" target="_blank" class="ml-4 flex-shrink-0 p-2 text-blue-600 dark:text-blue-400 hover:text-blue-800 dark:hover:text-blue-300 bg-blue-50 dark:bg-blue-900/20 rounded-full hover:bg-blue-100 dark:hover:bg-blue-900/40 transition-colors">
                                    <i class="fas fa-download"></i>
                                </a>
                            </div>
                            @endforeach
                        </div>
                    @else
                        <div class="bg-gray-50 dark:bg-gray-700/50 rounded-lg p-6 text-center">
                            <div class="mx-auto h-16 w-16 rounded-full bg-gray-100 dark:bg-gray-800 flex items-center justify-center text-gray-400 dark:text-gray-500 mb-4">
                                <i class="fas fa-file-alt text-2xl"></i>
                            </div>
                            <h3 class="text-gray-500 dark:text-gray-400 text-lg font-medium">No Documents Uploaded</h3>
                            <p class="text-gray-500 dark:text-gray-400 mt-1">There are no documents attached to this booking.</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Payment Tab -->
            <div id="content-payment" class="tab-pane hidden">
                <div class="p-6 border-b border-gray-200 dark:border-gray-700">
                    <div class="flex items-center mb-6">
                        <div class="flex-shrink-0 h-10 w-10 rounded-full bg-green-100 dark:bg-green-900/30 flex items-center justify-center text-green-600 dark:text-green-400 mr-4">
                            <i class="fas fa-credit-card text-lg"></i>
                        </div>
                        <h2 class="text-lg font-semibold text-gray-800 dark:text-white">Payment Information</h2>
                    </div>

                    @if($booking->payment_status === 'paid')
                        <div class="bg-white dark:bg-gray-700 rounded-lg shadow-sm border border-gray-200 dark:border-gray-600 p-5">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Amount Paid</p>
                                    <p class="mt-1 text-gray-900 dark:text-white font-medium text-lg">₱{{ number_format($booking->price, 2) }}</p>
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Payment Date</p>
                                    <p class="mt-1 text-gray-900 dark:text-white font-medium">{{ $booking->paid_at ? Carbon\Carbon::parse($booking->paid_at)->format('F d, Y g:i A') : 'N/A' }}</p>
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Payment Method</p>
                                    <p class="mt-1 text-gray-900 dark:text-white font-medium">{{ $booking->payment_method ? ucwords(str_replace('_', ' ', $booking->payment_method)) : 'N/A' }}</p>
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Reference Number</p>
                                    <p class="mt-1 text-gray-900 dark:text-white font-medium">{{ $booking->reference_number ?? 'N/A' }}</p>
                                </div>
                            </div>

                            @if($booking->payment_proof)
                                <div class="mt-6 border-t border-gray-200 dark:border-gray-600 pt-6">
                                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-3">Payment Proof</p>
                                    <div class="bg-gray-50 dark:bg-gray-800 p-4 rounded-lg border border-gray-200 dark:border-gray-600 text-center">
                                        <a href="{{ asset('storage/' . $booking->payment_proof) }}" target="_blank" class="inline-block">
                                            <img src="{{ asset('storage/' . $booking->payment_proof) }}" alt="Payment Proof" class="max-h-64 rounded-lg shadow-sm mx-auto">
                                        </a>
                                    </div>
                                </div>
                            @endif

                            @if($booking->verification_status !== 'pending')
                                <div class="mt-6 border-t border-gray-200 dark:border-gray-600 pt-6">
                                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-3">Verification Details</p>
                                    <div class="bg-gray-50 dark:bg-gray-800 p-4 rounded-lg border border-gray-200 dark:border-gray-600">
                                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                            <div>
                                                <p class="text-sm text-gray-500 dark:text-gray-400">Status</p>
                                                <p class="mt-1 font-medium {{ $booking->verification_status === 'verified' ? 'text-emerald-600 dark:text-emerald-400' : 'text-red-600 dark:text-red-400' }}">
                                                    {{ ucwords(str_replace('_', ' ', $booking->verification_status)) }}
                                                </p>
                                            </div>
                                            <div>
                                                <p class="text-sm text-gray-500 dark:text-gray-400">Verified By</p>
                                                <p class="mt-1 text-gray-900 dark:text-white font-medium">{{ optional($booking->verifiedBy)->name ?? 'N/A' }}</p>
                                            </div>
                                            <div>
                                                <p class="text-sm text-gray-500 dark:text-gray-400">Verified At</p>
                                                <p class="mt-1 text-gray-900 dark:text-white font-medium">{{ $booking->verified_at ? Carbon\Carbon::parse($booking->verified_at)->format('M d, Y g:i A') : 'N/A' }}</p>
                                            </div>
                                            @if($booking->verification_notes)
                                                <div class="md:col-span-2">
                                                    <p class="text-sm text-gray-500 dark:text-gray-400">Notes</p>
                                                    <p class="mt-1 text-gray-900 dark:text-white">{{ $booking->verification_notes }}</p>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>
                    @else
                        <div class="bg-gray-50 dark:bg-gray-700/50 rounded-lg p-6 text-center">
                            <div class="mx-auto h-16 w-16 rounded-full bg-gray-100 dark:bg-gray-800 flex items-center justify-center text-gray-400 dark:text-gray-500 mb-4">
                                <i class="fas fa-credit-card text-2xl"></i>
                            </div>
                            <h3 class="text-gray-500 dark:text-gray-400 text-lg font-medium">No Payment Information</h3>
                            <p class="text-gray-500 dark:text-gray-400 mt-1">This booking has not been paid for yet.</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Actions Tab removed - functionality moved to dropdown in header -->
        </div>
    </div>
</div>

{{-- Include admin modals here --}}
@include('partials.approve-modal')
@include('partials.cancel-modal')
@include('partials.new-verification-modal')

<!-- Hold for Payment Modal -->
<div id="holdForPaymentModal" class="fixed inset-0 bg-black/60 backdrop-blur-sm hidden items-center justify-center z-50 transition-opacity duration-300 font-sans">
    <div class="bg-white dark:bg-gray-800 rounded-xl p-6 max-w-md w-full mx-4 shadow-2xl transform transition-transform duration-300 scale-95 opacity-0" id="holdForPaymentModalContent">
        <!-- Header -->
        <div class="flex items-center mb-4">
            <div class="bg-yellow-100 dark:bg-yellow-900/30 p-2 rounded-full mr-3">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-yellow-600 dark:text-yellow-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
            <h3 class="text-xl font-bold text-gray-900 dark:text-white">Confirm Hold for Payment</h3>
        </div>
        
        <!-- Content -->
        <p class="text-gray-700 dark:text-gray-300 mb-6 pl-12">Are you sure you want to put this booking on hold for payment? This will notify the user to make a payment.</p>
        
        <!-- Form -->
        <form id="holdForPaymentForm" method="POST">
            @csrf
            <div class="flex justify-end gap-3 mt-8">
                <button 
                    type="button" 
                    onclick="closeHoldForPaymentModal()" 
                    class="px-4 py-2 bg-gray-200 text-gray-800 dark:bg-gray-700 dark:text-white rounded-lg hover:bg-gray-300 dark:hover:bg-gray-600 transition-colors focus:outline-none focus:ring-2 focus:ring-gray-300 dark:focus:ring-gray-600"
                    aria-label="Cancel hold for payment"
                >
                    Cancel
                </button>
                <button 
                    type="submit" 
                    class="px-4 py-2 bg-yellow-500 text-white rounded-lg hover:bg-yellow-600 transition-colors focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 flex items-center"
                    aria-label="Confirm hold for payment"
                >
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    Confirm Hold
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Payment Verification Modal -->
<div id="paymentVerificationModal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50 font-sans">
    <div class="relative top-20 mx-auto p-5 border w-full max-w-xl shadow-lg rounded-md bg-white dark:bg-gray-800">
        <div class="mt-3">
            <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Verify Payment</h3>
            <div class="payment-details space-y-4 mb-6 text-gray-700 dark:text-gray-300">
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Service Type</label>
                    <p class="mt-1 text-sm text-gray-900 dark:text-white" id="modal-service-type"></p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Amount Paid</label>
                    <p class="mt-1 text-sm text-gray-900 dark:text-white" id="modal-amount"></p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Payment Method</label>
                    <p class="mt-1 text-sm text-gray-900 dark:text-white" id="modal-payment-method"></p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Reference Number</label>
                    <p class="mt-1 text-sm text-gray-900 dark:text-white" id="modal-reference-number"></p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Proof of Payment</label>
                    <img id="modal-payment-proof" class="mt-2 max-w-full h-auto rounded-lg" src="" alt="Payment Proof">
                </div>
            </div>
            <div class="verification-form">
                <form id="verificationForm" class="space-y-4">
                     @csrf
                    <input type="hidden" name="_method" value="PUT"> {{-- Use PUT method for updates --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Verification Status</label>
                        <select id="verificationStatus" name="verification_status" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                            <option value="verified">Verify Payment</option>
                            <option value="rejected">Reject Payment</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Notes (Optional)</label>
                        <textarea id="verificationNotes" name="verification_notes" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white" placeholder="Add any verification notes here..."></textarea>
                    </div>
                </form>
            </div>
            <div class="mt-6 flex justify-end space-x-3">
                <button onclick="closeVerificationModal()" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-md hover:bg-gray-300 dark:bg-gray-700 dark:text-white dark:hover:bg-gray-600">Cancel</button>
                <button onclick="submitVerification()" class="px-4 py-2 bg-emerald-600 text-white rounded-md hover:bg-emerald-700">Submit Verification</button>
            </div>
        </div>
    </div>
</div>

<!-- Booking Details Modal (for Verified/Rejected Payment Info) -->
<div id="bookingDetailsModal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50 font-sans">
    <div class="relative top-20 mx-auto p-5 border w-full max-w-md shadow-lg rounded-md bg-white dark:bg-gray-800">
        <div class="mt-3">
            <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Payment & Verification Details</h3>
            <div class="payment-verification-details space-y-4 text-gray-700 dark:text-gray-300">
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Service Type</label>
                    <p class="mt-1 text-sm text-gray-900 dark:text-white" id="viewServiceType"></p>
                </div>
                 <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Amount Paid</label>
                    <p class="mt-1 text-sm text-gray-900 dark:text-white" id="viewServiceAmount"></p>
                </div>
                 <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Payment Method</label>
                    <p class="mt-1 text-sm text-gray-900 dark:text-white" id="viewPaymentMethod"></p>
                </div>
                 <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Reference Number</label>
                    <p class="mt-1 text-sm text-gray-900 dark:text-white" id="viewReferenceNumber"></p>
                </div>
                 <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Payment Proof</label>
                    <img id="viewPaymentProof" class="mt-2 max-w-full h-auto rounded-lg" src="" alt="Payment Proof">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Verification Status</label>
                    <p class="mt-1 text-sm font-medium" id="viewVerificationStatus"></p>
                </div>
                 <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Verified By</label>
                    <p class="mt-1 text-sm text-gray-900 dark:text-white" id="viewVerifiedBy"></p>
                </div>
                 <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Verified At</label>
                    <p class="mt-1 text-sm text-gray-900 dark:text-white" id="viewVerifiedAt"></p>
                </div>
                 <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Verification Notes</label>
                    <p class="mt-1 text-sm text-gray-900 dark:text-white" id="viewVerificationNotes"></p>
                </div>
            </div>
            <div class="mt-6 flex justify-end">
                <button onclick="closeBookingDetailsModal()" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-md hover:bg-gray-300 dark:bg-gray-700 dark:text-white dark:hover:bg-gray-600">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- Loading Overlay -->
<div id="loadingOverlay" class="hidden fixed inset-0 bg-gray-900 bg-opacity-50 flex items-center justify-center z-50 font-sans">
    <div class="bg-white dark:bg-gray-800 p-8 rounded-lg flex flex-col items-center shadow-xl max-w-sm w-full mx-4">
        <div class="relative">
            <!-- Outer spinning circle -->
            <div class="animate-spin rounded-full h-16 w-16 border-4 border-emerald-200 dark:border-emerald-700"></div>
            <!-- Inner spinning circle -->
            <div class="animate-spin rounded-full h-16 w-16 border-t-4 border-emerald-500 absolute top-0 dark:border-t-emerald-400"></div>
            <!-- Document icon in center -->
            <svg class="h-8 w-8 text-emerald-500 absolute top-4 left-4 dark:text-emerald-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
            </svg>
        </div>
        <p class="text-gray-700 dark:text-gray-200 mt-4 font-medium">Processing...</p>
        <p class="text-gray-500 dark:text-gray-400 text-sm mt-2">This may take a few moments</p>
    </div>
</div>

@endsection

@push('scripts')
<script>
    // JavaScript for modals and actions on the details page

    // Tab functionality
    document.addEventListener('DOMContentLoaded', function() {
        const tabButtons = document.querySelectorAll('.tab-button');
        const tabPanes = document.querySelectorAll('.tab-pane');
        
        tabButtons.forEach(button => {
            button.addEventListener('click', function() {
                // Remove active class from all buttons
                tabButtons.forEach(btn => {
                    btn.classList.remove('border-emerald-500', 'text-emerald-600', 'dark:text-emerald-400');
                    btn.classList.add('border-transparent', 'text-gray-500', 'dark:text-gray-400');
                });
                
                // Add active class to clicked button
                this.classList.remove('border-transparent', 'text-gray-500', 'dark:text-gray-400');
                this.classList.add('border-emerald-500', 'text-emerald-600', 'dark:text-emerald-400');
                
                // Hide all tab panes
                tabPanes.forEach(pane => {
                    pane.classList.add('hidden');
                });
                
                // Show the corresponding tab pane
                const tabId = this.id.replace('tab-', 'content-');
                document.getElementById(tabId).classList.remove('hidden');
            });
        });
    });

// Update these functions in your show.blade.php file
function openHoldForPaymentModal(bookingId) {
    const modal = document.getElementById('holdForPaymentModal');
    const modalContent = document.getElementById('holdForPaymentModalContent');
    
    document.getElementById('holdForPaymentForm').action = `/admin/bookings/${bookingId}/hold-for-payment`;
    
    // Show modal with animation
    modal.classList.remove('hidden');
    modal.classList.add('flex');
    
    // Trigger animation after a small delay
    setTimeout(() => {
        modalContent.classList.remove('scale-95', 'opacity-0');
        modalContent.classList.add('scale-100', 'opacity-100');
    }, 10);
    
    // Add event listener for ESC key
    document.addEventListener('keydown', closeModalOnEsc);
    
    // Add event listener for clicking outside
    modal.addEventListener('click', closeModalOnOutsideClick);
}

function closeHoldForPaymentModal() {
    const modal = document.getElementById('holdForPaymentModal');
    const modalContent = document.getElementById('holdForPaymentModalContent');
    
    // Animate out
    modalContent.classList.remove('scale-100', 'opacity-100');
    modalContent.classList.add('scale-95', 'opacity-0');
    
    // Hide modal after animation completes
    setTimeout(() => {
        modal.classList.remove('flex');
        modal.classList.add('hidden');
    }, 200);
    
    // Remove event listeners
    document.removeEventListener('keydown', closeModalOnEsc);
    modal.removeEventListener('click', closeModalOnOutsideClick);
}

// Helper functions for modal interactions
function closeModalOnEsc(e) {
    if (e.key === 'Escape') {
        const activeModals = document.querySelectorAll('.fixed.inset-0:not(.hidden)');
        activeModals.forEach(modal => {
            if (modal.id === 'holdForPaymentModal') closeHoldForPaymentModal();
            if (modal.id === 'cancelModal') closeCancelModal();
            if (modal.id === 'approveModal') closeApproveModal();
            if (modal.id === 'newVerificationModal') closeNewVerificationModal();
            // Add other modals as needed
        });
    }
}

function closeModalOnOutsideClick(e) {
    if (e.target === this) {
        if (this.id === 'holdForPaymentModal') closeHoldForPaymentModal();
        if (this.id === 'cancelModal') closeCancelModal();
        if (this.id === 'approveModal') closeApproveModal();
        if (this.id === 'newVerificationModal') closeNewVerificationModal();
        // Add other modals as needed
    }
}

    // Payment Verification Modal
    function openVerificationModal(bookingId, serviceType, amount, paymentMethod, referenceNumber, proofUrl) {
        document.getElementById('paymentVerificationModal').classList.remove('hidden');
        document.getElementById('modal-service-type').textContent = serviceType.replace('_', ' ').replace(/\b\w/g, l => l.toUpperCase());
        document.getElementById('modal-amount').textContent = `₱${amount.toFixed(2)}`;
        document.getElementById('modal-payment-method').textContent = paymentMethod;
        document.getElementById('modal-reference-number').textContent = referenceNumber;
        
        if (proofUrl) {
            document.getElementById('modal-payment-proof').src = proofUrl;
            document.getElementById('modal-payment-proof').classList.remove('hidden');
        } else {
            document.getElementById('modal-payment-proof').classList.add('hidden');
        }
        
        // Set the form action URL
        document.getElementById('verificationForm').action = `/admin/bookings/${bookingId}/verify-payment`;
    }

    function closeVerificationModal() {
        document.getElementById('paymentVerificationModal').classList.add('hidden');
    }

    function submitVerification() {
        // Show loading overlay
        document.getElementById('loadingOverlay').classList.remove('hidden');
        
        // Get form data
        const status = document.getElementById('verificationStatus').value;
        const notes = document.getElementById('verificationNotes').value;
        const form = document.getElementById('verificationForm');
        const actionUrl = form.action;
        
        // Create form data
        const formData = new FormData();
        formData.append('verification_status', status);
        formData.append('verification_notes', notes);
        formData.append('_token', document.querySelector('meta[name="csrf-token"]').getAttribute('content'));
        formData.append('_method', 'PUT');
        
        // Submit form via fetch
        fetch(actionUrl, {
            method: 'POST',
            body: formData
        })
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then(data => {
            // Hide loading overlay
            document.getElementById('loadingOverlay').classList.add('hidden');
            
            // Close modal
            closeVerificationModal();
            
            // Reload page to show updated status
            window.location.reload();
        })
        .catch(error => {
            console.error('Error:', error);
            document.getElementById('loadingOverlay').classList.add('hidden');
            alert('There was an error processing your request. Please try again.');
        });
    }

    // Booking Details Modal
    function openBookingDetailsModal(details) {
        document.getElementById('bookingDetailsModal').classList.remove('hidden');
        
        // Populate modal with booking details
        document.getElementById('viewServiceType').textContent = details.type.replace('_', ' ').replace(/\b\w/g, l => l.toUpperCase());
        document.getElementById('viewServiceAmount').textContent = `₱${details.amount.toFixed(2)}`;
        document.getElementById('viewPaymentMethod').textContent = details.payment_method;
        document.getElementById('viewReferenceNumber').textContent = details.payment_reference;
        
        if (details.payment_proof_url) {
            document.getElementById('viewPaymentProof').src = details.payment_proof_url;
            document.getElementById('viewPaymentProof').classList.remove('hidden');
        } else {
            document.getElementById('viewPaymentProof').classList.add('hidden');
        }
        
        // Set verification status with appropriate color
        const statusElement = document.getElementById('viewVerificationStatus');
        statusElement.textContent = details.verification_status.charAt(0).toUpperCase() + details.verification_status.slice(1);
        
        if (details.verification_status === 'verified') {
            statusElement.classList.add('text-emerald-600', 'dark:text-emerald-400');
            statusElement.classList.remove('text-red-600', 'dark:text-red-400');
        } else {
            statusElement.classList.add('text-red-600', 'dark:text-red-400');
            statusElement.classList.remove('text-emerald-600', 'dark:text-emerald-400');
        }
        
        document.getElementById('viewVerifiedBy').textContent = details.verified_by_name;
        
        // Format the verification date if it exists
        if (details.verified_at) {
            const date = new Date(details.verified_at);
            document.getElementById('viewVerifiedAt').textContent = date.toLocaleString();
        } else {
            document.getElementById('viewVerifiedAt').textContent = 'N/A';
        }
        
        document.getElementById('viewVerificationNotes').textContent = details.verification_notes;
    }

    function closeBookingDetailsModal() {
        document.getElementById('bookingDetailsModal').classList.add('hidden');
    }

    // Document release form submission
    document.addEventListener('DOMContentLoaded', function() {
        const releaseButtons = document.querySelectorAll('.release-document-button');

        releaseButtons.forEach(button => {
            button.addEventListener('click', function(e) {
                e.preventDefault();
                
                const bookingId = this.getAttribute('data-booking-id');
                const formAction = '{{ url("/admin/bookings") }}/' + bookingId + '/release-document';
                // Show loading overlay
                document.getElementById('loadingOverlay').classList.remove('hidden');

                // Submit the action via fetch
                fetch(formAction, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                })
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.json();
                })
                .then(data => {
                    // Hide loading overlay
                    document.getElementById('loadingOverlay').classList.add('hidden');
                    
                    // Reload page or redirect as needed
                    if (data.redirect) {
                        window.location.href = data.redirect;
                    } else {
                        window.location.reload();
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    document.getElementById('loadingOverlay').classList.add('hidden');
                    alert('There was an error processing your request. Please try again.');
                });
            });
        });
    });

    // Cancel Modal
    function openCancelModal(bookingId) {
        document.getElementById('cancelModal').classList.remove('hidden');
        document.getElementById('cancelModal').classList.add('flex');
        // Set the form action for the cancel modal
        document.getElementById('cancelForm').action = '{{ url("/admin/bookings") }}/' + bookingId + '/cancel';
    }

    function closeCancelModal() {
        document.getElementById('cancelModal').classList.remove('flex');
        document.getElementById('cancelModal').classList.add('hidden');
    }
</script>
@endpush