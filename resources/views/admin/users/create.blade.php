@extends('layouts.admin')

@section('title', 'Create User')

@section('content')
<div class="container px-6 mx-auto">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-semibold text-gray-700 dark:text-gray-200">Create New User</h1>
        <a href="{{ route('admin.users.index') }}" class="group inline-flex items-center px-4 py-2 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm text-gray-700 dark:text-gray-200 hover:bg-gray-50 dark:hover:bg-gray-600 transition-all duration-200">
            <i class="fas fa-arrow-left mr-2 group-hover:-translate-x-1 transition-transform duration-200"></i> Back to Users
        </a>
    </div>

    @if(session('success'))
    <div class="mb-6 p-4 bg-green-100 border border-green-200 text-green-700 rounded-lg animate-fadeIn">
        <div class="flex items-center">
            <i class="fas fa-check-circle mr-2"></i>
            <span>{{ session('success') }}</span>
        </div>
    </div>
    @endif

    @if(session('error'))
    <div class="mb-6 p-4 bg-red-100 border border-red-200 text-red-700 rounded-lg animate-fadeIn">
        <div class="flex items-center">
            <i class="fas fa-exclamation-circle mr-2"></i>
            <span>{{ session('error') }}</span>
        </div>
    </div>
    @endif

    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg overflow-hidden border border-gray-200 dark:border-gray-700 transition-all duration-300 hover:shadow-xl">
        <!-- Enhanced User Create Header with gradient -->
        <div class="bg-gradient-to-r from-blue-600/10 via-blue-400/10 to-blue-300/10 dark:from-blue-900/30 dark:via-blue-800/20 dark:to-gray-800 px-6 py-4 border-b border-gray-200 dark:border-gray-600">
            <div class="flex items-center space-x-3">
                <div class="p-2 rounded-full bg-blue-100 dark:bg-blue-900/70 text-blue-600 dark:text-blue-300 shadow-sm">
                    <i class="fas fa-user-plus"></i>
                </div>
                <div>
                    <h2 class="text-lg font-medium text-gray-800 dark:text-gray-200">User Information</h2>
                    <p class="text-sm text-gray-500 dark:text-gray-400">Create a new user account</p>
                </div>
            </div>
        </div>
        
        <!-- Form Content with enhanced spacing and transitions -->
        <div class="p-6 space-y-6">
            <form action="{{ route('admin.users.store') }}" method="POST" class="space-y-8">
                @csrf
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <!-- Left Column -->
                    <div class="space-y-6">
                        <div class="rounded-lg bg-gray-50 dark:bg-gray-800/50 p-6 border border-gray-200 dark:border-gray-700 transition-all duration-300 hover:shadow-md">
                            <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-4">Basic Information</h3>
                            
                            <!-- Enhanced Name Field -->
                            <div class="mb-4 group">
                                <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Full Name</label>
                                <div class="relative rounded-md shadow-sm">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-400 group-hover:text-blue-500 transition-colors duration-200">
                                        <i class="fas fa-user"></i>
                                    </div>
                                    <input type="text" name="name" id="name" value="{{ old('name') }}" 
                                        class="w-full pl-10 px-3 py-2.5 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white transition-all duration-200 hover:border-blue-400" required>
                                </div>
                                @error('name')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            
                            <!-- Enhanced Email Field -->
                            <div class="group">
                                <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Email Address</label>
                                <div class="relative rounded-md shadow-sm">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-400 group-hover:text-blue-500 transition-colors duration-200">
                                        <i class="fas fa-envelope"></i>
                                    </div>
                                    <input type="email" name="email" id="email" value="{{ old('email') }}" 
                                        class="w-full pl-10 px-3 py-2.5 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white transition-all duration-200 hover:border-blue-400" required>
                                </div>
                                @error('email')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                        
                        <!-- Enhanced User Roles & Permissions Section -->
                        <div class="rounded-lg bg-gray-50 dark:bg-gray-800/50 p-6 border border-gray-200 dark:border-gray-700 transition-all duration-300 hover:shadow-md">
                            <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-4">User Permissions</h3>
                            
                            <div class="space-y-4">
                                <!-- Enhanced Admin Role Toggle -->
                                <div class="bg-white dark:bg-gray-800 rounded-lg p-4 border border-gray-200 dark:border-gray-600 hover:border-blue-400 dark:hover:border-blue-500 transition-all duration-200 group">
                                    <div class="flex items-start space-x-3">
                                        <div class="flex items-center h-5 pt-0.5">
                                            <input type="checkbox" name="is_admin" id="is_admin" value="1" {{ old('is_admin') ? 'checked' : '' }} 
                                                class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded dark:bg-gray-700 dark:border-gray-600 transition-colors duration-200">
                                        </div>
                                        <div class="flex-1">
                                            <label for="is_admin" class="font-medium text-gray-700 dark:text-gray-300 group-hover:text-blue-600 dark:group-hover:text-blue-400 transition-colors duration-200">Admin User</label>
                                            <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Admin users have full access to the system including user management and configuration settings.</p>
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Enhanced Email Verification Toggle -->
                                <div class="bg-white dark:bg-gray-800 rounded-lg p-4 border border-gray-200 dark:border-gray-600 hover:border-blue-400 dark:hover:border-blue-500 transition-all duration-200 group">
                                    <div class="flex items-start space-x-3">
                                        <div class="flex items-center h-5 pt-0.5">
                                            <input type="checkbox" name="verified" id="verified" value="1" {{ old('verified') ? 'checked' : '' }} 
                                                class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded dark:bg-gray-700 dark:border-gray-600 transition-colors duration-200">
                                        </div>
                                        <div class="flex-1">
                                            <label for="verified" class="font-medium text-gray-700 dark:text-gray-300 group-hover:text-blue-600 dark:group-hover:text-blue-400 transition-colors duration-200">Email Verified</label>
                                            <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Mark the user's email as verified. Unverified users may have limited access to certain features.</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Right Column -->
                    <div class="space-y-6">
                        <div class="rounded-lg bg-gray-50 dark:bg-gray-800/50 p-6 border border-gray-200 dark:border-gray-700 transition-all duration-300 hover:shadow-md">
                            <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-4">Security</h3>
                            
                            <!-- Enhanced Password Field -->
                            <div class="mb-4 group">
                                <label for="password" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Password</label>
                                <div class="relative rounded-md shadow-sm">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-400 group-hover:text-blue-500 transition-colors duration-200">
                                        <i class="fas fa-lock"></i>
                                    </div>
                                    <input type="password" name="password" id="password" 
                                        class="w-full pl-10 px-3 py-2.5 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white transition-all duration-200 hover:border-blue-400" required>
                                </div>
                                @error('password')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            
                            <!-- Enhanced Confirm Password Field -->
                            <div class="group">
                                <label for="password_confirmation" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Confirm Password</label>
                                <div class="relative rounded-md shadow-sm">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-400 group-hover:text-blue-500 transition-colors duration-200">
                                        <i class="fas fa-lock"></i>
                                    </div>
                                    <input type="password" name="password_confirmation" id="password_confirmation" 
                                        class="w-full pl-10 px-3 py-2.5 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white transition-all duration-200 hover:border-blue-400" required>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Enhanced Info Card -->
                        <div class="bg-blue-50 dark:bg-blue-900/20 rounded-lg p-6 border border-blue-200 dark:border-blue-800/50 transition-all duration-300 hover:shadow-md">
                            <div class="flex items-center mb-4">
                                <div class="p-2 rounded-full bg-blue-100 dark:bg-blue-900/50 text-blue-600 dark:text-blue-300 mr-3">
                                    <i class="fas fa-info-circle"></i>
                                </div>
                                <h3 class="text-sm font-medium text-blue-800 dark:text-blue-300">Account Information</h3>
                            </div>
                            <div class="space-y-2 text-sm text-blue-700 dark:text-blue-300 ml-11 opacity-90">
                                <p class="flex items-center"><i class="fas fa-envelope-open mr-2"></i> New users will receive a welcome email if email verification is enabled.</p>
                                <p class="flex items-center"><i class="fas fa-shield-alt mr-2"></i> Password must be at least 8 characters long and contain a mix of letters, numbers, and symbols.</p>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Enhanced Action Buttons -->
                <div class="flex justify-end space-x-4 pt-6 border-t border-gray-200 dark:border-gray-700">
                    <a href="{{ route('admin.users.index') }}" 
                        class="px-6 py-2.5 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 dark:bg-gray-700 dark:text-gray-200 dark:hover:bg-gray-600 transition-all duration-200 flex items-center group">
                        <i class="fas fa-times mr-2 group-hover:scale-110 transition-transform duration-200"></i> Cancel
                    </a>
                    <button type="submit" 
                        class="px-6 py-2.5 bg-blue-600 text-white rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 dark:bg-blue-500 dark:hover:bg-blue-600 transition-all duration-200 flex items-center group shadow-md hover:shadow-lg">
                        <i class="fas fa-user-plus mr-2 group-hover:scale-110 transition-transform duration-200"></i> Create User
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection