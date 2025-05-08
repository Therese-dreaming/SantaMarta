<div id="editModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
    <div class="bg-white rounded-lg p-8 w-[500px]">
        <div class="flex justify-between items-start mb-6">
            <h3 class="text-xl font-bold">Edit {{ $type ?? 'User' }}</h3>
            <button onclick="closeEditModal()" class="text-gray-400 hover:text-gray-600">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <form id="editForm" method="POST" class="space-y-4">
            @csrf
            @method('PUT')
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Name</label>
                <input type="text" name="name" id="editName" required class="w-full px-4 py-2 rounded-lg border border-gray-300">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                <input type="email" name="email" id="editEmail" required class="w-full px-4 py-2 rounded-lg border border-gray-300">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Role</label>
                <select name="role" id="editRole" required class="w-full px-4 py-2 rounded-lg border border-gray-300">
                    <option value="user">User</option>
                    <option value="admin">Admin</option>
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">New Password (optional)</label>
                <input type="password" name="password" class="w-full px-4 py-2 rounded-lg border border-gray-300">
            </div>
            <div class="flex justify-end">
                <button type="submit" class="bg-[#18421F] text-white px-6 py-2 rounded-lg hover:bg-[#18421F]/90">
                    Update {{ $type ?? 'User' }}
                </button>
            </div>
        </form>
    </div>
</div>