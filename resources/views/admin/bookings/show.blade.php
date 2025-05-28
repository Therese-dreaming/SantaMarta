@extends('layouts.admin')

@section('title', 'Booking Details')

@section('content')
<div class="container px-6 mx-auto py-8">
    <div class="mb-6">
        <a href="{{ url()->previous() }}" class="inline-flex items-center text-emerald-600 hover:text-emerald-700 dark:text-emerald-400 dark:hover:text-emerald-300">
            <i class="fas fa-arrow-left mr-2"></i> Back
        </a>
    </div>

    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-6">
        <h1 class="text-2xl font-semibold text-gray-700 dark:text-gray-200">
            Booking #{{ $booking->ticket_number }}
        </h1>
        <div class="flex gap-2">
            <!-- Removed Approve and Cancel buttons -->
            @if($booking->status === 'approved' && !$booking->payment_status == 'paid')
            <form action="{{ route('admin.bookings.hold_for_payment', $booking->id) }}" method="POST" class="inline">
                @csrf
                <button type="submit" class="bg-yellow-600 hover:bg-yellow-700 text-white px-4 py-2 rounded-lg">
                    <i class="fas fa-clock mr-2"></i> Hold for Payment
                </button>
            </form>
            @endif
        </div>
    </div>

    <!-- Status Badge -->
    <div class="mb-6">
        <span class="px-3 py-1 text-sm font-medium rounded-full 
            @if($booking->status == 'approved') bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200
            @elseif($booking->status == 'pending') bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200
            @elseif($booking->status == 'cancelled') bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200
            @elseif($booking->status == 'payment_on_hold') bg-orange-100 text-orange-800 dark:bg-orange-900 dark:text-orange-200
            @endif">
            {{ ucfirst(str_replace('_', ' ', $booking->status)) }}
        </span>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Booking Information -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6">
            <h2 class="text-lg font-medium text-gray-700 dark:text-gray-300 mb-4 border-b pb-2">Booking Information</h2>
            
            <div class="space-y-3">
                <div>
                    <p class="text-sm text-gray-500 dark:text-gray-400">Service Type</p>
                    <p class="font-medium text-gray-800 dark:text-gray-200">{{ ucfirst(str_replace('_', ' ', $booking->type)) }}</p>
                </div>
                
                <div>
                    <p class="text-sm text-gray-500 dark:text-gray-400">Preferred Date</p>
                    <p class="font-medium text-gray-800 dark:text-gray-200">{{ \Carbon\Carbon::parse($booking->preferred_date)->format('F d, Y') }}</p>
                </div>
                
                <div>
                    <p class="text-sm text-gray-500 dark:text-gray-400">Preferred Time</p>
                    <p class="font-medium text-gray-800 dark:text-gray-200">
                        @php
                            $time = \Carbon\Carbon::parse($booking->preferred_time);
                            echo $time->format('g:i A');
                        @endphp
                    </p>
                </div>
                
                <div>
                    <p class="text-sm text-gray-500 dark:text-gray-400">Created On</p>
                    <p class="font-medium text-gray-800 dark:text-gray-200">{{ $booking->created_at->format('F d, Y g:i A') }}</p>
                </div>
                
                <div>
                    <p class="text-sm text-gray-500 dark:text-gray-400">Last Updated</p>
                    <p class="font-medium text-gray-800 dark:text-gray-200">{{ $booking->updated_at->format('F d, Y g:i A') }}</p>
                </div>
            </div>
        </div>
        
        <!-- Client Information -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6">
            <h2 class="text-lg font-medium text-gray-700 dark:text-gray-300 mb-4 border-b pb-2">Client Information</h2>
            
            <div class="space-y-3">
                <div>
                    <p class="text-sm text-gray-500 dark:text-gray-400">Name</p>
                    <p class="font-medium text-gray-800 dark:text-gray-200">{{ $booking->user->name }}</p>
                </div>
                
                <div>
                    <p class="text-sm text-gray-500 dark:text-gray-400">Email</p>
                    <p class="font-medium text-gray-800 dark:text-gray-200">{{ $booking->user->email }}</p>
                </div>
                
                <div>
                    <p class="text-sm text-gray-500 dark:text-gray-400">Phone</p>
                    <p class="font-medium text-gray-800 dark:text-gray-200">{{ $booking->user->phone ?? 'Not provided' }}</p>
                </div>
                
                <div>
                    <p class="text-sm text-gray-500 dark:text-gray-400">Address</p>
                    <p class="font-medium text-gray-800 dark:text-gray-200">{{ $booking->user->address ?? 'Not provided' }}</p>
                </div>
            </div>
        </div>
        
        <!-- Add this after the booking information section -->
        <!-- Payment Information -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6">
            <h2 class="text-lg font-medium text-gray-700 dark:text-gray-300 mb-4 border-b pb-2">Payment Information</h2>
            
            @if($booking->payment_status == 'paid')
            <div class="space-y-3">
                <div>
                    <p class="text-sm text-gray-500 dark:text-gray-400">Payment Status</p>
                    <p class="font-medium text-green-600 dark:text-green-400">Paid</p>
                </div>
                
                <div>
                    <p class="text-sm text-gray-500 dark:text-gray-400">Payment Method</p>
                    <p class="font-medium text-gray-800 dark:text-gray-200">{{ ucfirst($booking->payment_method ?? 'N/A') }}</p>
                </div>
                
                <div>
                    <p class="text-sm text-gray-500 dark:text-gray-400">Reference Number</p>
                    <p class="font-medium text-gray-800 dark:text-gray-200">{{ $booking->payment_reference ?? 'N/A' }}</p>
                </div>
                
                <div>
                    <p class="text-sm text-gray-500 dark:text-gray-400">Paid At</p>
                    <p class="font-medium text-gray-800 dark:text-gray-200">
                        {{ $booking->paid_at ? \Carbon\Carbon::parse($booking->paid_at)->format('F d, Y h:i A') : 'N/A' }}
                    </p>
                </div>
                
                @if($booking->payment_proof)
                <div>
                    <p class="text-sm text-gray-500 dark:text-gray-400">Payment Proof</p>
                    <a href="{{ asset('storage/' . $booking->payment_proof) }}" target="_blank" class="text-emerald-600 hover:text-emerald-700 dark:text-emerald-400 dark:hover:text-emerald-300">
                        <i class="fas fa-file-image mr-1"></i> View Payment Proof
                    </a>
                </div>
                @endif
            </div>
            @else
            <p class="text-gray-600 dark:text-gray-400">No payment information available.</p>
            @endif
        </div>
    </div>
    
    <!-- Service Details -->
    <div class="mt-6 bg-white dark:bg-gray-800 rounded-lg shadow-md p-6">
        <h2 class="text-lg font-medium text-gray-700 dark:text-gray-300 mb-4 border-b pb-2">Service Details</h2>
        
        @if($details)
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                @if($booking->type == 'baptism' && $details)
                    <div>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Child's Name</p>
                        <p class="font-medium text-gray-800 dark:text-gray-200">{{ $details->child_name }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Date of Birth</p>
                        <p class="font-medium text-gray-800 dark:text-gray-200">{{ \Carbon\Carbon::parse($details->date_of_birth)->format('F d, Y') }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Place of Birth</p>
                        <p class="font-medium text-gray-800 dark:text-gray-200">{{ $details->place_of_birth }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Father's Name</p>
                        <p class="font-medium text-gray-800 dark:text-gray-200">{{ $details->father_name }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Mother's Name</p>
                        <p class="font-medium text-gray-800 dark:text-gray-200">{{ $details->mother_name }}</p>
                    </div>
                @elseif($booking->type == 'wedding' && $details)
                    <div>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Groom's Name</p>
                        <p class="font-medium text-gray-800 dark:text-gray-200">{{ $details->groom_name }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Bride's Name</p>
                        <p class="font-medium text-gray-800 dark:text-gray-200">{{ $details->bride_name }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Groom's Address</p>
                        <p class="font-medium text-gray-800 dark:text-gray-200">{{ $details->groom_address }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Bride's Address</p>
                        <p class="font-medium text-gray-800 dark:text-gray-200">{{ $details->bride_address }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Groom's Birthdate</p>
                        <p class="font-medium text-gray-800 dark:text-gray-200">{{ \Carbon\Carbon::parse($details->groom_birthdate)->format('F d, Y') }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Bride's Birthdate</p>
                        <p class="font-medium text-gray-800 dark:text-gray-200">{{ \Carbon\Carbon::parse($details->bride_birthdate)->format('F d, Y') }}</p>
                    </div>
                @elseif($booking->type == 'confirmation' && $details)
                    <div>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Confirmand's Name</p>
                        <p class="font-medium text-gray-800 dark:text-gray-200">{{ $details->confirmand_name }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Date of Birth</p>
                        <p class="font-medium text-gray-800 dark:text-gray-200">{{ \Carbon\Carbon::parse($details->date_of_birth)->format('F d, Y') }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Place of Birth</p>
                        <p class="font-medium text-gray-800 dark:text-gray-200">{{ $details->place_of_birth }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Father's Name</p>
                        <p class="font-medium text-gray-800 dark:text-gray-200">{{ $details->father_name }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Mother's Name</p>
                        <p class="font-medium text-gray-800 dark:text-gray-200">{{ $details->mother_name }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Sponsor's Name</p>
                        <p class="font-medium text-gray-800 dark:text-gray-200">{{ $details->sponsor_name }}</p>
                    </div>
                @elseif($booking->type == 'mass_intention' && $details)
                    <div>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Intention Type</p>
                        <p class="font-medium text-gray-800 dark:text-gray-200">{{ ucfirst($details->intention_type) }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Person's Name</p>
                        <p class="font-medium text-gray-800 dark:text-gray-200">{{ $details->person_name }}</p>
                    </div>
                    <div class="md:col-span-2">
                        <p class="text-sm text-gray-500 dark:text-gray-400">Special Instructions</p>
                        <p class="font-medium text-gray-800 dark:text-gray-200">{{ $details->special_instructions ?? 'None' }}</p>
                    </div>
                @elseif($booking->type == 'blessing' && $details)
                    <div>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Blessing Type</p>
                        <p class="font-medium text-gray-800 dark:text-gray-200">{{ ucfirst(str_replace('_', ' ', $details->blessing_type)) }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Location</p>
                        <p class="font-medium text-gray-800 dark:text-gray-200">{{ $details->location }}</p>
                    </div>
                    <div class="md:col-span-2">
                        <p class="text-sm text-gray-500 dark:text-gray-400">Special Instructions</p>
                        <p class="font-medium text-gray-800 dark:text-gray-200">{{ $details->special_instructions ?? 'None' }}</p>
                    </div>
                @elseif($booking->type == 'sick_call' && $details)
                    <div>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Patient's Name</p>
                        <p class="font-medium text-gray-800 dark:text-gray-200">{{ $details->patient_name }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Location</p>
                        <p class="font-medium text-gray-800 dark:text-gray-200">{{ $details->location }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Contact Person</p>
                        <p class="font-medium text-gray-800 dark:text-gray-200">{{ $details->contact_person }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Contact Number</p>
                        <p class="font-medium text-gray-800 dark:text-gray-200">{{ $details->contact_number }}</p>
                    </div>
                    <div class="md:col-span-2">
                        <p class="text-sm text-gray-500 dark:text-gray-400">Special Instructions</p>
                        <p class="font-medium text-gray-800 dark:text-gray-200">{{ $details->special_instructions ?? 'None' }}</p>
                    </div>
                @endif
            </div>
        @else
        <div class="text-center py-6">
            <div class="text-gray-400 dark:text-gray-500 mb-2">
                <i class="fas fa-info-circle text-3xl"></i>
            </div>
            <p class="text-gray-500 dark:text-gray-400">No service details available.</p>
        </div>
    @endif
</div>
</div>

<!-- Documents Section -->
<div class="mt-6 bg-white dark:bg-gray-800 rounded-lg shadow-md p-6">
<h2 class="text-lg font-medium text-gray-700 dark:text-gray-300 mb-4 border-b pb-2">Documents</h2>

@if(isset($documents) && count($documents) > 0)
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
        @foreach($documents as $document)
            <div class="border border-gray-200 dark:border-gray-700 rounded-lg overflow-hidden">
                <div class="p-4">
                    <div class="flex items-center justify-between mb-2">
                        <h3 class="text-sm font-medium text-gray-700 dark:text-gray-300">{{ $document->document_type }}</h3>
                        <span class="text-xs text-gray-500 dark:text-gray-400">{{ $document->created_at->format('M d, Y') }}</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <a href="{{ asset('storage/' . $document->file_path) }}" target="_blank" class="text-emerald-600 hover:text-emerald-700 dark:text-emerald-400 dark:hover:text-emerald-300 text-sm">
                            <i class="fas fa-eye mr-1"></i> View
                        </a>
                        <a href="{{ asset('storage/' . $document->file_path) }}" download class="text-blue-600 hover:text-blue-700 dark:text-blue-400 dark:hover:text-blue-300 text-sm">
                            <i class="fas fa-download mr-1"></i> Download
                        </a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@else
    <div class="text-center py-6">
        <div class="text-gray-400 dark:text-gray-500 mb-2">
            <i class="fas fa-file-alt text-3xl"></i>
        </div>
        <p class="text-gray-500 dark:text-gray-400">No documents uploaded.</p>
    </div>
@endif
</div>

<!-- Notes and Admin Comments -->
<div class="mt-6 grid grid-cols-1 md:grid-cols-2 gap-6">
<!-- Client Notes -->
<div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6">
    <h2 class="text-lg font-medium text-gray-700 dark:text-gray-300 mb-4 border-b pb-2">Client Notes</h2>
    
    @if($booking->notes)
        <div class="p-4 bg-gray-50 dark:bg-gray-700 rounded-lg">
            <p class="text-gray-700 dark:text-gray-300">{{ $booking->notes }}</p>
        </div>
    @else
        <div class="text-center py-6">
            <div class="text-gray-400 dark:text-gray-500 mb-2">
                <i class="fas fa-sticky-note text-3xl"></i>
            </div>
            <p class="text-gray-500 dark:text-gray-400">No notes provided by client.</p>
        </div>
    @endif
</div>

<!-- Admin Comments -->
<div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6">
    <h2 class="text-lg font-medium text-gray-700 dark:text-gray-300 mb-4 border-b pb-2">Admin Comments</h2>
    
    @if($booking->admin_notes)
        <div class="p-4 bg-gray-50 dark:bg-gray-700 rounded-lg mb-4">
            <p class="text-gray-700 dark:text-gray-300">{{ $booking->admin_notes }}</p>
        </div>
    @else
        <div class="text-center py-2 mb-4">
            <p class="text-gray-500 dark:text-gray-400">No admin comments yet.</p>
        </div>
    @endif
    
    <form action="{{ route('admin.bookings.update-notes', $booking->id) }}" method="POST">
        @csrf
        <div class="mb-4">
            <label for="admin_notes" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Add/Update Comments</label>
            <textarea id="admin_notes" name="admin_notes" rows="3" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-emerald-500 focus:border-emerald-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white">{{ $booking->admin_notes }}</textarea>
        </div>
        <button type="submit" class="bg-emerald-600 hover:bg-emerald-700 text-white px-4 py-2 rounded-lg w-full">
            <i class="fas fa-save mr-2"></i> Save Comments
        </button>
    </form>
</div>
</div>

<!-- Print Certificate Button (for approved bookings) -->
@if(in_array($booking->status, ['approved', 'completed']))
<div class="mt-6 flex justify-end">
    <a href="{{ route('admin.bookings.generate-certificate', $booking->id) }}" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg inline-flex items-center">
        <i class="fas fa-file-pdf mr-2"></i> Generate Certificate
</a>
</div>
@endif
@endsection
