@extends('layouts.admin')

@section('title', 'Calendar View')

@section('content')
<div class="container px-6 mx-auto py-8">
    <h1 class="text-2xl font-semibold text-gray-700 dark:text-gray-200 mb-6">Service Bookings Calendar</h1>
    
    <!-- Filter Controls -->
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-4 mb-6">
        <div class="flex flex-wrap items-center gap-4">
            <div>
                <label for="service-type-filter" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Filter by Service Type</label>
                <select id="service-type-filter" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-emerald-500 focus:border-emerald-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white">
                    <option value="all">All Services</option>
                    <option value="baptism">Baptism</option>
                    <option value="wedding">Wedding</option>
                    <option value="confirmation">Confirmation</option>
                    <option value="mass_intention">Mass Intention</option>
                    <option value="blessing">Blessing</option>
                    <option value="sick_call">Sick Call</option>
                </select>
            </div>
            <div>
                <label for="status-filter" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Status</label>
                <select id="status-filter" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-emerald-500 focus:border-emerald-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white">
                    <option value="all">All Statuses</option>
                    <option value="approved" selected>Approved</option>
                    <option value="pending">Pending</option>
                    <option value="cancelled">Cancelled</option>
                    <option value="payment_on_hold">Payment On Hold</option>
                </select>
            </div>
            <div>
                <label for="view-filter" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">View</label>
                <select id="view-filter" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-emerald-500 focus:border-emerald-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white">
                    <option value="all">All</option>
                    <option value="bookings">Bookings Only</option>
                    <option value="activities">Activities Only</option>
                </select>
            </div>
        </div>
    </div>
    
    <!-- Calendar -->
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6">
        <!-- Calendar Navigation -->
        <div class="flex items-center justify-between mb-6">
            <button onclick="previousMonth()" class="text-emerald-600 dark:text-emerald-400 hover:bg-emerald-100 dark:hover:bg-emerald-800/30 p-2 rounded-lg">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
            </button>
            <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-200" id="currentMonth"></h2>
            <button onclick="nextMonth()" class="text-emerald-600 dark:text-emerald-400 hover:bg-emerald-100 dark:hover:bg-emerald-800/30 p-2 rounded-lg">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                </svg>
            </button>
        </div>

        <!-- Legend -->
        <div class="mb-4 grid grid-cols-2 md:grid-cols-4 gap-2 text-sm">
            <!-- Service Types -->
            <div class="flex items-center">
                <div class="w-4 h-4 rounded-full bg-emerald-500 mr-2"></div>
                <span class="text-gray-600 dark:text-gray-300">Baptism</span>
            </div>
            <div class="flex items-center">
                <div class="w-4 h-4 rounded-full bg-blue-500 mr-2"></div>
                <span class="text-gray-600 dark:text-gray-300">Wedding</span>
            </div>
            <div class="flex items-center">
                <div class="w-4 h-4 rounded-full bg-purple-500 mr-2"></div>
                <span class="text-gray-600 dark:text-gray-300">Confirmation</span>
            </div>
            <div class="flex items-center">
                <div class="w-4 h-4 rounded-full bg-yellow-500 mr-2"></div>
                <span class="text-gray-600 dark:text-gray-300">Mass Intention</span>
            </div>
            
            <!-- Activity Types -->
            <div class="flex items-center">
                <div class="w-4 h-4 rounded-full bg-gray-800 dark:bg-gray-400 mr-2"></div>
                <span class="text-gray-600 dark:text-gray-300">Parochial Activity</span>
            </div>
            <div class="flex items-center">
                <div class="w-4 h-4 rounded-full bg-red-500 mr-2"></div>
                <span class="text-gray-600 dark:text-gray-300">Blocked Time</span>
            </div>
        </div>

        <!-- Calendar Grid -->
        <div class="grid grid-cols-7 gap-2 mb-4">
            <div class="text-center font-medium text-gray-600 dark:text-gray-400">Sun</div>
            <div class="text-center font-medium text-gray-600 dark:text-gray-400">Mon</div>
            <div class="text-center font-medium text-gray-600 dark:text-gray-400">Tue</div>
            <div class="text-center font-medium text-gray-600 dark:text-gray-400">Wed</div>
            <div class="text-center font-medium text-gray-600 dark:text-gray-400">Thu</div>
            <div class="text-center font-medium text-gray-600 dark:text-gray-400">Fri</div>
            <div class="text-center font-medium text-gray-600 dark:text-gray-400">Sat</div>
        </div>
        <div id="calendarGrid" class="grid grid-cols-7 gap-2"></div>

        <!-- Bookings and Activities for Selected Date -->
        <div id="bookingsForDate" class="hidden mt-8 border-t pt-6">
            <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-200 mb-4">Events for <span id="selectedDateDisplay"></span></h3>
            
            <!-- Activities Section -->
            <div id="activitiesSection" class="mb-6">
                <h4 class="text-md font-medium text-gray-700 dark:text-gray-300 mb-2">Parochial Activities</h4>
                <div id="activitiesList" class="space-y-4"></div>
                <div id="noActivities" class="text-gray-500 dark:text-gray-400 text-sm italic hidden">No activities scheduled for this date.</div>
            </div>
            
            <!-- Bookings Section -->
            <div id="bookingsSection">
                <h4 class="text-md font-medium text-gray-700 dark:text-gray-300 mb-2">Service Bookings</h4>
                <div id="bookingsList" class="space-y-4"></div>
                <div id="noBookings" class="text-gray-500 dark:text-gray-400 text-sm italic hidden">No bookings scheduled for this date.</div>
            </div>
        </div>
    </div>
</div>

<script>
    // Store all bookings from the controller
    const allBookings = @json($approvedBookings);
    // Store all parochial activities
    const allActivities = @json($activities ?? []);
    
    let filteredBookings = [...allBookings];
    let filteredActivities = [...allActivities];
    let selectedDate = null;

    // Service type colors
    const serviceColors = {
        'baptism': 'bg-emerald-500',
        'wedding': 'bg-blue-500',
        'confirmation': 'bg-purple-500',
        'mass_intention': 'bg-yellow-500',
        'blessing': 'bg-red-500',
        'sick_call': 'bg-orange-500'
    };
    
    // Activity type colors - updated with more distinct colors
    const activityColors = {
        'mass': 'bg-indigo-600 dark:bg-indigo-500',
        'meeting': 'bg-amber-600 dark:bg-amber-500',
        'event': 'bg-teal-600 dark:bg-teal-500',
        'holiday': 'bg-pink-600 dark:bg-pink-500',
        'maintenance': 'bg-gray-600 dark:bg-gray-500',
        'blocked': 'bg-red-500'
    };

    // Initialize calendar
    document.addEventListener('DOMContentLoaded', () => {
        const today = new Date();
        renderCalendar(today.getFullYear(), today.getMonth());
        
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
            emptyCell.className = 'h-24 rounded-lg';
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

            // Base cell styling
            let className = 'min-h-24 rounded-lg border border-gray-200 dark:border-gray-700 p-1 relative ';
            
            if (isToday) {
                className += 'ring-2 ring-emerald-500 ring-offset-2 ';
            }
            
            if (isSelected) {
                className += 'bg-emerald-50 dark:bg-emerald-900/20 ';
            } else {
                className += 'bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700 cursor-pointer ';
            }
            
            // Add blocked time indicator
            if (hasBlockedTimes) {
                className += 'border-red-500 border-2 ';
            }

            cell.className = className;

            // Create date number
            const dateNumber = document.createElement('div');
            dateNumber.className = 'text-sm font-medium text-gray-700 dark:text-gray-300';
            dateNumber.textContent = day;
            cell.appendChild(dateNumber);

            // Add booking indicators
            if (bookingsForDay.length > 0) {
                const bookingContainer = document.createElement('div');
                bookingContainer.className = 'mt-1 flex flex-wrap gap-1';
                
                // Group bookings by type to show one indicator per type
                const bookingTypes = [...new Set(bookingsForDay.map(b => b.type))];
                
                bookingTypes.forEach(type => {
                    const count = bookingsForDay.filter(b => b.type === type).length;
                    const indicator = document.createElement('div');
                    indicator.className = `${serviceColors[type]} text-white text-xs rounded-full px-1.5 py-0.5 flex items-center`;
                    indicator.innerHTML = `<span>${count}</span>`;
                    bookingContainer.appendChild(indicator);
                });
                
                cell.appendChild(bookingContainer);
            }
            
            // Add activity indicators
            if (activitiesForDay.length > 0) {
                const activityContainer = document.createElement('div');
                activityContainer.className = 'mt-1 flex flex-wrap gap-1';
                
                // Group activities by type
                const activityTypes = [...new Set(activitiesForDay.map(a => a.block_bookings ? 'blocked' : a.type))];
                
                activityTypes.forEach(type => {
                    const count = type === 'blocked' 
                        ? activitiesForDay.filter(a => a.block_bookings).length
                        : activitiesForDay.filter(a => a.type === type && !a.block_bookings).length;
                    
                    if (count > 0) {
                        const indicator = document.createElement('div');
                        indicator.className = `${activityColors[type]} text-white text-xs rounded-full px-1.5 py-0.5 flex items-center`;
                        indicator.innerHTML = `<span>${count}</span>`;
                        activityContainer.appendChild(indicator);
                    }
                });
                
                cell.appendChild(activityContainer);
            }

            // Add click event to show bookings for this date
            cell.addEventListener('click', () => {
                selectedDate = date;
                showEventsForDate(date);
                
                // Update selected styling
                document.querySelectorAll('#calendarGrid > div').forEach(cell => {
                    cell.classList.remove('bg-emerald-50', 'dark:bg-emerald-900/20');
                    cell.classList.add('bg-white', 'dark:bg-gray-800', 'hover:bg-gray-50', 'dark:hover:bg-gray-700');
                });
                
                cell.classList.remove('bg-white', 'dark:bg-gray-800', 'hover:bg-gray-50', 'dark:hover:bg-gray-700');
                cell.classList.add('bg-emerald-50', 'dark:bg-emerald-900/20');
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
                const bookingCard = document.createElement('div');
                bookingCard.className = `p-4 rounded-lg border ${serviceColors[booking.type].replace('bg-', 'border-')} bg-white dark:bg-gray-800`;
                
                bookingCard.innerHTML = `
    <div class="flex justify-between items-start">
        <div>
            <h5 class="font-medium text-gray-800 dark:text-gray-200">${booking.ticket_number}</h5>
            <p class="text-sm text-gray-600 dark:text-gray-400">${booking.type.replace('_', ' ').charAt(0).toUpperCase() + booking.type.replace('_', ' ').slice(1)}</p>
            <p class="text-sm text-gray-600 dark:text-gray-400">Time: ${formatTime(booking.preferred_time)}</p>
        </div>
        <div class="flex space-x-2">
            <a href="/admin/bookings/${booking.id}" class="text-emerald-600 hover:text-emerald-800 dark:text-emerald-400 dark:hover:text-emerald-300">
                <i class="fas fa-eye"></i>
            </a>
        </div>
    </div>
`;
                
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
                const activityCard = document.createElement('div');
                const borderColor = activity.block_bookings ? 'border-red-500' : 'border-gray-300 dark:border-gray-700';
                const bgColor = activity.block_bookings ? 'bg-red-50 dark:bg-red-900/10' : 'bg-white dark:bg-gray-800';
                
                activityCard.className = `p-4 rounded-lg border ${borderColor} ${bgColor}`;
                
                activityCard.innerHTML = `
                    <div class="flex justify-between items-start">
                        <div>
                            <h5 class="font-medium text-gray-800 dark:text-gray-200">${activity.title}</h5>
                            <p class="text-sm text-gray-600 dark:text-gray-400">${activity.type.charAt(0).toUpperCase() + activity.type.slice(1)}</p>
                            <p class="text-sm text-gray-600 dark:text-gray-400">Time: ${formatTime(activity.start_time)} - ${formatTime(activity.end_time)}</p>
                            ${activity.block_bookings ? '<p class="text-sm font-medium text-red-600 dark:text-red-400 mt-1"><i class="fas fa-ban mr-1"></i> Bookings blocked during this time</p>' : ''}
                        </div>
                        <div class="flex space-x-2">
                            <a href="/admin/activities/${activity.id}/edit" class="text-emerald-600 hover:text-emerald-800 dark:text-emerald-400 dark:hover:text-emerald-300">
                                <i class="fas fa-edit"></i>
                            </a>
                        </div>
                    </div>
                `;
                
                activitiesList.appendChild(activityCard);
            });
            
            noActivities.classList.add('hidden');
        } else {
            noActivities.classList.remove('hidden');
        }
        
        document.getElementById('bookingsForDate').classList.remove('hidden');
    }

    function formatDateString(date) {
        const year = date.getFullYear();
        const month = String(date.getMonth() + 1).padStart(2, '0');
        const day = String(date.getDate()).padStart(2, '0');
        return `${year}-${month}-${day}`;
    }

    function previousMonth() {
        const currentMonth = document.getElementById('currentMonth').textContent;
        const date = new Date(currentMonth);
        date.setMonth(date.getMonth() - 1);
        renderCalendar(date.getFullYear(), date.getMonth());
        
        // Clear selected date when changing months
        selectedDate = null;
        document.getElementById('bookingsForDate').classList.add('hidden');
    }
    
    function nextMonth() {
        const currentMonth = document.getElementById('currentMonth').textContent;
        const date = new Date(currentMonth);
        date.setMonth(date.getMonth() + 1);
        renderCalendar(date.getFullYear(), date.getMonth());
        
        // Clear selected date when changing months
        selectedDate = null;
        document.getElementById('bookingsForDate').classList.add('hidden');
    }
    
    // Add a button to create a new activity when a date is selected
    document.addEventListener('DOMContentLoaded', function() {
        const bookingsForDateSection = document.getElementById('bookingsForDate');
        
        // Create the "Add Activity" button
        const addActivityButton = document.createElement('button');
        addActivityButton.className = 'mt-4 bg-emerald-600 hover:bg-emerald-700 text-white font-medium py-2 px-4 rounded-lg flex items-center';
        addActivityButton.innerHTML = '<i class="fas fa-plus mr-2"></i> Add Activity for This Date';
        
        // Add click event to redirect to the activity creation page with the selected date
        addActivityButton.addEventListener('click', function() {
            if (selectedDate) {
                const dateString = formatDateString(selectedDate);
                window.location.href = `/admin/activities/create?date=${dateString}`;
            }
        });
        
        // Add the button after the bookings section
        bookingsForDateSection.appendChild(addActivityButton);
    });
    
    // Check for time conflicts between bookings and activities
    function checkTimeConflicts(booking, activities) {
        // Convert booking time to minutes for easier comparison
        const [bookingHours, bookingMinutes] = booking.preferred_time.split(':').map(Number);
        const bookingTimeInMinutes = bookingHours * 60 + bookingMinutes;
        
        // Default service duration (in minutes)
        const serviceDurations = {
            'baptism': 60,
            'wedding': 120,
            'confirmation': 90,
            'mass_intention': 60,
            'blessing': 60,
            'sick_call': 60
        };
        
        const bookingDuration = serviceDurations[booking.type] || 60;
        const bookingEndTimeInMinutes = bookingTimeInMinutes + bookingDuration;
        
        // Check each activity for time conflicts
        for (const activity of activities) {
            if (activity.block_bookings) {
                const [activityStartHours, activityStartMinutes] = activity.start_time.split(':').map(Number);
                const [activityEndHours, activityEndMinutes] = activity.end_time.split(':').map(Number);
                
                const activityStartInMinutes = activityStartHours * 60 + activityStartMinutes;
                const activityEndInMinutes = activityEndHours * 60 + activityEndMinutes;
                
                // Check if booking time overlaps with activity time
                const hasConflict = (
                    (bookingTimeInMinutes >= activityStartInMinutes && bookingTimeInMinutes < activityEndInMinutes) ||
                    (bookingEndTimeInMinutes > activityStartInMinutes && bookingEndTimeInMinutes <= activityEndInMinutes) ||
                    (bookingTimeInMinutes <= activityStartInMinutes && bookingEndTimeInMinutes >= activityEndInMinutes)
                );
                
                if (hasConflict) {
                    return true;
                }
            }
        }
        
        return false;
    }
    
    // Helper function to format time for display
    function formatTime(timeString) {
        if (!timeString) return '';
        
        const [hours, minutes] = timeString.split(':').map(Number);
        const period = hours >= 12 ? 'PM' : 'AM';
        const displayHours = hours % 12 || 12;
        
        return `${displayHours}:${minutes.toString().padStart(2, '0')} ${period}`;
    }
</script>
@endsection