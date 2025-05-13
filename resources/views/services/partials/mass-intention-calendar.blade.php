<form action="{{ route('services.store') }}" method="POST" class="space-y-6">
    @csrf
    <input type="hidden" name="service_type" value="mass_intention">

    <div class="mb-6">
        <label for="preferred_date" class="block text-sm font-medium text-gray-700">Mass Date <span class="text-red-500">*</span></label>
        <input type="date" id="preferred_date" name="preferred_date" 
            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500"
            required
            min="{{ date('Y-m-d') }}"
            value="{{ old('preferred_date') }}">
        @error('preferred_date')
        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <div class="mb-6">
        <label for="preferred_time" class="block text-sm font-medium text-gray-700">Mass Time <span class="text-red-500">*</span></label>
        <select id="preferred_time" name="preferred_time" 
            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500"
            required>
            <option value="">Select a time</option>
            <option value="06:00" {{ old('preferred_time') == '06:00' ? 'selected' : '' }}>6:00 AM</option>
            <option value="07:30" {{ old('preferred_time') == '07:30' ? 'selected' : '' }}>7:30 AM</option>
            <option value="09:00" {{ old('preferred_time') == '09:00' ? 'selected' : '' }}>9:00 AM</option>
            <option value="16:30" {{ old('preferred_time') == '16:30' ? 'selected' : '' }}>4:30 PM</option>
            <option value="18:00" {{ old('preferred_time') == '18:00' ? 'selected' : '' }}>6:00 PM</option>
        </select>
        @error('preferred_time')
        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <div class="mb-6">
        <label for="notes" class="block text-sm font-medium text-gray-700">Mass Intention Details <span class="text-red-500">*</span></label>
        <textarea id="notes" name="notes" rows="4" 
            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500"
            placeholder="Please specify the intention for this mass (e.g., for the soul of, thanksgiving, special intention)"
            required>{{ old('notes') }}</textarea>
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