@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')
<div class="font-[Poppins]">
    <!-- Welcome Header -->
    <div class="mb-6">
        <h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-2">Welcome back, {{ Auth::user()->name }}!</h1>
        <p class="text-gray-600 dark:text-gray-400">Here's what's happening at Santa Marta Parish today.</p>
    </div>

    <!-- Charts Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-8">
        <!-- Bookings Trend Chart -->
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700">
            <div class="p-6 border-b border-gray-200 dark:border-gray-700">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white flex items-center">
                    <i class="fas fa-chart-line text-emerald-600 dark:text-emerald-400 mr-2"></i>
                    Bookings Trend
                </h3>
            </div>
            <div class="p-6">
                <canvas id="bookingsTrendChart" height="80"></canvas>
            </div>
        </div>

        <!-- User Registrations Chart -->
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700">
            <div class="p-6 border-b border-gray-200 dark:border-gray-700">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white flex items-center">
                    <i class="fas fa-user-plus text-blue-600 dark:text-blue-400 mr-2"></i>
                    User Registrations
                </h3>
            </div>
            <div class="p-6">
                <canvas id="userGrowthChart" height="80"></canvas>
            </div>
        </div>

        <!-- Revenue Trend Chart (spans both columns on md, single on lg) -->
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 md:col-span-2">
            <div class="p-6 border-b border-gray-200 dark:border-gray-700">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white flex items-center">
                    <i class="fas fa-coins text-yellow-600 dark:text-yellow-400 mr-2"></i>
                    Revenue Trend
                </h3>
            </div>
            <div class="p-6">
                <canvas id="revenueTrendChart" height="80"></canvas>
            </div>
        </div>
    </div>

    <!-- Quick Actions - Moved to Top -->
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 mb-8">
        <div class="p-6 border-b border-gray-200 dark:border-gray-700">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white flex items-center">
                <i class="fas fa-bolt text-emerald-600 dark:text-emerald-400 mr-2"></i>
                Quick Actions
            </h3>
        </div>
        <div class="p-6">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                <a href="{{ route('admin.bookings') }}" class="flex items-center p-4 bg-emerald-50 dark:bg-emerald-900/10 hover:bg-emerald-100 dark:hover:bg-emerald-900/20 rounded-lg transition-all duration-200 group hover:shadow-md">
                    <div class="p-3 bg-emerald-100 dark:bg-emerald-900/20 rounded-lg group-hover:bg-emerald-200 dark:group-hover:bg-emerald-900/40 group-hover:scale-110 transition-all duration-200">
                        <i class="fas fa-list text-emerald-600 dark:text-emerald-400 text-lg"></i>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-semibold text-gray-900 dark:text-white">Manage Bookings</p>
                        <p class="text-xs text-gray-600 dark:text-gray-400">Review and approve</p>
                        @if($pendingBookings > 0)
                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800 dark:bg-yellow-900/20 dark:text-yellow-400 mt-1">
                                {{ $pendingBookings }} pending
                            </span>
                        @endif
                    </div>
                </a>

                <a href="{{ route('admin.activities.create') }}" class="flex items-center p-4 bg-blue-50 dark:bg-blue-900/10 hover:bg-blue-100 dark:hover:bg-blue-900/20 rounded-lg transition-all duration-200 group hover:shadow-md">
                    <div class="p-3 bg-blue-100 dark:bg-blue-900/20 rounded-lg group-hover:bg-blue-200 dark:group-hover:bg-blue-900/40 group-hover:scale-110 transition-all duration-200">
                        <i class="fas fa-plus text-blue-600 dark:text-blue-400 text-lg"></i>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-semibold text-gray-900 dark:text-white">Add Activity</p>
                        <p class="text-xs text-gray-600 dark:text-gray-400">Schedule new event</p>
                    </div>
                </a>

                <a href="{{ route('admin.users.index') }}" class="flex items-center p-4 bg-purple-50 dark:bg-purple-900/10 hover:bg-purple-100 dark:hover:bg-purple-900/20 rounded-lg transition-all duration-200 group hover:shadow-md">
                    <div class="p-3 bg-purple-100 dark:bg-purple-900/20 rounded-lg group-hover:bg-purple-200 dark:group-hover:bg-purple-900/40 group-hover:scale-110 transition-all duration-200">
                        <i class="fas fa-users text-purple-600 dark:text-purple-400 text-lg"></i>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-semibold text-gray-900 dark:text-white">Manage Users</p>
                        <p class="text-xs text-gray-600 dark:text-gray-400">{{ number_format($totalUsers) }} registered</p>
                        @if($newUsersThisMonth > 0)
                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900/20 dark:text-green-400 mt-1">
                                +{{ $newUsersThisMonth }} this month
                            </span>
                        @endif
                    </div>
                </a>

                <a href="{{ route('admin.reports') }}" class="flex items-center p-4 bg-yellow-50 dark:bg-yellow-900/10 hover:bg-yellow-100 dark:hover:bg-yellow-900/20 rounded-lg transition-all duration-200 group hover:shadow-md">
                    <div class="p-3 bg-yellow-100 dark:bg-yellow-900/20 rounded-lg group-hover:bg-yellow-200 dark:group-hover:bg-yellow-900/40 group-hover:scale-110 transition-all duration-200">
                        <i class="fas fa-chart-bar text-yellow-600 dark:text-yellow-400 text-lg"></i>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-semibold text-gray-900 dark:text-white">View Reports</p>
                        <p class="text-xs text-gray-600 dark:text-gray-400">Analytics & insights</p>
                    </div>
                </a>
            </div>
        </div>
    </div>

    <!-- Quick Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <!-- Total Bookings -->
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-6 border border-gray-200 dark:border-gray-700">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-blue-100 dark:bg-blue-900/20">
                    <i class="fas fa-calendar-alt text-blue-600 dark:text-blue-400 text-xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Total Bookings</p>
                    <p class="text-2xl font-semibold text-gray-900 dark:text-white">{{ number_format($totalBookings) }}</p>
                </div>
            </div>
        </div>

        <!-- Pending Bookings -->
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-6 border border-gray-200 dark:border-gray-700">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-yellow-100 dark:bg-yellow-900/20">
                    <i class="fas fa-clock text-yellow-600 dark:text-yellow-400 text-xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Pending Approval</p>
                    <p class="text-2xl font-semibold text-gray-900 dark:text-white">{{ number_format($pendingBookings) }}</p>
                </div>
            </div>
            @if($pendingBookings > 0)
                <div class="mt-4">
                    <a href="{{ route('admin.bookings') }}" class="text-yellow-600 hover:text-yellow-800 text-sm font-medium">Review pending →</a>
                </div>
            @endif
        </div>

        <!-- Payment Verification -->
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-6 border border-gray-200 dark:border-gray-700">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-orange-100 dark:bg-orange-900/20">
                    <i class="fas fa-money-check-alt text-orange-600 dark:text-orange-400 text-xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Payment Verification</p>
                    <p class="text-2xl font-semibold text-gray-900 dark:text-white">{{ number_format($paymentsToVerify) }}</p>
                </div>
            </div>
            @if($paymentsToVerify > 0)
                <div class="mt-4">
                    <a href="{{ route('admin.bookings') }}" class="text-orange-600 hover:text-orange-800 text-sm font-medium">Verify payments →</a>
                </div>
            @endif
        </div>

        <!-- Monthly Revenue -->
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-6 border border-gray-200 dark:border-gray-700">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-green-100 dark:bg-green-900/20">
                    <i class="fas fa-peso-sign text-green-600 dark:text-green-400 text-xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600 dark:text-gray-400">This Month</p>
                    <p class="text-2xl font-semibold text-gray-900 dark:text-white">₱{{ number_format($monthlyRevenue, 2) }}</p>
                </div>
            </div>
            <div class="mt-2">
                <p class="text-xs text-gray-500 dark:text-gray-400">Total: ₱{{ number_format($totalRevenue, 2) }}</p>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
        <!-- Recent Bookings -->
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700">
            <div class="p-6 border-b border-gray-200 dark:border-gray-700">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Recent Bookings</h3>
                <p class="text-sm text-gray-600 dark:text-gray-400">Last 7 days</p>
            </div>
            <div class="p-6">
                @if($recentBookings->count() > 0)
                    <div class="space-y-4">
                        @foreach($recentBookings->take(5) as $booking)
                            <div class="flex items-center justify-between p-4 bg-gray-50 dark:bg-gray-700 rounded-lg">
                                <div class="flex items-center space-x-3">
                                    <div class="p-2 rounded-full bg-{{ $booking->service_color }}-100 dark:bg-{{ $booking->service_color }}-900/20">
                                        <i class="{{ $booking->service_icon }} text-{{ $booking->service_color }}-600 dark:text-{{ $booking->service_color }}-400"></i>
                                    </div>
                                    <div>
                                        <p class="text-sm font-medium text-gray-900 dark:text-white">{{ $booking->ticket_number }}</p>
                                        <p class="text-xs text-gray-600 dark:text-gray-400">{{ ucfirst(str_replace('_', ' ', $booking->type)) }}</p>
                                        <p class="text-xs text-gray-500 dark:text-gray-500">{{ $booking->user->name ?? 'Unknown' }}</p>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                                        @if($booking->status === 'pending') bg-yellow-100 text-yellow-800 dark:bg-yellow-900/20 dark:text-yellow-400
                                        @elseif($booking->status === 'approved') bg-green-100 text-green-800 dark:bg-green-900/20 dark:text-green-400
                                        @elseif($booking->status === 'payment_on_hold') bg-orange-100 text-orange-800 dark:bg-orange-900/20 dark:text-orange-400
                                        @else bg-gray-100 text-gray-800 dark:bg-gray-900/20 dark:text-gray-400
                                        @endif">
                                        {{ ucfirst(str_replace('_', ' ', $booking->status)) }}
                                    </span>
                                    <p class="text-xs text-gray-500 dark:text-gray-500 mt-1">{{ $booking->created_at->diffForHumans() }}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <div class="mt-4 text-center">
                        <a href="{{ route('admin.bookings') }}" class="text-emerald-600 hover:text-emerald-800 dark:text-emerald-400 dark:hover:text-emerald-300 text-sm font-medium">
                            View all bookings →
                        </a>
                    </div>
                @else
                    <div class="text-center py-8">
                        <i class="fas fa-calendar-alt text-gray-400 text-4xl mb-3"></i>
                        <p class="text-gray-500 dark:text-gray-400">No recent bookings</p>
                    </div>
                @endif
            </div>
        </div>

        <!-- Today's Schedule -->
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700">
            <div class="p-6 border-b border-gray-200 dark:border-gray-700">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Today's Schedule</h3>
                <p class="text-sm text-gray-600 dark:text-gray-400">{{ now()->format('F d, Y') }}</p>
            </div>
            <div class="p-6">
                @if($todaysBookings->count() > 0)
                    <div class="space-y-3">
                        @foreach($todaysBookings as $booking)
                            <div class="flex items-center justify-between p-3 bg-emerald-50 dark:bg-emerald-900/10 rounded-lg border border-emerald-200 dark:border-emerald-800">
                                <div class="flex items-center space-x-3">
                                    <div class="p-2 rounded-full bg-emerald-100 dark:bg-emerald-900/20">
                                        <i class="{{ $booking->service_icon }} text-emerald-600 dark:text-emerald-400 text-sm"></i>
                                    </div>
                                    <div>
                                        <p class="text-sm font-medium text-gray-900 dark:text-white">{{ $booking->ticket_number }}</p>
                                        <p class="text-xs text-gray-600 dark:text-gray-400">{{ ucfirst(str_replace('_', ' ', $booking->type)) }}</p>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <p class="text-sm font-medium text-gray-900 dark:text-white">{{ $booking->preferred_time ?? 'No time set' }}</p>
                                    <p class="text-xs text-gray-600 dark:text-gray-400">{{ $booking->user->name ?? 'Unknown' }}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-8">
                        <i class="fas fa-calendar-check text-gray-400 text-4xl mb-3"></i>
                        <p class="text-gray-500 dark:text-gray-400">No scheduled services today</p>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Upcoming Activities -->
    @if($upcomingActivities->count() > 0)
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 mb-8">
        <div class="p-6 border-b border-gray-200 dark:border-gray-700">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Upcoming Activities</h3>
            <p class="text-sm text-gray-600 dark:text-gray-400">Scheduled parish events</p>
        </div>
        <div class="p-6">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                @foreach($upcomingActivities as $activity)
                    <div class="border border-gray-200 dark:border-gray-700 rounded-lg p-4 hover:shadow-md transition-shadow">
                        <div class="flex items-start justify-between mb-2">
                            <h4 class="font-semibold text-gray-900 dark:text-white text-sm">{{ $activity->title }}</h4>
                            @if($activity->is_recurring)
                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800 dark:bg-blue-900/20 dark:text-blue-400">
                                    <i class="fas fa-repeat mr-1"></i> Recurring
                                </span>
                            @endif
                        </div>
                        <p class="text-xs text-gray-600 dark:text-gray-400 mb-3">{{ Str::limit($activity->description, 100) }}</p>
                        <div class="flex items-center justify-between text-xs text-gray-500 dark:text-gray-500">
                            <div class="flex items-center">
                                <i class="fas fa-calendar mr-1"></i>
                                {{ Carbon\Carbon::parse($activity->date)->format('M d, Y') }}
                            </div>
                            @if($activity->time)
                                <div class="flex items-center">
                                    <i class="fas fa-clock mr-1"></i>
                                    {{ Carbon\Carbon::parse($activity->time)->format('g:i A') }}
                                </div>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="mt-4 text-center">
                <a href="{{ route('admin.activities.index') }}" class="text-emerald-600 hover:text-emerald-800 dark:text-emerald-400 dark:hover:text-emerald-300 text-sm font-medium">
                    View all activities →
                </a>
            </div>
        </div>
    </div>
    @endif

    <!-- Service Distribution and Pie Chart Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-8">
        <!-- Service Distribution (existing bar or breakdown) -->
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700">
            <div class="p-6 border-b border-gray-200 dark:border-gray-700">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white flex items-center">
                    <i class="fas fa-chart-bar text-emerald-600 dark:text-emerald-400 mr-2"></i>
                    Service Distribution
                </h3>
            </div>
            <div class="p-6">
                <!-- Existing service distribution breakdown here -->
                @if($serviceTypeStats->count() > 0)
                    <div class="space-y-4">
                        @php 
                            $colors = ['blue', 'emerald', 'yellow', 'red', 'purple', 'indigo'];
                            $totalServices = $serviceTypeStats->sum();
                        @endphp
                        @foreach($serviceTypeStats as $service => $count)
                            @php $color = $colors[array_search($service, $serviceTypeStats->keys()->toArray()) % count($colors)] @endphp
                            <div class="flex items-center justify-between">
                                <div class="flex items-center space-x-3">
                                    <div class="w-4 h-4 rounded-full bg-{{ $color }}-500"></div>
                                    <span class="text-sm font-medium text-gray-900 dark:text-white">{{ $service }}</span>
                                </div>
                                <div class="flex items-center space-x-3">
                                    <div class="w-32 bg-gray-200 dark:bg-gray-700 rounded-full h-2">
                                        <div class="bg-{{ $color }}-500 h-2 rounded-full" style="width: {{ ($count / $totalServices) * 100 }}%"></div>
                                    </div>
                                    <span class="text-sm font-semibold text-gray-900 dark:text-white min-w-[3rem] text-right">{{ $count }}</span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-8">
                        <i class="fas fa-chart-pie text-gray-400 text-4xl mb-3"></i>
                        <p class="text-gray-500 dark:text-gray-400">No service data available</p>
                    </div>
                @endif
            </div>
        </div>
        <!-- Service Type Pie Chart (small) -->
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 flex flex-col items-center justify-center">
            <div class="p-6 border-b border-gray-200 dark:border-gray-700 w-full">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white flex items-center">
                    <i class="fas fa-chart-pie text-purple-600 dark:text-purple-400 mr-2"></i>
                    Service Type Pie
                </h3>
            </div>
            <div class="p-6 flex justify-center">
                <canvas id="serviceTypePieChart" width="180" height="180"></canvas>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    // Auto-refresh dashboard data every 5 minutes
    setInterval(function() {
        // You can add AJAX calls here to refresh specific sections
        // without reloading the entire page
    }, 300000); // 5 minutes
</script>
@endpush
@endsection
