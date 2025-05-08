@if($booking->baptismDetails)
<div class="mt-4 border-t pt-4">
    <h4 class="font-medium text-gray-900 mb-2">Baptism Details</h4>
    <div class="grid grid-cols-2 gap-4 text-sm">
        <div>
            <span class="font-medium">Child's Name:</span>
            <p class="text-gray-600">{{ $booking->baptismDetails->child_name }}</p>
        </div>
        <div>
            <span class="font-medium">Date of Birth:</span>
            <p class="text-gray-600">{{ \Carbon\Carbon::parse($booking->baptismDetails->date_of_birth)->format('F j, Y') }}</p>
        </div>
        <div>
            <span class="font-medium">Place of Birth:</span>
            <p class="text-gray-600">{{ $booking->baptismDetails->place_of_birth }}</p>
        </div>
        <div>
            <span class="font-medium">Father's Name:</span>
            <p class="text-gray-600">{{ $booking->baptismDetails->father_name }}</p>
        </div>
        <div>
            <span class="font-medium">Mother's Name:</span>
            <p class="text-gray-600">{{ $booking->baptismDetails->mother_name }}</p>
        </div>
        <div>
            <span class="font-medium">Nationality:</span>
            <p class="text-gray-600">{{ $booking->baptismDetails->nationality }}</p>
        </div>
    </div>
</div>
@endif