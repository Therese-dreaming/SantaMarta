@extends('layouts.admin')

@section('title', 'Parochial Activities')

@section('content')
<div class="container px-4 mx-auto py-6">
    <!-- Compact Header -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-6">
        <div>
            <h1 class="text-2xl font-bold text-gray-800 dark:text-gray-100 flex items-center">
                <i class="fas fa-calendar-check text-emerald-600 mr-3"></i>
                Parochial Activities
            </h1>
            <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">Manage church activities and schedules</p>
        </div>
        <div class="flex gap-2">
            <a href="{{ route('admin.calendar') }}" class="inline-flex items-center px-3 py-2 text-sm font-medium text-gray-700 dark:text-gray-200 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 rounded-md hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                <i class="fas fa-calendar-alt mr-1.5"></i> Calendar
            </a>
            <a href="{{ route('admin.activities.create') }}" class="inline-flex items-center px-3 py-2 text-sm font-medium text-white bg-emerald-600 hover:bg-emerald-700 rounded-md transition-colors">
                <i class="fas fa-plus mr-1.5"></i> Add Activity
            </a>
        </div>
    </div>

    <!-- Filters -->
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-5 mb-6">
        <div class="flex items-center justify-between mb-4">
            <h2 class="text-lg font-medium text-gray-700 dark:text-gray-300">
                <i class="fas fa-filter mr-2"></i> Filter Activities
            </h2>
            <button id="toggle-filters" class="text-sm text-emerald-600 hover:text-emerald-800 dark:text-emerald-400 dark:hover:text-emerald-300">
                <span id="filter-text">Hide Filters</span> <i id="filter-icon" class="fas fa-chevron-up ml-1"></i>
            </button>
        </div>
        
        <div id="filter-container">
            <form action="{{ route('admin.activities.index') }}" method="GET" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                <div>
                    <label for="filter-type" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Activity Type</label>
                    <select id="filter-type" name="type" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-emerald-500 focus:border-emerald-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white">
                        <option value="">All Types</option>
                        <option value="mass" {{ request('type') == 'mass' ? 'selected' : '' }}>Mass</option>
                        <option value="meeting" {{ request('type') == 'meeting' ? 'selected' : '' }}>Meeting</option>
                        <option value="event" {{ request('type') == 'event' ? 'selected' : '' }}>Special Event</option>
                        <option value="holiday" {{ request('type') == 'holiday' ? 'selected' : '' }}>Holiday</option>
                        <option value="maintenance" {{ request('type') == 'maintenance' ? 'selected' : '' }}>Maintenance</option>
                    </select>
                </div>
                
                <div>
                    <label for="filter-date-from" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Date From</label>
                    <input type="date" id="filter-date-from" name="date_from" value="{{ request('date_from') }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-emerald-500 focus:border-emerald-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white">
                </div>
                
                <div>
                    <label for="filter-date-to" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Date To</label>
                    <input type="date" id="filter-date-to" name="date_to" value="{{ request('date_to') }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-emerald-500 focus:border-emerald-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white">
                </div>
                
                <div>
                    <label for="filter-block" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Booking Status</label>
                    <select id="filter-block" name="block" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-emerald-500 focus:border-emerald-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white">
                        <option value="">All</option>
                        <option value="1" {{ request('block') == '1' ? 'selected' : '' }}>Blocks Bookings</option>
                        <option value="0" {{ request('block') == '0' ? 'selected' : '' }}>Allows Bookings</option>
                    </select>
                </div>
                
                <div class="md:col-span-2 lg:col-span-4 flex flex-wrap gap-2 mt-2">
                    <button type="submit" class="bg-emerald-600 hover:bg-emerald-700 text-white px-4 py-2 rounded-lg flex items-center">
                        <i class="fas fa-filter mr-2"></i> Apply Filters
                    </button>
                    <a href="{{ route('admin.activities.index') }}" class="bg-gray-200 hover:bg-gray-300 text-gray-700 dark:bg-gray-700 dark:hover:bg-gray-600 dark:text-gray-200 px-4 py-2 rounded-lg flex items-center">
                        <i class="fas fa-times mr-2"></i> Clear Filters
                    </a>
                </div>
            </form>
        </div>
    </div>

    <!-- Activities Table -->
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md overflow-hidden">
        <div class="p-4 border-b border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-700">
            <h3 class="text-lg font-medium text-gray-700 dark:text-gray-300">
                @if(request()->anyFilled(['type', 'date_from', 'date_to', 'block']))
                    <span class="text-emerald-600 dark:text-emerald-400">Filtered</span> Activities
                @else
                    All Activities
                @endif
                <span class="text-sm font-normal text-gray-500 dark:text-gray-400 ml-2">({{ $activities->total() }} total)</span>
            </h3>
        </div>
        
        @if(count($activities) > 0)
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                    <thead class="bg-gray-50 dark:bg-gray-700">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Title</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Type</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Date</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Time</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Recurrence</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Bookings</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Created By</th>
                            <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                        @foreach($activities as $activity)
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-700 transition duration-150">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900 dark:text-white">{{ $activity->title }}</div>
                                    @if($activity->description)
                                        <div class="text-xs text-gray-500 dark:text-gray-400 mt-1 truncate max-w-xs">{{ Str::limit($activity->description, 50) }}</div>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full 
                                        @if($activity->type == 'mass') bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200
                                        @elseif($activity->type == 'meeting') bg-purple-100 text-purple-800 dark:bg-purple-900 dark:text-purple-200
                                        @elseif($activity->type == 'event') bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200
                                        @elseif($activity->type == 'holiday') bg-emerald-100 text-emerald-800 dark:bg-emerald-900 dark:text-emerald-200
                                        @else bg-gray-100 text-gray-800 dark:bg-gray-900 dark:text-gray-200
                                        @endif">
                                        {{ ucfirst($activity->type) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-500 dark:text-gray-400">{{ $activity->date->format('M d, Y') }}</div>
                                    <div class="text-xs text-gray-400 dark:text-gray-500">{{ $activity->date->format('l') }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-500 dark:text-gray-400">
                                        {{ $activity->formatted_start_time }} - {{ $activity->formatted_end_time }}
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-500 dark:text-gray-400">
                                        @if($activity->recurrence == 'none')
                                            One-time
                                        @else
                                            {{ ucfirst($activity->recurrence) }}
                                        @endif
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if($activity->block_bookings)
                                        <span class="px-2 inline-flex text-xs font-bold rounded-full bg-red-200 text-red-900 dark:bg-red-800 dark:text-red-100 font-sans tracking-wide uppercase">
                                            Blocked
                                        </span>
                                    @else
                                        <span class="px-2 inline-flex text-xs font-bold rounded-full bg-green-200 text-green-900 dark:bg-green-800 dark:text-green-100 font-sans tracking-wide uppercase">
                                            Allowed
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-500 dark:text-gray-400">
                                        {{ $activity->user ? $activity->user->name : 'System' }}
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <div class="flex justify-end space-x-3">
                                        <a href="{{ route('admin.activities.edit', $activity->id) }}" class="text-emerald-600 hover:text-emerald-900 dark:text-emerald-400 dark:hover:text-emerald-300" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('admin.activities.destroy', $activity->id) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this activity?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-300" title="Delete">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            
            <!-- Pagination -->
            <div class="px-6 py-4 bg-white dark:bg-gray-800 border-t border-gray-200 dark:border-gray-700">
                {{ $activities->withQueryString()->links() }}
            </div>
        @else
            <div class="p-8 text-center">
                <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-gray-100 dark:bg-gray-700 mb-4">
                    <i class="fas fa-calendar-times text-2xl text-gray-500 dark:text-gray-400"></i>
                </div>
                <p class="text-gray-500 dark:text-gray-400 mb-2">No activities found.</p>
                @if(request()->anyFilled(['type', 'date_from', 'date_to', 'block']))
                    <p class="text-sm text-gray-400 dark:text-gray-500 mb-4">Try adjusting your filters or clearing them.</p>
                    <a href="{{ route('admin.activities.index') }}" class="bg-gray-200 hover:bg-gray-300 text-gray-700 dark:bg-gray-700 dark:hover:bg-gray-600 dark:text-gray-200 px-4 py-2 rounded-lg inline-flex items-center">
                        <i class="fas fa-times mr-2"></i> Clear Filters
                    </a>
                @else
                    <a href="{{ route('admin.activities.create') }}" class="mt-4 inline-flex items-center bg-emerald-600 hover:bg-emerald-700 text-white px-4 py-2 rounded-lg">
                        <i class="fas fa-plus mr-2"></i> Add Your First Activity
                    </a>
                @endif
            </div>
        @endif
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Toggle filters
        const toggleButton = document.getElementById('toggle-filters');
        const filterContainer = document.getElementById('filter-container');
        const filterText = document.getElementById('filter-text');
        const filterIcon = document.getElementById('filter-icon');
        
        toggleButton.addEventListener('click', function() {
            if (filterContainer.style.display === 'none') {
                filterContainer.style.display = 'block';
                filterText.textContent = 'Hide Filters';
                filterIcon.classList.remove('fa-chevron-down');
                filterIcon.classList.add('fa-chevron-up');
            } else {
                filterContainer.style.display = 'none';
                filterText.textContent = 'Show Filters';
                filterIcon.classList.remove('fa-chevron-up');
                filterIcon.classList.add('fa-chevron-down');
            }
        });
        
        // Date range validation
        const dateFrom = document.getElementById('filter-date-from');
        const dateTo = document.getElementById('filter-date-to');
        
        dateFrom.addEventListener('change', function() {
            if (dateTo.value && this.value > dateTo.value) {
                dateTo.value = this.value;
            }
        });
        
        dateTo.addEventListener('change', function() {
            if (dateFrom.value && this.value < dateFrom.value) {
                dateFrom.value = this.value;
            }
        });
    });
</script>
@endsection