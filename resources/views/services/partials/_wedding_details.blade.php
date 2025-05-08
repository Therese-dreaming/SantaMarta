@if($booking->weddingDetails)
<div class="mt-4 border-t pt-4">
    <h4 class="font-medium text-gray-900 mb-2">Wedding Details</h4>
    <div class="grid grid-cols-2 gap-4 text-sm">
        <div>
            <h5 class="font-medium text-gray-800">Groom Information</h5>
            <div class="mt-2">
                <span class="font-medium">Name:</span>
                <p class="text-gray-600">{{ $booking->weddingDetails->groom_name }}</p>
            </div>
            <div class="mt-1">
                <span class="font-medium">Age:</span>
                <p class="text-gray-600">{{ $booking->weddingDetails->groom_age }}</p>
            </div>
            <div class="mt-1">
                <span class="font-medium">Religion:</span>
                <p class="text-gray-600">{{ $booking->weddingDetails->groom_religion }}</p>
            </div>
        </div>
        <div>
            <h5 class="font-medium text-gray-800">Bride Information</h5>
            <div class="mt-2">
                <span class="font-medium">Name:</span>
                <p class="text-gray-600">{{ $booking->weddingDetails->bride_name }}</p>
            </div>
            <div class="mt-1">
                <span class="font-medium">Age:</span>
                <p class="text-gray-600">{{ $booking->weddingDetails->bride_age }}</p>
            </div>
            <div class="mt-1">
                <span class="font-medium">Religion:</span>
                <p class="text-gray-600">{{ $booking->weddingDetails->bride_religion }}</p>
            </div>
        </div>
    </div>
</div>
@endif