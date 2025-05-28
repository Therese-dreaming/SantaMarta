@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')
<div class="container px-6 mx-auto">
    <!-- Page header with overview stats -->
    <div class="mb-8">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-semibold text-gray-700 dark:text-gray-200">Dashboard</h1>
            <div class="flex space-x-2">
                <span class="bg-emerald-100 text-emerald-800 text-xs font-medium px-2.5 py-0.5 rounded-full dark:bg-emerald-900 dark:text-emerald-300 flex items-center">
                    <i class="fas fa-calendar-day mr-1"></i>
                    {{ now()->format('F d, Y') }}
                </span>
            </div>
        </div>
        
        <!-- Key metrics cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            <!-- Total Bookings -->
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6 border-l-4 border-blue-500 transition-transform duration-300 hover:scale-105">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-blue-100 dark:bg-blue-900 mr-4">
                        <i class="fas fa-calendar-check text-blue-500 dark:text-blue-300 text-xl"></i>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Total Bookings</p>
                        <p class="text-2xl font-semibold text-gray-700 dark:text-gray-200">{{ $totalBookings ?? 0 }}</p>
                    </div>
                </div>
                <div class="mt-4">
                    <a href="{{ route('admin.bookings') }}" class="text-sm text-blue-600 dark:text-blue-400 hover:underline flex items-center">
                        View all bookings
                        <i class="fas fa-arrow-right ml-1 text-xs"></i>
                    </a>
                </div>
            </div>

            <!-- Pending Bookings -->
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6 border-l-4 border-yellow-500 transition-transform duration-300 hover:scale-105">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-yellow-100 dark:bg-yellow-900 mr-4">
                        <i class="fas fa-clock text-yellow-500 dark:text-yellow-300 text-xl"></i>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Pending Approval</p>
                        <p class="text-2xl font-semibold text-gray-700 dark:text-gray-200">{{ $pendingBookings ?? 0 }}</p>
                    </div>
                </div>
                <div class="mt-4">
                    <a href="{{ route('admin.bookings', ['status' => 'pending']) }}" class="text-sm text-yellow-600 dark:text-yellow-400 hover:underline flex items-center">
                        View pending bookings
                        <i class="fas fa-arrow-right ml-1 text-xs"></i>
                    </a>
                </div>
            </div>

            <!-- Today's Bookings -->
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6 border-l-4 border-emerald-500 transition-transform duration-300 hover:scale-105">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-emerald-100 dark:bg-emerald-900 mr-4">
                        <i class="fas fa-calendar-day text-emerald-500 dark:text-emerald-300 text-xl"></i>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Today's Services</p>
                        <p class="text-2xl font-semibold text-gray-700 dark:text-gray-200">{{ $todayBookings ?? 0 }}</p>
                    </div>
                </div>
                <div class="mt-4">
                    <a href="{{ route('admin.calendar') }}" class="text-sm text-emerald-600 dark:text-emerald-400 hover:underline flex items-center">
                        View calendar
                        <i class="fas fa-arrow-right ml-1 text-xs"></i>
                    </a>
                </div>
            </div>

            <!-- Registered Users -->
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6 border-l-4 border-purple-500 transition-transform duration-300 hover:scale-105">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-purple-100 dark:bg-purple-900 mr-4">
                        <i class="fas fa-users text-purple-500 dark:text-purple-300 text-xl"></i>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Registered Users</p>
                        <p class="text-2xl font-semibold text-gray-700 dark:text-gray-200">{{ $totalUsers ?? 0 }}</p>
                    </div>
                </div>
                <div class="mt-4">
                    <a href="{{ route('admin.users.index') }}" class="text-sm text-purple-600 dark:text-purple-400 hover:underline flex items-center">
                        Manage users
                        <i class="fas fa-arrow-right ml-1 text-xs"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Financial overview section -->
    <div class="mb-8">
        <h2 class="text-xl font-semibold text-gray-700 dark:text-gray-200 mb-6 flex items-center">
            <i class="fas fa-chart-line mr-2 text-emerald-500"></i>
            Financial Overview
        </h2>
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Financial summary -->
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6 lg:col-span-2">
                <h3 class="text-lg font-semibold text-gray-700 dark:text-gray-200 mb-4">Revenue Trends</h3>
                <div class="relative h-80">
                    <canvas id="financialChart"></canvas>
                </div>
                <div class="mt-6 grid grid-cols-2 gap-4">
                    <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-lg">
                        <div class="flex justify-between items-center">
                            <p class="text-sm text-gray-500 dark:text-gray-400">Total Revenue</p>
                            <span class="text-xs font-medium px-2 py-1 rounded-full {{ ($yearOverYearGrowth['revenue_growth'] ?? 0) > 0 ? 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300' : 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-300' }}">
                                {{ ($yearOverYearGrowth['revenue_growth'] ?? 0) > 0 ? '+' : '' }}{{ $yearOverYearGrowth['revenue_growth'] ?? 0 }}%
                            </span>
                        </div>
                        <p class="text-2xl font-semibold text-gray-700 dark:text-gray-200">₱{{ number_format($totalRevenue ?? 0, 2) }}</p>
                    </div>
                    <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-lg">
                        <div class="flex justify-between items-center">
                            <p class="text-sm text-gray-500 dark:text-gray-400">This Month</p>
                            <span class="text-xs font-medium px-2 py-1 rounded-full bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-300">
                                {{ now()->format('M Y') }}
                            </span>
                        </div>
                        <p class="text-2xl font-semibold text-gray-700 dark:text-gray-200">₱{{ number_format($monthlyRevenue ?? 0, 2) }}</p>
                    </div>
                </div>
            </div>

            <!-- Revenue by service type -->
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6">
                <h3 class="text-lg font-semibold text-gray-700 dark:text-gray-200 mb-4">Revenue by Service</h3>
                <div class="relative h-80">
                    <canvas id="revenueByServiceChart"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Service analytics section -->
    <div class="mb-8">
        <h2 class="text-xl font-semibold text-gray-700 dark:text-gray-200 mb-6 flex items-center">
            <i class="fas fa-church mr-2 text-blue-500"></i>
            Service Analytics
        </h2>
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Service distribution -->
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6">
                <h3 class="text-lg font-semibold text-gray-700 dark:text-gray-200 mb-4">Service Distribution</h3>
                <div class="relative h-80">
                    <canvas id="serviceDistributionChart"></canvas>
                </div>
            </div>

            <!-- Booking completion rate -->
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6">
                <h3 class="text-lg font-semibold text-gray-700 dark:text-gray-200 mb-4">Booking Status</h3>
                <div class="relative h-80">
                    <canvas id="bookingStatusChart"></canvas>
                </div>
                <div class="mt-4 grid grid-cols-3 gap-2 text-center">
                    <div>
                        <p class="text-xs font-medium text-gray-500 dark:text-gray-400">Approval Rate</p>
                        <p class="text-lg font-semibold text-green-600 dark:text-green-400">{{ $bookingCompletionRate['approval_rate'] ?? 0 }}%</p>
                    </div>
                    <div>
                        <p class="text-xs font-medium text-gray-500 dark:text-gray-400">Pending</p>
                        <p class="text-lg font-semibold text-yellow-600 dark:text-yellow-400">{{ $bookingCompletionRate['pending'] ?? 0 }}</p>
                    </div>
                    <div>
                        <p class="text-xs font-medium text-gray-500 dark:text-gray-400">Cancelled</p>
                        <p class="text-lg font-semibold text-red-600 dark:text-red-400">{{ $bookingCompletionRate['cancelled'] ?? 0 }}</p>
                    </div>
                </div>
            </div>

            <!-- Peak booking times -->
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6">
                <h3 class="text-lg font-semibold text-gray-700 dark:text-gray-200 mb-4">Peak Booking Days</h3>
                <div class="relative h-80">
                    <canvas id="peakBookingChart"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent activity section -->
    <div class="mb-8">
        <h2 class="text-xl font-semibold text-gray-700 dark:text-gray-200 mb-6 flex items-center">
            <i class="fas fa-history mr-2 text-purple-500"></i>
            Recent Activity
        </h2>
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Recent bookings -->
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md overflow-hidden">
                <div class="p-6 border-b border-gray-200 dark:border-gray-700 flex justify-between items-center">
                    <h3 class="text-lg font-semibold text-gray-700 dark:text-gray-200">Recent Bookings</h3>
                    <a href="{{ route('admin.bookings') }}" class="text-sm text-blue-600 dark:text-blue-400 hover:underline flex items-center">
                        View all
                        <i class="fas fa-arrow-right ml-1 text-xs"></i>
                    </a>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                            <tr>
                                <th scope="col" class="px-6 py-3">Ticket</th>
                                <th scope="col" class="px-6 py-3">Service</th>
                                <th scope="col" class="px-6 py-3">Date</th>
                                <th scope="col" class="px-6 py-3">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recentBookings ?? [] as $booking)
                            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700">
                                <td class="px-6 py-4 font-medium">
                                    <a href="{{ route('admin.bookings.show', $booking->id) }}" class="text-blue-600 dark:text-blue-400 hover:underline">
                                        {{ $booking->ticket_number }}
                                    </a>
                                </td>
                                <td class="px-6 py-4">{{ ucfirst(str_replace('_', ' ', $booking->type)) }}</td>
                                <td class="px-6 py-4">{{ $booking->preferred_date ? date('M d, Y', strtotime($booking->preferred_date)) : 'N/A' }}</td>
                                <td class="px-6 py-4">
                                    <span class="px-2 py-1 text-xs rounded-full 
                                        @if($booking->status == 'approved') bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300
                                        @elseif($booking->status == 'pending') bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-300
                                        @elseif($booking->status == 'cancelled') bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-300
                                        @else bg-gray-100 text-gray-800 dark:bg-gray-900 dark:text-gray-300
                                        @endif">
                                        {{ ucfirst($booking->status) }}
                                    </span>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="px-6 py-4 text-center text-gray-500 dark:text-gray-400">
                                    No recent bookings
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Upcoming events -->
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md overflow-hidden">
                <div class="p-6 border-b border-gray-200 dark:border-gray-700 flex justify-between items-center">
                    <h3 class="text-lg font-semibold text-gray-700 dark:text-gray-200">Upcoming Events</h3>
                    <a href="{{ route('admin.activities.index') }}" class="text-sm text-blue-600 dark:text-blue-400 hover:underline flex items-center">
                        View all
                        <i class="fas fa-arrow-right ml-1 text-xs"></i>
                    </a>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                            <tr>
                                <th scope="col" class="px-6 py-3">Event</th>
                                <th scope="col" class="px-6 py-3">Date</th>
                                <th scope="col" class="px-6 py-3">Time</th>
                                <th scope="col" class="px-6 py-3">Created By</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($upcomingEvents ?? [] as $event)
                            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700">
                                <td class="px-6 py-4 font-medium">
                                    <a href="{{ route('admin.activities.edit', $event->id) }}" class="text-blue-600 dark:text-blue-400 hover:underline">
                                        {{ $event->title }}
                                    </a>
                                </td>
                                <td class="px-6 py-4">{{ $event->date ? date('M d, Y', strtotime($event->date)) : 'N/A' }}</td>
                                <td class="px-6 py-4">{{ $event->start_time }} - {{ $event->end_time }}</td>
                                <td class="px-6 py-4">{{ $event->user ? $event->user->name : 'System' }}</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="px-6 py-4 text-center text-gray-500 dark:text-gray-400">
                                    No upcoming events
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick actions -->
    <div class="mb-8">
        <h2 class="text-xl font-semibold text-gray-700 dark:text-gray-200 mb-6 flex items-center">
            <i class="fas fa-bolt mr-2 text-yellow-500"></i>
            Quick Actions
        </h2>
        <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
            <a href="{{ route('admin.bookings') }}" class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6 flex flex-col items-center justify-center text-center transition-all duration-300 hover:shadow-lg hover:bg-blue-50 dark:hover:bg-gray-700">
                <div class="p-3 rounded-full bg-blue-100 dark:bg-blue-900 mb-4">
                    <i class="fas fa-calendar-plus text-blue-500 dark:text-blue-300 text-xl"></i>
                </div>
                <h3 class="text-base font-bold text-gray-700 dark:text-gray-200">New Booking</h3>
                <p class="text-xs text-gray-500 dark:text-gray-400 mt-2">Create a new service booking</p>
            </a>
            
            <a href="{{ route('admin.activities.create') }}" class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6 flex flex-col items-center justify-center text-center transition-all duration-300 hover:shadow-lg hover:bg-emerald-50 dark:hover:bg-gray-700">
                <div class="p-3 rounded-full bg-emerald-100 dark:bg-emerald-900 mb-4">
                    <i class="fas fa-plus-circle text-emerald-500 dark:text-emerald-300 text-xl"></i>
                </div>
                <h3 class="text-base font-bold text-gray-700 dark:text-gray-200">New Event</h3>
                <p class="text-xs text-gray-500 dark:text-gray-400 mt-2">Schedule a new church event</p>
            </a>
            
            <a href="{{ route('admin.users.create') }}" class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6 flex flex-col items-center justify-center text-center transition-all duration-300 hover:shadow-lg hover:bg-purple-50 dark:hover:bg-gray-700">
                <div class="p-3 rounded-full bg-purple-100 dark:bg-purple-900 mb-4">
                    <i class="fas fa-user-plus text-purple-500 dark:text-purple-300 text-xl"></i>
                </div>
                <h3 class="text-base font-bold text-gray-700 dark:text-gray-200">Add User</h3>
                <p class="text-xs text-gray-500 dark:text-gray-400 mt-2">Register a new user account</p>
            </a>
            
            <a href="{{ route('admin.reports') }}" class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6 flex flex-col items-center justify-center text-center transition-all duration-300 hover:shadow-lg hover:bg-yellow-50 dark:hover:bg-gray-700">
                <div class="p-3 rounded-full bg-yellow-100 dark:bg-yellow-900 mb-4">
                    <i class="fas fa-chart-line text-yellow-500 dark:text-yellow-300 text-xl"></i>
                </div>
                <h3 class="text-base font-bold text-gray-700 dark:text-gray-200">Reports</h3>
                <p class="text-xs text-gray-500 dark:text-gray-400 mt-2">View detailed analytics reports</p>
            </a>
        </div>
    </div>

    <!-- User activity section -->
    <div class="mb-8">
        <h2 class="text-xl font-semibold text-gray-700 dark:text-gray-200 mb-6 flex items-center">
            <i class="fas fa-user-chart mr-2 text-indigo-500"></i>
            User Activity
        </h2>
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6">
            <h3 class="text-lg font-semibold text-gray-700 dark:text-gray-200 mb-4">User Registration Trends</h3>
            <div class="relative h-80">
                <canvas id="userRegistrationChart"></canvas>
            </div>
        </div>
    </div>
</div>

<!-- Chart.js for the charts -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const textColor = document.documentElement.classList.contains('dark') ? '#e2e8f0' : '#4b5563';
        const gridColor = document.documentElement.classList.contains('dark') ? 'rgba(255, 255, 255, 0.1)' : 'rgba(0, 0, 0, 0.1)';
        
        // Service Distribution Chart
        const serviceData = {
            labels: ['Baptism', 'Wedding', 'Funeral', 'Confirmation', 'Mass Intention'],
            datasets: [{
                data: [{{ $baptismCount ?? 30 }}, {{ $weddingCount ?? 15 }}, {{ $funeralCount ?? 10 }}, {{ $confirmationCount ?? 20 }}, {{ $massIntentionCount ?? 25 }}],
                backgroundColor: [
                    'rgba(54, 162, 235, 0.7)',
                    'rgba(255, 99, 132, 0.7)',
                    'rgba(75, 192, 192, 0.7)',
                    'rgba(255, 206, 86, 0.7)',
                    'rgba(153, 102, 255, 0.7)'
                ],
                borderColor: [
                    'rgba(54, 162, 235, 1)',
                    'rgba(255, 99, 132, 1)',
                    'rgba(75, 192, 192, 1)',
                    'rgba(255, 206, 86, 1)',
                    'rgba(153, 102, 255, 1)'
                ],
                borderWidth: 1
            }]
        };

        const ctx = document.getElementById('serviceDistributionChart').getContext('2d');
        const serviceDistributionChart = new Chart(ctx, {
            type: 'doughnut',
            data: serviceData,
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            color: textColor,
                            font: {
                                size: 12
                            }
                        }
                    }
                }
            }
        });

        // Financial Chart - Last 6 months
        const financialData = {
            labels: {!! json_encode($monthlyRevenueData['labels'] ?? ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun']) !!},
            datasets: [{
                label: 'Revenue',
                data: {!! json_encode($monthlyRevenueData['data'] ?? [15000, 22000, 18500, 25000, 30000, 28000]) !!},
                backgroundColor: 'rgba(16, 185, 129, 0.2)',
                borderColor: 'rgba(16, 185, 129, 1)',
                borderWidth: 2,
                tension: 0.3
            }]
        };

        const finCtx = document.getElementById('financialChart').getContext('2d');
        const financialChart = new Chart(finCtx, {
            type: 'line',
            data: financialData,
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            callback: function(value) {
                                return '₱' + value.toLocaleString();
                            },
                            color: textColor
                        },
                        grid: {
                            color: gridColor
                        }
                    },
                    x: {
                        ticks: {
                            color: textColor
                        },
                        grid: {
                            color: gridColor
                        }
                    }
                },
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                return '₱' + context.raw.toLocaleString();
                            }
                        }
                    }
                }
            }
        });

        // Revenue by Service Type Chart
        const revenueByServiceData = {
            labels: Object.keys({!! json_encode($revenueByServiceType ?? ['Baptism' => 25000, 'Wedding' => 50000, 'Funeral' => 15000, 'Confirmation' => 20000, 'Mass Intention' => 10000]) !!}),
            datasets: [{
                data: Object.values({!! json_encode($revenueByServiceType ?? ['Baptism' => 25000, 'Wedding' => 50000, 'Funeral' => 15000, 'Confirmation' => 20000, 'Mass Intention' => 10000]) !!}),
                backgroundColor: [
                    'rgba(54, 162, 235, 0.7)',
                    'rgba(255, 99, 132, 0.7)',
                    'rgba(75, 192, 192, 0.7)',
                    'rgba(255, 206, 86, 0.7)',
                    'rgba(153, 102, 255, 0.7)'
                ],
                borderColor: [
                    'rgba(54, 162, 235, 1)',
                    'rgba(255, 99, 132, 1)',
                    'rgba(75, 192, 192, 1)',
                    'rgba(255, 206, 86, 1)',
                    'rgba(153, 102, 255, 1)'
                ],
                borderWidth: 1
            }]
        };

        const revenueByServiceCtx = document.getElementById('revenueByServiceChart').getContext('2d');
        const revenueByServiceChart = new Chart(revenueByServiceCtx, {
            type: 'pie',
            data: revenueByServiceData,
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            color: textColor,
                            font: {
                                size: 12
                            }
                        }
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                const value = context.raw;
                                const total = context.dataset.data.reduce((a, b) => a + b, 0);
                                const percentage = Math.round((value / total) * 100);
                                return `₱${value.toLocaleString()} (${percentage}%)`;
                            }
                        }
                    }
                }
            }
        });

        // Booking Status Chart
        const bookingStatusData = {
            labels: ['Approved', 'Pending', 'Cancelled'],
            datasets: [{
                data: [
                    {{ $bookingCompletionRate['approved'] ?? 50 }}, 
                    {{ $bookingCompletionRate['pending'] ?? 30 }}, 
                    {{ $bookingCompletionRate['cancelled'] ?? 20 }}
                ],
                backgroundColor: [
                    'rgba(16, 185, 129, 0.7)',  // Green for approved
                    'rgba(245, 158, 11, 0.7)',  // Yellow for pending
                    'rgba(239, 68, 68, 0.7)'    // Red for cancelled
                ],
                borderColor: [
                    'rgba(16, 185, 129, 1)',
                    'rgba(245, 158, 11, 1)',
                    'rgba(239, 68, 68, 1)'
                ],
                borderWidth: 1
            }]
        };

        const bookingStatusCtx = document.getElementById('bookingStatusChart').getContext('2d');
        const bookingStatusChart = new Chart(bookingStatusCtx, {
            type: 'doughnut',
            data: bookingStatusData,
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            color: textColor,
                            font: {
                                size: 12
                            }
                        }
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                const value = context.raw;
                                const total = context.dataset.data.reduce((a, b) => a + b, 0);
                                const percentage = Math.round((value / total) * 100);
                                return `${context.label}: ${value} (${percentage}%)`;
                            }
                        }
                    }
                }
            }
        });

        // Peak Booking Times Chart
        const peakBookingData = {
            labels: Object.keys({!! json_encode($peakBookingTimes ?? ['Sunday' => 15, 'Monday' => 25, 'Tuesday' => 30, 'Wednesday' => 40, 'Thursday' => 35, 'Friday' => 20, 'Saturday' => 10]) !!}),
            datasets: [{
                label: 'Bookings',
                data: Object.values({!! json_encode($peakBookingTimes ?? ['Sunday' => 15, 'Monday' => 25, 'Tuesday' => 30, 'Wednesday' => 40, 'Thursday' => 35, 'Friday' => 20, 'Saturday' => 10]) !!}),
                backgroundColor: 'rgba(79, 70, 229, 0.7)',
                borderColor: 'rgba(79, 70, 229, 1)',
                borderWidth: 1
            }]
        };

        const peakBookingCtx = document.getElementById('peakBookingChart').getContext('2d');
        const peakBookingChart = new Chart(peakBookingCtx, {
            type: 'bar',
            data: peakBookingData,
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            color: textColor
                        },
                        grid: {
                            color: gridColor
                        }
                    },
                    x: {
                        ticks: {
                            color: textColor
                        },
                        grid: {
                            color: gridColor
                        }
                    }
                },
                plugins: {
                    legend: {
                        display: false
                    }
                }
            }
        });

        // User Registration Trends Chart
        const userRegistrationData = {
            labels: {!! json_encode($userRegistrationTrends['labels'] ?? ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun']) !!},
            datasets: [{
                label: 'New Users',
                data: {!! json_encode($userRegistrationTrends['data'] ?? [8, 12, 15, 10, 18, 20]) !!},
                backgroundColor: 'rgba(124, 58, 237, 0.2)',
                borderColor: 'rgba(124, 58, 237, 1)',
                borderWidth: 2,
                tension: 0.3
            }]
        };

        const userRegistrationCtx = document.getElementById('userRegistrationChart').getContext('2d');
        const userRegistrationChart = new Chart(userRegistrationCtx, {
            type: 'line',
            data: userRegistrationData,
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            stepSize: 5,
                            color: textColor
                        },
                        grid: {
                            color: gridColor
                        }
                    },
                    x: {
                        ticks: {
                            color: textColor
                        },
                        grid: {
                            color: gridColor
                        }
                    }
                },
                plugins: {
                    legend: {
                        display: false
                    }
                }
            }
        });

        // Handle theme changes to update chart colors
        const themeToggle = document.getElementById('theme-toggle');
        if (themeToggle) {
            themeToggle.addEventListener('click', function() {
                // Give time for the theme to change
                setTimeout(function() {
                    const newTextColor = document.documentElement.classList.contains('dark') ? '#e2e8f0' : '#4b5563';
                    const newGridColor = document.documentElement.classList.contains('dark') ? 'rgba(255, 255, 255, 0.1)' : 'rgba(0, 0, 0, 0.1)';
                    
                    // Update chart text colors
                    [financialChart, serviceDistributionChart, revenueByServiceChart, bookingStatusChart, peakBookingChart, userRegistrationChart].forEach(chart => {
                        if (chart.options.scales) {
                            if (chart.options.scales.y) {
                                chart.options.scales.y.ticks.color = newTextColor;
                                chart.options.scales.y.grid.color = newGridColor;
                            }
                            if (chart.options.scales.x) {
                                chart.options.scales.x.ticks.color = newTextColor;
                                chart.options.scales.x.grid.color = newGridColor;
                            }
                        }
                        
                        if (chart.options.plugins && chart.options.plugins.legend && chart.options.plugins.legend.labels) {
                            chart.options.plugins.legend.labels.color = newTextColor;
                        }
                        
                        chart.update();
                    });
                }, 100);
            });
        }
    });
</script>

<!-- Add a print button for reports -->
<script>
    function printDashboard() {
        // Create a new window
        const printWindow = window.open('', '_blank');
        
        // Get all chart canvases
        const charts = document.querySelectorAll('canvas');
        const chartImages = [];
        
        // Convert all charts to images
        charts.forEach((canvas, index) => {
            chartImages.push(canvas.toDataURL('image/png'));
        });
        
        // Create the print content
        let printContent = `
            <html>
            <head>
                <title>Santa Marta Parish Dashboard Report - ${new Date().toLocaleDateString()}</title>
                <style>
                    body { font-family: Arial, sans-serif; padding: 20px; }
                    h1 { text-align: center; color: #1f2937; }
                    .report-header { text-align: center; margin-bottom: 30px; }
                    .date { font-size: 14px; color: #6b7280; margin-top: 10px; }
                    .section { margin-bottom: 30px; }
                    .section-title { color: #1f2937; border-bottom: 1px solid #e5e7eb; padding-bottom: 10px; }
                    .metrics { display: flex; flex-wrap: wrap; gap: 20px; margin-bottom: 20px; }
                    .metric-card { border: 1px solid #e5e7eb; border-radius: 8px; padding: 15px; width: calc(25% - 20px); box-sizing: border-box; }
                    .metric-title { font-size: 14px; color: #6b7280; margin-bottom: 5px; }
                    .metric-value { font-size: 24px; font-weight: bold; color: #1f2937; }
                    .chart-container { margin-top: 20px; text-align: center; page-break-inside: avoid; }
                    .chart { max-width: 100%; height: auto; }
                    table { width: 100%; border-collapse: collapse; margin-top: 20px; }
                    th, td { border: 1px solid #e5e7eb; padding: 12px; text-align: left; }
                    th { background-color: #f9fafb; }
                    @media print {
                        .no-break { page-break-inside: avoid; }
                    }
                </style>
            </head>
            <body>
                <div class="report-header">
                    <h1>Santa Marta Parish Dashboard Report</h1>
                    <div class="date">Generated on ${new Date().toLocaleDateString()} at ${new Date().toLocaleTimeString()}</div>
                </div>
                
                <div class="section">
                    <h2 class="section-title">Overview</h2>
                    <div class="metrics">
                        <div class="metric-card">
                            <div class="metric-title">Total Bookings</div>
                            <div class="metric-value">${document.querySelector('.text-blue-500').closest('.bg-white').querySelector('.text-2xl').textContent.trim()}</div>
                        </div>
                        <div class="metric-card">
                            <div class="metric-title">Pending Approval</div>
                            <div class="metric-value">${document.querySelector('.text-yellow-500').closest('.bg-white').querySelector('.text-2xl').textContent.trim()}</div>
                        </div>
                        <div class="metric-card">
                            <div class="metric-title">Today's Services</div>
                            <div class="metric-value">${document.querySelector('.text-emerald-500').closest('.bg-white').querySelector('.text-2xl').textContent.trim()}</div>
                        </div>
                        <div class="metric-card">
                            <div class="metric-title">Registered Users</div>
                            <div class="metric-value">${document.querySelector('.text-purple-500').closest('.bg-white').querySelector('.text-2xl').textContent.trim()}</div>
                        </div>
                    </div>
                </div>
                
                <div class="section no-break">
                    <h2 class="section-title">Financial Overview</h2>
                    <div class="chart-container">
                        <img class="chart" src="${chartImages[0]}" alt="Revenue Trends">
                    </div>
                </div>
                
                <div class="section no-break">
                    <h2 class="section-title">Service Distribution</h2>
                    <div class="chart-container">
                        <img class="chart" src="${chartImages[2]}" alt="Service Distribution">
                    </div>
                </div>
                
                <div class="section no-break">
                    <h2 class="section-title">Revenue by Service</h2>
                    <div class="chart-container">
                        <img class="chart" src="${chartImages[1]}" alt="Revenue by Service">
                    </div>
                </div>
                
                <div class="section no-break">
                    <h2 class="section-title">Booking Status</h2>
                    <div class="chart-container">
                        <img class="chart" src="${chartImages[3]}" alt="Booking Status">
                    </div>
                </div>
                
                <div class="section no-break">
                    <h2 class="section-title">Peak Booking Days</h2>
                    <div class="chart-container">
                        <img class="chart" src="${chartImages[4]}" alt="Peak Booking Days">
                    </div>
                </div>
                
                <div class="section no-break">
                    <h2 class="section-title">User Registration Trends</h2>
                    <div class="chart-container">
                        <img class="chart" src="${chartImages[5]}" alt="User Registration Trends">
                    </div>
                </div>
            </body>
            </html>
        `;
        
        // Write to the new window and print
        printWindow.document.open();
        printWindow.document.write(printContent);
        printWindow.document.close();
        
        // Wait for images to load before printing
        setTimeout(() => {
            printWindow.print();
        }, 500);
    }
</script>

<!-- Add a floating print button -->
<div class="fixed bottom-6 right-6">
    <button onclick="printDashboard()" class="bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-full p-3 shadow-lg transition-all duration-300 flex items-center">
        <i class="fas fa-print mr-2"></i>
        Print Report
    </button>
</div>
@endsection