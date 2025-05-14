@extends('layouts.admin')

@section('title', 'Service Bookings')

@section('content')
<div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm p-8 font-[Poppins]">
    <div class="flex justify-between items-center mb-8">
        <h1 class="text-2xl font-semibold text-gray-800 dark:text-white">Service Bookings</h1>
        <div class="flex space-x-4">
            <select id="paymentFilter" class="rounded-lg border border-gray-200 dark:border-gray-700 text-sm focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 dark:bg-gray-700 dark:text-gray-200 py-2.5 px-4">
                <option value="all">All Payments</option>
                <option value="pending_payment">Pending Payment</option>
                <option value="pending_verification">Pending Verification</option>
                <option value="verified">Payment Verified</option>
                <option value="rejected">Payment Rejected</option>
            </select>
            <select id="statusFilter" class="rounded-lg border border-gray-200 dark:border-gray-700 text-sm focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 dark:bg-gray-700 dark:text-gray-200 py-2.5 px-4">
                <option value="all">All Status</option>
                <option value="pending">Pending</option>
                <option value="approved">Approved</option>
                <option value="completed">Completed</option>
                <option value="cancelled">Cancelled</option>
            </select>
            <select id="serviceFilter" class="rounded-lg border border-gray-200 dark:border-gray-700 text-sm focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 dark:bg-gray-700 dark:text-gray-200 py-2.5 px-4">
                <option value="all">All Services</option>
                <option value="baptism">Baptism</option>
                <option value="wedding">Wedding</option>
                <option value="mass_intention">Mass Intention</option>
                <option value="blessing">Blessing</option>
                <option value="confirmation">Confirmation</option>
                <option value="sick_call">Sick Call</option>
            </select>
        </div>
    </div>

    @include('partials.service-table', ['services' => $bookings])

    <!-- Payment Verification Modal -->
    <div id="paymentVerificationModal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full">
        <div class="relative top-20 mx-auto p-5 border w-full max-w-xl shadow-lg rounded-md bg-white">
            <div class="mt-3">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Verify Payment</h3>
                <div class="payment-details space-y-4 mb-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Service Type</label>
                        <p class="mt-1 text-sm text-gray-900" id="modal-service-type"></p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Amount Paid</label>
                        <p class="mt-1 text-sm text-gray-900" id="modal-amount"></p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Payment Method</label>
                        <p class="mt-1 text-sm text-gray-900" id="modal-payment-method"></p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Reference Number</label>
                        <p class="mt-1 text-sm text-gray-900" id="modal-reference-number"></p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Proof of Payment</label>
                        <img id="modal-payment-proof" class="mt-2 max-w-full h-auto rounded-lg" src="" alt="Payment Proof">
                    </div>
                </div>
                <div class="verification-form">
                    <form id="verificationForm" class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Verification Status</label>
                            <select id="verificationStatus" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500">
                                <option value="verified">Verify Payment</option>
                                <option value="rejected">Reject Payment</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Notes</label>
                            <textarea id="verificationNotes" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500" placeholder="Add any verification notes here..."></textarea>
                        </div>
                    </form>
                </div>
                <div class="mt-6 flex justify-end space-x-3">
                    <button id="closeVerificationModal" class="px-4 py-2 bg-gray-100 text-gray-700 rounded-md hover:bg-gray-200">Cancel</button>
                    <button id="submitVerification" class="px-4 py-2 bg-emerald-600 text-white rounded-md hover:bg-emerald-700">Submit Verification</button>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Loading Overlay -->
<div id="loadingOverlay" class="hidden fixed inset-0 bg-gray-900 bg-opacity-50 flex items-center justify-center z-50">
    <div class="bg-white p-8 rounded-lg flex flex-col items-center shadow-xl max-w-sm w-full mx-4">
        <div class="relative">
            <!-- Outer spinning circle -->
            <div class="animate-spin rounded-full h-16 w-16 border-4 border-emerald-200"></div>
            <!-- Inner spinning circle -->
            <div class="animate-spin rounded-full h-16 w-16 border-t-4 border-emerald-500 absolute top-0"></div>
            <!-- Document icon in center -->
            <svg class="h-8 w-8 text-emerald-500 absolute top-4 left-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
            </svg>
        </div>
        <p class="text-gray-700 mt-4 font-medium">Generating document...</p>
        <p class="text-gray-500 text-sm mt-2">This may take a few moments</p>
    </div>
</div>

@endsection

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Add loading indicator for document release
    document.querySelectorAll('a[href*="release-document"]').forEach(link => {
        link.addEventListener('click', function(e) {
            const loadingOverlay = document.getElementById('loadingOverlay');
            loadingOverlay.classList.remove('hidden');
            
            // Create a download detection iframe
            const downloadCheck = setInterval(() => {
                // Check if the document started downloading
                if (document.cookie.includes('document_download_started')) {
                    loadingOverlay.classList.add('hidden');
                    clearInterval(downloadCheck);
                    // Clear the cookie
                    document.cookie = 'document_download_started=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;';
                }
            }, 1000);

            // Fallback - hide overlay after 30 seconds in case something goes wrong
            setTimeout(() => {
                loadingOverlay.classList.add('hidden');
                clearInterval(downloadCheck);
            }, 30000);
        });
    });
});
</script>