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
@endsection