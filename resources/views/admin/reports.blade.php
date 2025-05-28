@extends('layouts.admin')

@section('title', 'Reports')

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-800 dark:text-white">Financial Reports</h1>
        <div class="flex space-x-2">
            <a href="{{ route('admin.reports.download') }}?{{ http_build_query(request()->all()) }}" class="bg-emerald-600 hover:bg-emerald-700 text-white px-4 py-2 rounded-lg flex items-center">
                <i class="fas fa-download mr-2"></i> Export Report
            </a>
        </div>
    </div>

    <!-- Filters -->
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6 mb-6">
        <h2 class="text-lg font-semibold text-gray-700 dark:text-gray-300 mb-4">Filters</h2>
        <form action="{{ route('admin.reports') }}" method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div>
                <label for="date_from" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Date From</label>
                <input type="date" id="date_from" name="date_from" value="{{ request('date_from') }}" 
                    class="w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-emerald-500 focus:ring focus:ring-emerald-500 focus:ring-opacity-50">
            </div>
            <div>
                <label for="date_to" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Date To</label>
                <input type="date" id="date_to" name="date_to" value="{{ request('date_to') }}" 
                    class="w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-emerald-500 focus:ring focus:ring-emerald-500 focus:ring-opacity-50">
            </div>
            <div>
                <label for="service_type" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Service Type</label>
                <select id="service_type" name="service_type" 
                    class="w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-emerald-500 focus:ring focus:ring-emerald-500 focus:ring-opacity-50">
                    <option value="">All Services</option>
                    <option value="baptism" {{ request('service_type') == 'baptism' ? 'selected' : '' }}>Baptism</option>
                    <option value="communion" {{ request('service_type') == 'communion' ? 'selected' : '' }}>First Communion</option>
                    <option value="confirmation" {{ request('service_type') == 'confirmation' ? 'selected' : '' }}>Confirmation</option>
                    <option value="wedding" {{ request('service_type') == 'wedding' ? 'selected' : '' }}>Wedding</option>
                    <option value="funeral" {{ request('service_type') == 'funeral' ? 'selected' : '' }}>Funeral</option>
                    <option value="blessing" {{ request('service_type') == 'blessing' ? 'selected' : '' }}>Blessing</option>
                    <option value="mass" {{ request('service_type') == 'mass' ? 'selected' : '' }}>Mass</option>
                </select>
            </div>
            <div>
                <label for="status" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Status</label>
                <select id="status" name="status" 
                    class="w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-emerald-500 focus:ring focus:ring-emerald-500 focus:ring-opacity-50">
                    <option value="">All Statuses</option>
                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>Approved</option>
                    <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Completed</option>
                    <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                    <option value="payment_pending" {{ request('status') == 'payment_pending' ? 'selected' : '' }}>Payment Pending</option>
                </select>
            </div>
            <div class="md:col-span-4 flex justify-end">
                <button type="submit" class="bg-emerald-600 hover:bg-emerald-700 text-white px-4 py-2 rounded-lg">
                    <i class="fas fa-filter mr-2"></i> Apply Filters
                </button>
            </div>
        </form>
    </div>

    <!-- Summary Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-emerald-100 dark:bg-emerald-900 mr-4">
                    <i class="fas fa-calendar-check text-emerald-600 dark:text-emerald-400"></i>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Total Bookings</p>
                    <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ $totalBookings }}</p>
                </div>
            </div>
            <div class="mt-4">
                <div class="flex justify-between items-center">
                    <span class="text-sm text-gray-500 dark:text-gray-400">{{ $completedBookings }} completed</span>
                    <span class="text-sm text-emerald-600 dark:text-emerald-400">
                        {{ $completedBookings > 0 ? round(($completedBookings / $totalBookings) * 100) : 0 }}%
                    </span>
                </div>
                <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-2 mt-1">
                    <div class="bg-emerald-600 h-2 rounded-full" style="width: {{ $completedBookings > 0 ? ($completedBookings / $totalBookings) * 100 : 0 }}%"></div>
                </div>
            </div>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-blue-100 dark:bg-blue-900 mr-4">
                    <i class="fas fa-peso-sign text-blue-600 dark:text-blue-400"></i>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Total Revenue</p>
                    <p class="text-2xl font-bold text-gray-900 dark:text-white">₱{{ number_format($totalRevenue, 2) }}</p>
                </div>
            </div>
            <div class="mt-4">
                <div class="flex justify-between items-center">
                    <span class="text-sm text-gray-500 dark:text-gray-400">{{ $paidBookings }} paid bookings</span>
                    <span class="text-sm text-blue-600 dark:text-blue-400">
                        {{ $paidBookings > 0 ? round(($paidBookings / $totalBookings) * 100) : 0 }}%
                    </span>
                </div>
                <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-2 mt-1">
                    <div class="bg-blue-600 h-2 rounded-full" style="width: {{ $paidBookings > 0 ? ($paidBookings / $totalBookings) * 100 : 0 }}%"></div>
                </div>
            </div>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-purple-100 dark:bg-purple-900 mr-4">
                    <i class="fas fa-chart-line text-purple-600 dark:text-purple-400"></i>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Avg. Revenue/Booking</p>
                    <p class="text-2xl font-bold text-gray-900 dark:text-white">
                        ₱{{ $paidBookings > 0 ? number_format($totalRevenue / $paidBookings, 2) : '0.00' }}
                    </p>
                </div>
            </div>
            <div class="mt-4">
                <div class="flex justify-between items-center">
                    <span class="text-sm text-gray-500 dark:text-gray-400">This period</span>
                    <span class="text-sm text-purple-600 dark:text-purple-400">
                        {{ $revenueGrowth >= 0 ? '+' : '' }}{{ number_format($revenueGrowth, 1) }}%
                    </span>
                </div>
                <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-2 mt-1">
                    <div class="bg-purple-600 h-2 rounded-full" style="width: {{ min(max($revenueGrowth, 0), 100) }}%"></div>
                </div>
            </div>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-amber-100 dark:bg-amber-900 mr-4">
                    <i class="fas fa-users text-amber-600 dark:text-amber-400"></i>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-600 dark:text-gray-400">New Users</p>
                    <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ $newUsers }}</p>
                </div>
            </div>
            <div class="mt-4">
                <div class="flex justify-between items-center">
                    <span class="text-sm text-gray-500 dark:text-gray-400">This period</span>
                    <span class="text-sm text-amber-600 dark:text-amber-400">
                        {{ $userGrowth >= 0 ? '+' : '' }}{{ number_format($userGrowth, 1) }}%
                    </span>
                </div>
                <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-2 mt-1">
                    <div class="bg-amber-600 h-2 rounded-full" style="width: {{ min(max($userGrowth, 0), 100) }}%"></div>
                </div>
            </div>
        </div>
    </div>

    <!-- Service Type Breakdown -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
        <!-- Service Type Stats -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6">
            <h2 class="text-lg font-semibold text-gray-700 dark:text-gray-300 mb-4">Service Type Breakdown</h2>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                    <thead>
                        <tr>
                            <th class="px-4 py-3 bg-gray-50 dark:bg-gray-700 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Service Type</th>
                            <th class="px-4 py-3 bg-gray-50 dark:bg-gray-700 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Bookings</th>
                            <th class="px-4 py-3 bg-gray-50 dark:bg-gray-700 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Revenue</th>
                            <th class="px-4 py-3 bg-gray-50 dark:bg-gray-700 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">% of Total</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                        @foreach($serviceStats as $stat)
                        <tr>
                            <td class="px-4 py-3 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="w-2 h-2 rounded-full mr-2" style="background-color: {{ $stat['color'] }}"></div>
                                    <span class="text-sm font-medium text-gray-900 dark:text-white">{{ ucfirst($stat['service_type']) }}</span>
                                </div>
                            </td>
                            <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                {{ $stat['count'] }}
                            </td>
                            <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                ₱{{ number_format($stat['revenue'], 2) }}
                            </td>
                            <td class="px-4 py-3 whitespace-nowrap">
                                <div class="flex items-center">
                                    <span class="text-sm text-gray-500 dark:text-gray-400 mr-2">{{ number_format($stat['percentage'], 1) }}%</span>
                                    <div class="w-16 bg-gray-200 dark:bg-gray-700 rounded-full h-2">
                                        <div class="h-2 rounded-full" style="width: {{ $stat['percentage'] }}%; background-color: {{ $stat['color'] }}"></div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Revenue Chart -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6">
            <h2 class="text-lg font-semibold text-gray-700 dark:text-gray-300 mb-4">Revenue Trend</h2>
            <div class="h-64">
                <canvas id="revenueChart" class="w-full h-64"></canvas>
            </div>
        </div>
    </div>

    <!-- Transaction Logs -->
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6 mb-6">
        <h2 class="text-lg font-semibold text-gray-700 dark:text-gray-300 mb-4">Transaction Logs</h2>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                <thead>
                    <tr>
                        <th class="px-4 py-3 bg-gray-50 dark:bg-gray-700 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Date</th>
                        <th class="px-4 py-3 bg-gray-50 dark:bg-gray-700 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Ticket #</th>
                        <th class="px-4 py-3 bg-gray-50 dark:bg-gray-700 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Service</th>
                        <th class="px-4 py-3 bg-gray-50 dark:bg-gray-700 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">User</th>
                        <th class="px-4 py-3 bg-gray-50 dark:bg-gray-700 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Amount</th>
                        <th class="px-4 py-3 bg-gray-50 dark:bg-gray-700 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Status</th>
                        <th class="px-4 py-3 bg-gray-50 dark:bg-gray-700 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Payment Method</th>
                    </tr>
                </thead>
                <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                    @forelse($transactions as $transaction)
                    <tr>
                        <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                            {{ $transaction->created_at->format('M d, Y h:i A') }}
                        </td>
                        <td class="px-4 py-3 whitespace-nowrap">
                            <a href="{{ route('admin.bookings.show', $transaction->id) }}" class="text-sm font-medium text-emerald-600 hover:text-emerald-800 dark:text-emerald-400 dark:hover:text-emerald-300">
                                {{ $transaction->ticket_number }}
                            </a>
                        </td>
                        <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                            {{ ucfirst($transaction->type) }}
                        </td>
                        <td class="px-4 py-3 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 h-8 w-8">
                                    <img class="h-8 w-8 rounded-full" src="{{ $transaction->user->avatar ?? 'https://ui-avatars.com/api/?name=' . urlencode($transaction->user->name) }}" alt="{{ $transaction->user->name }}">
                                </div>
                                <div class="ml-3">
                                    <div class="text-sm font-medium text-gray-900 dark:text-white">
                                        {{ $transaction->user->name }}
                                    </div>
                                    <div class="text-xs text-gray-500 dark:text-gray-400">
                                        {{ $transaction->user->email }}
                                    </div>
                                </div>
                            </div>
                        </td>
                        <td class="px-4 py-3 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-white">
                            ₱{{ number_format($transaction->amount, 2) }}
                        </td>
                        <td class="px-4 py-3 whitespace-nowrap">
                            @if($transaction->payment_status == 'completed')
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200">
                                    Completed
                                </span>
                            @elseif($transaction->payment_status == 'pending')
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200">
                                    Pending
                                </span>
                            @elseif($transaction->payment_status == 'failed')
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200">
                                    Failed
                                </span>
                            @else
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300">
                                    {{ ucfirst($transaction->payment_status) }}
                                </span>
                            @endif
                        </td>
                        <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                            {{ ucfirst($transaction->payment_method) }}
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="px-4 py-8 text-center text-gray-500 dark:text-gray-400">
                            <div class="flex flex-col items-center">
                                <i class="fas fa-receipt text-4xl mb-3 text-gray-400 dark:text-gray-500"></i>
                                <p>No transactions found for the selected period</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="mt-4">
            {{ $transactions->links() }}
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Add console logging to debug
        console.log('Chart data:', {
            labels: {!! json_encode($revenueChart['labels'] ?? []) !!},
            data: {!! json_encode($revenueChart['data'] ?? []) !!}
        });
        
        // Revenue Chart
        const ctx = document.getElementById('revenueChart');
        if (ctx) {
            console.log('Canvas element found');
            const revenueChart = new Chart(ctx.getContext('2d'), {
                type: 'line',
                data: {
                    labels: {!! json_encode($revenueChart['labels'] ?? []) !!},
                    datasets: [{
                        label: 'Revenue',
                        data: {!! json_encode($revenueChart['data'] ?? []) !!},
                        backgroundColor: 'rgba(16, 185, 129, 0.2)',
                        borderColor: 'rgba(16, 185, 129, 1)',
                        borderWidth: 2,
                        tension: 0.3,
                        pointBackgroundColor: 'rgba(16, 185, 129, 1)',
                        pointBorderColor: '#fff',
                        pointBorderWidth: 1,
                        pointRadius: 4,
                        pointHoverRadius: 6
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false
                        },
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    return '₱' + context.raw.toLocaleString('en-PH', {
                                        minimumFractionDigits: 2,
                                        maximumFractionDigits: 2
                                    });
                                }
                            }
                        }
                    },
                    scales: {
                        x: {
                            grid: {
                                display: false
                            },
                            ticks: {
                                color: document.documentElement.classList.contains('dark') ? '#9ca3af' : '#6b7280'
                            }
                        },
                        y: {
                            beginAtZero: true,
                            ticks: {
                                callback: function(value) {
                                    return '₱' + value.toLocaleString('en-PH');
                                },
                                color: document.documentElement.classList.contains('dark') ? '#9ca3af' : '#6b7280'
                            },
                            grid: {
                                color: document.documentElement.classList.contains('dark') ? 'rgba(75, 85, 99, 0.2)' : 'rgba(209, 213, 219, 0.2)'
                            }
                        }
                    }
                }
            });
        } else {
            console.error('Canvas element not found');
        }
    });
</script>
@endsection