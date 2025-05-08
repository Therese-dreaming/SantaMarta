<div id="bookingDetailsModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50 p-4 backdrop-blur-sm">
    <div class="bg-white dark:bg-gray-800 rounded-xl p-8 w-[600px] max-h-[80vh] overflow-y-auto relative shadow-2xl">
        <!-- Exit button -->        
        <button onclick="closeBookingDetailsModal()" class="absolute top-6 right-6 text-gray-400 hover:text-red-500">
            <i class="fas fa-times text-xl"></i>
        </button>
        
        <h3 class="text-2xl font-bold mb-6 text-gray-900 dark:text-white border-b pb-4 border-gray-200 dark:border-gray-700">Booking Details</h3>
        
        <div class="space-y-6">
            <!-- Service Details -->
            <div class="bg-gray-50 dark:bg-gray-700 p-6 rounded-xl shadow-sm border border-gray-100 dark:border-gray-600">
                <h4 class="font-semibold text-lg text-gray-900 dark:text-white mb-4">Service Information</h4>
                <div class="grid grid-cols-2 gap-6 text-sm">
                    <div>
                        <p class="text-gray-500 dark:text-gray-400 mb-1">Service Type</p>
                        <p class="text-gray-900 dark:text-white font-medium text-base" id="viewServiceType"></p>
                    </div>
                    <div>
                        <p class="text-gray-500 dark:text-gray-400 mb-1">Amount</p>
                        <p class="text-gray-900 dark:text-white font-medium text-base">₱<span id="viewServiceAmount"></span></p>
                    </div>
                </div>
            </div>

            <!-- Payment Details -->
            <div class="bg-gray-50 dark:bg-gray-700 p-6 rounded-xl shadow-sm border border-gray-100 dark:border-gray-600">
                <h4 class="font-semibold text-lg text-gray-900 dark:text-white mb-4">Payment Information</h4>
                <div class="grid grid-cols-2 gap-6 text-sm">
                    <div>
                        <p class="text-gray-500 dark:text-gray-400 mb-1">Payment Method</p>
                        <p class="text-gray-900 dark:text-white font-medium text-base" id="viewPaymentMethod"></p>
                    </div>
                    <div>
                        <p class="text-gray-500 dark:text-gray-400 mb-1">Reference Number</p>
                        <p class="text-gray-900 dark:text-white font-medium text-base" id="viewReferenceNumber"></p>
                    </div>
                </div>
            </div>

            <!-- Payment Proof -->
            <div class="bg-gray-50 dark:bg-gray-700 p-6 rounded-xl shadow-sm border border-gray-100 dark:border-gray-600">
                <h4 class="font-semibold text-lg text-gray-900 dark:text-white mb-4">Payment Proof</h4>
                <div class="rounded-lg overflow-hidden bg-gray-100 dark:bg-gray-600">
                    <img id="viewPaymentProof" src="" alt="Payment Proof" class="w-full h-auto object-contain">
                </div>
            </div>

            <!-- Verification Details -->
            <div class="bg-gray-50 dark:bg-gray-700 p-6 rounded-xl shadow-sm border border-gray-100 dark:border-gray-600">
                <h4 class="font-semibold text-lg text-gray-900 dark:text-white mb-4">Verification Details</h4>
                <div class="space-y-4">
                    <div>
                        <p class="text-gray-500 dark:text-gray-400 mb-1">Status</p>
                        <p id="viewVerificationStatus" class="text-base font-medium"></p>
                    </div>
                    <div>
                        <p class="text-gray-500 dark:text-gray-400 mb-1">Verified By</p>
                        <p class="text-gray-900 dark:text-white font-medium text-base" id="viewVerifiedBy"></p>
                    </div>
                    <div>
                        <p class="text-gray-500 dark:text-gray-400 mb-1">Verified At</p>
                        <p class="text-gray-900 dark:text-white font-medium text-base" id="viewVerifiedAt"></p>
                    </div>
                    <div>
                        <p class="text-gray-500 dark:text-gray-400 mb-1">Notes</p>
                        <p class="text-gray-900 dark:text-white text-base" id="viewVerificationNotes"></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function openBookingDetailsModal(booking) {
        const modal = document.getElementById('bookingDetailsModal');

        // Update modal content
        document.getElementById('viewServiceType').textContent = booking.type.charAt(0).toUpperCase() + booking.type.slice(1);
        document.getElementById('viewServiceAmount').textContent = booking.amount.toLocaleString();
        document.getElementById('viewPaymentMethod').textContent = booking.payment_method.charAt(0).toUpperCase() + booking.payment_method.slice(1);
        document.getElementById('viewReferenceNumber').textContent = booking.payment_reference;
        document.getElementById('viewPaymentProof').src = booking.payment_proof_url;

        // Update verification details
        const statusElement = document.getElementById('viewVerificationStatus');
        statusElement.textContent = booking.verification_status.charAt(0).toUpperCase() + booking.verification_status.slice(1);
        statusElement.className = `text-base font-medium ${
            booking.verification_status === 'verified' ? 'text-emerald-600 dark:text-emerald-400' : 'text-red-600 dark:text-red-400'
        }`;

        document.getElementById('viewVerifiedBy').textContent = booking.verified_by_name;
        document.getElementById('viewVerifiedAt').textContent = new Date(booking.verified_at).toLocaleString();
        document.getElementById('viewVerificationNotes').textContent = booking.verification_notes || 'No notes provided';

        // Show modal
        modal.classList.remove('hidden');
        modal.classList.add('flex');
    }

    function closeBookingDetailsModal() {
        const modal = document.getElementById('bookingDetailsModal');
        modal.classList.remove('flex');
        modal.classList.add('hidden');
    }
</script>