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
            <div class="flex items-center">
                <div class="w-4 h-4 rounded-full bg-red-500 mr-2"></div>
                <span class="text-gray-600 dark:text-gray-300">Blessing</span>
            </div>
            <div class="flex items-center">
                <div class="w-4 h-4 rounded-full bg-orange-500 mr-2"></div>
                <span class="text-gray-600 dark:text-gray-300">Sick Call</span>
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

        <!-- Bookings for Selected Date -->
        <div id="bookingsForDate" class="hidden mt-8 border-t pt-6">
            <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-200 mb-4">Bookings for <span id="selectedDateDisplay"></span></h3>
            <div id="bookingsList" class="space-y-4"></div>
        </div>
    </div>
</div>

<script>
    // Store all bookings from the controller
    const allBookings = @json($approvedBookings);
    let filteredBookings = [...allBookings];
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

    // Initialize calendar
    document.addEventListener('DOMContentLoaded', () => {
        const today = new Date();
        renderCalendar(today.getFullYear(), today.getMonth());
        
        // Set up event listeners for filters
        document.getElementById('service-type-filter').addEventListener('change', applyFilters);
        document.getElementById('status-filter').addEventListener('change', applyFilters);
    });

    function applyFilters() {
        const serviceType = document.getElementById('service-type-filter').value;
        const status = document.getElementById('status-filter').value;
        
        filteredBookings = allBookings.filter(booking => {
            const serviceTypeMatch = serviceType === 'all' || booking.type === serviceType;
            const statusMatch = status === 'all' || booking.status === status;
            return serviceTypeMatch && statusMatch;
        });
        
        // Re-render the calendar with the filtered bookings
        const currentMonth = document.getElementById('currentMonth').textContent;
        const date = new Date(currentMonth);
        renderCalendar(date.getFullYear(), date.getMonth());
        
        // If a date was selected, update the bookings for that date
        if (selectedDate) {
            showBookingsForDate(selectedDate);
        }
    }

    function renderCalendar(year, month) {
        const firstDay = new Date(year, month, 1);
        const lastDay = new Date(year, month + 1, 0);
        const startingDay = firstDay.getDay();
        const monthLength = lastDay.getDate();

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

            // Format date string for comparison with bookings
            const dateString = formatDateString(date);
            
            // Get bookings for this date
            const bookingsForDay = filteredBookings.filter(booking => 
                booking.preferred_date === dateString
            );

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
                    indicator.className = `w-2 h-2 rounded-full ${serviceColors[type] || 'bg-gray-500'}`;
                    indicator.title = `${count} ${type.replace('_', ' ')} booking(s)`;
                    bookingContainer.appendChild(indicator);
                });
                
                cell.appendChild(bookingContainer);
                
                // Add count if more than 3 bookings
                if (bookingsForDay.length > 3) {
                    const countBadge = document.createElement('div');
                    countBadge.className = 'absolute bottom-1 right-1 text-xs bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-300 rounded-full w-5 h-5 flex items-center justify-center';
                    countBadge.textContent = bookingsForDay.length;
                    cell.appendChild(countBadge);
                }
            }

            // Add click event to show bookings for this date
            cell.onclick = () => selectDate(date);
            calendarGrid.appendChild(cell);
        }

        // Update month display
        document.getElementById('currentMonth').textContent =
            new Date(year, month).toLocaleDateString('en-US', {
                month: 'long',
                year: 'numeric'
            });
    }

    function selectDate(date) {
        selectedDate = date;

        // Re-render the calendar to update selected cell
        const currentMonth = document.getElementById('currentMonth').textContent;
        const currentDate = new Date(currentMonth);
        renderCalendar(currentDate.getFullYear(), currentDate.getMonth());

        // Show bookings for the selected date
        showBookingsForDate(date);
    }

    function showBookingsForDate(date) {
        const dateString = formatDateString(date);
        const bookingsForDate = filteredBookings.filter(booking => booking.preferred_date === dateString);
        
        const bookingsDiv = document.getElementById('bookingsForDate');
        const bookingsList = document.getElementById('bookingsList');
        const selectedDateDisplay = document.getElementById('selectedDateDisplay');
        
        // Format the date for display
        selectedDateDisplay.textContent = date.toLocaleDateString('en-US', {
            weekday: 'long',
            year: 'numeric',
            month: 'long',
            day: 'numeric'
        });
        
        // Clear previous bookings
        bookingsList.innerHTML = '';
        
        if (bookingsForDate.length === 0) {
            const noBookings = document.createElement('div');
            noBookings.className = 'text-gray-500 dark:text-gray-400 text-center py-4';
            noBookings.textContent = 'No bookings for this date.';
            bookingsList.appendChild(noBookings);
        } else {
            // Sort bookings by time
            bookingsForDate.sort((a, b) => a.preferred_time.localeCompare(b.preferred_time));
            
            // Create booking cards
            bookingsForDate.forEach(booking => {
                const card = document.createElement('div');
                card.className = `p-4 rounded-lg border border-gray-200 dark:border-gray-700 ${serviceColors[booking.type] ? serviceColors[booking.type].replace('bg-', 'border-l-4 border-l-') : ''}`;
                
                const header = document.createElement('div');
                header.className = 'flex justify-between items-start';
                
                const title = document.createElement('h4');
                title.className = 'text-lg font-medium text-gray-900 dark:text-white';
                title.textContent = `${booking.type.replace('_', ' ').replace(/\b\w/g, l => l.toUpperCase())} - ${booking.preferred_time}`;
                
                const ticketNumber = document.createElement('span');
                ticketNumber.className = 'text-sm text-gray-500 dark:text-gray-400';
                ticketNumber.textContent = booking.ticket_number;
                
                header.appendChild(title);
                header.appendChild(ticketNumber);
                card.appendChild(header);
                
                const userInfo = document.createElement('p');
                userInfo.className = 'mt-2 text-gray-600 dark:text-gray-300';
                userInfo.textContent = `Client: ${booking.user.name}`;
                card.appendChild(userInfo);
                
                const viewLink = document.createElement('a');
                viewLink.href = `/admin/bookings/${booking.id}`;
                viewLink.className = 'mt-3 inline-flex items-center text-sm font-medium text-emerald-600 dark:text-emerald-400 hover:underline';
                viewLink.textContent = 'View Details';
                card.appendChild(viewLink);
                
                bookingsList.appendChild(card);
            });
        }
        
        // Show the bookings section
        bookingsDiv.classList.remove('hidden');
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
    }

    function nextMonth() {
        const currentMonth = document.getElementById('currentMonth').textContent;
        const date = new Date(currentMonth);
        date.setMonth(date.getMonth() + 1);
        renderCalendar(date.getFullYear(), date.getMonth());
    }
</script>
@endsection