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

        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50 dark:bg-gray-700">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Ticket #</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Service Type</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Schedule</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Status</th>
                    </tr>
                </thead>
                <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                    @forelse($bookings as $booking)
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors duration-150">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="font-medium text-gray-900 dark:text-white bg-gray-100 dark:bg-gray-700 px-3 py-1 rounded-full">
                                    #{{ $booking->ticket_number }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="w-8 h-8 rounded-lg bg-emerald-100 dark:bg-emerald-900 flex items-center justify-center text-emerald-800 dark:text-emerald-200 mr-3">
                                        <i class="fas {{ 
                                            $booking->type === 'baptism' ? 'fa-water' : 
                                            ($booking->type === 'wedding' ? 'fa-rings-wedding' : 
                                            ($booking->type === 'mass_intention' ? 'fa-church' : 
                                            ($booking->type === 'blessing' ? 'fa-hands-praying' : 
                                            ($booking->type === 'confirmation' ? 'fa-dove' : 
                                            ($booking->type === 'sick_call' ? 'fa-hospital-user' : 'fa-circle'))))) }}"></i>
                                    </div>
                                    <span class="font-medium text-gray-900 dark:text-white">{{ ucfirst($booking->type) }}</span>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-gray-700 dark:text-gray-300">
                                {{ Carbon\Carbon::parse($booking->preferred_date)->format('M d, Y') }} at
                                {{ Carbon\Carbon::parse($booking->preferred_time)->format('g:i A') }}
                            </td>
                            <!-- Inside the table row, after the status column -->
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($booking->status === 'payment_on_hold' && $booking->payment_status !== 'paid')
                                    <div class="flex flex-col items-start gap-2">
                                        <span class="px-3 py-1.5 rounded-full text-sm font-medium bg-blue-100 text-blue-800">
                                            Payment On Hold
                                        </span>
                                        <a href="{{ route('services.payment', $booking->id) }}" class="inline-flex items-center px-4 py-2 bg-[#0d5c2f] text-white rounded-lg hover:bg-[#0d5c2f]/90 transition-colors w-fit">
                                            <i class="fas fa-money-bill mr-2"></i>
                                            Pay Now
                                        </a>
                                    </div>
                                @elseif($booking->payment_status === 'pending')
                                    <span class="px-3 py-1.5 rounded-full text-sm font-medium bg-yellow-100 text-yellow-800">
                                        Payment Pending
                                    </span>
                                @elseif($booking->payment_status === 'paid')
                                    <span class="px-3 py-1.5 rounded-full text-sm font-medium bg-emerald-100 text-emerald-800">
                                        Paid
                                    </span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-6 py-8 text-center text-gray-500 dark:text-gray-400">
                                <div class="flex flex-col items-center">
                                    <i class="fas fa-calendar-xmark text-4xl mb-3"></i>
                                    <p>You don't have any service bookings yet</p>
                                    <a href="{{ route('services.book') }}" class="mt-4 inline-flex items-center px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white rounded-lg transition-colors duration-150">
                                        <i class="fas fa-plus mr-2"></i>
                                        Book a Service
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            @if($bookings->count() > 0)
                <div class="mt-4">
                    {{ $bookings->links() }}
                </div>
            @endif
        </div>
    </div>
</div>
@endsection