@extends('layouts.admin')

@section('title', 'Service Bookings')

@section('content')
<div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm p-6 font-[Poppins]">
    <div class="grid grid-cols-4 gap-4 mb-8 w-full">
        <button id="pendingBtn" class="status-btn active w-full">
            <div class="flex items-center justify-center space-x-3">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <span>Pending</span>
                <span class="bg-yellow-500 text-white text-sm rounded-full px-2 py-1" id="pendingCount">{{ $pendingCount }}</span>
            </div>
        </button>
        <button id="paymentHoldBtn" class="status-btn w-full">
            <div class="flex items-center justify-center space-x-3">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <span>Payment Hold</span>
                <span class="bg-yellow-500 text-white text-sm rounded-full px-2 py-1" id="paymentHoldCount">{{ $paymentHoldCount }}</span>
            </div>
        </button>
        <button id="verifyPaymentBtn" class="status-btn w-full">
            <div class="flex items-center justify-center space-x-3">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path>
                </svg>
                <span>Verify Payment</span>
                <span class="bg-blue-500 text-white text-sm rounded-full px-2 py-1" id="verifyPaymentCount">{{ $verifyPaymentCount }}</span>
            </div>
        </button>
        <button id="approvedBtn" class="status-btn w-full">
            <div class="flex items-center justify-center space-x-3">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <span>Approved</span>
                <span class="bg-green-500 text-white text-sm rounded-full px-2 py-1" id="approvedCount">{{ $approvedCount }}</span>
            </div>
        </button>
    </div>
    <div class="flex justify-end mb-4">
        <div class="inline-flex rounded-full border border-emerald-500 bg-white dark:bg-gray-800 shadow-sm overflow-hidden" id="viewToggleGroup">
            <button id="tableViewBtn" class="view-toggle-btn active flex items-center gap-2 px-6 py-2 text-emerald-700 dark:text-emerald-200 font-semibold text-sm transition-all duration-200 focus:outline-none">
                <i class="fas fa-table"></i> Table
            </button>
            <button id="cardViewBtn" class="view-toggle-btn flex items-center gap-2 px-6 py-2 text-emerald-700 dark:text-emerald-200 font-semibold text-sm transition-all duration-200 focus:outline-none">
                <i class="fas fa-th-large"></i> Cards
            </button>
        </div>
    </div>
    <div id="pendingTable">
        @include('partials.service-table', ['services' => $bookings->where('status', 'pending')])
    </div>
    <div id="pendingCards" class="hidden">
        @include('partials.service-cards', ['services' => $bookings->where('status', 'pending')])
    </div>
    <div id="approvedTable" class="hidden">
        @include('partials.service-table', ['services' => $bookings->where('status', 'approved')])
    </div>
    <div id="approvedCards" class="hidden">
        @include('partials.service-cards', ['services' => $bookings->where('status', 'approved')])
    </div> 
<div id="paymentHoldTable" class="hidden">
    @include('partials.service-table', ['services' => $bookings->where('status', 'payment_on_hold')->where('payment_status', '!=', 'paid')])
</div>
<div id="paymentHoldCards" class="hidden">
    @include('partials.service-cards', ['services' => $bookings->where('status', 'payment_on_hold')->where('payment_status', '!=', 'paid')])
</div>
<div id="verifyPaymentTable" class="hidden">
    @include('partials.service-table', ['services' => $bookings->where('status', 'payment_on_hold')->where('payment_status', 'paid')])
</div>
<div id="verifyPaymentCards" class="hidden">
    @include('partials.service-cards', ['services' => $bookings->where('status', 'payment_on_hold')->where('payment_status', 'paid')])
</div>
</div>

<style>
.status-btn {
    padding: 1.5rem 0;
    font-size: 1.25rem;
    font-weight: bold;
    border-radius: 0.5rem;
    background: #f3f4f6;
    color: #6b7280;
    transition: all 0.3s;
    width: 100%;
    border: none;
    box-shadow: 0 1px 2px rgba(16,185,129,0.05);
    outline: none;
}
.status-btn:hover, .status-btn:focus {
    background: #e5e7eb;
    color: #059669;
}
.status-btn.active {
    background: #059669;
    color: #fff;
    box-shadow: 0 4px 16px rgba(16,185,129,0.15);
}
.view-toggle-btn {
    background: transparent;
    border: none;
    border-radius: 0;
    box-shadow: none;
    cursor: pointer;
}
#viewToggleGroup .view-toggle-btn.active {
    background: #059669;
    color: #fff;
    box-shadow: 0 2px 8px rgba(16,185,129,0.15);
}
#viewToggleGroup .view-toggle-btn:not(.active):hover {
    background: #f0fdfa;
    color: #059669;
}
#viewToggleGroup .view-toggle-btn:first-child {
    border-right: 1px solid #d1fae5;
}
#viewToggleGroup .view-toggle-btn {
    min-width: 100px;
}

/* Custom class for vertical alignment in table cells */
.align-middle-cell {
    vertical-align: middle;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const pendingBtn = document.getElementById('pendingBtn');
    const paymentHoldBtn = document.getElementById('paymentHoldBtn');
    const verifyPaymentBtn = document.getElementById('verifyPaymentBtn');
    const approvedBtn = document.getElementById('approvedBtn');
    const pendingTable = document.getElementById('pendingTable');
    const paymentHoldTable = document.getElementById('paymentHoldTable');
    const verifyPaymentTable = document.getElementById('verifyPaymentTable');
    const approvedTable = document.getElementById('approvedTable');
    const pendingCards = document.getElementById('pendingCards');
    const paymentHoldCards = document.getElementById('paymentHoldCards');
    const verifyPaymentCards = document.getElementById('verifyPaymentCards');
    const approvedCards = document.getElementById('approvedCards');
    const tableViewBtn = document.getElementById('tableViewBtn');
    const cardViewBtn = document.getElementById('cardViewBtn');

    function hideAllSections() {
        [pendingTable, pendingCards, paymentHoldTable, paymentHoldCards,
         verifyPaymentTable, verifyPaymentCards, approvedTable, approvedCards]
        .forEach(el => {
            if (el) el.classList.add('hidden');
        });
    }

    function setActiveStatusButton(activeBtn) {
        [pendingBtn, paymentHoldBtn, verifyPaymentBtn, approvedBtn]
        .forEach(btn => {
            if (btn) btn.classList.remove('active');
        });
        activeBtn.classList.add('active');
    }

    function setActiveViewButton(activeBtn, inactiveBtn) {
        activeBtn.classList.add('active');
        inactiveBtn.classList.remove('active');
    }

    function updateViewForActiveStatus() {
        const activeStatusButton = document.querySelector('.status-btn.active');
        let currentTable, currentCards;
        if (activeStatusButton === pendingBtn) {
            currentTable = pendingTable;
            currentCards = pendingCards;
        } else if (activeStatusButton === paymentHoldBtn) {
            currentTable = paymentHoldTable;
            currentCards = verifyPaymentCards;
        } else if (activeStatusButton === verifyPaymentBtn) {
            currentTable = verifyPaymentTable;
            currentCards = verifyPaymentCards;
        } else if (activeStatusButton === approvedBtn) {
            currentTable = approvedTable;
            currentCards = approvedCards;
        }

        if (currentTable && currentCards) {
            if (tableViewBtn.classList.contains('active')) {
                currentTable.classList.remove('hidden');
                currentCards.classList.add('hidden');
            } else {
                currentTable.classList.add('hidden');
                currentCards.classList.remove('hidden');
            }
        }
    }

    function showStatusSection(tableEl, cardsEl, btn) {
        hideAllSections();
        setActiveStatusButton(btn);
        if (tableViewBtn.classList.contains('active')) {
            if (tableEl) tableEl.classList.remove('hidden');
        } else {
            if (cardsEl) cardsEl.classList.remove('hidden');
        }
    }

    pendingBtn.addEventListener('click', () => showStatusSection(pendingTable, pendingCards, pendingBtn));
    if(paymentHoldBtn) paymentHoldBtn.addEventListener('click', () => showStatusSection(paymentHoldTable, paymentHoldCards, paymentHoldBtn));
    if(verifyPaymentBtn) verifyPaymentBtn.addEventListener('click', () => showStatusSection(verifyPaymentTable, verifyPaymentCards, verifyPaymentBtn));
    approvedBtn.addEventListener('click', () => showStatusSection(approvedTable, approvedCards, approvedBtn));

    tableViewBtn.addEventListener('click', function() {
        setActiveViewButton(tableViewBtn, cardViewBtn);
        updateViewForActiveStatus();
    });
    cardViewBtn.addEventListener('click', function() {
        setActiveViewButton(cardViewBtn, tableViewBtn);
        updateViewForActiveStatus();
    });

    // Initial state
    showStatusSection(pendingTable, pendingCards, pendingBtn);
    setActiveViewButton(tableViewBtn, cardViewBtn);
    updateViewForActiveStatus();
});

// Move openHoldForPaymentModal and rejectBooking functions, and the .hold-for-payment-btn event listener here
window.openHoldForPaymentModal = function(bookingId) {
    const form = document.getElementById('holdForPaymentForm');
    form.action = '{{ url("/admin/bookings") }}/' + bookingId + '/hold-for-payment';
    const modal = document.getElementById('holdForPaymentModal');
    modal.classList.remove('hidden');
    modal.classList.add('flex');
}

function rejectBooking() {
    const form = document.getElementById('holdForPaymentForm');
    const actionUrl = form.action.replace('hold-for-payment', 'cancel');
    
    // Create a new form for the cancel action
    const cancelForm = document.createElement('form');
    cancelForm.method = 'POST';
    cancelForm.action = actionUrl;
    
    // Add CSRF token from the existing form
    const csrfToken = form.querySelector('input[name="_token"]').value;
    const csrfInput = document.createElement('input');
    csrfInput.type = 'hidden';
    csrfInput.name = '_token';
    csrfInput.value = csrfToken;
    cancelForm.appendChild(csrfInput);
    
    // Submit the form
    document.body.appendChild(cancelForm);
    cancelForm.submit();
    
    // Hide the modal
    holdForPaymentModal.classList.add('hidden');
}

// Event delegation for hold-for-payment-btn moved from service-table.blade.php
document.addEventListener('click', function(e) {
    if (e.target.closest('.hold-for-payment-btn')) {
        e.preventDefault();
        const btn = e.target.closest('.hold-for-payment-btn');
        const form = btn.closest('form');
        const bookingId = form.action.match(/bookings\/(\d+)/)[1];
        openHoldForPaymentModal(bookingId);
    }
});

// Add event listener for release document forms
document.addEventListener('submit', function(e) {
    if (e.target.classList.contains('release-document-form')) {
        e.preventDefault();
        const loadingOverlay = document.getElementById('loadingOverlay');
        if (loadingOverlay) {
            loadingOverlay.classList.remove('hidden');
            loadingOverlay.classList.add('flex');
        }
        // Submit the form after showing the overlay
        e.target.submit();
    }
});

</script>
@endsection

@include('partials.approve-modal')
@include('partials.cancel-modal')
@include('partials.booking-details-modal')
@include('partials.new-verification-modal')

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
                <button type="button" onclick="rejectBooking()" class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700 transition-colors duration-150">
                    Reject
                </button>
                <button type="submit" class="px-4 py-2 bg-emerald-600 text-white rounded hover:bg-emerald-700 transition-colors duration-150">
                    Confirm
                </button>
            </div>
        </form>
    </div>
</div>