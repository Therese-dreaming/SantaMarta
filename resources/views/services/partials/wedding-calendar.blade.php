<form action="{{ route('services.store') }}" method="POST" class="space-y-6">
    @csrf
    <input type="hidden" name="service_type" value="wedding">

    <div class="mb-6">
        <label for="preferred_date" class="block text-sm font-medium text-gray-700">Wedding Date <span class="text-red-500">*</span></label>
        <input type="date" id="preferred_date" name="preferred_date" 
            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500"
            required
            min="{{ date('Y-m-d', strtotime('+6 months')) }}"
            value="{{ old('preferred_date') }}">
        <p class="mt-1 text-sm text-gray-500">Note: Wedding dates must be booked at least 6 months in advance</p>
        @error('preferred_date')
        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <div class="mb-6">
        <label for="preferred_time" class="block text-sm font-medium text-gray-700">Wedding Time <span class="text-red-500">*</span></label>
        <select id="preferred_time" name="preferred_time" 
            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500"
            required>
            <option value="">Select a time</option>
            <option value="08:00" {{ old('preferred_time') == '08:00' ? 'selected' : '' }}>8:00 AM</option>
            <option value="10:00" {{ old('preferred_time') == '10:00' ? 'selected' : '' }}>10:00 AM</option>
            <option value="14:00" {{ old('preferred_time') == '14:00' ? 'selected' : '' }}>2:00 PM</option>
            <option value="16:00" {{ old('preferred_time') == '16:00' ? 'selected' : '' }}>4:00 PM</option>
        </select>
        @error('preferred_time')
        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <div class="mb-6">
        <label for="notes" class="block text-sm font-medium text-gray-700">Additional Notes</label>
        <textarea id="notes" name="notes" rows="4" 
            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500"
            placeholder="Any special requests or additional information for your wedding">{{ old('notes') }}</textarea>
        @error('notes')
        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <div class="flex justify-end">
        <button type="submit" class="bg-[#0d5c2f] text-white px-6 py-2 rounded-lg hover:bg-[#0d5c2f]/90 transition duration-150 ease-in-out">
            Continue
        </button>
    </div>
</form>