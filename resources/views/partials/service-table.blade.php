<div class="overflow-x-auto rounded-lg border border-gray-200 dark:border-gray-700 font-[Poppins]">
    <table class="w-full">
        <thead class="bg-gray-50 dark:bg-gray-700">
            <tr>
                <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Ticket #</th>
                <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Service Type</th>
                <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Requestor</th>
                <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Schedule</th>
                <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Status</th>
                <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Actions</th>
            </tr>
        </thead>
        <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-100 dark:divide-gray-700">
            @forelse($services as $service)
            <tr class="service-item hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors duration-150" data-status="{{ strtolower($service->status) }}" data-service="{{ str_replace(' ', '_', strtolower($service->type)) }}">
                <td class="px-6 py-4 whitespace-nowrap">
                    <span class="font-medium text-gray-900 dark:text-white bg-gray-100 dark:bg-gray-700 px-3 py-1 rounded-full">#{{ $service->ticket_number }}</span>
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                    <div class="flex items-center">
                        <div class="w-8 h-8 rounded-lg bg-emerald-100 dark:bg-emerald-900 flex items-center justify-center text-emerald-800 dark:text-emerald-200 mr-3">
                            <i class="fas {{ 
                                $service->type === 'baptism' ? 'fa-water' : 
                                ($service->type === 'wedding' ? 'fa-rings-wedding' : 
                                ($service->type === 'mass_intention' ? 'fa-church' : 
                                ($service->type === 'blessing' ? 'fa-hands-praying' : 
                                ($service->type === 'confirmation' ? 'fa-dove' : 
                                ($service->type === 'sick_call' ? 'fa-hospital-user' : 'fa-circle'))))) }}">
                            </i>
                        </div>
                        <span class="font-medium text-gray-900 dark:text-white">{{ ucfirst($service->type) }}</span>
                    </div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                    <div class="flex items-center">
                        <div class="h-8 w-8 rounded-full bg-emerald-100 dark:bg-emerald-900 flex items-center justify-center text-emerald-800 dark:text-emerald-200 font-medium">
                            {{ substr($service->user->name, 0, 1) }}
                        </div>
                        <span class="ml-3 font-medium text-gray-900 dark:text-white">{{ $service->user->name }}</span>
                    </div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-gray-700 dark:text-gray-300">
                    {{ Carbon\Carbon::parse($service->preferred_date)->format('M d, Y') }} at
                    {{ Carbon\Carbon::parse($service->preferred_time)->format('g:i A') }}
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                    <span class="px-3 py-1.5 rounded-full text-sm font-medium
                        {{ $service->status === 'approved' ? 'bg-emerald-100 dark:bg-emerald-900 text-emerald-800 dark:text-emerald-200' : 
                           ($service->status === 'pending' ? 'bg-yellow-100 dark:bg-yellow-900 text-yellow-800 dark:text-yellow-200' : 
                           ($service->status === 'completed' ? 'bg-blue-100 dark:bg-blue-900 text-blue-800 dark:text-blue-200' : 
                           ($service->status === 'payment_on_hold' ? 'bg-yellow-100 dark:bg-yellow-900 text-yellow-800 dark:text-yellow-200' : 
                           'bg-red-100 dark:bg-red-900 text-red-800 dark:text-red-200'))) }}">
                        {{ $service->status === 'payment_on_hold' ? 'Payment On Hold' : ucfirst($service->status) }}
                    </span>
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                    <div class="flex gap-3">
                        @if($service->status === 'pending')
                        <form action="{{ route('admin.bookings.hold_for_payment', $service->id) }}" method="POST" class="inline">
                            @csrf
                            <button type="button" class="p-1.5 rounded-lg bg-emerald-50 dark:bg-emerald-900 text-emerald-600 dark:text-emerald-200 hover:bg-emerald-100 dark:hover:bg-emerald-800 transition-colors duration-150 approve-btn">
                                <i class="fas fa-check"></i>
                                <span class="ml-1">Hold for Payment</span>
                            </button>
                        </form>
                        @endif

                        @if($service->status === 'payment_on_hold' && $service->payment_status === 'paid' && $service->verification_status === 'pending')
                        <button onclick="openVerificationModal({{ $service->id }}, '{{ $service->type }}', {{ $service->amount }}, '{{ $service->payment_method }}', '{{ $service->payment_reference }}', '{{ asset("storage/" . $service->payment_proof) }}')" class="p-1.5 rounded-lg bg-blue-50 dark:bg-blue-900 text-blue-600 dark:text-blue-200 hover:bg-blue-100 dark:hover:bg-blue-800 transition-colors duration-150">
                            <i class="fas fa-check-circle mr-1"></i>
                            Verify Payment
                        </button>

                        @endif

                        @if($service->status === 'payment_on_hold' && $service->payment_status !== 'paid')
                        <span class="px-3 py-1.5 rounded-full text-sm font-medium bg-yellow-100 dark:bg-yellow-900 text-yellow-800 dark:text-yellow-200">
                            Waiting for Payment
                        </span>
                        @endif

                        @if($service->payment_status === 'paid' && !($service->status === 'payment_on_hold' && $service->verification_status === 'pending'))
                        <button 
                            onclick="openBookingDetailsModal({
                                id: {{ $service->id }},
                                type: '{{ $service->type }}',
                                amount: {{ $service->amount }},
                                payment_method: '{{ $service->payment_method }}',
                                payment_reference: '{{ $service->payment_reference }}',
                                payment_proof_url: '{{ asset('storage/' . $service->payment_proof) }}',
                                verification_status: '{{ $service->verification_status }}',
                                verified_by_name: '{{ optional($service->verifiedBy)->name ?? 'N/A' }}',
                                verified_at: '{{ $service->verified_at }}',
                                verification_notes: '{{ $service->verification_notes ?? 'No notes' }}'
                            })" 
                            class="p-1.5 rounded-lg bg-gray-50 dark:bg-gray-700 text-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-600 transition-colors duration-150"
                        >
                            <i class="fas fa-eye mr-1"></i>
                            View Details
                        </button>

                        @if($service->status === 'approved' || $service->status === 'completed')
                        <a 
                            href="{{ route('admin.bookings.release-document', $service->id) }}" 
                            class="p-1.5 rounded-lg bg-blue-50 dark:bg-blue-900 text-blue-600 dark:text-blue-200 hover:bg-blue-100 dark:hover:bg-blue-800 transition-colors duration-150"
                        >
                            <i class="fas fa-file-download mr-1"></i>
                            Release Document
                        </a>
                        @endif
                        @endif
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

<!-- Hold for Payment Modal -->
<div id="holdForPaymentModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center">
    <div class="bg-white rounded-lg p-6 w-[400px]">
        <h3 class="text-xl font-bold mb-4">Confirm Hold for Payment</h3>
        <p class="text-gray-600 mb-6">Are you sure you want to put this booking on hold for payment?</p>
        <form id="holdForPaymentForm" method="POST">
            @csrf
            <div class="flex justify-end gap-4">
                <button type="button" onclick="holdForPaymentModal.classList.add('hidden')" class="px-4 py-2 text-gray-600 dark:text-gray-300 hover:text-gray-800 dark:hover:text-white transition-colors duration-150">
                    Cancel
                </button>
                <button type="submit" class="px-4 py-2 bg-emerald-600 text-white rounded hover:bg-emerald-700 transition-colors duration-150">
                    Confirm
                </button>
            </div>
        </form>
    </div>
</div>

@include('partials.approve-modal')
@include('partials.cancel-modal')
@include('partials.verification-modal')
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

        // Update the action buttons to use modals
        document.querySelectorAll('.approve-btn').forEach(btn => {
            btn.addEventListener('click', function(e) {
                e.preventDefault();
                const form = this.closest('form');
                // Extract the service ID from the data attribute
                const bookingId = form.action.match(/bookings\/(\d+)\/approve/)[1];
                openApproveModal(bookingId);
            });
        });

        // Modal functions
        window.openHoldForPaymentModal = function(bookingId) {
            const form = document.getElementById('holdForPaymentForm');
            form.action = '{{ url("/admin/bookings") }}/' + bookingId + '/hold-for-payment';
            const modal = document.getElementById('holdForPaymentModal');
            modal.classList.remove('hidden');
            modal.classList.add('flex');
        }

        // Update the action buttons to use modals
        document.querySelectorAll('.approve-btn').forEach(btn => {
            btn.addEventListener('click', function(e) {
                e.preventDefault();
                const form = this.closest('form');
                const bookingId = form.action.match(/bookings\/(\d+)/)[1];
                openHoldForPaymentModal(bookingId);
            });
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
