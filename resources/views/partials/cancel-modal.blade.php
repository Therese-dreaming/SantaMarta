<div id="cancelModal" class="fixed inset-0 bg-black/60 backdrop-blur-sm hidden items-center justify-center z-50 transition-opacity duration-300">
    <div class="bg-white dark:bg-gray-800 rounded-xl p-6 w-[450px] shadow-2xl transform transition-transform duration-300 scale-95 opacity-0" id="cancelModalContent">
        <!-- Header -->
        <div class="flex items-center mb-4">
            <div class="bg-red-100 dark:bg-red-900/30 p-2 rounded-full mr-3">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-red-600 dark:text-red-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </div>
            <h3 class="text-xl font-bold text-gray-900 dark:text-white">Confirm Cancellation</h3>
        </div>
        
        <!-- Content -->
        <p class="text-gray-600 dark:text-gray-300 mb-6 pl-12">Are you sure you want to cancel this service request? This action cannot be undone.</p>
        
        <!-- Actions -->
        <div class="flex justify-end gap-4 mt-8">
            <button 
                onclick="closeCancelModal()" 
                class="px-4 py-2 text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-lg transition-colors focus:outline-none focus:ring-2 focus:ring-gray-300 dark:focus:ring-gray-600"
                aria-label="Go back without cancelling"
            >
                Go Back
            </button>
            <form id="cancelForm" method="POST" class="inline">
                @csrf
                @method('POST')
                <button 
                    type="submit" 
                    class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 flex items-center"
                    aria-label="Confirm service cancellation"
                >
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                    Confirm Cancel
                </button>
            </form>
        </div>
    </div>
</div>

<script>
// Add this script if not already present elsewhere
document.addEventListener('DOMContentLoaded', function() {
    // Get modal elements
    const cancelModal = document.getElementById('cancelModal');
    const cancelModalContent = document.getElementById('cancelModalContent');
    
    // Add event listener for ESC key to close modal
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape' && !cancelModal.classList.contains('hidden')) {
            closeCancelModal();
        }
    });
    
    // Close modal when clicking outside content
    cancelModal.addEventListener('click', function(e) {
        if (e.target === cancelModal) {
            closeCancelModal();
        }
    });
});

// Update the open function to include animation
window.openCancelModal = function(bookingId) {
    const form = document.getElementById('cancelForm');
    form.action = '{{ url("/admin/bookings") }}/' + bookingId + '/cancel';
    
    // Show modal with fade in
    const modal = document.getElementById('cancelModal');
    const modalContent = document.getElementById('cancelModalContent');
    
    modal.classList.remove('hidden');
    modal.classList.add('flex');
    
    // Trigger animation after a small delay
    setTimeout(() => {
        modalContent.classList.remove('scale-95', 'opacity-0');
        modalContent.classList.add('scale-100', 'opacity-100');
    }, 10);
};

// Update the close function to include animation
window.closeCancelModal = function() {
    const modal = document.getElementById('cancelModal');
    const modalContent = document.getElementById('cancelModalContent');
    
    // Animate out
    modalContent.classList.remove('scale-100', 'opacity-100');
    modalContent.classList.add('scale-95', 'opacity-0');
    
    // Hide modal after animation completes
    setTimeout(() => {
        modal.classList.remove('flex');
        modal.classList.add('hidden');
    }, 200);
};
</script>