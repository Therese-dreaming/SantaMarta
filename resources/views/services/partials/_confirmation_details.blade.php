@if($booking->confirmationDetails)
<div class="mt-4 border-t pt-4">
    <h4 class="font-medium text-gray-900 mb-2">Confirmation Details</h4>
    <div class="grid grid-cols-2 gap-4 text-sm">
        <div>
            <span class="font-medium">Confirmand's Name:</span>
            <p class="text-gray-600">{{ $booking->confirmationDetails->confirmand_name }}</p>
        </div>
        <div>
            <span class="font-medium">Date of Birth:</span>
            <p class="text-gray-600">{{ \Carbon\Carbon::parse($booking->confirmationDetails->confirmand_dob)->format('F j, Y') }}</p>
        </div>
        <div>
            <span class="font-medium">Baptism Place:</span>
            <p class="text-gray-600">{{ $booking->confirmationDetails->baptism_place }}</p>
        </div>
        <div>
            <span class="font-medium">Baptism Date:</span>
            <p class="text-gray-600">{{ \Carbon\Carbon::parse($booking->confirmationDetails->baptism_date)->format('F j, Y') }}</p>
        </div>
        <div>
            <span class="font-medium">Sponsor's Name:</span>
            <p class="text-gray-600">{{ $booking->confirmationDetails->sponsor_name }}</p>
        </div>
    </div>
</div>
@endif