@extends('layouts.user')

@section('title', 'My Bookings')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm p-6">
        <h1 class="text-2xl font-semibold text-gray-800 dark:text-white mb-6">My Service Bookings</h1>

        @if(session('success'))
            <div class="bg-emerald-50 dark:bg-emerald-900/50 border border-emerald-200 dark:border-emerald-800 text-emerald-800 dark:text-emerald-200 px-4 py-3 rounded-lg mb-6">
                {{ session('success') }}
            </div>
        @endif

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($bookings as $booking)
                <a href="{{ route('services.booking.details', $booking->id) }}" class="block">
                    <div class="bg-white dark:bg-gray-700 rounded-lg shadow-md overflow-hidden transition-transform duration-300 hover:scale-[1.02] hover:shadow-lg relative border border-gray-100 dark:border-gray-600 cursor-pointer">
                        <div class="{{ 
                            $booking->type === 'baptism' ? 'bg-sky-100 text-sky-800 dark:bg-sky-900 dark:text-sky-200' : 
                            ($booking->type === 'wedding' ? 'bg-rose-100 text-rose-800 dark:bg-rose-900 dark:text-rose-200' : 
                            ($booking->type === 'mass_intention' ? 'bg-indigo-100 text-indigo-800 dark:bg-indigo-900 dark:text-indigo-200' : 
                            ($booking->type === 'blessing' ? 'bg-amber-100 text-amber-800 dark:bg-amber-900 dark:text-amber-200' : 
                            ($booking->type === 'confirmation' ? 'bg-emerald-100 text-emerald-800 dark:bg-emerald-900 dark:text-emerald-200' : 
                            ($booking->type === 'sick_call' ? 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200' : 'bg-gray-100 text-gray-800 dark:bg-gray-900 dark:text-gray-200'))))) }} 
                            p-4 border-b border-gray-200 dark:border-gray-600">
                            <div class="flex items-center justify-between">
                                <span class="font-medium text-lg">#{{ $booking->ticket_number }}</span>
                                <div class="w-8 h-8 rounded-full bg-white/80 dark:bg-gray-800/80 flex items-center justify-center {{ 
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
                                        ($booking->type === 'sick_call' ? 'fa-hospital-user' : 'fa-circle'))))) }}"></i>
                                </div>
                            </div>
                            <h3 class="text-xl font-semibold mt-2">{{ 
                                $booking->type === 'mass_intention' ? 'Mass Intention' : ucfirst(str_replace('_', ' ', $booking->type)) 
                            }}</h3>
                        </div>
                        
                        <div class="p-4">
                            <div class="mb-4">
                                <div class="text-sm text-gray-500 dark:text-gray-400">Schedule</div>
                                <div class="text-gray-800 dark:text-gray-200">
                                    {{ Carbon\Carbon::parse($booking->preferred_date)->format('M d, Y') }} at
                                    {{ Carbon\Carbon::parse($booking->preferred_time)->format('g:i A') }}
                                </div>
                            </div>

                            <div class="flex items-center justify-between">
                                @if($booking->status === 'pending')
                                    <span class="px-3 py-1.5 rounded-full text-sm font-medium bg-yellow-50 text-yellow-700 dark:bg-yellow-900/30 dark:text-yellow-300 border border-yellow-200 dark:border-yellow-800">
                                        Pending
                                    </span>
                                @elseif($booking->status === 'payment_on_hold' && $booking->payment_status !== 'paid')
                                    <span class="px-3 py-1.5 rounded-full text-sm font-medium bg-blue-50 text-blue-700 dark:bg-blue-900/30 dark:text-blue-300 border border-blue-200 dark:border-blue-800">
                                        Payment On Hold
                                    </span>
                                    <a href="{{ route('services.payment', $booking->id) }}" class="inline-flex items-center px-4 py-2 bg-[#0d5c2f] text-white rounded-lg hover:bg-[#0d5c2f]/90 transition-colors z-10 relative">
                                        <i class="fas fa-money-bill mr-2"></i>
                                        Pay Now
                                    </a>
                                @elseif($booking->payment_status === 'pending')
                                    <span class="px-3 py-1.5 rounded-full text-sm font-medium bg-yellow-50 text-yellow-700 dark:bg-yellow-900/30 dark:text-yellow-300 border border-yellow-200 dark:border-yellow-800">
                                        Payment Pending
                                    </span>
                                @elseif($booking->payment_status === 'paid')
                                    <span class="px-3 py-1.5 rounded-full text-sm font-medium bg-emerald-50 text-emerald-700 dark:bg-emerald-900/30 dark:text-emerald-300 border border-emerald-200 dark:border-emerald-800">
                                        Paid
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>
                </a>
            @empty
                <div class="col-span-full text-center py-12 bg-gray-50 dark:bg-gray-700 rounded-lg border border-gray-200 dark:border-gray-600">
                    <i class="fas fa-calendar-xmark text-4xl mb-3 text-gray-400 dark:text-gray-500"></i>
                    <p class="text-gray-500 dark:text-gray-400 mb-4">You don't have any service bookings yet</p>
                    <a href="{{ route('userServices') }}" class="inline-flex items-center px-4 py-2 bg-[#0d5c2f] hover:bg-[#0d5c2f]/90 text-white rounded-lg transition-colors duration-150">
                        <i class="fas fa-plus mr-2"></i>
                        Book a Service
                    </a>
                </div>
            @endforelse
        </div>

        @if($bookings->count() > 0)
            <div class="mt-6">
                {{ $bookings->links() }}
            </div>
        @endif
    </div>
</div>
@endsection