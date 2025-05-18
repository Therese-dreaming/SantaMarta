@extends('layouts.admin')

@section('title', 'Booking Calendar')

@section('content')
    <div class="container mx-auto px-4 py-8">
        <div class="mb-6">
            <div class="flex items-center justify-between mb-6">
                <h1 class="text-2xl font-bold text-gray-900 dark:text-white">
                    <i class="fas fa-calendar-alt mr-3 text-emerald-600"></i>
                    Booking Calendar
                </h1>
                <div class="flex space-x-2">
                    <button onclick="today()"
                        class="flex items-center px-4 py-2 bg-emerald-100 text-emerald-700 rounded-lg hover:bg-emerald-200 transition-colors">
                        <i class="fas fa-calendar-day mr-2"></i>
                        Today
                    </button>
                </div>
            </div>

            <!-- Enhanced Legend -->
            <div
                class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-4 mb-6 p-6 bg-white dark:bg-gray-800 rounded-xl shadow-md border border-gray-100 dark:border-gray-700">
                <div class="legend-item">
                    <div class="legend-color bg-blue-500"></div>
                    <span class="text-sm text-gray-600 dark:text-gray-300">
                        <i class="fas fa-water mr-2"></i>Baptism
                    </span>
                </div>
                <div class="legend-item">
                    <div class="legend-color bg-pink-500"></div>
                    <span class="text-sm text-gray-600 dark:text-gray-300">
                        <i class="fas fa-ring mr-2"></i>Wedding
                    </span>
                </div>
                <div class="legend-item">
                    <div class="legend-color bg-purple-500"></div>
                    <span class="text-sm text-gray-600 dark:text-gray-300">
                        <i class="fas fa-dove mr-2"></i>Confirmation
                    </span>
                </div>
                <div class="legend-item">
                    <div class="legend-color bg-emerald-500"></div>
                    <span class="text-sm text-gray-600 dark:text-gray-300">
                        <i class="fas fa-pray mr-2"></i>Mass Intention
                    </span>
                </div>
                <div class="legend-item">
                    <div class="legend-color bg-amber-500"></div>
                    <span class="text-sm text-gray-600 dark:text-gray-300">
                        <i class="fas fa-hand-holding-heart mr-2"></i>Blessing
                    </span>
                </div>
                <div class="legend-item">
                    <div class="legend-color bg-red-500"></div>
                    <span class="text-sm text-gray-600 dark:text-gray-300">
                        <i class="fas fa-hospital-user mr-2"></i>Sick Call
                    </span>
                </div>
            </div>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg border border-gray-100 dark:border-gray-700 p-6">
            <!-- Enhanced Calendar Navigation -->
            <div class="flex items-center justify-between mb-8">
                <button onclick="previousMonth()"
                    class="flex items-center justify-center w-10 h-10 rounded-full text-emerald-600 hover:bg-emerald-100 dark:hover:bg-emerald-900/30 transition-colors">
                    <i class="fas fa-chevron-left"></i>
                </button>
                <h2 class="text-2xl font-bold text-gray-800 dark:text-white" id="currentMonth"></h2>
                <button onclick="nextMonth()"
                    class="flex items-center justify-center w-10 h-10 rounded-full text-emerald-600 hover:bg-emerald-100 dark:hover:bg-emerald-900/30 transition-colors">
                    <i class="fas fa-chevron-right"></i>
                </button>
            </div>

            <!-- Enhanced Calendar Grid -->
            <div class="grid grid-cols-7 gap-4 mb-4">
                <div class="text-center font-semibold text-emerald-600 dark:text-emerald-400">Sun</div>
                <div class="text-center font-semibold text-emerald-600 dark:text-emerald-400">Mon</div>
                <div class="text-center font-semibold text-emerald-600 dark:text-emerald-400">Tue</div>
                <div class="text-center font-semibold text-emerald-600 dark:text-emerald-400">Wed</div>
                <div class="text-center font-semibold text-emerald-600 dark:text-emerald-400">Thu</div>
                <div class="text-center font-semibold text-emerald-600 dark:text-emerald-400">Fri</div>
                <div class="text-center font-semibold text-emerald-600 dark:text-emerald-400">Sat</div>
            </div>
            <div id="calendarGrid" class="grid grid-cols-7 gap-4"></div>
        </div>
    </div>

    <!-- Enhanced Modal -->
    <div id="eventModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-2xl p-6 w-full max-w-lg mx-4 transform transition-all">
            <div class="flex justify-between items-start mb-6">
                <h3 class="text-xl font-bold text-gray-900 dark:text-white flex items-center" id="modalTitle">
                    <i class="fas fa-calendar-check text-emerald-600 mr-3"></i>
                    <span></span>
                </h3>
                <button onclick="closeModal()" class="text-gray-400 hover:text-gray-500 transition-colors">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div class="space-y-6" id="modalContent">
                <!-- Event details will be populated here -->
            </div>
        </div>
    </div>

    <script>
        const approvedBookings = @json($approvedBookings);

        // Add this new function
        function today() {
            const today = new Date();
            renderCalendar(today.getFullYear(), today.getMonth());
        }

        function getEasterSunday(year) {
            const a = year % 19;
            const b = Math.floor(year / 100);
            const c = year % 100;
            const d = Math.floor(b / 4);
            const e = b % 4;
            const f = Math.floor((b + 8) / 25);
            const g = Math.floor((b - f + 1) / 3);
            const h = (19 * a + b - d - g + 15) % 30;
            const i = Math.floor(c / 4);
            const k = c % 4;
            const l = (32 + 2 * e + 2 * i - h - k) % 7;
            const m = Math.floor((a + 11 * h + 22 * l) / 451);
            const month = Math.floor((h + l - 7 * m + 114) / 31) - 1;
            const day = ((h + l - 7 * m + 114) % 31) + 1;
            return new Date(year, month, day);
        }

        function getCatholicHolidays(year) {
            const easter = getEasterSunday(year);
            const ashWednesday = new Date(easter);
            ashWednesday.setDate(easter.getDate() - 46);
            const palmSunday = new Date(easter);
            palmSunday.setDate(easter.getDate() - 7);
            const holyThursday = new Date(easter);
            holyThursday.setDate(easter.getDate() - 3);
            const goodFriday = new Date(easter);
            goodFriday.setDate(easter.getDate() - 2);
            const holySaturday = new Date(easter);
            holySaturday.setDate(easter.getDate() - 1);

            return [
                new Date(year, 0, 1), // New Year's Day
                new Date(year, 0, 6), // Epiphany
                new Date(year, 2, 19), // St. Joseph's Day
                new Date(year, 7, 15), // Assumption of Mary
                new Date(year, 10, 1), // All Saints' Day
                new Date(year, 11, 8), // Immaculate Conception
                new Date(year, 11, 25), // Christmas
                ashWednesday,
                palmSunday,
                holyThursday,
                goodFriday,
                holySaturday,
                easter
            ];
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
                emptyCell.className = 'h-14 rounded-lg';
                calendarGrid.appendChild(emptyCell);
            }

            // Add cells for each day of the month
            for (let day = 1; day <= monthLength; day++) {
                const date = new Date(year, month, day);
                const cell = document.createElement('div');
                const dateString = date.toISOString().split('T')[0];

                // Get bookings for this date
                const dayBookings = approvedBookings.filter(booking => booking.preferred_date === dateString);
                const isHoliday = getCatholicHolidays(year).some(holiday =>
                    holiday.getDate() === date.getDate() &&
                    holiday.getMonth() === date.getMonth() &&
                    holiday.getFullYear() === date.getFullYear()
                );

                let className = 'h-14 rounded-lg flex flex-col items-center justify-center relative p-1 ';

                if (isHoliday) {
                    className += 'bg-yellow-100 dark:bg-yellow-900 border border-yellow-300';
                } else {
                    className += 'bg-white dark:bg-gray-700 border border-gray-200 dark:border-gray-600';
                }

                cell.className = className;

                // Add date number
                const dateNumber = document.createElement('span');
                dateNumber.textContent = day;
                dateNumber.className = 'text-sm font-medium text-gray-700 dark:text-gray-300';
                cell.appendChild(dateNumber);

                // Add booking indicators if there are any
                if (dayBookings.length > 0) {
                    const indicatorContainer = document.createElement('div');
                    indicatorContainer.className = 'flex gap-1 mt-1';

                    // Group bookings by type and add colored dots
                    const bookingTypes = [...new Set(dayBookings.map(b => b.type))];
                    bookingTypes.forEach(type => {
                        const dot = document.createElement('div');
                        dot.className = 'w-2 h-2 rounded-full';

                        // Use the same colors as in the legend
                        dot.style.backgroundColor = {
                            'baptism': '#3B82F6',
                            'wedding': '#EC4899',
                            'confirmation': '#8B5CF6',
                            'mass_intention': '#10B981',
                            'blessing': '#F59E0B',
                            'sick_call': '#EF4444'
                        } [type];

                        indicatorContainer.appendChild(dot);
                    });

                    cell.appendChild(indicatorContainer);
                }

                // Add click handler to show bookings
                if (dayBookings.length > 0) {
                    cell.onclick = () => showDayBookings(dateString, dayBookings);
                    cell.style.cursor = 'pointer';
                }

                calendarGrid.appendChild(cell);
            }

            // Update month display
            document.getElementById('currentMonth').textContent =
                new Date(year, month).toLocaleDateString('en-US', {
                    month: 'long',
                    year: 'numeric'
                });
        }

        function showDayBookings(date, bookings) {
            const modalContent = document.getElementById('modalContent');
            const formattedDate = new Date(date).toLocaleDateString('en-US', {
                weekday: 'long',
                year: 'numeric',
                month: 'long',
                day: 'numeric'
            });

            document.getElementById('modalTitle').textContent = `Bookings for ${formattedDate}`;

            // Group bookings by type
            const bookingsByType = bookings.reduce((acc, booking) => {
                if (!acc[booking.type]) acc[booking.type] = [];
                acc[booking.type].push(booking);
                return acc;
            }, {});

            let content = '';

            for (const [type, typeBookings] of Object.entries(bookingsByType)) {
                const icon = {
                    'baptism': 'water',
                    'wedding': 'ring',
                    'confirmation': 'dove',
                    'mass_intention': 'pray',
                    'blessing': 'hand-holding-heart',
                    'sick_call': 'hospital-user'
                } [type];

                content += `
            <div class="mb-6">
                <h4 class="flex items-center font-semibold text-gray-900 dark:text-white mb-4">
                    <i class="fas fa-${icon} text-emerald-600 mr-2"></i>
                    ${type.replace('_', ' ').toUpperCase()}
                </h4>
                <div class="space-y-3">
                    ${typeBookings.map(booking => `
                            <div class="p-4 bg-gray-50 dark:bg-gray-700 rounded-xl border border-gray-200 dark:border-gray-600 hover:border-emerald-500 transition-colors">
                                <div class="flex justify-between items-center">
                                    <span class="font-semibold text-gray-900 dark:text-white">#${booking.ticket_number}</span>
                                    <span class="text-sm text-emerald-600 dark:text-emerald-400">${booking.preferred_time}</span>
                                </div>
                                <div class="text-sm text-gray-600 dark:text-gray-400 mt-2">
                                    <i class="fas fa-user mr-2"></i>${booking.user.name}
                                </div>
                            </div>
                        `).join('')}
                </div>
            </div>
        `;
            }

            modalContent.innerHTML = content;
            document.getElementById('eventModal').classList.remove('hidden');
            document.getElementById('eventModal').classList.add('flex');
        }

        function closeModal() {
            document.getElementById('eventModal').classList.add('hidden');
            document.getElementById('eventModal').classList.remove('flex');
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

        // Initialize calendar
        document.addEventListener('DOMContentLoaded', () => {
            const today = new Date();
            renderCalendar(today.getFullYear(), today.getMonth());
        });
    </script>

    <style>
        .legend-item {
            @apply flex items-center p-2 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors;
        }

        .legend-color {
            @apply w-4 h-4 rounded-lg mr-3;
        }
    </style>
@endsection
