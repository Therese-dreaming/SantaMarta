@extends('layouts.admin')

@section('title', 'Add Parochial Activity')

@section('content')
<div class="container px-6 mx-auto py-8">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-semibold text-gray-700 dark:text-gray-200">Add Parochial Activity</h1>
        <a href="/admin/activities" class="bg-gray-200 hover:bg-gray-300 text-gray-700 dark:bg-gray-700 dark:hover:bg-gray-600 dark:text-gray-200 px-4 py-2 rounded-lg flex items-center">
            <i class="fas fa-arrow-left mr-2"></i> Back to Activities
        </a>
    </div>

    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6">
        <form action="/admin/activities" method="POST" id="activityForm">
            @csrf
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="title" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Activity Title</label>
                    <input type="text" name="title" id="title" required 
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-emerald-500 focus:border-emerald-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white"
                        placeholder="e.g., Sunday Mass, Parish Meeting">
                </div>
                
                <div>
                    <label for="type" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Activity Type</label>
                    <select name="type" id="type" required
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-emerald-500 focus:border-emerald-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white">
                        <option value="">Select Type</option>
                        <option value="mass">Mass</option>
                        <option value="meeting">Meeting</option>
                        <option value="event">Special Event</option>
                        <option value="holiday">Holiday</option>
                        <option value="maintenance">Maintenance</option>
                    </select>
                </div>
                
                <div>
                    <label for="date" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Date</label>
                    <input type="date" name="date" id="date" required
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-emerald-500 focus:border-emerald-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white">
                </div>
                
                <div>
                    <label for="recurrence" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Recurrence</label>
                    <select name="recurrence" id="recurrence"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-emerald-500 focus:border-emerald-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white">
                        <option value="none">One-time</option>
                        <option value="daily">Daily</option>
                        <option value="weekly">Weekly</option>
                        <option value="monthly">Monthly</option>
                        <option value="yearly">Yearly</option>
                    </select>
                </div>
                
                <div id="recurrence_end_container" style="display: none;">
                    <label for="recurrence_end_date" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">End Recurrence Date</label>
                    <input type="date" name="recurrence_end_date" id="recurrence_end_date" 
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-emerald-500 focus:border-emerald-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white">
                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Leave blank to create recurring events for up to one year.</p>
                </div>
                
                <div>
                    <label for="start_time" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Start Time</label>
                    <input type="time" name="start_time" id="start_time" required
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-emerald-500 focus:border-emerald-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white">
                </div>
                
                <div>
                    <label for="end_time" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">End Time</label>
                    <input type="time" name="end_time" id="end_time" required
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-emerald-500 focus:border-emerald-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white">
                </div>
                
                <div class="md:col-span-2">
                    <label for="description" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Description</label>
                    <textarea name="description" id="description" rows="4"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-emerald-500 focus:border-emerald-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white"
                        placeholder="Describe the activity..."></textarea>
                </div>
                
                <div class="md:col-span-2">
                    <div class="flex items-center">
                        <input type="checkbox" name="block_bookings" id="block_bookings" value="1"
                            class="w-4 h-4 text-emerald-600 bg-gray-100 border-gray-300 rounded focus:ring-emerald-500 dark:focus:ring-emerald-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                        <label for="block_bookings" class="ml-2 text-sm font-medium text-gray-700 dark:text-gray-300">
                            Block service bookings during this activity
                        </label>
                    </div>
                </div>
            </div>
            
            <div class="mt-6">
                <button type="submit" class="bg-emerald-600 hover:bg-emerald-700 text-white font-medium py-2 px-4 rounded-lg">
                    <i class="fas fa-save mr-2"></i> Save Activity
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Check if there's a date parameter in the URL
        const urlParams = new URLSearchParams(window.location.search);
        const dateParam = urlParams.get('date');
        
        if (dateParam) {
            document.getElementById('date').value = dateParam;
        } else {
            // Set default date to today
            const today = new Date();
            const year = today.getFullYear();
            const month = String(today.getMonth() + 1).padStart(2, '0');
            const day = String(today.getDate()).padStart(2, '0');
            document.getElementById('date').value = `${year}-${month}-${day}`;
        }
        
        // Set default times
        document.getElementById('start_time').value = '08:00';
        document.getElementById('end_time').value = '09:00';
        
        // Toggle recurrence end date field
        const recurrenceSelect = document.getElementById('recurrence');
        const recurrenceEndContainer = document.getElementById('recurrence_end_container');
        
        recurrenceSelect.addEventListener('change', function() {
            if (this.value !== 'none') {
                recurrenceEndContainer.style.display = 'block';
                
                // Set default end date to one year from start date
                const startDate = new Date(document.getElementById('date').value);
                if (startDate) {
                    const endDate = new Date(startDate);
                    endDate.setFullYear(endDate.getFullYear() + 1);
                    const endYear = endDate.getFullYear();
                    const endMonth = String(endDate.getMonth() + 1).padStart(2, '0');
                    const endDay = String(endDate.getDate()).padStart(2, '0');
                    document.getElementById('recurrence_end_date').value = `${endYear}-${endMonth}-${endDay}`;
                }
            } else {
                recurrenceEndContainer.style.display = 'none';
            }
        });
        
        // Form validation
        const activityForm = document.getElementById('activityForm');
        activityForm.addEventListener('submit', function(event) {
            const startTime = document.getElementById('start_time').value;
            const endTime = document.getElementById('end_time').value;
            
            // Check if end time is after start time
            if (startTime >= endTime) {
                event.preventDefault();
                alert('End time must be after start time');
                return false;
            }
            
            // Check if title is provided
            const title = document.getElementById('title').value.trim();
            if (!title) {
                event.preventDefault();
                alert('Please provide an activity title');
                return false;
            }
            
            // Check if type is selected
            const type = document.getElementById('type').value;
            if (!type) {
                event.preventDefault();
                alert('Please select an activity type');
                return false;
            }
            
            return true;
        });
        
        // Show/hide recurrence options based on activity type
        const typeSelect = document.getElementById('type');
        const recurrenceDiv = document.getElementById('recurrence').closest('div');
        
        typeSelect.addEventListener('change', function() {
            const selectedType = this.value;
            
            // For certain types like 'mass', show recurrence options
            if (selectedType === 'mass' || selectedType === 'meeting') {
                recurrenceDiv.classList.remove('hidden');
            } else {
                // For one-time events, hide recurrence and set to 'none'
                document.getElementById('recurrence').value = 'none';
            }
        });
        
        // When block_bookings is checked, show a warning
        const blockBookingsCheckbox = document.getElementById('block_bookings');
        blockBookingsCheckbox.addEventListener('change', function() {
            if (this.checked) {
                const confirmed = confirm('Blocking bookings will prevent users from scheduling services during this time. Are you sure you want to continue?');
                if (!confirmed) {
                    this.checked = false;
                }
            }
        });
    });
</script>

<!-- Add this JavaScript at the end of the file -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const recurrenceSelect = document.getElementById('recurrence');
        const recurrenceOptions = document.querySelector('.recurrence-options');
        
        function toggleRecurrenceOptions() {
            if (recurrenceSelect.value !== 'none') {
                recurrenceOptions.style.display = 'block';
            } else {
                recurrenceOptions.style.display = 'none';
            }
        }
        
        recurrenceSelect.addEventListener('change', toggleRecurrenceOptions);
        toggleRecurrenceOptions(); // Initial state
    });
</script>
@endsection