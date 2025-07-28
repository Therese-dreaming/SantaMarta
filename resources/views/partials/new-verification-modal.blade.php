<div id="newVerificationModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50 p-4">
    <div class="bg-white dark:bg-gray-800 rounded-xl p-8 w-[600px] max-h-[80vh] overflow-y-auto relative shadow-2xl">
        <!-- Exit button -->
        <button onclick="closeNewVerificationModal()" class="absolute top-6 right-6 text-gray-400 hover:text-red-500">
            <i class="fas fa-times text-xl"></i>
        </button>

        <h3 class="text-2xl font-bold mb-6 text-gray-900 dark:text-white border-b pb-4 border-gray-200 dark:border-gray-700">Verify Payment</h3>

        <div class="space-y-6">
            <!-- Verification Form -->
            <form id="newVerificationForm" method="POST" class="space-y-6">
                @csrf
                @method('PUT')
                <input type="hidden" name="verification_status" id="newVerificationStatusInput">

                <!-- Priest Selection (only shown when approving) -->
                <div id="priestSelectionDiv" class="space-y-2 hidden">
                    <label for="newVerificationPriest" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                        <i class="fas fa-user-tie mr-2 text-emerald-600 dark:text-emerald-400"></i>
                        Assign Priest
                    </label>
                    <select 
                        id="newVerificationPriest" 
                        name="priest_id" 
                        class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 bg-white dark:bg-gray-700 text-gray-900 dark:text-white"
                    >
                        <option value="">Select a priest...</option>
                        @php
                            $priests = \App\Models\Priest::where('availability_status', true)->orderBy('name')->get();
                        @endphp
                        @foreach($priests as $priest)
                            <option value="{{ $priest->id }}">
                                {{ $priest->name }}
                                @if($priest->specialization)
                                    - {{ $priest->specialization }}
                                @endif
                            </option>
                        @endforeach
                    </select>
                    <p class="text-xs text-gray-500 dark:text-gray-400">Required when approving the booking</p>
                </div>

                <div class="space-y-2">
                    <label for="newVerificationNotes" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Notes</label>
                    <textarea
                        name="verification_notes"
                        id="newVerificationNotes"
                        rows="3"
                        class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:border-emerald-500 dark:focus:border-emerald-500 focus:ring-emerald-500 shadow-sm px-4 py-3"
                        placeholder="Add any verification notes here..."
                    ></textarea>
                </div>

                <div class="flex justify-end gap-4 pt-4">
                    <button
                        type="button"
                        onclick="submitNewVerification('rejected')"
                        class="px-6 py-2.5 bg-red-600 text-white rounded-lg hover:bg-red-700 font-medium shadow-sm focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800"
                    >
                        Reject
                    </button>
                    <button
                        type="button"
                        onclick="submitNewVerification('verified')"
                        class="px-6 py-2.5 bg-emerald-600 text-white rounded-lg hover:bg-emerald-700 font-medium shadow-sm focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800"
                    >
                        Approve & Assign
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function closeNewVerificationModal() {
        const modal = document.getElementById('newVerificationModal');
        modal.classList.remove('flex');
        modal.classList.add('hidden');
    }

    window.openNewVerificationModal = function(bookingId, type, amount, method, reference, proofUrl) {
        const modal = document.getElementById('newVerificationModal');
        const form = document.getElementById('newVerificationForm');

        // Set the form action URL
        form.action = `/admin/bookings/${bookingId}/verify-payment`;

        // Show modal
        modal.classList.remove('hidden');
        modal.classList.add('flex');
    }

    function submitNewVerification(status) {
        const priestSelectionDiv = document.getElementById('priestSelectionDiv');
        const priestSelect = document.getElementById('newVerificationPriest');
        
        if (status === 'verified') {
            // Show priest selection and make it required
            priestSelectionDiv.classList.remove('hidden');
            priestSelect.setAttribute('required', 'required');
            
            // Check if priest is selected
            if (!priestSelect.value) {
                alert('Please select a priest before approving the booking.');
                return;
            }
        } else {
            // Hide priest selection and remove required attribute
            priestSelectionDiv.classList.add('hidden');
            priestSelect.removeAttribute('required');
            priestSelect.value = '';
        }
        
        document.getElementById('newVerificationStatusInput').value = status;
        const form = document.getElementById('newVerificationForm');
        
        // Use the form's submit method to ensure @method('PUT') is respected
        form.submit();
    }
    
    // Add event listener to show/hide priest selection when modal is opened
    document.addEventListener('DOMContentLoaded', function() {
        // Add click listeners to the approve/reject buttons to show/hide priest selection
        const approveBtn = document.querySelector('button[onclick="submitNewVerification(\'verified\')"]');
        const rejectBtn = document.querySelector('button[onclick="submitNewVerification(\'rejected\')"]');
        
        if (approveBtn) {
            approveBtn.addEventListener('click', function(e) {
                e.preventDefault();
                const priestSelectionDiv = document.getElementById('priestSelectionDiv');
                priestSelectionDiv.classList.remove('hidden');
                
                // Wait a moment for the UI to update, then check if priest is selected
                setTimeout(() => {
                    submitNewVerification('verified');
                }, 100);
            });
        }
        
        if (rejectBtn) {
            rejectBtn.addEventListener('click', function(e) {
                e.preventDefault();
                submitNewVerification('rejected');
            });
        }
    });
</script>