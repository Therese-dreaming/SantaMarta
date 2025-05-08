@if($booking->massIntentionDetails)
<div class="mt-4 border-t pt-4">
    <h4 class="font-medium text-gray-900 mb-2">Mass Intention Details</h4>
    <div class="grid grid-cols-2 gap-4 text-sm">
        <div>
            <span class="font-medium">Type of Mass:</span>
            <p class="text-gray-600 capitalize">{{ str_replace('_', ' ', $booking->massIntentionDetails->mass_type) }}</p>
        </div>
        <div>
            <span class="font-medium">Names Included:</span>
            <p class="text-gray-600">{{ $booking->massIntentionDetails->mass_names }}</p>
        </div>
    </div>
</div>
@endif