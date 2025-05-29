<div class="overflow-x-auto rounded-lg border border-gray-200 dark:border-gray-700 font-[Poppins]">
    <table class="w-full text-sm">
        <thead class="bg-gray-50 dark:bg-gray-700">
            <tr>
                <th class="px-3 py-2 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Ticket #</th>
                <th class="px-3 py-2 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Service Type</th>
                <th class="px-3 py-2 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Requestor</th>
                <th class="px-3 py-2 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Schedule</th>
                <th class="px-3 py-2 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Status</th>
                <th class="px-3 py-2 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Actions</th>
            </tr>
        </thead>
        <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-100 dark:divide-gray-700">
            @forelse($services as $service)
            <tr class="service-item hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors duration-150" data-status="{{ strtolower($service->status) }}" data-service="{{ str_replace(' ', '_', strtolower($service->type)) }}" data-payment-status="{{ strtolower($service->payment_status ?? '') }}">
                <td class="px-3 py-2 whitespace-nowrap text-sm">
                    <span class="font-medium text-gray-900 dark:text-white bg-gray-100 dark:bg-gray-700 px-2 py-1 rounded-full text-sm">#{{ $service->ticket_number }}</span>
                </td>
                <td class="px-3 py-2 whitespace-nowrap text-sm">
                    <div class="flex items-center">
                        <div class="w-6 h-6 rounded-lg bg-emerald-100 dark:bg-emerald-900 flex items-center justify-center text-emerald-800 dark:text-emerald-200 mr-2 text-base">
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
                </td>
                <td class="px-3 py-2 whitespace-nowrap text-sm">
                    <div class="flex items-center">
                        <div class="h-6 w-6 rounded-full bg-emerald-100 dark:bg-emerald-900 flex items-center justify-center text-emerald-800 dark:text-emerald-200 font-medium text-xs">
                            {{ substr($service->user->name, 0, 1) }}
                        </div>
                        <span class="ml-2 font-medium text-gray-900 dark:text-white text-sm">{{ $service->user->name }}</span>
                    </div>
                </td>
                <td class="px-3 py-2 whitespace-nowrap text-sm text-gray-700 dark:text-gray-300">
                    {{ Carbon\Carbon::parse($service->preferred_date)->format('M d, Y') }} at
                    {{ Carbon\Carbon::parse($service->preferred_time)->format('g:i A') }}
                </td>
                <td class="px-3 py-2 whitespace-nowrap text-sm">
                    <span class="px-2 py-1 rounded-full text-xs font-medium
                        {{ $service->status === 'approved' ? 'bg-emerald-100 dark:bg-emerald-900 text-emerald-800 dark:text-emerald-200' : 
                           ($service->status === 'pending' ? 'bg-yellow-100 dark:bg-yellow-900 text-yellow-800 dark:text-yellow-200' : 
                           ($service->status === 'completed' ? 'bg-blue-100 dark:bg-blue-900 text-blue-800 dark:text-blue-200' : 
                           ($service->status === 'payment_on_hold' ? 'bg-yellow-100 dark:bg-yellow-900 text-yellow-800 dark:text-yellow-200' : 
                           'bg-red-100 dark:bg-red-900 text-red-800 dark:text-red-200'))) }}">
                        {{ $service->status === 'payment_on_hold' ? 'Payment On Hold' : ucfirst($service->status) }}
                    </span>
                </td>
                <td class="px-3 py-2 whitespace-nowrap text-sm">
                    <div class="flex gap-2">
                        <a href="{{ route('admin.bookings.show', $service->id) }}" class="p-1.5 rounded-lg bg-gray-50 dark:bg-gray-700 text-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-600 transition-colors duration-150 text-xs">
                            <i class="fas fa-eye mr-1 text-xs"></i>
                            View
                        </a>
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="6" class="px-6 py-8 text-center text-gray-500 dark:text-gray-400">
                    <div class="flex flex-col items-center">
                        <i class="fas fa-inbox text-4xl mb-3 text-gray-400 dark:text-gray-500"></i>
                        <p>No services found</p>
                    </div>
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

@include('partials.approve-modal')
@include('partials.cancel-modal')
@include('partials.booking-details-modal')

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const statusFilter = document.getElementById('statusFilter');
        const serviceFilter = document.getElementById('serviceFilter');
        const serviceRows = document.querySelectorAll('tr.service-item');
        const approveModal = document.getElementById('approveModal');
        const cancelModal = document.getElementById('cancelModal');

        function filterServices() {
            const statusValue = statusFilter.value.toLowerCase();
            const serviceValue = serviceFilter.value.toLowerCase();
            let visibleCount = 0;

            serviceRows.forEach(row => {
                const status = row.getAttribute('data-status');
                const service = row.getAttribute('data-service');

                const statusMatch = statusValue === 'all' || status === statusValue;
                const serviceMatch = serviceValue === 'all' || service === serviceValue;

                if (statusMatch && serviceMatch) {
                    row.style.display = '';
                    visibleCount++;
                } else {
                    row.style.display = 'none';
                }
            });

            // Handle no results message
            const tbody = document.querySelector('tbody');
            const existingNoResults = tbody.querySelector('.no-results-row');

            if (visibleCount === 0) {
                if (!existingNoResults) {
                    const noResultsRow = document.createElement('tr');
                    noResultsRow.className = 'no-results-row';
                    noResultsRow.innerHTML = `
                        <td colspan="6" class="px-6 py-8 text-center text-gray-500 dark:text-gray-400">
                            <div class="flex flex-col items-center">
                                <i class="fas fa-filter text-4xl mb-3 text-gray-400 dark:text-gray-500"></i>
                                <p>No services found matching the selected filters</p>
                            </div>
                        </td>
                    `;
                    tbody.appendChild(noResultsRow);
                }
            } else if (existingNoResults) {
                existingNoResults.remove();
            }
        }

        // Initial filter on page load
        filterServices();

        // Add event listeners for filters
        statusFilter.addEventListener('change', filterServices);
        serviceFilter.addEventListener('change', filterServices);

        // Modal functions
        window.openApproveModal = function(bookingId) {
            const form = document.getElementById('approveForm');
            // Use the route helper to generate the correct URL
            form.action = '{{ url("/admin/bookings") }}/' + bookingId + '/approve';
            approveModal.classList.remove('hidden');
            approveModal.classList.add('flex');
        }

        // Only attach approve modal to .approve-btn
        document.querySelectorAll('.approve-btn').forEach(btn => {
            btn.addEventListener('click', function(e) {
                e.preventDefault();
                const form = this.closest('form');
                // Extract the service ID from the data attribute
                const bookingId = form.action.match(/bookings\/(\d+)\/approve/)[1];
                openApproveModal(bookingId);
            });
        });

        // Remove direct event listener for .hold-for-payment-btn
        // Use event delegation for all .hold-for-payment-btn (table and cards)
        window.openHoldForPaymentModal = function(bookingId) {
            const form = document.getElementById('holdForPaymentForm');
            form.action = '{{ url("/admin/bookings") }}/' + bookingId + '/hold-for-payment';
            const modal = document.getElementById('holdForPaymentModal');
            modal.classList.remove('hidden');
            modal.classList.add('flex');
        }

        // Event delegation for hold-for-payment-btn
        document.addEventListener('click', function(e) {
            if (e.target.closest('.hold-for-payment-btn')) {
                e.preventDefault();
                const btn = e.target.closest('.hold-for-payment-btn');
                const form = btn.closest('form');
                const bookingId = form.action.match(/bookings\/(\d+)/)[1];
                if (typeof openHoldForPaymentModal === 'function') {
                    openHoldForPaymentModal(bookingId);
                } else if (window.openHoldForPaymentModal) {
                    window.openHoldForPaymentModal(bookingId);
                }
            }
        });

        document.querySelectorAll('.final-approve-btn').forEach(btn => {
            btn.addEventListener('click', function(e) {
                e.preventDefault();
                const form = this.closest('form');
                form.submit();
            });
        });

        window.openCancelModal = function(bookingId) {
            const form = document.getElementById('cancelForm');
            form.action = '{{ url("/admin/bookings") }}/' + bookingId + '/cancel';
            const modal = document.getElementById('cancelModal');
            modal.classList.remove('hidden');
            modal.classList.add('flex');
        }

        window.closeCancelModal = function() {
            const modal = document.getElementById('cancelModal');
            modal.classList.remove('flex');
            modal.classList.add('hidden');
        }

        // Update the cancel button event listeners
        document.querySelectorAll('.cancel-btn').forEach(btn => {
            btn.addEventListener('click', function(e) {
                e.preventDefault();
                const form = this.closest('form');
                const bookingId = form.action.match(/bookings\/(\d+)/)[1];
                openCancelModal(bookingId);
            }); 
        });
    });
</script>