@if($booking->sickCallDetailss)
<div class="mt-4 border-t pt-4">
    <h4 class="font-medium text-gray-900 mb-2">Sick Call Details</h4>
    <div class="grid grid-cols-2 gap-4 text-sm">
        <div>
            <span class="font-medium">Patient's Name:</span>
            <p class="text-gray-600">{{ $booking->sickCallDetails->patient_name }}</p>
        </div>
        <div>
            <span class="font-medium">Age:</span>
            <p class="text-gray-600">{{ $booking->sickCallDetails->patient_age }}</p>
        </div>
        <div>
            <span class="font-medium">Condition:</span>
            <p class="text-gray-600">{{ $booking->sickCallDetails->patient_condition }}</p>
        </div>
        <div>
            <span class="font-medium">Location:</span>
            <p class="text-gray-600">{{ $booking->sickCallDetails->location }}</p>
        </div>
        <div>
            <span class="font-medium">Room Number:</span>
            <p class="text-gray-600">{{ $booking->sickCallDetails->room_number }}</p>
        </div>
        <div>
            <span class="font-medium">Contact Person:</span>
            <p class="text-gray-600">{{ $booking->sickCallDetails->contact_person }}</p>
        </div>
        <div>
            <span class="font-medium">Emergency Contact:</span>
            <p class="text-gray-600">{{ $booking->sickCallDetails->emergency_contact }}</p>
        </div>
    </div>
</div>
@endif