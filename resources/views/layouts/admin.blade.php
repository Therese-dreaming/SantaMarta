<!DOCTYPE html>
<html lang="en" x-data="{ darkMode: localStorage.getItem('darkMode') === 'true' }" x-init="$watch('darkMode', val => localStorage.setItem('darkMode', val))" :class="{ 'dark': darkMode }">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - Santa Marta Admin</title>
    
    <!-- Move Alpine.js to the head and remove defer -->
    <script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
        }
    </script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://site-assets.fontawesome.com/releases/v6.4.2/css/all.css">
    
    <!-- Link to external CSS for admin booking details page -->
    <link rel="stylesheet" href="{{ asset('css/admin/booking-show.css') }}">

    <!-- Add x-cloak style in the head -->
    <style>
        [x-cloak] { display: none !important; }
    </style>
</head>

<body class="bg-white dark:bg-gray-900">
    <div class="flex h-screen bg-gray-50 dark:bg-gray-900" x-data="{ 
            isSideMenuOpen: false,
            currentPath: window.location.pathname,
            isCurrentPath(path) {
                return this.currentPath === path;
            }
         }">
        <!-- Desktop sidebar -->
        <aside class="z-20 hidden w-64 overflow-y-auto bg-emerald-800 dark:bg-gray-800 md:block flex-shrink-0">
            <div class="py-4 text-gray-100">
                <div class="ml-6 flex items-center space-x-3">
                    <div class="w-10 h-10 bg-white rounded-lg flex items-center justify-center">
                        <i class="fas fa-church text-emerald-800 text-xl"></i>
                    </div>
                    <div>
                        <h1 class="text-xl font-bold text-white">Santa Marta</h1>
                        <p class="text-xs text-emerald-200">Admin Portal</p>
                    </div>
                </div>
                <ul class="mt-8 space-y-2">
                    <li class="relative px-4">
                        <a href="/admin/dashboard" class="flex items-center w-full text-sm font-semibold transition-colors duration-150 text-gray-300 hover:text-white hover:bg-emerald-700/50 px-4 py-3 rounded-lg" :class="{ 'bg-emerald-100 !text-emerald-900': isCurrentPath('/admin/dashboard') }">
                            <i class="fas fa-home w-5 h-5"></i>
                            <span class="ml-3">Dashboard</span>
                        </a>
                    </li>
                    <li class="relative px-4" x-data="{ open: false }">
                        <button @click="open = !open" class="flex items-center justify-between w-full text-sm font-semibold transition-colors duration-150 text-gray-300 hover:text-white hover:bg-emerald-700/50 px-4 py-3 rounded-lg" 
                            :class="{ 'bg-emerald-100 !text-emerald-900': isCurrentPath('/admin/bookings') || isCurrentPath('/admin/calendar') }">
                            <div class="flex items-center">
                                <i class="fas fa-calendar-alt w-5 h-5"></i>
                                <span class="ml-3">Bookings</span>
                            </div>
                            <i class="fas fa-chevron-down w-4 h-4 transition-transform" :class="{ 'transform rotate-180': open }"></i>
                        </button>
                        <div x-show="open" x-transition:enter="transition ease-out duration-100" x-transition:enter-start="transform opacity-0 scale-95" x-transition:enter-end="transform opacity-100 scale-100" class="mt-2 space-y-1">
                            <a href="/admin/bookings" class="flex items-center text-sm pl-11 py-2 text-gray-300 hover:text-white hover:bg-emerald-700/50 rounded-lg" :class="{ 'bg-emerald-100 !text-emerald-900': isCurrentPath('/admin/bookings') }">
                                <i class="fas fa-list-ul w-4 h-4 mr-2"></i>
                                List View
                            </a>
                            <a href="/admin/calendar" class="flex items-center text-sm pl-11 py-2 text-gray-300 hover:text-white hover:bg-emerald-700/50 rounded-lg" :class="{ 'bg-emerald-100 !text-emerald-900': isCurrentPath('/admin/calendar') }">
                                <i class="fas fa-calendar-week w-4 h-4 mr-2"></i>
                                Calendar View
                            </a>
                        </div>
                    </li>
                    <li class="relative px-4">
                        <a href="/admin/users" class="flex items-center w-full text-sm font-semibold transition-colors duration-150 text-gray-300 hover:text-white hover:bg-emerald-700/50 px-4 py-3 rounded-lg" :class="{ 'bg-emerald-100 !text-emerald-900': isCurrentPath('/admin/users') }">
                            <i class="fas fa-users w-5 h-5"></i>
                            <span class="ml-3">Users</span>
                        </a>
                    </li>
                    <li class="relative px-4">
                        <a href="{{ route('admin.reports') }}" class="flex items-center w-full text-sm font-semibold transition-colors duration-150 text-gray-300 hover:text-white hover:bg-emerald-700/50 px-4 py-3 rounded-lg" :class="{ 'bg-emerald-100 !text-emerald-900': isCurrentPath('/admin/reports') }">
                            <i class="fas fa-chart-bar w-5 h-5"></i>
                            <span class="ml-3">Reports</span>
                        </a>
                    </li>
                    
                    <!-- Add Parochial Activities Menu Item -->
                    <li class="relative px-4" x-data="{ open: false }">
                        <button @click="open = !open" class="flex items-center justify-between w-full text-sm font-semibold transition-colors duration-150 text-gray-300 hover:text-white hover:bg-emerald-700/50 px-4 py-3 rounded-lg" 
                            :class="{ 'bg-emerald-100 !text-emerald-900': isCurrentPath('/admin/activities') }">
                        <div class="flex items-center">
                            <i class="fas fa-church w-5 h-5"></i>
                            <span class="ml-3">Parochial Activities</span>
                        </div>
                        <i class="fas fa-chevron-down w-4 h-4 transition-transform" :class="{ 'transform rotate-180': open }"></i>
                    </button>
                    <div x-show="open" x-transition:enter="transition ease-out duration-100" x-transition:enter-start="transform opacity-0 scale-95" x-transition:enter-end="transform opacity-100 scale-100" class="mt-2 space-y-1">
                        <a href="/admin/activities" class="flex items-center text-sm pl-11 py-2 text-gray-300 hover:text-white hover:bg-emerald-700/50 rounded-lg" :class="{ 'bg-emerald-100 !text-emerald-900': isCurrentPath('/admin/activities') }">
                            <i class="fas fa-list-ul w-4 h-4 mr-2"></i>
                            View Activities
                        </a>
                        <a href="/admin/activities/create" class="flex items-center text-sm pl-11 py-2 text-gray-300 hover:text-white hover:bg-emerald-700/50 rounded-lg" :class="{ 'bg-emerald-100 !text-emerald-900': isCurrentPath('/admin/activities/create') }">
                            <i class="fas fa-plus w-4 h-4 mr-2"></i>
                            Add New Activity
                        </a>
                    </div>
                </li>
                </ul>
            </div>
        </aside>

        <!-- Mobile sidebar backdrop -->
        <div x-show="isSideMenuOpen" x-transition:enter="transition ease-in-out duration-150" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in-out duration-150" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" class="fixed inset-0 z-10 flex items-end bg-black bg-opacity-50 sm:items-center sm:justify-center">
        </div>

        <!-- Mobile sidebar -->
        <aside class="fixed inset-y-0 z-20 flex-shrink-0 w-64 mt-16 overflow-y-auto bg-emerald-800 md:hidden" x-show="isSideMenuOpen" x-transition:enter="transition ease-in-out duration-150" x-transition:enter-start="opacity-0 transform -translate-x-20" x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in-out duration-150" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0 transform -translate-x-20">
            <div class="py-4 text-gray-100">
                <!-- Copy the same menu items from desktop sidebar here -->
            </div>
        </aside>

        <div class="flex flex-col flex-1">
            <header class="z-10 py-4 bg-white dark:bg-gray-800 shadow-sm border-b border-gray-200 dark:border-gray-700">
                <div class="flex items-center justify-between h-full px-6 mx-auto">
                    <!-- Mobile hamburger -->
                    <button class="p-1 mr-5 -ml-1 rounded-md md:hidden focus:outline-none focus:ring-2 focus:ring-emerald-600 dark:focus:ring-emerald-500">
                        <i class="fas fa-bars text-gray-600 dark:text-gray-400"></i>
                    </button>

                    <!-- Search -->
                    <!-- Replace the search input section with this: -->
                    <div class="flex justify-center flex-1 lg:mr-32">
                        <div class="relative w-full max-w-xl mr-6">
                            <div class="absolute inset-y-0 flex items-center pl-3">
                                <i class="fas fa-search text-gray-400"></i>
                            </div>
                            <input id="searchInput" class="w-full pl-10 pr-4 py-2 text-sm text-gray-700 dark:text-gray-300 placeholder-gray-500 bg-gray-100 dark:bg-gray-700 border-0 rounded-lg focus:ring-2 focus:ring-emerald-600 dark:focus:ring-emerald-500 focus:outline-none" type="text" placeholder="Search ticket number..." aria-label="Search">
                        </div>
                    </div>

                    <!-- Add this script at the end of the body -->
                    <script>
                        document.addEventListener('DOMContentLoaded', function() {
                            const searchInput = document.getElementById('searchInput');

                            if (searchInput) {
                                searchInput.addEventListener('input', function() {
                                    const searchValue = this.value.toLowerCase().trim();
                                    const serviceRows = document.querySelectorAll('tr.service-item');
                                    let hasVisibleRows = false;

                                    serviceRows.forEach(row => {
                                        const ticketNumber = row.querySelector('td:first-child span').textContent.toLowerCase();

                                        if (ticketNumber.includes(searchValue)) {
                                            row.style.display = '';
                                            hasVisibleRows = true;
                                        } else {
                                            row.style.display = 'none';
                                        }
                                    });

                                    // Handle no results message
                                    const tbody = document.querySelector('tbody');
                                    const existingNoResults = tbody.querySelector('.no-results-row');

                                    if (!hasVisibleRows && searchValue) {
                                        if (!existingNoResults) {
                                            const noResultsRow = document.createElement('tr');
                                            noResultsRow.className = 'no-results-row';
                                            noResultsRow.innerHTML = `
                                                <td colspan="6" class="px-6 py-8 text-center text-gray-500 dark:text-gray-400">
                                                    <div class="flex flex-col items-center">
                                                        <i class="fas fa-search text-4xl mb-3 text-gray-400 dark:text-gray-500"></i>
                                                        <p>No tickets found matching "${searchValue}"</p>
                                                    </div>
                                                </td>
                                            `;
                                            tbody.appendChild(noResultsRow);
                                        }
                                    } else if (existingNoResults) {
                                        existingNoResults.remove();
                                    }
                                });
                            }
                        });

                    </script>

                    <ul class="flex items-center flex-shrink-0 space-x-6">
                        <!-- Dark mode toggle -->
                        <li class="relative">
                            <button @click="darkMode = !darkMode" class="p-2 text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 focus:outline-none focus:ring-2 focus:ring-emerald-600 dark:focus:ring-emerald-500 rounded-lg">
                                <i class="fas" :class="darkMode ? 'fa-sun' : 'fa-moon'"></i>
                            </button>
                        </li>
                        <!-- Notifications -->
                        <li class="relative">
                            <button class="p-2 text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 focus:outline-none focus:ring-2 focus:ring-emerald-600 dark:focus:ring-emerald-500 rounded-lg">
                                <i class="fas fa-bell"></i>
                            </button>
                        </li>
                        <!-- Profile menu -->
                        <!-- Profile menu -->
                        <li class="relative" x-data="{ isOpen: false }" x-cloak>
                            <button class="flex items-center space-x-2 focus:outline-none" @click="isOpen = !isOpen">
                                <img class="object-cover w-8 h-8 rounded-full border-2 border-emerald-600" 
                                     src="{{ Auth::user()->avatar ?? 'https://ui-avatars.com/api/?name=' . urlencode(Auth::user()->name) }}" 
                                     alt="User avatar">
                                <span class="text-sm font-medium text-gray-700 dark:text-gray-300">{{ Auth::user()->name }}</span>
                                <i class="fas fa-chevron-down text-gray-400 text-sm"></i>
                            </button>
                            <div x-show="isOpen" 
                                 x-cloak 
                                 @click.away="isOpen = false"
                                 class="absolute right-0 mt-2 w-48 bg-white dark:bg-gray-800 rounded-lg shadow-lg py-2 border border-gray-200 dark:border-gray-700">
                                <a href="#" class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700">
                                    <i class="fas fa-user-circle mr-2"></i> Profile
                                </a>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="w-full text-left px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700">
                                        <i class="fas fa-sign-out-alt mr-2"></i> Logout
                                    </button>
                                </form>
                            </div>
                        </li>
                    </ul>
                </div>
            </header>

            <main class="h-full overflow-y-auto bg-gray-50 dark:bg-gray-900">
                <div class="container px-6 mx-auto py-8">
                    @if(session('success'))
                    <div class="mb-6 p-4 bg-emerald-100 border border-emerald-200 text-emerald-700 rounded-lg" x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 3000)">
                        <div class="flex items-center">
                            <i class="fas fa-check-circle mr-2"></i>
                            <span>{{ session('success') }}</span>
                            <button @click="show = false" class="ml-auto">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                    </div>
                    @endif

                    @yield('content')
                </div>
            </main>
        </div>
    </div>

    <style>
        [x-cloak] {
            display: none !important;
        }

    </style>

    @stack('scripts')

</body>
</html>
