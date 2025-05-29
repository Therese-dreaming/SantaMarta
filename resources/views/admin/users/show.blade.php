@extends('layouts.admin')

@section('title', 'User Details - ' . $user->name)

@section('content')
<div class="container mx-auto px-4 py-6 font-sans">
    <!-- Back button with improved styling -->
    <div class="mb-6">
        <a href="{{ route('admin.users.index') }}" class="group inline-flex items-center px-3 py-2 text-sm font-medium rounded-md text-gray-600 dark:text-gray-300 hover:text-emerald-600 dark:hover:text-emerald-400 hover:bg-gray-100 dark:hover:bg-gray-700/50 transition-all duration-200">
            <i class="fas fa-arrow-left mr-2 group-hover:-translate-x-1 transition-transform duration-200"></i> Back to Users List
        </a>
    </div>

    <!-- User profile card with enhanced design -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-6">
        <!-- User information card -->
        <div class="lg:col-span-1">
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm overflow-hidden h-full">
                <div class="p-6">
                    <div class="flex flex-col items-center text-center mb-6">
                        <div class="h-24 w-24 rounded-full bg-emerald-100 dark:bg-emerald-900/30 flex items-center justify-center text-emerald-600 dark:text-emerald-400 mb-4">
                            <span class="text-3xl font-bold">{{ strtoupper(substr($user->name, 0, 1)) }}</span>
                        </div>
                        <h2 class="text-xl font-bold text-gray-900 dark:text-white">{{ $user->name }}</h2>
                        <p class="text-gray-500 dark:text-gray-400 font-medium">{{ $user->email }}</p>
                        <div class="mt-3">
                            <span class="px-3 py-1 text-xs font-medium rounded-full {{ $user->is_admin ? 'bg-purple-100 text-purple-800 dark:bg-purple-900/50 dark:text-purple-300' : 'bg-blue-100 text-blue-800 dark:bg-blue-900/50 dark:text-blue-300' }}">
                                {{ $user->is_admin ? 'Administrator' : 'Regular User' }}
                            </span>
                        </div>
                    </div>
                    
                    {{-- Edit and Delete buttons moved here --}}
                    <div class="flex space-x-2 mt-6 mb-4 border-gray-200 dark:border-gray-700 py-4">
                        <a href="{{ route('admin.users.edit', $user->id) }}" class="flex-1 inline-flex justify-center items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-emerald-600 hover:bg-emerald-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500 transition-colors duration-200">
                            <i class="fas fa-edit mr-2"></i> Edit User
                        </a>
                        <button type="button" onclick="confirmDelete()" class="inline-flex justify-center items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition-colors duration-200">
                            <i class="fas fa-trash-alt"></i>
                        </button>
                    </div>

                    <div class="border-t border-gray-200 dark:border-gray-700 pt-4">
                        <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-3">Account Information</h3>
                        <div class="space-y-3">
                            <div class="flex justify-between items-center">
                                <span class="text-gray-600 dark:text-gray-400">Member Since</span>
                                <span class="text-gray-900 dark:text-white font-medium">{{ $user->created_at->format('F d, Y') }}</span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-gray-600 dark:text-gray-400">Last Login</span>
                                <span class="text-gray-900 dark:text-white font-medium">{{ $user->updated_at->diffForHumans() }}</span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-gray-600 dark:text-gray-400">Total Bookings</span>
                                <span class="text-gray-900 dark:text-white font-medium">{{ $totalBookingsCount }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Service bookings card -->
        <div class="lg:col-span-2">
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm overflow-hidden h-full">
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                    <h2 class="text-lg font-semibold text-gray-800 dark:text-white mb-4 sm:mb-0">Service Bookings</h2>
                </div>

                <div class="p-6">
                    @if($bookings->count() > 0)
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                                <thead>
                                    <tr class="bg-gray-50 dark:bg-gray-700">
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Ticket #</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Service Type</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Date</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Status</th>
                                        <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Amount</th>
                                        <th scope="col" class="relative px-6 py-3">
                                            <span class="sr-only">View</span>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700" id="bookings-table-body">
                                    @foreach($bookings as $booking)
                                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors duration-150" data-status="{{ strtolower(str_replace('_', ' ', $booking->status)) }}" data-ticket="{{ strtolower($booking->ticket_number) }}" data-type="{{ strtolower(str_replace('_', ' ', $booking->type)) }}">
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <span class="text-sm font-medium text-gray-900 dark:text-white">{{ $booking->ticket_number }}</span>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="flex items-center">
                                                    <div class="flex-shrink-0 h-8 w-8 rounded-full bg-{{ $booking->service_color }}-100 dark:bg-{{ $booking->service_color }}-900/30 flex items-center justify-center text-{{ $booking->service_color }}-600 dark:text-{{ $booking->service_color }}-400 mr-3">
                                                        <i class="{{ $booking->service_icon }}"></i>
                                                    </div>
                                                    <span class="text-sm text-gray-500 dark:text-gray-400 font-medium">{{ ucwords(str_replace('_', ' ', $booking->type)) }}</span>
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <span class="text-sm text-gray-500 dark:text-gray-400 font-medium">{{ Carbon\Carbon::parse($booking->preferred_date)->format('F d, Y') }}</span>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full {{ $booking->status === 'approved' ? 'bg-green-100 text-green-800 dark:bg-green-900/50 dark:text-green-300' : ($booking->status === 'pending' ? 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900/50 dark:text-yellow-300' : ($booking->status === 'payment_on_hold' ? 'bg-blue-100 text-blue-800 dark:bg-blue-900/50 dark:text-blue-300' : 'bg-red-100 text-red-800 dark:bg-red-300')) }}">
                                                    {{ ucwords(str_replace('_', ' ', $booking->status)) }}
                                                </span>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm text-gray-500 dark:text-gray-400">
                                                <span class="font-medium">₱{{ number_format($booking->amount, 2) }}</span>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                                <a href="{{ route('admin.bookings.show', $booking->id) }}" class="text-emerald-600 hover:text-emerald-900 dark:text-emerald-400 dark:hover:text-emerald-300 hover:underline transition-colors duration-150">
                                                    View Details
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        
                        <div class="mt-4">
                            {{ $bookings->links() }}
                        </div>
                    @else
                        <div class="bg-gray-50 dark:bg-gray-700/50 rounded-lg p-8 text-center">
                            <div class="mx-auto h-16 w-16 rounded-full bg-gray-100 dark:bg-gray-800 flex items-center justify-center text-gray-400 dark:text-gray-500 mb-4">
                                <i class="fas fa-calendar-alt text-2xl"></i>
                            </div>
                            <h3 class="text-gray-500 dark:text-gray-400 text-lg font-medium mb-2">No Bookings Found</h3>
                            <p class="text-gray-500 dark:text-gray-400 max-w-md mx-auto">This user has not created any service bookings yet. When they do, they will appear here.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Activity and Stats Section -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Recent Activity -->
        <div class="lg:col-span-2">
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                    <h2 class="text-lg font-semibold text-gray-800 dark:text-white">Recent Activity</h2>
                </div>
                <div class="p-6">
                    <div class="flow-root">
                        <ul class="-mb-8">
                            @if($totalBookingsCount > 0)
                                @foreach($allBookings->sortByDesc('created_at')->take(5) as $booking)
                                    <li>
                                        <div class="relative pb-8">
                                            @if(!$loop->last)
                                                <span class="absolute top-4 left-4 -ml-px h-full w-0.5 bg-gray-200 dark:bg-gray-700" aria-hidden="true"></span>
                                            @endif
                                            <div class="relative flex space-x-3">
                                                <div>
                                                    <span class="h-8 w-8 rounded-full bg-{{ $booking->service_color }}-100 dark:bg-{{ $booking->service_color }}-900/30 flex items-center justify-center ring-8 ring-white dark:ring-gray-800">
                                                        <i class="{{ $booking->service_icon }} text-{{ $booking->service_color }}-600 dark:text-{{ $booking->service_color }}-400"></i>
                                                    </span>
                                                </div>
                                                <div class="min-w-0 flex-1 pt-1.5 flex justify-between space-x-4">
                                                    <div>
                                                        <p class="text-sm text-gray-500 dark:text-gray-400">Created a <span class="font-medium text-gray-900 dark:text-white">{{ ucwords(str_replace('_', ' ', $booking->type)) }}</span> booking</p>
                                                    </div>
                                                    <div class="text-right text-sm whitespace-nowrap text-gray-500 dark:text-gray-400">
                                                        <time datetime="{{ $booking->created_at->format('Y-m-d') }}">{{ $booking->created_at->diffForHumans() }}</time>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                @endforeach
                            @else
                                <li class="text-center py-4">
                                    <div class="bg-gray-50 dark:bg-gray-700/50 rounded-lg p-6 text-center">
                                        <div class="mx-auto h-12 w-12 rounded-full bg-gray-100 dark:bg-gray-800 flex items-center justify-center text-gray-400 dark:text-gray-500 mb-4">
                                            <i class="fas fa-history text-2xl"></i>
                                        </div>
                                        <h3 class="text-gray-500 dark:text-gray-400 text-lg font-medium mb-2">No Recent Activity</h3>
                                        <p class="text-gray-500 dark:text-gray-400 max-w-md mx-auto text-sm">This user has not made any recent booking activity to display yet.</p>
                                    </div>
                                </li>
                            @endif
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <!-- Stats Card -->
        <div class="lg:col-span-1">
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                    <h2 class="text-lg font-semibold text-gray-800 dark:text-white">Statistics</h2>
                </div>
                <div class="p-6">
                    <dl class="grid grid-cols-1 gap-5">
                        <div class="bg-gray-50 dark:bg-gray-700/50 rounded-lg p-5">
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400 truncate">Total Bookings</dt>
                            <dd class="mt-1 text-3xl font-semibold text-gray-900 dark:text-white">{{ $totalBookingsCount }}</dd>
                        </div>
                        <div class="bg-gray-50 dark:bg-gray-700/50 rounded-lg p-5">
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400 truncate">Pending Bookings</dt>
                            <dd class="mt-1 text-3xl font-semibold text-yellow-600 dark:text-yellow-400">{{ $pendingBookingsCount }}</dd>
                        </div>
                        <div class="bg-gray-50 dark:bg-gray-700/50 rounded-lg p-5">
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400 truncate">Approved Bookings</dt>
                            <dd class="mt-1 text-3xl font-semibold text-green-600 dark:text-green-400">{{ $approvedBookingsCount }}</dd>
                        </div>
                        <div class="bg-gray-50 dark:bg-gray-700/50 rounded-lg p-5">
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400 truncate">Total Amount</dt>
                            <dd class="mt-1 text-3xl font-semibold text-gray-900 dark:text-white">₱{{ number_format($totalBookingsAmount, 2) }}</dd>
                        </div>
                    </dl>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div id="delete-modal" class="fixed inset-0 z-50 overflow-y-auto hidden" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 dark:bg-gray-900 dark:bg-opacity-75 transition-opacity" aria-hidden="true"></div>
        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
        <div class="inline-block align-bottom bg-white dark:bg-gray-800 rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
            <div class="bg-white dark:bg-gray-800 px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                <div class="sm:flex sm:items-start">
                    <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-red-100 dark:bg-red-900/30 sm:mx-0 sm:h-10 sm:w-10">
                        <i class="fas fa-exclamation-triangle text-red-600 dark:text-red-400"></i>
                    </div>
                    <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                        <h3 class="text-lg leading-6 font-medium text-gray-900 dark:text-white" id="modal-title">Delete User Account</h3>
                        <div class="mt-2">
                            <p class="text-sm text-gray-500 dark:text-gray-400">Are you sure you want to delete this user account? All of their data will be permanently removed. This action cannot be undone.</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="bg-gray-50 dark:bg-gray-700 px-4 py-3 sm:px-6 flex flex-row-reverse items-center gap-3">
                <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" class="w-full sm:w-auto">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="inline-flex justify-center items-center rounded-md border border-red-600 shadow-sm px-4 py-2 bg-red-600 text-base font-font-medium text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 sm:w-auto sm:text-sm sm:min-w-[6rem] transition-colors duration-200">
                        Delete
                    </button>
                </form>
                <button type="button" onclick="closeDeleteModal()" class="inline-flex justify-center items-center rounded-md border border-gray-300 dark:border-gray-600 shadow-sm px-4 py-2 bg-white dark:bg-gray-700 text-base font-medium text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500 sm:w-auto sm:text-sm sm:min-w-[6rem] transition-colors duration-200">
                    Cancel
                </button>
            </div>
        </div>
    </div>
</div>

@endsection

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Dark mode toggle
        const darkModeToggle = document.getElementById('dark-mode-toggle');
        if (darkModeToggle) {
            darkModeToggle.addEventListener('click', function() {
                document.documentElement.classList.toggle('dark');
                const isDark = document.documentElement.classList.contains('dark');
                localStorage.setItem('darkMode', isDark ? 'enabled' : 'disabled');

                // Update icon
                const sunIcon = document.getElementById('sun-icon');
                const moonIcon = document.getElementById('moon-icon');
                if (sunIcon && moonIcon) {
                    sunIcon.classList.toggle('hidden');
                    moonIcon.classList.toggle('hidden');
                }
            });

            // Check for saved dark mode preference
            if (localStorage.getItem('darkMode') === 'enabled' || 
                (window.matchMedia('(prefers-color-scheme: dark)').matches && !localStorage.getItem('darkMode'))) {
                document.documentElement.classList.add('dark');
                const sunIcon = document.getElementById('sun-icon');
                const moonIcon = document.getElementById('moon-icon');
                if (sunIcon && moonIcon) {
                    sunIcon.classList.add('hidden');
                    moonIcon.classList.remove('hidden');
                } else {
                    // Default state (light mode) if no preference is saved
                    sunIcon.classList.remove('hidden');
                    moonIcon.classList.add('hidden');
                }
            }
        }

        // Delete modal functions
        window.confirmDelete = function() {
            document.getElementById('delete-modal').classList.remove('hidden');
        }

        window.closeDeleteModal = function() {
            document.getElementById('delete-modal').classList.add('hidden');
        }
    });
</script>