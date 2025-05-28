@extends('layouts.admin')

@section('title', 'Edit Activity')

@section('content')
<div class="container px-6 mx-auto py-8">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-semibold text-gray-700 dark:text-gray-200">Edit Activity</h1>
        <a href="{{ route('admin.activities.index') }}" class="bg-gray-200 hover:bg-gray-300 text-gray-700 dark:bg-gray-700 dark:hover:bg-gray-600 dark:text-gray-200 px-4 py-2 rounded-lg flex items-center">
            <i class="fas fa-arrow-left mr-2"></i> Back to Activities
        </a>
    </div>

    @if(session('error'))
    <div class="mb-6 p-4 bg-red-100 border border-red-200 text-red-700 rounded-lg animate-fadeIn">
        <div class="flex items-center">
            <i class="fas fa-exclamation-circle mr-2"></i>
            <span>{{ session('error') }}</span>
        </div>
    </div>
    @endif

    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md overflow-hidden">
        <div class="p-6">
            <form action="{{ route('admin.activities.update', $activity->id) }}" method="POST">
                @csrf
                @method('PUT')
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Title -->
                    <div class="col-span-1 md:col-span-2">
                        <label for="title" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Activity Title <span class="text-red-500">*</span></label>
                        <input type="text" name="title" id="title" value="{{ old('title', $activity->title) }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-emerald-500 focus:border-emerald-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white" required>
                        @error('title')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <!-- Type -->
                    <div>
                        <label for="type" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Activity Type <span class="text-red-500">*</span></label>
                        <select name="type" id="type" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-emerald-500 focus:border-emerald-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white" required>
                            <option value="mass" {{ old('type', $activity->type) == 'mass' ? 'selected' : '' }}>Mass</option>
                            <option value="meeting" {{ old('type', $activity->type) == 'meeting' ? 'selected' : '' }}>Meeting</option>
                            <option value="event" {{ old('type', $activity->type) == 'event' ? 'selected' : '' }}>Special Event</option>
                            <option value="holiday" {{ old('type', $activity->type) == 'holiday' ? 'selected' : '' }}>Holiday</option>
                            <option value="maintenance" {{ old('type', $activity->type) == 'maintenance' ? 'selected' : '' }}>Maintenance</option>
                        </select>
                        @error('type')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <!-- Date -->
                    <div>
                        <label for="date" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Date <span class="text-red-500">*</span></label>
                        <input type="date" name="date" id="date" value="{{ old('date', $activity->date->format('Y-m-d')) }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-emerald-500 focus:border-emerald-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white" required>
                        @error('date')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <!-- Start Time -->
                    <div>
                        <label for="start_time" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Start Time <span class="text-red-500">*</span></label>
                        <input type="time" name="start_time" id="start_time" value="{{ old('start_time', $activity->start_time) }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-emerald-500 focus:border-emerald-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white" required>
                        @error('start_time')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <!-- End Time -->
                    <div>
                        <label for="end_time" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">End Time <span class="text-red-500">*</span></label>
                        <input type="time" name="end_time" id="end_time" value="{{ old('end_time', $activity->end_time) }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-emerald-500 focus:border-emerald-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white" required>
                        @error('end_time')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <!-- Recurrence -->
                    <div>
                        <label for="recurrence" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Recurrence</label>
                        <select name="recurrence" id="recurrence" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-emerald-500 focus:border-emerald-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white">
                            <option value="none" {{ old('recurrence', $activity->recurrence) == 'none' ? 'selected' : '' }}>None (One-time)</option>
                            <option value="daily" {{ old('recurrence', $activity->recurrence) == 'daily' ? 'selected' : '' }}>Daily</option>
                            <option value="weekly" {{ old('recurrence', $activity->recurrence) == 'weekly' ? 'selected' : '' }}>Weekly</option>
                            <option value="monthly" {{ old('recurrence', $activity->recurrence) == 'monthly' ? 'selected' : '' }}>Monthly</option>
                            <option value="yearly" {{ old('recurrence', $activity->recurrence) == 'yearly' ? 'selected' : '' }}>Yearly</option>
                        </select>
                        @error('recurrence')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <!-- Block Bookings -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Booking Status</label>
                        <div class="flex items-center space-x-4">
                            <div class="flex items-center">
                                <input type="radio" name="block_bookings" id="allow_bookings" value="0" {{ old('block_bookings', $activity->block_bookings) == 0 ? 'checked' : '' }} class="w-4 h-4 text-emerald-600 bg-gray-100 border-gray-300 focus:ring-emerald-500 dark:focus:ring-emerald-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                <label for="allow_bookings" class="ml-2 text-sm font-medium text-gray-700 dark:text-gray-300">Allow Bookings</label>
                            </div>
                            <div class="flex items-center">
                                <input type="radio" name="block_bookings" id="block_bookings" value="1" {{ old('block_bookings', $activity->block_bookings) == 1 ? 'checked' : '' }} class="w-4 h-4 text-emerald-600 bg-gray-100 border-gray-300 focus:ring-emerald-500 dark:focus:ring-emerald-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                <label for="block_bookings" class="ml-2 text-sm font-medium text-gray-700 dark:text-gray-300">Block Bookings</label>
                            </div>
                        </div>
                        @error('block_bookings')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <!-- Description -->
                    <div class="col-span-1 md:col-span-2">
                        <label for="description" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Description</label>
                        <textarea name="description" id="description" rows="4" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-emerald-500 focus:border-emerald-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white">{{ old('description', $activity->description) }}</textarea>
                        @error('description')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
                
                <div class="mt-6 flex justify-end space-x-3">
                    <a href="{{ route('admin.activities.index') }}" class="bg-gray-200 hover:bg-gray-300 text-gray-700 dark:bg-gray-700 dark:hover:bg-gray-600 dark:text-gray-200 px-4 py-2 rounded-lg">Cancel</a>
                    <button type="submit" class="bg-emerald-600 hover:bg-emerald-700 text-white px-4 py-2 rounded-lg">Update Activity</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Time validation
        const startTime = document.getElementById('start_time');
        const endTime = document.getElementById('end_time');
        
        endTime.addEventListener('change', function() {
            if (startTime.value && this.value <= startTime.value) {
                alert('End time must be after start time');
                this.value = '';
            }
        });
        
        startTime.addEventListener('change', function() {
            if (endTime.value && this.value >= endTime.value) {
                alert('Start time must be before end time');
                this.value = '';
            }
        });
    });
</script>
@endsection