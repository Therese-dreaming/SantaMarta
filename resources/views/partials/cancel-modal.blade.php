<div id="cancelModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center">
    <div class="bg-white rounded-lg p-6 w-[400px]">
        <h3 class="text-xl font-bold mb-4">Confirm Cancellation</h3>
        <p class="text-gray-600 mb-6">Are you sure you want to cancel this service request?</p>
        <div class="flex justify-end gap-4">
            <button onclick="closeCancelModal()" class="px-4 py-2 text-gray-600 hover:text-gray-800">
                Go Back
            </button>
            <form id="cancelForm" method="POST" class="inline">
                @csrf
                @method('POST')
                <button type="submit" class="px-4 py-2 bg-red-500 text-white rounded-lg hover:bg-red-600">
                    Confirm Cancel
                </button>
            </form>
        </div>
    </div>
</div>