@extends('layouts.admin')

@section('title', 'Calendar View')

@section('content')
<div class="container px-6 mx-auto py-8">
    <!-- Enhanced Page Header -->
    <div class="text-center mb-8">
        <div class="flex justify-center items-center space-x-3 mb-4">
            <div class="p-3 bg-emerald-100 dark:bg-emerald-900 rounded-full">
                <i class="fas fa-calendar-alt text-2xl text-emerald-600 dark:text-emerald-400"></i>
            </div>
            <div>
                <h1 class="text-3xl font-bold text-gray-800 dark:text-gray-100">Service Bookings Calendar</h1>
                <p class="text-gray-600 dark:text-gray-400">Manage and view church services and activities</p>
            </div>
        </div>
    </div>

    <!-- Enhanced Filter Controls -->
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-6 mb-8 border-l-4 border-emerald-500">
        <div class="flex items-center mb-4">
            <i class="fas fa-filter text-emerald-600 dark:text-emerald-400 mr-2"></i>
            <h2 class="text-lg font-semibold text-gray-700 dark:text-gray-300">Filter Events</h2>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-3 gap-3">
            <div>
                <label for="service-type-filter" class="flex items-center text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                    <i class="fas fa-church mr-2 text-blue-500"></i>
                    Service Type
                </label>
                <select id="service-type-filter" class="w-full bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-emerald-500 focus:border-emerald-500 p-3 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white">
                    <option value="all">All Services</option>
                    <option value="baptism">Baptism</option>
                    <option value="wedding">Wedding</option>
                    <option value="confirmation">Confirmation</option>
                    <option value="mass_intention">Mass Intention</option>
                    <option value="blessing">Blessing</option>
                    <option value="sick_call">Sick Call</option>
                    <option value="funeral">Funeral</option>
                </select>
            </div>
            
            <div>
                <label for="status-filter" class="flex items-center text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                    <i class="fas fa-check-circle mr-2 text-green-500"></i>
                    Status
                </label>
                <select id="status-filter" class="w-full bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-emerald-500 focus:border-emerald-500 p-3 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white">
                    <option value="all">All Statuses</option>
                    <option value="approved" selected>Approved</option>
                    <option value="pending">Pending</option>
                    <option value="cancelled">Cancelled</option>
                    <option value="payment_on_hold">Payment On Hold</option>
                </select>
            </div>
            
            <div>
                <label for="view-filter" class="flex items-center text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                    <i class="fas fa-eye mr-2 text-purple-500"></i>
                    View Type
                </label>
                <select id="view-filter" class="w-full bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-emerald-500 focus:border-emerald-500 p-3 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white">
                    <option value="all">Show All</option>
                    <option value="bookings">Bookings Only</option>
                    <option value="activities">Activities Only</option>
                </select>
            </div>
        </div>
    </div>

    <!-- Enhanced Legend Section -->
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-6 mb-8">
        <div class="flex items-center mb-4">
            <i class="fas fa-palette text-pink-500 mr-2"></i>
            <h2 class="text-lg font-semibold text-gray-700 dark:text-gray-300">Color Legend</h2>
        </div>
        
        <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6 gap-4">
            <!-- Service Types -->
            <div class="bg-gradient-to-r from-emerald-50 to-emerald-100 dark:from-emerald-900/20 dark:to-emerald-800/20 p-3 rounded-lg border border-emerald-200 dark:border-emerald-700">
                <div class="flex items-center space-x-2">
                    <div class="w-4 h-4 bg-emerald-500 rounded-full shadow-sm"></div>
                    <i class="fas fa-baby text-emerald-600 dark:text-emerald-400"></i>
                    <span class="text-sm font-medium text-gray-700 dark:text-gray-300">Baptism</span>
                </div>
            </div>
            
            <div class="bg-gradient-to-r from-blue-50 to-blue-100 dark:from-blue-900/20 dark:to-blue-800/20 p-3 rounded-lg border border-blue-200 dark:border-blue-700">
                <div class="flex items-center space-x-2">
                    <div class="w-4 h-4 bg-blue-500 rounded-full shadow-sm"></div>
                    <i class="fas fa-ring text-blue-600 dark:text-blue-400"></i>
                    <span class="text-sm font-medium text-gray-700 dark:text-gray-300">Wedding</span>
                </div>
            </div>
            
            <div class="bg-gradient-to-r from-purple-50 to-purple-100 dark:from-purple-900/20 dark:to-purple-800/20 p-3 rounded-lg border border-purple-200 dark:border-purple-700">
                <div class="flex items-center space-x-2">
                    <div class="w-4 h-4 bg-purple-500 rounded-full shadow-sm"></div>
                    <i class="fas fa-hands-praying text-purple-600 dark:text-purple-400"></i>
                    <span class="text-sm font-medium text-gray-700 dark:text-gray-300">Confirmation</span>
                </div>
            </div>
            
            <div class="bg-gradient-to-r from-yellow-50 to-yellow-100 dark:from-yellow-900/20 dark:to-yellow-800/20 p-3 rounded-lg border border-yellow-200 dark:border-yellow-700">
                <div class="flex items-center space-x-2">
                    <div class="w-4 h-4 bg-yellow-500 rounded-full shadow-sm"></div>
                    <i class="fas fa-candle-holder text-yellow-600 dark:text-yellow-400"></i>
                    <span class="text-sm font-medium text-gray-700 dark:text-gray-300">Mass Intention</span>
                </div>
            </div>
            
            <div class="bg-gradient-to-r from-pink-50 to-pink-100 dark:from-pink-900/20 dark:to-pink-800/20 p-3 rounded-lg border border-pink-200 dark:border-pink-700">
                <div class="flex items-center space-x-2">
                    <div class="w-4 h-4 bg-pink-500 rounded-full shadow-sm"></div>
                    <i class="fas fa-heart text-pink-600 dark:text-pink-400"></i>
                    <span class="text-sm font-medium text-gray-700 dark:text-gray-300">Blessing</span>
                </div>
            </div>
            
            <div class="bg-gradient-to-r from-orange-50 to-orange-100 dark:from-orange-900/20 dark:to-orange-800/20 p-3 rounded-lg border border-orange-200 dark:border-orange-700">
                <div class="flex items-center space-x-2">
                    <div class="w-4 h-4 bg-orange-500 rounded-full shadow-sm"></div>
                    <i class="fas fa-cross text-orange-600 dark:text-orange-400"></i>
                    <span class="text-sm font-medium text-gray-700 dark:text-gray-300">Sick Call</span>
                </div>
            </div>
        </div>
        
        <!-- Activity Types -->
        <div class="mt-6 border-t border-gray-200 dark:border-gray-700 pt-4">
            <h3 class="text-md font-medium text-gray-600 dark:text-gray-400 mb-3 flex items-center">
                <i class="fas fa-calendar-week mr-2"></i>
                Parish Activities
            </h3>
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-4">
                <div class="bg-gradient-to-r from-indigo-50 to-indigo-100 dark:from-indigo-900/20 dark:to-indigo-800/20 p-3 rounded-lg border border-indigo-200 dark:border-indigo-700">
                    <div class="flex items-center space-x-2">
                        <div class="w-4 h-4 bg-indigo-600 rounded-full shadow-sm"></div>
                        <i class="fas fa-church text-indigo-600 dark:text-indigo-400"></i>
                        <span class="text-sm font-medium text-gray-700 dark:text-gray-300">Mass</span>
                    </div>
                </div>
                
                <div class="bg-gradient-to-r from-amber-50 to-amber-100 dark:from-amber-900/20 dark:to-amber-800/20 p-3 rounded-lg border border-amber-200 dark:border-amber-700">
                    <div class="flex items-center space-x-2">
                        <div class="w-4 h-4 bg-amber-600 rounded-full shadow-sm"></div>
                        <i class="fas fa-users text-amber-600 dark:text-amber-400"></i>
                        <span class="text-sm font-medium text-gray-700 dark:text-gray-300">Meeting</span>
                    </div>
                </div>
                
                <div class="bg-gradient-to-r from-teal-50 to-teal-100 dark:from-teal-900/20 dark:to-teal-800/20 p-3 rounded-lg border border-teal-200 dark:border-teal-700">
                    <div class="flex items-center space-x-2">
                        <div class="w-4 h-4 bg-teal-600 rounded-full shadow-sm"></div>
                        <i class="fas fa-star text-teal-600 dark:text-teal-400"></i>
                        <span class="text-sm font-medium text-gray-700 dark:text-gray-300">Event</span>
                    </div>
                </div>
                
                <div class="bg-gradient-to-r from-rose-50 to-rose-100 dark:from-rose-900/20 dark:to-rose-800/20 p-3 rounded-lg border border-rose-200 dark:border-rose-700">
                    <div class="flex items-center space-x-2">
                        <div class="w-4 h-4 bg-rose-600 rounded-full shadow-sm"></div>
                        <i class="fas fa-gift text-rose-600 dark:text-rose-400"></i>
                        <span class="text-sm font-medium text-gray-700 dark:text-gray-300">Holiday</span>
                    </div>
                </div>
                
                <div class="bg-gradient-to-r from-red-50 to-red-100 dark:from-red-900/20 dark:to-red-800/20 p-3 rounded-lg border border-red-200 dark:border-red-700">
                    <div class="flex items-center space-x-2">
                        <div class="w-4 h-4 bg-red-500 rounded-full shadow-sm"></div>
                        <i class="fas fa-ban text-red-600 dark:text-red-400"></i>
                        <span class="text-sm font-medium text-gray-700 dark:text-gray-300">Blocked</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Enhanced Calendar Container -->
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg overflow-hidden">
        <!-- Calendar Navigation -->
        <div class="bg-gradient-to-r from-emerald-600 to-emerald-700 px-6 py-4">
            <div class="flex items-center justify-between">
                <button onclick="previousMonth()" class="text-white hover:bg-emerald-500 p-3 rounded-lg transition-colors duration-200 flex items-center">
                    <i class="fas fa-chevron-left mr-2"></i>
                    Previous
                </button>
                
                <div class="text-center">
                    <h2 class="text-2xl font-bold text-white" id="currentMonth"></h2>
                    <p class="text-emerald-100 text-sm">Click any date to view details</p>
                </div>
                
                <button onclick="nextMonth()" class="text-white hover:bg-emerald-500 p-3 rounded-lg transition-colors duration-200 flex items-center">
                    Next
                    <i class="fas fa-chevron-right ml-2"></i>
                </button>
            </div>
        </div>

        <!-- Calendar Grid -->
        <div class="p-6">
            <!-- Day Headers -->
            <div class="grid grid-cols-7 gap-2 mb-4">
                <div class="text-center font-semibold text-gray-600 dark:text-gray-400 py-2 border-b-2 border-red-200">
                    <i class="fas fa-sun text-red-500"></i><br>
                    <span class="text-sm">Sunday</span>
                </div>
                <div class="text-center font-semibold text-gray-600 dark:text-gray-400 py-2 border-b-2 border-blue-200">
                    <i class="fas fa-calendar-day text-blue-500"></i><br>
                    <span class="text-sm">Monday</span>
                </div>
                <div class="text-center font-semibold text-gray-600 dark:text-gray-400 py-2 border-b-2 border-green-200">
                    <i class="fas fa-calendar-day text-green-500"></i><br>
                    <span class="text-sm">Tuesday</span>
                </div>
                <div class="text-center font-semibold text-gray-600 dark:text-gray-400 py-2 border-b-2 border-yellow-200">
                    <i class="fas fa-calendar-day text-yellow-500"></i><br>
                    <span class="text-sm">Wednesday</span>
                </div>
                <div class="text-center font-semibold text-gray-600 dark:text-gray-400 py-2 border-b-2 border-orange-200">
                    <i class="fas fa-calendar-day text-orange-500"></i><br>
                    <span class="text-sm">Thursday</span>
                </div>
                <div class="text-center font-semibold text-gray-600 dark:text-gray-400 py-2 border-b-2 border-purple-200">
                    <i class="fas fa-calendar-day text-purple-500"></i><br>
                    <span class="text-sm">Friday</span>
                </div>
                <div class="text-center font-semibold text-gray-600 dark:text-gray-400 py-2 border-b-2 border-indigo-200">
                    <i class="fas fa-calendar-week text-indigo-500"></i><br>
                    <span class="text-sm">Saturday</span>
                </div>
            </div>
            <div id="calendarGrid" class="grid grid-cols-7 gap-2"></div>
        </div>

        <!-- Today's Quick Stats -->
        <div class="bg-gray-50 dark:bg-gray-700 px-6 py-4 border-t border-gray-200 dark:border-gray-600">
            <div class="flex items-center justify-center space-x-8 text-sm">
                <div class="flex items-center space-x-2">
                    <i class="fas fa-calendar-check text-green-500"></i>
                    <span class="text-gray-600 dark:text-gray-400">Today:</span>
                    <span id="todayStats" class="font-semibold text-gray-800 dark:text-gray-200">0 events</span>
                </div>
                <div class="flex items-center space-x-2">
                    <i class="fas fa-calendar-week text-blue-500"></i>
                    <span class="text-gray-600 dark:text-gray-400">This Week:</span>
                    <span id="weekStats" class="font-semibold text-gray-800 dark:text-gray-200">0 events</span>
                </div>
                <div class="flex items-center space-x-2">
                    <i class="fas fa-calendar-alt text-purple-500"></i>
                    <span class="text-gray-600 dark:text-gray-400">This Month:</span>
                    <span id="monthStats" class="font-semibold text-gray-800 dark:text-gray-200">0 events</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Enhanced Events Details Panel -->
    <div id="bookingsForDate" class="hidden mt-8">
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg overflow-hidden">
            <div class="bg-gradient-to-r from-blue-600 to-blue-700 px-6 py-4">
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-3">
                        <i class="fas fa-calendar-day text-2xl text-white"></i>
                        <div>
                            <h3 class="text-xl font-bold text-white">Events for <span id="selectedDateDisplay"></span></h3>
                            <p class="text-blue-100 text-sm">Detailed view of scheduled activities</p>
                        </div>
                    </div>
                    <button onclick="closeEventDetails()" class="text-white hover:bg-blue-500 p-2 rounded-lg transition-colors duration-200">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            </div>

            <div class="p-6">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                    <!-- Activities Section -->
                    <div id="activitiesSection">
                        <div class="flex items-center space-x-3 mb-4">
                            <div class="p-2 bg-indigo-100 dark:bg-indigo-900 rounded-lg">
                                <i class="fas fa-church text-indigo-600 dark:text-indigo-400"></i>
                            </div>
                            <h4 class="text-lg font-semibold text-gray-700 dark:text-gray-300">Parish Activities</h4>
                        </div>
                        <div id="activitiesList" class="space-y-4"></div>
                        <div id="noActivities" class="hidden text-center py-8">
                            <i class="fas fa-calendar-times text-4xl text-gray-300 dark:text-gray-600 mb-3"></i>
                            <p class="text-gray-500 dark:text-gray-400">No activities scheduled for this date.</p>
                        </div>
                    </div>

                    <!-- Bookings Section -->
                    <div id="bookingsSection">
                        <div class="flex items-center space-x-3 mb-4">
                            <div class="p-2 bg-emerald-100 dark:bg-emerald-900 rounded-lg">
                                <i class="fas fa-bookmark text-emerald-600 dark:text-emerald-400"></i>
                            </div>
                            <h4 class="text-lg font-semibold text-gray-700 dark:text-gray-300">Service Bookings</h4>
                        </div>
                        <div id="bookingsList" class="space-y-4"></div>
                        <div id="noBookings" class="hidden text-center py-8">
                            <i class="fas fa-calendar-check text-4xl text-gray-300 dark:text-gray-600 mb-3"></i>
                            <p class="text-gray-500 dark:text-gray-400">No bookings scheduled for this date.</p>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

<script>
    // Store all bookings from the controller
    const allBookings = @json($approvedBookings ?? []);
    // Store all parochial activities
    const allActivities = @json($activities ?? []);
    
    let filteredBookings = [...allBookings];
    let filteredActivities = [...allActivities];
    let selectedDate = null;

    // Enhanced service type colors and icons
    const serviceConfig = {
        'baptism': { color: 'bg-emerald-500', icon: 'fas fa-baby', borderColor: 'border-emerald-500' },
        'wedding': { color: 'bg-blue-500', icon: 'fas fa-ring', borderColor: 'border-blue-500' },
        'confirmation': { color: 'bg-purple-500', icon: 'fas fa-hands-praying', borderColor: 'border-purple-500' },
        'mass_intention': { color: 'bg-yellow-500', icon: 'fas fa-candle-holder', borderColor: 'border-yellow-500' },
        'blessing': { color: 'bg-pink-500', icon: 'fas fa-heart', borderColor: 'border-pink-500' },
        'sick_call': { color: 'bg-orange-500', icon: 'fas fa-cross', borderColor: 'border-orange-500' },
        'funeral': { color: 'bg-gray-600', icon: 'fas fa-cross', borderColor: 'border-gray-600' }
    };
    
    // Enhanced activity type colors and icons
    const activityConfig = {
        'mass': { color: 'bg-indigo-600', icon: 'fas fa-church', borderColor: 'border-indigo-600' },
        'meeting': { color: 'bg-amber-600', icon: 'fas fa-users', borderColor: 'border-amber-600' },
        'event': { color: 'bg-teal-600', icon: 'fas fa-star', borderColor: 'border-teal-600' },
        'holiday': { color: 'bg-rose-600', icon: 'fas fa-gift', borderColor: 'border-rose-600' },
        'maintenance': { color: 'bg-gray-600', icon: 'fas fa-tools', borderColor: 'border-gray-600' },
        'blocked': { color: 'bg-red-500', icon: 'fas fa-ban', borderColor: 'border-red-500' }
    };

    // Initialize calendar
    document.addEventListener('DOMContentLoaded', () => {
        const today = new Date();
        renderCalendar(today.getFullYear(), today.getMonth());
        updateStats();
        
        // Set up event listeners for filters
        document.getElementById('service-type-filter').addEventListener('change', applyFilters);
        document.getElementById('status-filter').addEventListener('change', applyFilters);
        document.getElementById('view-filter').addEventListener('change', applyFilters);
    });

    function applyFilters() {
        const serviceType = document.getElementById('service-type-filter').value;
        const status = document.getElementById('status-filter').value;
        const view = document.getElementById('view-filter').value;
        
        // Filter bookings
        filteredBookings = allBookings.filter(booking => {
            const serviceTypeMatch = serviceType === 'all' || booking.type === serviceType;
            const statusMatch = status === 'all' || booking.status === status;
            const viewMatch = view === 'all' || view === 'bookings';
            return serviceTypeMatch && statusMatch && viewMatch;
        });
        
        // Filter activities
        filteredActivities = allActivities.filter(activity => {
            return view === 'all' || view === 'activities';
        });
        
        // Re-render the calendar with the filtered events
        const currentMonth = document.getElementById('currentMonth').textContent;
        const date = new Date(currentMonth);
        renderCalendar(date.getFullYear(), date.getMonth());
        updateStats();
        
        // If a date was selected, update the events for that date
        if (selectedDate) {
            showEventsForDate(selectedDate);
        }
    }

    function renderCalendar(year, month) {
        const firstDay = new Date(year, month, 1);
        const lastDay = new Date(year, month + 1, 0);
        const startingDay = firstDay.getDay();
        const monthLength = lastDay.getDate();
        
        // Update month display
        const monthNames = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
        document.getElementById('currentMonth').textContent = `${monthNames[month]} ${year}`;

        const calendarGrid = document.getElementById('calendarGrid');
        calendarGrid.innerHTML = '';

        // Add empty cells for days before the first day of the month
        for (let i = 0; i < startingDay; i++) {
            const emptyCell = document.createElement('div');
            emptyCell.className = 'h-32 rounded-lg bg-gray-50 dark:bg-gray-700';
            calendarGrid.appendChild(emptyCell);
        }

        // Add cells for each day of the month
        for (let day = 1; day <= monthLength; day++) {
            const date = new Date(year, month, day);
            const cell = document.createElement('div');
            const isToday = date.toDateString() === new Date().toDateString();
            const isSelected = selectedDate && date.toDateString() === selectedDate.toDateString();

            // Format date string for comparison with events
            const dateString = formatDateString(date);
            
            // Get bookings for this date
            const bookingsForDay = filteredBookings.filter(booking => 
                booking.preferred_date === dateString
            );
            
            // Get activities for this date
            const activitiesForDay = filteredActivities.filter(activity => 
                activity.date === dateString
            );
            
            // Check if this date has blocked times
            const hasBlockedTimes = activitiesForDay.some(activity => activity.block_bookings);

            // Enhanced cell styling
            let className = 'min-h-32 rounded-lg border-2 p-3 relative cursor-pointer transition-all duration-300 ';
            
            if (isToday) {
                className += 'ring-4 ring-emerald-300 ring-opacity-50 shadow-lg ';
            }
            
            if (isSelected) {
                className += 'bg-gradient-to-br from-emerald-50 to-emerald-100 dark:from-emerald-900/30 dark:to-emerald-800/30 border-emerald-400 ';
            } else {
                className += 'bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700 border-gray-200 dark:border-gray-700 hover:border-emerald-300 ';
            }
            
            // Add blocked time indicator
            if (hasBlockedTimes) {
                className += 'border-red-400 bg-red-50 dark:bg-red-900/20 ';
            }

            cell.className = className;

            // Create enhanced date number with icons
            const dateHeader = document.createElement('div');
            dateHeader.className = 'flex items-center justify-between mb-2';
            
            const dateNumber = document.createElement('div');
            dateNumber.className = `text-lg font-bold ${isToday ? 'text-emerald-600 dark:text-emerald-400' : 'text-gray-700 dark:text-gray-300'}`;
            dateNumber.textContent = day;
            
            const eventCount = bookingsForDay.length + activitiesForDay.length;
            if (eventCount > 0) {
                const countBadge = document.createElement('div');
                countBadge.className = 'bg-emerald-500 text-white text-xs font-bold rounded-full w-6 h-6 flex items-center justify-center';
                countBadge.textContent = eventCount;
                dateHeader.appendChild(countBadge);
            }
            
            dateHeader.appendChild(dateNumber);
            cell.appendChild(dateHeader);

            // Add enhanced booking indicators
            if (bookingsForDay.length > 0) {
                const bookingContainer = document.createElement('div');
                bookingContainer.className = 'mb-2 space-y-1';
                
                // Group bookings by type to show one indicator per type
                const bookingTypes = [...new Set(bookingsForDay.map(b => b.type))];
                
                bookingTypes.slice(0, 3).forEach(type => {
                    const count = bookingsForDay.filter(b => b.type === type).length;
                    const config = serviceConfig[type];
                    const indicator = document.createElement('div');
                    indicator.className = `${config.color} text-white text-xs rounded-lg px-2 py-1 flex items-center shadow-sm`;
                    indicator.innerHTML = `<i class="${config.icon} mr-1"></i><span>${count}</span>`;
                    bookingContainer.appendChild(indicator);
                });
                
                if (bookingTypes.length > 3) {
                    const moreIndicator = document.createElement('div');
                    moreIndicator.className = 'bg-gray-500 text-white text-xs rounded-lg px-2 py-1 text-center';
                    moreIndicator.textContent = `+${bookingTypes.length - 3} more`;
                    bookingContainer.appendChild(moreIndicator);
                }
                
                cell.appendChild(bookingContainer);
            }
            
            // Add enhanced activity indicators
            if (activitiesForDay.length > 0) {
                const activityContainer = document.createElement('div');
                activityContainer.className = 'space-y-1';
                
                // Group activities by type
                const activityTypes = [...new Set(activitiesForDay.map(a => a.block_bookings ? 'blocked' : a.type))];
                
                activityTypes.slice(0, 2).forEach(type => {
                    const count = type === 'blocked' 
                        ? activitiesForDay.filter(a => a.block_bookings).length
                        : activitiesForDay.filter(a => a.type === type && !a.block_bookings).length;
                    
                    if (count > 0) {
                        const config = activityConfig[type];
                        const indicator = document.createElement('div');
                        indicator.className = `${config.color} text-white text-xs rounded-lg px-2 py-1 flex items-center shadow-sm`;
                        indicator.innerHTML = `<i class="${config.icon} mr-1"></i><span>${count}</span>`;
                        activityContainer.appendChild(indicator);
                    }
                });
                
                if (activityTypes.length > 2) {
                    const moreIndicator = document.createElement('div');
                    moreIndicator.className = 'bg-gray-500 text-white text-xs rounded-lg px-2 py-1 text-center';
                    moreIndicator.textContent = `+${activityTypes.length - 2}`;
                    activityContainer.appendChild(moreIndicator);
                }
                
                cell.appendChild(activityContainer);
            }

            // Add click event to show bookings for this date
            cell.addEventListener('click', () => {
                selectedDate = date;
                showEventsForDate(date);
                
                // Update selected styling
                document.querySelectorAll('#calendarGrid > div').forEach(cell => {
                    cell.classList.remove('bg-gradient-to-br', 'from-emerald-50', 'to-emerald-100', 'dark:from-emerald-900/30', 'dark:to-emerald-800/30', 'border-emerald-400');
                    if (!cell.classList.contains('bg-gray-50')) {
                        cell.classList.add('bg-white', 'dark:bg-gray-800', 'border-gray-200', 'dark:border-gray-700');
                    }
                });
                
                cell.classList.remove('bg-white', 'dark:bg-gray-800', 'border-gray-200', 'dark:border-gray-700');
                cell.classList.add('bg-gradient-to-br', 'from-emerald-50', 'to-emerald-100', 'dark:from-emerald-900/30', 'dark:to-emerald-800/30', 'border-emerald-400');
            });

            calendarGrid.appendChild(cell);
        }
    }

    function showEventsForDate(date) {
        const dateString = formatDateString(date);
        const formattedDate = date.toLocaleDateString('en-US', { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' });
        
        document.getElementById('selectedDateDisplay').textContent = formattedDate;
        
        // Show bookings section
        const bookingsForDate = filteredBookings.filter(booking => booking.preferred_date === dateString);
        const bookingsList = document.getElementById('bookingsList');
        const noBookings = document.getElementById('noBookings');
        
        bookingsList.innerHTML = '';
        
        if (bookingsForDate.length > 0) {
            bookingsForDate.forEach(booking => {
                const config = serviceConfig[booking.type];
                const bookingCard = document.createElement('div');
                bookingCard.innerHTML = `
                    <div class="flex items-center space-x-4">
                        <div class="flex-shrink-0">
                            <div class="w-12 h-12 flex items-center justify-center rounded-full ${config.color} shadow-md">
                                <i class="${config.icon} text-white text-xl"></i>
                            </div>
                        </div>
                        <div class="flex-1 min-w-0">
                            <h5 class="font-bold text-lg text-gray-800 dark:text-gray-100 font-sans">${booking.ticket_number}</h5>
                            <div class="flex items-center space-x-2 mt-1">
                                <span class="text-sm font-medium capitalize text-emerald-700 dark:text-emerald-300 font-sans">${booking.type.replace('_', ' ')}</span>
                                <span class="text-xs px-2 py-1 rounded-full ${getStatusColor(booking.status)} font-bold uppercase tracking-wide font-sans">${booking.status}</span>
                            </div>
                            <div class="text-xs text-gray-500 dark:text-gray-400 mt-1 font-sans">
                                <i class="fas fa-clock mr-1"></i>${formatTime(booking.preferred_time)}
                            </div>
                        </div>
                        <div>
                            <a href="/admin/bookings/${booking.id}" class="text-emerald-600 hover:text-emerald-800 dark:text-emerald-400 dark:hover:text-emerald-300 p-2 hover:bg-emerald-100 dark:hover:bg-emerald-900/30 rounded-lg transition-colors duration-200">
                                <i class="fas fa-eye"></i>
                            </a>
                        </div>
                    </div>
                `;
                bookingCard.className = `p-5 rounded-2xl shadow-lg bg-white dark:bg-gray-800 border border-gray-100 dark:border-gray-700 transition-transform duration-200 hover:scale-105 hover:shadow-xl font-sans mb-2`;
                bookingsList.appendChild(bookingCard);
            });
            
            noBookings.classList.add('hidden');
        } else {
            noBookings.classList.remove('hidden');
        }
        
        // Show activities section
        const activitiesForDate = filteredActivities.filter(activity => activity.date === dateString);
        const activitiesList = document.getElementById('activitiesList');
        const noActivities = document.getElementById('noActivities');
        
        activitiesList.innerHTML = '';
        
        if (activitiesForDate.length > 0) {
            activitiesForDate.forEach(activity => {
                const config = activityConfig[activity.block_bookings ? 'blocked' : activity.type];
                const activityCard = document.createElement('div');
                activityCard.innerHTML = `
                    <div class="flex items-center space-x-4">
                        <div class="flex-shrink-0">
                            <div class="w-12 h-12 flex items-center justify-center rounded-full ${config.color} shadow-md">
                                <i class="${config.icon} text-white text-xl"></i>
                            </div>
                        </div>
                        <div class="flex-1 min-w-0">
                            <h5 class="font-bold text-lg text-gray-800 dark:text-gray-100 font-sans">${activity.title}</h5>
                            <div class="flex items-center space-x-2 mt-1">
                                <span class="text-sm font-medium capitalize text-indigo-700 dark:text-indigo-300 font-sans">${activity.type}</span>
                                ${activity.block_bookings ? `<span class="text-xs px-2 py-1 rounded-full bg-red-100 text-red-700 font-bold uppercase tracking-wide font-sans">Blocked</span>` : ''}
                            </div>
                            <div class="text-xs text-gray-500 dark:text-gray-400 mt-1 font-sans">
                                <i class="fas fa-clock mr-1"></i>${formatTime(activity.start_time)} - ${formatTime(activity.end_time)}
                            </div>
                            ${activity.description ? `<div class="text-xs text-gray-400 dark:text-gray-500 mt-1 font-sans">${activity.description}</div>` : ''}
                        </div>
                        <div>
                            <a href="/admin/activities/${activity.id}/edit" class="text-emerald-600 hover:text-emerald-800 dark:text-emerald-400 dark:hover:text-emerald-300 p-2 hover:bg-emerald-100 dark:hover:bg-emerald-900/30 rounded-lg transition-colors duration-200">
                                <i class="fas fa-edit"></i>
                            </a>
                        </div>
                    </div>
                `;
                activityCard.className = `p-5 rounded-2xl shadow-lg bg-white dark:bg-gray-800 border border-gray-100 dark:border-gray-700 transition-transform duration-200 hover:scale-105 hover:shadow-xl font-sans mb-2`;
                activitiesList.appendChild(activityCard);
            });
            
            noActivities.classList.add('hidden');
        } else {
            noActivities.classList.remove('hidden');
        }
        
        document.getElementById('bookingsForDate').classList.remove('hidden');
        document.getElementById('bookingsForDate').scrollIntoView({ behavior: 'smooth' });
    }

    function updateStats() {
        // Get the displayed month and year from the calendar header
        const currentMonthText = document.getElementById('currentMonth').textContent;
        const [displayedMonthName, displayedYear] = currentMonthText.split(' ');
        const monthNames = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
        const displayedMonth = monthNames.indexOf(displayedMonthName);
        const displayedYearNum = parseInt(displayedYear);

        const today = new Date();
        const todayString = formatDateString(today);
        
        // Calculate today's events (still based on real today)
        const todayBookings = filteredBookings.filter(b => b.preferred_date === todayString).length;
        const todayActivities = filteredActivities.filter(a => a.date === todayString).length;
        const todayTotal = todayBookings + todayActivities;
        
        // Calculate this week's events (for the week containing today)
        const startOfWeek = new Date(today.getFullYear(), today.getMonth(), today.getDate() - today.getDay());
        const endOfWeek = new Date(startOfWeek.getFullYear(), startOfWeek.getMonth(), startOfWeek.getDate() + 6);
        let weekTotal = 0;
        for (let d = new Date(startOfWeek); d <= endOfWeek; d.setDate(d.getDate() + 1)) {
            const dateString = formatDateString(d);
            weekTotal += filteredBookings.filter(b => b.preferred_date === dateString).length;
            weekTotal += filteredActivities.filter(a => a.date === dateString).length;
        }
        
        // Calculate this month's events (for the displayed month)
        const monthBookings = filteredBookings.filter(b => {
            if (!b.preferred_date) return false;
            const date = new Date(b.preferred_date);
            return date.getMonth() === displayedMonth && date.getFullYear() === displayedYearNum;
        }).length;
        const monthActivities = filteredActivities.filter(a => {
            if (!a.date) return false;
            const date = new Date(a.date);
            return date.getMonth() === displayedMonth && date.getFullYear() === displayedYearNum;
        }).length;
        const monthTotal = monthBookings + monthActivities;
        
        document.getElementById('todayStats').textContent = `${todayTotal} event${todayTotal !== 1 ? 's' : ''}`;
        document.getElementById('weekStats').textContent = `${weekTotal} event${weekTotal !== 1 ? 's' : ''}`;
        document.getElementById('monthStats').textContent = `${monthTotal} event${monthTotal !== 1 ? 's' : ''}`;
    }

    function getStatusColor(status) {
        const colors = {
            'approved': 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300',
            'pending': 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-300',
            'cancelled': 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-300',
            'payment_on_hold': 'bg-orange-100 text-orange-800 dark:bg-orange-900 dark:text-orange-300'
        };
        return colors[status] || 'bg-gray-100 text-gray-800 dark:bg-gray-900 dark:text-gray-300';
    }

    function formatDateString(date) {
        const year = date.getFullYear();
        const month = String(date.getMonth() + 1).padStart(2, '0');
        const day = String(date.getDate()).padStart(2, '0');
        return `${year}-${month}-${day}`;
    }

    function formatTime(timeString) {
        if (!timeString) return '';
        
        const [hours, minutes] = timeString.split(':').map(Number);
        const period = hours >= 12 ? 'PM' : 'AM';
        const displayHours = hours % 12 || 12;
        
        return `${displayHours}:${minutes.toString().padStart(2, '0')} ${period}`;
    }

    function previousMonth() {
        const currentMonth = document.getElementById('currentMonth').textContent;
        const date = new Date(currentMonth);
        date.setMonth(date.getMonth() - 1);
        renderCalendar(date.getFullYear(), date.getMonth());
        updateStats();
        
        // Clear selected date when changing months
        selectedDate = null;
        document.getElementById('bookingsForDate').classList.add('hidden');
    }
    
    function nextMonth() {
        const currentMonth = document.getElementById('currentMonth').textContent;
        const date = new Date(currentMonth);
        date.setMonth(date.getMonth() + 1);
        renderCalendar(date.getFullYear(), date.getMonth());
        updateStats();
        
        // Clear selected date when changing months
        selectedDate = null;
        document.getElementById('bookingsForDate').classList.add('hidden');
    }

    function closeEventDetails() {
        document.getElementById('bookingsForDate').classList.add('hidden');
        selectedDate = null;
        
        // Remove selected styling from all calendar cells
        document.querySelectorAll('#calendarGrid > div').forEach(cell => {
            cell.classList.remove('bg-gradient-to-br', 'from-emerald-50', 'to-emerald-100', 'dark:from-emerald-900/30', 'dark:to-emerald-800/30', 'border-emerald-400');
            if (!cell.classList.contains('bg-gray-50')) {
                cell.classList.add('bg-white', 'dark:bg-gray-800', 'border-gray-200', 'dark:border-gray-700');
            }
        });
    }
</script>

@endsection
