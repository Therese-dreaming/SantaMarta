@if($booking->blessingDetails)
<div class="mt-4 border-t pt-4">
    <h4 class="font-medium text-gray-900 mb-2">Blessing Details</h4>
    <div class="grid grid-cols-2 gap-4 text-sm">
        <div>
            <span class="font-medium">Type of Blessing:</span>
            <p class="text-gray-600 capitalize">{{ str_replace('_', ' ', $booking->blessingDetailss->blessing_type) }}</p>
        </div>
        <div>
            <span class="font-medium">Location:</span>
            <p class="text-gray-600">{{ $booking->blessingDetails->blessing_location }}</p>
        </div>
    </div>
</div>
@endif