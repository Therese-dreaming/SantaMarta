@extends('layouts.user')

@section('title', 'Booking Details')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="mb-6">
        <a href="{{ route('services.my-bookings') }}" class="inline-flex items-center text-gray-600 dark:text-gray-400 hover:text-gray-800 dark:hover:text-gray-200">
            <i class="fas fa-arrow-left mr-2"></i> Back to My Bookings
        </a>
    </div>

    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm overflow-hidden">
        <!-- Header with service type color -->
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
                    <h1 class="text-2xl font-bold">{{ 
                        $booking->type === 'mass_intention' ? 'Mass Intention' : ucfirst(str_replace('_', ' ', $booking->type)) 
                    }} Service</h1>
                    <p class="text-lg mt-1">Ticket #{{ $booking->ticket_number }}</p>
                </div>
                <div class="w-12 h-12 rounded-full bg-white/80 dark:bg-gray-800/80 flex items-center justify-center {{ 
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
                        ($booking->type === 'sick_call' ? 'fa-hospital-user' : 'fa-circle'))))) }} text-2xl"></i>
                </div>
            </div>
        </div>

        <!-- Booking Status -->
        <div class="p-6 border-b border-gray-200 dark:border-gray-700">
            <h2 class="text-lg font-semibold text-gray-800 dark:text-white mb-4">Booking Status</h2>
            <div class="flex flex-wrap gap-4">
                <div class="flex items-center">
                    <span class="mr-2 text-gray-600 dark:text-gray-400">Status:</span>
                    @if($booking->status === 'pending')
                        <span class="px-3 py-1.5 rounded-full text-sm font-medium bg-yellow-50 text-yellow-700 dark:bg-yellow-900/30 dark:text-yellow-300 border border-yellow-200 dark:border-yellow-800">
                            Pending
                        </span>
                    @elseif($booking->status === 'payment_on_hold')
                        <span class="px-3 py-1.5 rounded-full text-sm font-medium bg-blue-50 text-blue-700 dark:bg-blue-900/30 dark:text-blue-300 border border-blue-200 dark:border-blue-800">
                            Payment On Hold
                        </span>
                    @elseif($booking->status === 'approved')
                        <span class="px-3 py-1.5 rounded-full text-sm font-medium bg-emerald-50 text-emerald-700 dark:bg-emerald-900/30 dark:text-emerald-300 border border-emerald-200 dark:border-emerald-800">
                            Approved
                        </span>
                    @elseif($booking->status === 'cancelled')
                        <span class="px-3 py-1.5 rounded-full text-sm font-medium bg-red-50 text-red-700 dark:bg-red-900/30 dark:text-red-300 border border-red-200 dark:border-red-800">
                            Cancelled
                        </span>
                    @endif
                </div>

                <div class="flex items-center">
                    <span class="mr-2 text-gray-600 dark:text-gray-400">Payment:</span>
                    @if($booking->payment_status === 'pending')
                        <span class="px-3 py-1.5 rounded-full text-sm font-medium bg-yellow-50 text-yellow-700 dark:bg-yellow-900/30 dark:text-yellow-300 border border-yellow-200 dark:border-yellow-800">
                            Payment Pending
                        </span>
                    @elseif($booking->payment_status === 'paid')
                        <span class="px-3 py-1.5 rounded-full text-sm font-medium bg-emerald-50 text-emerald-700 dark:bg-emerald-900/30 dark:text-emerald-300 border border-emerald-200 dark:border-emerald-800">
                            Paid
                        </span>
                    @else
                        <span class="px-3 py-1.5 rounded-full text-sm font-medium bg-gray-50 text-gray-700 dark:bg-gray-900/30 dark:text-gray-300 border border-gray-200 dark:border-gray-800">
                            Not Paid
                        </span>
                    @endif
                </div>

                @if($booking->status === 'payment_on_hold' && $booking->payment_status !== 'paid')
                    <a href="{{ route('services.payment', $booking->id) }}" class="inline-flex items-center px-4 py-2 bg-[#0d5c2f] text-white rounded-lg hover:bg-[#0d5c2f]/90 transition-colors">
                        <i class="fas fa-money-bill mr-2"></i>
                        Pay Now
                    </a>
                @endif
            </div>
        </div>

        <!-- Schedule Information -->
        <div class="p-6 border-b border-gray-200 dark:border-gray-700">
            <h2 class="text-lg font-semibold text-gray-800 dark:text-white mb-4">Schedule Information</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <p class="text-gray-600 dark:text-gray-400">Date</p>
                    <p class="text-gray-900 dark:text-white font-medium">{{ Carbon\Carbon::parse($booking->preferred_date)->format('F d, Y') }}</p>
                </div>
                <div>
                    <p class="text-gray-600 dark:text-gray-400">Time</p>
                    <p class="text-gray-900 dark:text-white font-medium">{{ Carbon\Carbon::parse($booking->preferred_time)->format('g:i A') }}</p>
                </div>
            </div>
        </div>

        <!-- Service Details -->
        <div class="p-6 border-b border-gray-200 dark:border-gray-700">
            <h2 class="text-lg font-semibold text-gray-800 dark:text-white mb-4">Service Details</h2>
            
            @if($booking->type === 'baptism' && $booking->baptismDetail)
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <p class="text-gray-600 dark:text-gray-400">Child's Name</p>
                        <p class="text-gray-900 dark:text-white font-medium">{{ $booking->baptismDetail->child_name }}</p>
                    </div>
                    <div>
                        <p class="text-gray-600 dark:text-gray-400">Baptism Type</p>
                        <p class="text-gray-900 dark:text-white font-medium">{{ ucfirst($booking->baptismDetail->baptism_type) }}</p>
                    </div>
                    <div>
                        <p class="text-gray-600 dark:text-gray-400">Date of Birth</p>
                        <p class="text-gray-900 dark:text-white font-medium">{{ Carbon\Carbon::parse($booking->baptismDetail->date_of_birth)->format('F d, Y') }}</p>
                    </div>
                    <div>
                        <p class="text-gray-600 dark:text-gray-400">Place of Birth</p>
                        <p class="text-gray-900 dark:text-white font-medium">{{ $booking->baptismDetail->place_of_birth }}</p>
                    </div>
                    <div>
                        <p class="text-gray-600 dark:text-gray-400">Father's Name</p>
                        <p class="text-gray-900 dark:text-white font-medium">{{ $booking->baptismDetail->father_name }}</p>
                    </div>
                    <div>
                        <p class="text-gray-600 dark:text-gray-400">Mother's Name</p>
                        <p class="text-gray-900 dark:text-white font-medium">{{ $booking->baptismDetail->mother_name }}</p>
                    </div>
                    <div>
                        <p class="text-gray-600 dark:text-gray-400">Nationality</p>
                        <p class="text-gray-900 dark:text-white font-medium">{{ $booking->baptismDetail->nationality }}</p>
                    </div>
                </div>
            @elseif($booking->type === 'wedding' && $booking->weddingDetail)
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <p class="text-gray-600 dark:text-gray-400">Groom's Name</p>
                        <p class="text-gray-900 dark:text-white font-medium">{{ $booking->weddingDetail->groom_name }}</p>
                    </div>
                    <div>
                        <p class="text-gray-600 dark:text-gray-400">Groom's Age</p>
                        <p class="text-gray-900 dark:text-white font-medium">{{ $booking->weddingDetail->groom_age }}</p>
                    </div>
                    <div>
                        <p class="text-gray-600 dark:text-gray-400">Groom's Religion</p>
                        <p class="text-gray-900 dark:text-white font-medium">{{ $booking->weddingDetail->groom_religion }}</p>
                    </div>
                    <div>
                        <p class="text-gray-600 dark:text-gray-400">Bride's Name</p>
                        <p class="text-gray-900 dark:text-white font-medium">{{ $booking->weddingDetail->bride_name }}</p>
                    </div>
                    <div>
                        <p class="text-gray-600 dark:text-gray-400">Bride's Age</p>
                        <p class="text-gray-900 dark:text-white font-medium">{{ $booking->weddingDetail->bride_age }}</p>
                    </div>
                    <div>
                        <p class="text-gray-600 dark:text-gray-400">Bride's Religion</p>
                        <p class="text-gray-900 dark:text-white font-medium">{{ $booking->weddingDetail->bride_religion }}</p>
                    </div>
                </div>
            @elseif($booking->type === 'mass_intention' && $booking->massIntentionDetail)
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <p class="text-gray-600 dark:text-gray-400">Mass Type</p>
                        <p class="text-gray-900 dark:text-white font-medium">{{ $booking->massIntentionDetail->mass_type }}</p>
                    </div>
                    <div>
                        <p class="text-gray-600 dark:text-gray-400">Mass Names</p>
                        <p class="text-gray-900 dark:text-white font-medium">{{ $booking->massIntentionDetail->mass_names }}</p>
                    </div>
                </div>
            @elseif($booking->type === 'blessing' && $booking->blessingDetail)
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <p class="text-gray-600 dark:text-gray-400">Blessing Type</p>
                        <p class="text-gray-900 dark:text-white font-medium">{{ $booking->blessingDetail->blessing_type }}</p>
                    </div>
                    <div>
                        <p class="text-gray-600 dark:text-gray-400">Blessing Location</p>
                        <p class="text-gray-900 dark:text-white font-medium">{{ $booking->blessingDetail->blessing_location }}</p>
                    </div>
                </div>
            @elseif($booking->type === 'confirmation' && $booking->confirmationDetail)
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <p class="text-gray-600 dark:text-gray-400">Confirmand's Name</p>
                        <p class="text-gray-900 dark:text-white font-medium">{{ $booking->confirmationDetail->confirmand_name }}</p>
                    </div>
                    <div>
                        <p class="text-gray-600 dark:text-gray-400">Date of Birth</p>
                        <p class="text-gray-900 dark:text-white font-medium">{{ Carbon\Carbon::parse($booking->confirmationDetail->confirmand_dob)->format('F d, Y') }}</p>
                    </div>
                    <div>
                        <p class="text-gray-600 dark:text-gray-400">Baptism Place</p>
                        <p class="text-gray-900 dark:text-white font-medium">{{ $booking->confirmationDetail->baptism_place }}</p>
                    </div>
                    <div>
                        <p class="text-gray-600 dark:text-gray-400">Baptism Date</p>
                        <p class="text-gray-900 dark:text-white font-medium">{{ Carbon\Carbon::parse($booking->confirmationDetail->baptism_date)->format('F d, Y') }}</p>
                    </div>
                </div>
            @elseif($booking->type === 'sick_call' && $booking->sickCallDetail)
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <p class="text-gray-600 dark:text-gray-400">Patient's Name</p>
                        <p class="text-gray-900 dark:text-white font-medium">{{ $booking->sickCallDetail->patient_name }}</p>
                    </div>
                    <div>
                        <p class="text-gray-600 dark:text-gray-400">Patient's Address</p>
                        <p class="text-gray-900 dark:text-white font-medium">{{ $booking->sickCallDetail->patient_address }}</p>
                    </div>
                    <div>
                        <p class="text-gray-600 dark:text-gray-400">Patient's Condition</p>
                        <p class="text-gray-900 dark:text-white font-medium">{{ $booking->sickCallDetail->patient_condition }}</p>
                    </div>
                </div>
            @endif
        </div>

        <!-- Additional Notes -->
        @if($booking->notes)
        <div class="p-6 border-b border-gray-200 dark:border-gray-700">
            <h2 class="text-lg font-semibold text-gray-800 dark:text-white mb-4">Additional Notes</h2>
            <p class="text-gray-700 dark:text-gray-300">{{ $booking->notes }}</p>
        </div>
        @endif

        <!-- Documents -->
        @if($booking->documents->count() > 0)
        <div class="p-6 border-b border-gray-200 dark:border-gray-700">
            <h2 class="text-lg font-semibold text-gray-800 dark:text-white mb-4">Uploaded Documents</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                @foreach($booking->documents as $document)
                <div class="flex items-center p-3 bg-gray-50 dark:bg-gray-700 rounded-lg">
                    <i class="fas fa-file-alt text-gray-500 dark:text-gray-400 mr-3"></i>
                    <div>
                        <p class="text-gray-900 dark:text-white font-medium">{{ $document->name }}</p>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Uploaded {{ $document->created_at->diffForHumans() }}</p>
                    </div>
                    <a href="{{ Storage::url($document->path) }}" target="_blank" class="ml-auto text-blue-600 dark:text-blue-400 hover:text-blue-800 dark:hover:text-blue-300">
                        <i class="fas fa-download"></i>
                    </a>
                </div>
                @endforeach
            </div>
        </div>
        @endif

        <!-- Payment Information -->
        @if($booking->payment_status === 'paid')
        <div class="p-6 border-b border-gray-200 dark:border-gray-700">
            <h2 class="text-lg font-semibold text-gray-800 dark:text-white mb-4">Payment Information</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <p class="text-gray-600 dark:text-gray-400">Amount Paid</p>
                    <p class="text-gray-900 dark:text-white font-medium">₱{{ number_format($booking->price, 2) }}</p>
                </div>
                <div>
                    <p class="text-gray-600 dark:text-gray-400">Payment Date</p>
                    <p class="text-gray-900 dark:text-white font-medium">{{ $booking->payment->first() ? Carbon\Carbon::parse($booking->payment->first()->created_at)->format('F d, Y') : 'N/A' }}</p>
                </div>
                <div>
                    <p class="text-gray-600 dark:text-gray-400">Payment Method</p>
                    <p class="text-gray-900 dark:text-white font-medium">{{ $booking->payment->first() ? ucfirst($booking->payment->first()->payment_method) : 'N/A' }}</p>
                </div>
                <div>
                    <p class="text-gray-600 dark:text-gray-400">Reference Number</p>
                    <p class="text-gray-900 dark:text-white font-medium">{{ $booking->payment->first() ? $booking->payment->first()->reference_number : 'N/A' }}</p>
                </div>
            </div>
            <div class="mt-4">
                <a href="{{ route('services.payment.receipt', $booking->id) }}" target="_blank" class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                    <i class="fas fa-receipt mr-2"></i>
                    View Receipt
                </a>
            </div>
        </div>
        @endif

        <!-- Actions -->
        <div class="p-6">
            <div class="flex flex-wrap gap-3">
                <a href="{{ route('services.my-bookings') }}" class="inline-flex items-center px-4 py-2 bg-gray-200 text-gray-800 dark:bg-gray-700 dark:text-white rounded-lg hover:bg-gray-300 dark:hover:bg-gray-600 transition-colors">
                    <i class="fas fa-arrow-left mr-2"></i>
                    Back to My Bookings
                </a>
                
                @if($booking->status === 'pending' || $booking->status === 'payment_on_hold')
                <button onclick="confirmCancel()" class="inline-flex items-center px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors">
                    <i class="fas fa-times mr-2"></i>
                    Cancel Booking
                </button>
                @endif
            </div>
        </div>
    </div>
</div>

@if($booking->status === 'pending' || $booking->status === 'payment_on_hold')
<!-- Cancel Confirmation Modal -->
<div id="cancelModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center hidden">
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-xl max-w-md w-full mx-4">
        <div class="p-6">
            <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-4">Cancel Booking</h3>
            <p class="text-gray-700 dark:text-gray-300 mb-6">Are you sure you want to cancel this booking? This action cannot be undone.</p>
            
            <div class="flex justify-end gap-3">
                <button onclick="closeCancelModal()" class="px-4 py-2 bg-gray-200 text-gray-800 dark:bg-gray-700 dark:text-white rounded-lg hover:bg-gray-300 dark:hover:bg-gray-600 transition-colors">
                    No, Keep Booking
                </button>
                <form action="{{ route('bookings.cancel', $booking->id) }}" method="POST">
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
    function confirmCancel() {
        document.getElementById('cancelModal').classList.remove('hidden');
    }
    
    function closeCancelModal() {
        document.getElementById('cancelModal').classList.add('hidden');
    }
</script>
@endif
@endsection