<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 font-[Poppins]">
    @forelse($services as $service)
    <div class="service-item bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden hover:shadow-md transition-shadow duration-200 mb-2">
        <!-- Card Header -->
        <div class="px-4 py-2 border-b border-gray-200 dark:border-gray-700 flex justify-between items-center">
            <span class="font-medium text-gray-900 dark:text-white bg-gray-100 dark:bg-gray-700 px-2 py-0.5 rounded-full text-xs">#{{ $service->ticket_number }}</span>
            <span class="px-2 py-0.5 rounded-full text-xs font-medium
                {{ $service->status === 'approved' ? 'bg-emerald-100 dark:bg-emerald-900 text-emerald-800 dark:text-emerald-200' : 
                   ($service->status === 'pending' ? 'bg-yellow-100 dark:bg-yellow-900 text-yellow-800 dark:text-yellow-200' : 
                   ($service->status === 'completed' ? 'bg-blue-100 dark:bg-blue-900 text-blue-800 dark:text-blue-200' : 
                   ($service->status === 'payment_on_hold' ? 'bg-yellow-100 dark:bg-yellow-900 text-yellow-800 dark:text-yellow-200' : 
                   'bg-red-100 dark:bg-red-900 text-red-800 dark:text-red-200'))) }}">
                {{ $service->status === 'payment_on_hold' ? 'Payment On Hold' : ucfirst($service->status) }}
            </span>
        </div>
        <!-- Card Body -->
        <div class="px-4 py-2 space-y-2">
            <!-- Service Type -->
            <div class="flex items-center">
                <div class="w-7 h-7 rounded-lg bg-emerald-100 dark:bg-emerald-900 flex items-center justify-center text-emerald-800 dark:text-emerald-200 mr-2 text-base">
                    <i class="fas {{ 
                        $service->type === 'baptism' ? 'fa-water' : 
                        ($service->type === 'wedding' ? 'fa-rings-wedding' : 
                        ($service->type === 'mass_intention' ? 'fa-church' : 
                        ($service->type === 'blessing' ? 'fa-hands-praying' : 
                        ($service->type === 'confirmation' ? 'fa-dove' : 
                        ($service->type === 'sick_call' ? 'fa-hospital-user' : 'fa-circle'))))) }}"></i>
                </div>
                <span class="font-medium text-gray-900 dark:text-white text-sm">{{ ucwords(str_replace('_', ' ', $service->type)) }}</span>
            </div>
            <!-- Requestor -->
            <div class="flex items-center">
                <div class="h-7 w-7 rounded-full bg-emerald-100 dark:bg-emerald-900 flex items-center justify-center text-emerald-800 dark:text-emerald-200 font-medium text-xs">
                    {{ substr($service->user->name, 0, 1) }}
                </div>
                <span class="ml-2 font-medium text-gray-900 dark:text-white text-xs">{{ $service->user->name }}</span>
            </div>
            <!-- Schedule -->
            <div class="flex items-center">
                <div class="w-6 h-6 rounded-full bg-gray-100 dark:bg-gray-700 flex items-center justify-center text-gray-600 dark:text-gray-300 mr-2 text-xs">
                    <i class="fas fa-calendar-alt"></i>
                </div>
                <span class="text-gray-700 dark:text-gray-300 text-xs">
                    {{ Carbon\Carbon::parse($service->preferred_date)->format('M d, Y') }} at
                    {{ Carbon\Carbon::parse($service->preferred_time)->format('g:i A') }}
                </span>
            </div>
        </div>
        <!-- Card Footer -->
        <div class="px-4 py-2 bg-gray-50 dark:bg-gray-700 border-t border-gray-200 dark:border-gray-600">
            <div class="flex flex-wrap gap-1 items-center">
                <a href="{{ route('admin.bookings.show', $service->id) }}" class="p-1 rounded bg-gray-50 dark:bg-gray-700 text-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-600 transition-colors duration-150 text-xs">
                    <i class="fas fa-eye mr-1 text-xs"></i>
                    View
                </a>
            </div>
        </div>
    </div>
    @empty
    <div class="col-span-full py-6 text-center text-gray-500 dark:text-gray-400 bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700">
        <div class="flex flex-col items-center">
            <i class="fas fa-inbox text-3xl mb-2 text-gray-400 dark:text-gray-500"></i>
            <p class="text-xs">No services found</p>
        </div>
    </div>
    @endforelse
</div> 