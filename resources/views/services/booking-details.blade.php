@extends('layouts.user')

@section('title', 'Booking Details')

@section('content')
<div class="container mx-auto px-4 py-8 font-sans">
    <!-- Back button -->
    <div class="mb-6">
        <a href="{{ route('services.my-bookings') }}" class="inline-flex items-center text-gray-600 dark:text-gray-400 hover:text-gray-800 dark:hover:text-gray-200 transition-colors">
            <i class="fas fa-arrow-left mr-2"></i> Back to My Bookings
        </a>
    </div>

    <!-- Main content card -->
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-md overflow-hidden border border-gray-100 dark:border-gray-700">
        <!-- Header with service type color -->
        <div class="{{ 
            $booking->type === 'baptism' ? 'bg-sky-100 text-sky-800 dark:bg-sky-900 dark:text-sky-200' : 
            ($booking->type === 'wedding' ? 'bg-rose-100 text-rose-800 dark:bg-rose-900 dark:text-rose-200' : 
            ($booking->type === 'mass_intention' ? 'bg-indigo-100 text-indigo-800 dark:bg-indigo-900 dark:text-indigo-200' : 
            ($booking->type === 'blessing' ? 'bg-amber-100 text-amber-800 dark:bg-amber-900 dark:text-amber-200' : 
            ($booking->type === 'confirmation' ? 'bg-emerald-100 text-emerald-800 dark:bg-emerald-900/50 dark:text-emerald-300' : 
            ($booking->type === 'sick_call' ? 'bg-red-100 text-red-800 dark:bg-red-900/50 dark:text-red-200' : 'bg-gray-100 text-gray-800 dark:bg-gray-900 dark:text-gray-200'))))) }} 
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
                </div>
                <div class="flex items-center space-x-4">
                    @if($booking->status === 'payment_on_hold' && $booking->payment_status !== 'paid')
                    <a href="{{ route('services.payment', $booking->id) }}" class="inline-flex items-center px-4 py-2 bg-[#0d5c2f] text-white rounded-lg hover:bg-[#0d5c2f]/90 transition-colors text-sm">
                        <i class="fas fa-money-bill mr-2"></i>
                        Pay Now
                    </a>
                    @endif
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
        </div>

        <!-- Tabbed interface -->
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
            </nav>
        </div>

        <!-- Tab content sections -->
        <div class="tab-content">
            <!-- Overview Tab (visible by default) -->
            <div id="content-overview" class="tab-pane">
                <!-- Status Cards -->
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
                    </div>
                </div>

                <!-- Schedule Information -->
                <div class="p-6 border-b border-gray-200 dark:border-gray-700">
                    <div class="flex items-start">
                        <div class="flex-shrink-0 h-10 w-10 rounded-full bg-emerald-100 dark:bg-emerald-900/30 flex items-center justify-center text-emerald-600 dark:text-emerald-400 mr-4">
                            <i class="fas fa-calendar-day text-lg"></i>
                        </div>
                        <div>
                            <h2 class="text-lg font-semibold text-gray-800 dark:text-white mb-2">Schedule Information</h2>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Date</p>
                                    <p class="mt-1 text-gray-900 dark:text-white font-medium">{{ Carbon\Carbon::parse($booking->preferred_date)->format('F d, Y') }}</p>
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Time</p>
                                    <p class="mt-1 text-gray-900 dark:text-white font-medium">{{ Carbon\Carbon::parse($booking->preferred_time)->format('g:i A') }}</p>
                                </div>
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

                    {{-- Service-specific details with improved layout --}}
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
                                <p class="mt-1 text-gray-900 dark:text-white font-medium">{{ Carbon\Carbon::parse($booking->confirmationDetail->baptism_place)->format('F d, Y') }}</p>
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
                                <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Location</p>
                                <p class="mt-1 text-gray-900 dark:text-white font-medium">{{ $booking->sickCallDetail->location }}</p>
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
                    {{-- Display Payment Details when paid --}}
                    <div class="bg-white dark:bg-gray-700 rounded-lg shadow-sm border border-gray-200 dark:border-gray-600 p-5 space-y-6"> {{-- Added space-y-6 --}}

                        {{-- Payment Completed Message --}}
                        <div class="bg-emerald-50 dark:bg-emerald-900/30 border border-emerald-200 dark:border-emerald-800 rounded-lg p-4"> {{-- Removed mb-6 --}}
                            <div class="flex">
                                <div class="flex-shrink-0">
                                    <i class="fas fa-check-circle text-emerald-400 text-xl"></i>
                                </div>
                                <div class="ml-3">
                                    <h3 class="text-sm font-medium text-emerald-800 dark:text-emerald-300">Payment Completed</h3>
                                    <div class="mt-2 text-sm text-emerald-700 dark:text-emerald-200">
                                        <p>Your payment has been successfully processed.</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <h4 class="text-md font-semibold text-gray-800 dark:text-white">Transaction Details</h4> {{-- Removed mb-4 --}}

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6"> {{-- Grid for core details --}}
                            <div>
                                <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Amount Paid</p>
                                <p class="mt-1 text-gray-900 dark:text-white font-medium text-lg flex items-center"><i class="fas fa-dollar-sign mr-2 text-emerald-500"></i>₱{{ number_format($booking->amount, 2) }}</p>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Payment Date</p>
                                <p class="mt-1 text-gray-900 dark:text-white font-medium flex items-center"><i class="fas fa-calendar-alt mr-2 text-blue-500"></i>{{ $booking->paid_at ? Carbon\Carbon::parse($booking->paid_at)->format('F d, Y g:i A') : 'N/A' }}</p>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Payment Method</p>
                                <p class="mt-1 text-gray-900 dark:text-white font-medium flex items-center"><i class="fas fa-credit-card mr-2 text-purple-500"></i>{{ $booking->payment_method ? ucwords(str_replace('_', ' ', $booking->payment_method)) : 'N/A' }}</p>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Reference Number</p>
                                <p class="mt-1 text-gray-900 dark:text-white font-medium flex items-center"><i class="fas fa-hashtag mr-2 text-teal-500"></i>{{ $booking->payment_reference ?? 'N/A' }}</p>
                            </div>
                        </div>

                        @if($booking->payment_proof)
                        <div class="mt-6 border-t border-gray-200 dark:border-gray-600 pt-6"> {{-- Separator --}}
                            <p class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-3">Payment Proof</p>
                            <div class="bg-gray-50 dark:bg-gray-800 p-4 rounded-lg border border-gray-200 dark:border-gray-600 text-center"> {{-- Proof Image Card --}}
                                <a href="{{ asset('storage/' . $booking->payment_proof) }}" target="_blank" class="inline-block">
                                    <img src="{{ asset('storage/' . $booking->payment_proof) }}" alt="Payment Proof" class="max-h-64 rounded-lg shadow-sm mx-auto">
                                    <p class="mt-2 text-blue-600 dark:text-blue-400 hover:underline">View Full Image</p>
                                </a>
                            </div>
                        </div>
                        @endif

                        {{-- Verification Status (always show when paid) --}}
                        <div class="mt-6 border-t border-gray-200 dark:border-gray-600 pt-6"> {{-- Separator --}}
                            <p class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-3">Verification Status</p>
                            <div class="flex items-center"> {{-- Status indicator --}}
                                <span class="h-3 w-3 rounded-full mr-2 {{ $booking->verification_status === 'verified' ? 'bg-emerald-500' : ($booking->verification_status === 'rejected' ? 'bg-red-500' : 'bg-yellow-500') }}"></span>
                                <p class="mt-1 font-medium {{ $booking->verification_status === 'verified' ? 'text-emerald-600 dark:text-emerald-400' : ($booking->verification_status === 'rejected' ? 'text-red-600 dark:text-red-400' : 'text-yellow-600 dark:text-yellow-400') }}">
                                    {{ ucwords(str_replace('_', ' ', $booking->verification_status)) }}
                                </p>
                            </div>
                            @if($booking->verification_status === 'rejected' && $booking->verification_notes)
                            <div class="mt-4 text-sm text-gray-700 dark:text-gray-300"> {{-- Admin Notes for rejection --}}
                                <p class="font-medium text-gray-800 dark:text-white mb-1">Admin Notes:</p>
                                <p>{{ $booking->verification_notes }}</p>
                            </div>
                            @endif
                        </div>

                    </div>

                    @else
                    {{-- Display Pay Now button and message when not paid --}}
                    <div class="p-6 text-center">
                        @if($booking->status === 'payment_on_hold' && $booking->payment_status !== 'paid')
                        <div class="mx-auto h-16 w-16 rounded-full bg-gray-100 dark:bg-gray-800 flex items-center justify-center text-gray-400 dark:text-gray-500 mb-4">
                            <i class="fas fa-credit-card text-2xl"></i>
                        </div>
                        <h3 class="text-gray-500 dark:text-gray-400 text-lg font-medium">Payment Required</h3>
                        <p class="text-gray-500 dark:text-gray-400 mt-1">Please complete the payment for your booking to proceed.</p>
                        @else
                        {{-- Placeholder when payment not required/pending --}}
                        <div class="mx-auto h-16 w-16 rounded-full bg-gray-100 dark:bg-gray-800 flex items-center justify-center text-gray-400 dark:text-gray-500 mb-4">
                            <i class="fas fa-credit-card text-2xl"></i>
                        </div>
                        <h3 class="text-gray-500 dark:text-gray-400 text-lg font-medium">No Payment Information</h3>
                        <p class="text-gray-500 dark:text-gray-400 mt-1">This booking has not been paid for yet.</p>
                        @endif
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Actions -->
    <div class="mt-6">
        <div class="flex flex-wrap gap-3">
            <a href="{{ route('services.my-bookings') }}" class="inline-flex items-center px-4 py-2 bg-gray-200 text-gray-800 dark:bg-gray-700 dark:text-white rounded-lg hover:bg-gray-300 dark:hover:bg-gray-600 transition-colors">
                <i class="fas fa-arrow-left mr-2"></i>
                Back to My Bookings
            </a>

            @if($booking->status === 'pending' || $booking->status === 'payment_on_hold')
            <button onclick="openCancelModal()" class="inline-flex items-center px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors">
                <i class="fas fa-times mr-2"></i>
                Cancel Booking
            </button>
            @endif

            {{-- Link to generate certificate if approved and payment verified --}}
            @if($booking->status === 'approved' && $booking->payment_status === 'paid' && $booking->verification_status === 'verified')
            <a href="{{ route('bookings.generateCertificate', $booking->id) }}" class="inline-flex items-center px-4 py-2 bg-emerald-600 text-white rounded-lg hover:bg-emerald-700 transition-colors">
                <i class="fas fa-file-download mr-2"></i>
                Download Certificate
            </a>
            @endif
        </div>
    </div>
</div>

{{-- Cancel Confirmation Modal --}}
@if($booking->status === 'pending' || $booking->status === 'payment_on_hold')
<div id="cancelModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center hidden">
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-xl max-w-md w-full mx-4">
        <div class="p-6">
            <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-4">Cancel Booking</h3>
            <p class="text-gray-700 dark:text-gray-300 mb-6">Are you sure you want to cancel this booking? This action cannot be undone.</p>

            <div class="flex justify-end gap-3">
                <button type="button" onclick="closeCancelModal()" class="px-4 py-2 bg-gray-200 text-gray-800 dark:bg-gray-700 dark:text-white rounded-lg hover:bg-gray-300 dark:hover:bg-gray-600 transition-colors">
                    No, Keep Booking
                </button>
                <form id="cancelForm" action="{{ route('bookings.cancel', $booking->id) }}" method="POST">
                    @csrf
                    <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors">
                        Yes, Cancel Booking
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const tabButtons = document.querySelectorAll('.tab-button');
        const tabPanes = document.querySelectorAll('.tab-pane');

        // Show the first tab by default
        tabPanes.forEach((pane, index) => {
            if (index === 0) {
                pane.classList.remove('hidden');
            } else {
                pane.classList.add('hidden');
            }
        });

        tabButtons.forEach(button => {
            button.addEventListener('click', function() {
                console.log('Tab clicked:', this.id);
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

    function openCancelModal() {
        document.getElementById('cancelModal').classList.remove('hidden');
        document.getElementById('cancelModal').classList.add('flex');
    }
    function closeCancelModal() {
        document.getElementById('cancelModal').classList.remove('flex');
        document.getElementById('cancelModal').classList.add('hidden');
    }
</script>

@endif
@endsection
