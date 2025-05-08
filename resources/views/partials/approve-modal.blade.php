<div id="approveModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center">
    <div class="bg-white rounded-lg p-6 w-[400px]">
        <h3 class="text-xl font-bold mb-4">Confirm Approval</h3>
        <p class="text-gray-600 mb-6">Are you sure you want to approve this service request?</p>
        <div class="flex justify-end gap-4">
            <button onclick="closeApproveModal()" class="px-4 py-2 text-gray-600 hover:text-gray-800">
                Cancel
            </button>
            <form id="approveForm" action="" method="POST" class="inline">
                @csrf
                <button type="submit" class="px-4 py-2 bg-[#18421F] text-white rounded-lg hover:bg-[#18421F]/90">
                    Confirm Approval
                </button>
            </form>
        </div>
    </div>
</div>