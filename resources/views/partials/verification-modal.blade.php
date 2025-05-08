<div id="verificationModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50 p-4">
    <div class="bg-white dark:bg-gray-800 rounded-xl p-8 w-[600px] max-h-[80vh] overflow-y-auto relative shadow-2xl">
        <!-- Exit button -->        
        <button onclick="closeVerificationModal()" class="absolute top-6 right-6 text-gray-400 hover:text-red-500">
            <i class="fas fa-times text-xl"></i>
        </button>
        
        <h3 class="text-2xl font-bold mb-6 text-gray-900 dark:text-white border-b pb-4 border-gray-200 dark:border-gray-700">Verify Payment</h3>
        
        <div class="space-y-6">
            <!-- Service Details with hover effect -->
            <div class="bg-gray-50 dark:bg-gray-700 p-6 rounded-xl shadow-sm hover:shadow-md transition-all duration-300 border border-gray-100 dark:border-gray-600 group">
                <h4 class="font-semibold text-lg text-gray-900 dark:text-white mb-4 group-hover:text-emerald-600 dark:group-hover:text-emerald-400 transition-colors duration-300">Service Details</h4>
                <div class="grid grid-cols-2 gap-6 text-sm">
                    <div class="group/item">
                        <p class="text-gray-500 dark:text-gray-400 mb-1 group-hover/item:text-emerald-600 dark:group-hover/item:text-emerald-400 transition-colors duration-300">Service Type</p>
                        <p class="text-gray-900 dark:text-white font-medium text-base" id="serviceType"></p>
                    </div>
                    <div class="group/item">
                        <p class="text-gray-500 dark:text-gray-400 mb-1 group-hover/item:text-emerald-600 dark:group-hover/item:text-emerald-400 transition-colors duration-300">Amount</p>
                        <p class="text-gray-900 dark:text-white font-medium text-base">₱<span id="serviceAmount"></span></p>
                    </div>
                </div>
            </div>

            <!-- Payment Details with hover effect -->
            <div class="bg-gray-50 dark:bg-gray-700 p-6 rounded-xl shadow-sm hover:shadow-md transition-all duration-300 border border-gray-100 dark:border-gray-600 group">
                <h4 class="font-semibold text-lg text-gray-900 dark:text-white mb-4 group-hover:text-emerald-600 dark:group-hover:text-emerald-400 transition-colors duration-300">Payment Details</h4>
                <div class="grid grid-cols-2 gap-6 text-sm">
                    <div class="group/item">
                        <p class="text-gray-500 dark:text-gray-400 mb-1 group-hover/item:text-emerald-600 dark:group-hover/item:text-emerald-400 transition-colors duration-300">Payment Method</p>
                        <p class="text-gray-900 dark:text-white font-medium text-base" id="paymentMethod"></p>
                    </div>
                    <div class="group/item">
                        <p class="text-gray-500 dark:text-gray-400 mb-1 group-hover/item:text-emerald-600 dark:group-hover/item:text-emerald-400 transition-colors duration-300">Reference Number</p>
                        <p class="text-gray-900 dark:text-white font-medium text-base" id="referenceNumber"></p>
                    </div>
                </div>
            </div>

            <!-- Payment Proof with hover effect -->
            <div class="bg-gray-50 dark:bg-gray-700 p-6 rounded-xl shadow-sm hover:shadow-md transition-all duration-300 border border-gray-100 dark:border-gray-600 group">
                <h4 class="font-semibold text-lg text-gray-900 dark:text-white mb-4 group-hover:text-emerald-600 dark:group-hover:text-emerald-400 transition-colors duration-300">Payment Proof</h4>
                <div class="rounded-lg overflow-hidden bg-gray-100 dark:bg-gray-600 hover:shadow-lg transition-shadow duration-300">
                    <img id="paymentProof" src="" alt="Payment Proof" class="w-full h-auto object-contain transform transition-transform duration-300 hover:scale-105">
                </div>
            </div>

            <!-- Verification Form with enhanced styling -->
            <form id="verificationForm" method="POST" class="space-y-6">
                @csrf
                <input type="hidden" name="status" id="verification_status">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">

                <div class="space-y-2">
                    <label for="notes" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Notes</label>
                    <textarea 
                        name="notes" 
                        id="verification_notes" 
                        rows="3" 
                        class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:border-emerald-500 dark:focus:border-emerald-500 focus:ring-emerald-500 shadow-sm px-4 py-3" 
                        placeholder="Add any verification notes here..."
                    ></textarea>
                </div>

                <div class="flex justify-end gap-4 pt-4">
                    <button 
                        type="button" 
                        onclick="submitVerification('rejected')" 
                        class="px-6 py-2.5 bg-red-600 text-white rounded-lg hover:bg-red-700 font-medium shadow-sm focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800"
                    >
                        Reject
                    </button>
                    <button 
                        type="button" 
                        onclick="submitVerification('verified')" 
                        class="px-6 py-2.5 bg-emerald-600 text-white rounded-lg hover:bg-emerald-700 font-medium shadow-sm focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800"
                    >
                        Approve
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function closeVerificationModal() {
        const modal = document.getElementById('verificationModal');
        modal.classList.remove('flex');
        modal.classList.add('hidden');
    }

    window.openVerificationModal = function(bookingId, type, amount, method, reference, proofUrl) {
        const modal = document.getElementById('verificationModal');
        const form = document.getElementById('verificationForm');
        const serviceType = document.getElementById('serviceType');
        const serviceAmount = document.getElementById('serviceAmount');
        const paymentMethod = document.getElementById('paymentMethod');
        const referenceNumber = document.getElementById('referenceNumber');
        const paymentProof = document.getElementById('paymentProof');

        // Update form action
        form.action = `/admin/bookings/${bookingId}/verify-payment`;

        // Update modal content
        serviceType.textContent = type.charAt(0).toUpperCase() + type.slice(1);
        serviceAmount.textContent = amount.toLocaleString();
        paymentMethod.textContent = method.charAt(0).toUpperCase() + method.slice(1);
        referenceNumber.textContent = reference;
        paymentProof.src = proofUrl;

        // Show modal
        modal.classList.remove('hidden');
        modal.classList.add('flex');
    }

    function submitVerification(status) {
        document.getElementById('verification_status').value = status;
        const form = document.getElementById('verificationForm');
        const formData = new FormData(form);
        
        // Submit form using fetch
        fetch(form.action, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
            },
            body: formData
        })
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            const message = status === 'verified' ? 'Payment verified successfully' : 'Payment rejected successfully';
            const notification = document.createElement('div');
            notification.className = 'mb-6 p-4 bg-emerald-100 border border-emerald-200 text-emerald-700 rounded-lg';
            notification.innerHTML = `
                <div class="flex items-center">
                    <i class="fas fa-check-circle mr-2"></i>
                    <span>${message}</span>
                </div>
            `;
            
            // Insert notification at the top of the main content
            const mainContent = document.querySelector('main .container');
            mainContent.insertBefore(notification, mainContent.firstChild);
            
            // Close modal and remove notification after delay
            closeVerificationModal();
            setTimeout(() => {
                notification.remove();
                window.location.reload();
            }, 3000);
        })
        .catch(error => {
            console.error('Error:', error);
            alert('An error occurred while processing your request.');
        });
    }
</script>