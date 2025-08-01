<div id="approveModal" class="fixed inset-0 bg-black/60 backdrop-blur-sm hidden items-center justify-center z-50 transition-opacity duration-300">
    <div class="bg-white dark:bg-gray-800 rounded-xl p-6 w-[500px] shadow-2xl transform transition-transform duration-300 scale-95 opacity-0" id="approveModalContent">
        <!-- Header -->
        <div class="flex items-center mb-4">
            <div class="bg-emerald-100 dark:bg-emerald-900/30 p-2 rounded-full mr-3">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-emerald-600 dark:text-emerald-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                </svg>
            </div>
            <h3 class="text-xl font-bold text-gray-900 dark:text-white">Approve Service Request</h3>
        </div>
        
        <form id="approveForm" action="" method="POST">
            @csrf
            
            <!-- Content -->
            <p class="text-gray-600 dark:text-gray-300 mb-6">Please select a priest to assign to this service request.</p>
            
            <!-- Priest Selection -->
            <div class="mb-6">
                <label for="priest_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                    <i class="fas fa-user-tie mr-2 text-emerald-600 dark:text-emerald-400"></i>
                    Assign Priest
                </label>
                <select 
                    id="priest_id" 
                    name="priest_id" 
                    class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 bg-white dark:bg-gray-700 text-gray-900 dark:text-white"
                    required
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
                <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Only available priests are shown</p>
            </div>
            
            <!-- Actions -->
            <div class="flex justify-end gap-3">
                <button 
                    type="button"
                    onclick="closeApproveModal()" 
                    class="px-4 py-2 text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-lg transition-colors focus:outline-none focus:ring-2 focus:ring-gray-300 dark:focus:ring-gray-600"
                >
                    Cancel
                </button>
                <button 
                    type="submit" 
                    class="px-4 py-2 bg-emerald-600 text-white rounded-lg hover:bg-emerald-700 transition-colors focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 flex items-center"
                >
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                    Approve & Assign
                </button>
            </div>
        </form>
    </div>
</div>

<script>
// Add this script if not already present elsewhere
document.addEventListener('DOMContentLoaded', function() {
    // Get modal elements
    const approveModal = document.getElementById('approveModal');
    const approveModalContent = document.getElementById('approveModalContent');
    
    // Add event listener for ESC key to close modal
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape' && !approveModal.classList.contains('hidden')) {
            closeApproveModal();
        }
    });
    
    // Close modal when clicking outside content
    approveModal.addEventListener('click', function(e) {
        if (e.target === approveModal) {
            closeApproveModal();
        }
    });
});

// Update the open function to include animation
window.openApproveModal = function(bookingId) {
    const form = document.getElementById('approveForm');
    form.action = '{{ url("/admin/bookings") }}/' + bookingId + '/approve';
    
    // Show modal with fade in
    const modal = document.getElementById('approveModal');
    const modalContent = document.getElementById('approveModalContent');
    
    modal.classList.remove('hidden');
    modal.classList.add('flex');
    
    // Trigger animation after a small delay
    setTimeout(() => {
        modalContent.classList.remove('scale-95', 'opacity-0');
        modalContent.classList.add('scale-100', 'opacity-100');
    }, 10);
};

// Update the close function to include animation
window.closeApproveModal = function() {
    const modal = document.getElementById('approveModal');
    const modalContent = document.getElementById('approveModalContent');
    
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