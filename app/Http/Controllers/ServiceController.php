<?php

namespace App\Http\Controllers;

use App\Models\ServiceBooking;
use App\Models\BaptismDetail;
use App\Models\WeddingDetail;
use App\Models\ConfirmationDetail;
use App\Models\MassIntentionDetail;
use App\Models\BlessingDetail;
use App\Models\SickCallDetail;
use App\Models\ServiceDocument;
use App\Notifications\ServiceBookingNotification;
use App\Notifications\PaymentConfirmationNotification;
use App\Notifications\PaymentRequestNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;

class ServiceController extends Controller
{
    public function store(Request $request)
    {
        // Common validation for all services
        $commonValidation = [
            'preferred_date' => 'required|date',
            'preferred_time' => 'required',
            'notes' => 'nullable|string'
        ];

        // Service-specific validation rules
        $serviceValidations = [
            'baptism' => [
                'baptism_type' => 'required|in:group,solo',
                'child_name' => 'required|string|max:255',
                'date_of_birth' => 'required|date',
                'place_of_birth' => 'required|string|max:255',
                'father_name' => 'required|string|max:255',
                'mother_name' => 'required|string|max:255',
                'nationality' => 'required|string|max:255',
            ],
            'wedding' => [
                'groom_name' => 'required|string|max:255',
                'groom_age' => 'required|numeric',
                'groom_religion' => 'required|string|max:255',
                'bride_name' => 'required|string|max:255',
                'bride_age' => 'required|numeric',
                'bride_religion' => 'required|string|max:255',
            ],
            'mass_intention' => [
                'mass_type' => 'required|string|max:255',
                'mass_names' => 'required|string',
            ],
            'blessing' => [
                'blessing_type' => 'required|string|max:255',
                'blessing_location' => 'required|string',
            ],
            'confirmation' => [
                'confirmand_name' => 'required|string|max:255',
                'confirmand_dob' => 'required|date',
                'baptism_place' => 'required|string|max:255',
                'baptism_date' => 'required|date',
            ],
            'sick_call' => [
                'patient_name' => 'required|string|max:255',
                'patient_address' => 'required|string',
                'patient_condition' => 'required|string',
            ],
        ];

        // Get validation rules for the specific service
        $validationRules = array_merge(
            $commonValidation,
            $serviceValidations[$request->service_type] ?? []
        );

        // Validate the request
        $request->validate($validationRules);

        // Generate unique ticket number based on service type
        $prefix = strtoupper(substr($request->service_type, 0, 3));
        $ticketNumber = $prefix . '-' . Str::random(8);

        // Set service prices
        $servicePrices = [
            'baptism' => 1000.00,
            'wedding' => 5000.00,
            'mass_intention' => 500.00,
            'blessing' => 1500.00,
            'confirmation' => 1000.00,
            'sick_call' => 1000.00
        ];

        // Create service booking
        $serviceBooking = ServiceBooking::create([
            'user_id' => auth()->id(),
            'name' => ucfirst($request->service_type) . ' Service',
            'type' => $request->service_type,
            'ticket_number' => $ticketNumber,
            'preferred_date' => $request->preferred_date,
            'preferred_time' => $request->preferred_time,
            'notes' => $request->notes,
            'status' => 'pending',
            'amount' => $servicePrices[$request->service_type]
        ]);

        // Create service-specific details
        switch ($request->service_type) {
            case 'baptism':
                BaptismDetail::create([
                    'service_booking_id' => $serviceBooking->id,
                    'baptism_type' => $request->baptism_type,
                    'child_name' => $request->child_name,
                    'date_of_birth' => $request->date_of_birth,
                    'place_of_birth' => $request->place_of_birth,
                    'father_name' => $request->father_name,
                    'mother_name' => $request->mother_name,
                    'nationality' => $request->nationality
                ]);
                break;
            case 'wedding':
                WeddingDetail::create([
                    'service_booking_id' => $serviceBooking->id,
                    'groom_name' => $request->groom_name,
                    'groom_age' => $request->groom_age,
                    'groom_religion' => $request->groom_religion,
                    'bride_name' => $request->bride_name,
                    'bride_age' => $request->bride_age,
                    'bride_religion' => $request->bride_religion
                ]);
                break;
            case 'mass_intention':
                MassIntentionDetail::create([
                    'service_booking_id' => $serviceBooking->id,
                    'mass_type' => $request->mass_type,
                    'mass_names' => $request->mass_names
                ]);
                break;
            case 'blessing':
                BlessingDetail::create([
                    'service_booking_id' => $serviceBooking->id,
                    'blessing_type' => $request->blessing_type,
                    'blessing_location' => $request->blessing_location
                ]);
                break;
            case 'confirmation':
                ConfirmationDetail::create([
                    'service_booking_id' => $serviceBooking->id,
                    'confirmand_name' => $request->confirmand_name,
                    'confirmand_dob' => $request->confirmand_dob,
                    'baptism_place' => $request->baptism_place,
                    'baptism_date' => $request->baptism_date
                ]);
                break;
            case 'sick_call':
                SickCallDetail::create([
                    'service_booking_id' => $serviceBooking->id,
                    'patient_name' => $request->patient_name,
                    'patient_address' => $request->patient_address,
                    'patient_condition' => $request->patient_condition
                ]);
                break;
        }

        return redirect()->back()->with('success', ucfirst($request->service_type) . ' service has been booked successfully. Your ticket number is ' . $ticketNumber);
    }

    public function show(ServiceBooking $serviceBooking)
    {
        // Load the service-specific details
        $detailRelation = $serviceBooking->type . 'Detail';
        if (method_exists($serviceBooking, $detailRelation)) {
            $serviceBooking->load($detailRelation);
        }

        return view('services.' . $serviceBooking->type . '.show', compact('serviceBooking'));
    }

    public function update(Request $request, ServiceBooking $serviceBooking)
    {
        // Common validation for all services
        $commonValidation = [
            'preferred_date' => 'required|date',
            'preferred_time' => 'required',
            'notes' => 'nullable|string'
        ];

        // Get validation rules for the specific service
        $validationRules = array_merge(
            $commonValidation,
            $serviceValidations[$serviceBooking->type] ?? []
        );

        // Validate the request
        $request->validate($validationRules);

        // Update service booking
        $serviceBooking->update([
            'preferred_date' => $request->preferred_date,
            'preferred_time' => $request->preferred_time,
            'notes' => $request->notes
        ]);

        // Update service-specific details
        $detailRelation = $serviceBooking->type . 'Detail';
        if (method_exists($serviceBooking, $detailRelation)) {
            $serviceBooking->$detailRelation->update($request->except([
                'preferred_date',
                'preferred_time',
                'notes',
                '_token',
                '_method'
            ]));
        }

        return redirect()->back()->with('success', ucfirst($serviceBooking->type) . ' service details have been updated successfully.');
    }

    /**
     * Display a listing of the bookings for admin/staff.
     *
     */
    public function adminIndex()
    {
        $bookings = ServiceBooking::with(['baptismDetail', 'weddingDetail', 'confirmationDetail', 'user'])
            ->orderBy('created_at', 'desc')
            ->get();

        return view('admin.bookings', compact('bookings'));
    }

    public function approve(ServiceBooking $booking)
    {
        $booking->update([
            'status' => 'approved'
        ]);

        return redirect()->back()->with('success', 'Service booking has been approved successfully.');
    }

    public function cancel(ServiceBooking $booking)
    {
        $booking->update([
            'status' => 'cancelled'
        ]);

        return redirect()->back()->with('success', 'Service booking has been cancelled successfully.');
    }

    public function myBookings()
    {
        $bookings = auth()->user()->serviceBookings()
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('services.my-bookings', compact('bookings'));
    }

    /**
     * Show the payment page for a specific booking.
     */
    public function showPayment(ServiceBooking $booking)
    {
        // Check if the booking belongs to the authenticated user
        if ($booking->user_id !== auth()->id()) {
            abort(403, 'Unauthorized action.');
        }

        // Check if the booking is available for payment
        if (!in_array($booking->status, ['payment_on_hold']) || $booking->payment_status === 'paid') {
            return redirect()->route('services.my-bookings')
                ->with('error', 'This booking is not available for payment.');
        }

        return view('services.payment', compact('booking'));
    }

    /**
     * Store the payment details for a specific booking.
     */
    public function storePayment(Request $request, ServiceBooking $booking)
    {
        // Validate the request
        $request->validate([
            'payment_method' => 'required|in:gcash,bank_transfer',
            'reference_number' => 'required|string|max:255',
            'payment_proof' => 'required|image|max:2048' // Max 2MB
        ]);

        // Check if the booking belongs to the authenticated user
        if ($booking->user_id !== auth()->id()) {
            abort(403, 'Unauthorized action.');
        }

        // Store the payment proof file
        $paymentProofPath = $request->file('payment_proof')
            ->store('payment-proofs', 'public');

        // Update the booking with payment details
        $booking->update([
            'payment_status' => 'paid',
            'payment_method' => $request->payment_method,
            'payment_reference' => $request->reference_number,
            'payment_proof' => $paymentProofPath,
            'paid_at' => now()
        ]);

        // Send payment confirmation email
        $booking->user->notify(new PaymentConfirmationNotification($booking));

        return redirect()->route('services.my-bookings')
            ->with('success', 'Payment submitted successfully. Please wait for confirmation.');
    }

    public function verifyPayment(ServiceBooking $booking, Request $request)
    {
        $request->validate([
            'status' => 'required|in:verified,rejected',
            'notes' => 'nullable|string|max:1000'
        ]);

        $booking->update([
            'verification_status' => $request->status,
            'verification_notes' => $request->notes,
            'verified_at' => now(),
            'verified_by' => auth()->id()
        ]);

        // Update booking status based on verification status
        if ($request->status === 'verified') {
            $booking->update(['status' => 'approved']);
        } else {
            $booking->update(['status' => 'rejected']);
        }

        return redirect()->back()->with('success', 'Payment verification updated successfully');
    }
    public function holdForPayment(ServiceBooking $booking)
    {
        $booking->update([
            'status' => 'payment_on_hold'
        ]);

        // Send email notification to the user
        $booking->user->notify(new PaymentRequestNotification($booking));

        return redirect()->back()->with('success', 'Service booking is now on hold for payment.');
    }

    public function showRequirements(Request $request)
    {
        // Validate and store the selected date/time
        $validated = $request->validate([
            'service_type' => 'required|string',
            'selected_date' => 'required|date',
            'selected_time' => 'required|string'
        ]);

        // Store in session for next step
        session(['booking_details' => $validated]);

        // Redirect to requirements page (you'll need to create this)
        return redirect()->route('services.requirements.show');
    }

    public function create(Request $request)
    {
        $serviceType = $request->query('service_type');
        return view('services.book', [
            'serviceType' => $serviceType,
            'understood' => $request->query('understood', 0),
            'selected_date' => $request->query('selected_date'),
            'selected_time' => $request->query('selected_time')
        ]);
    }

    public function storeStep1(Request $request)
    {
        // Base validation rules
        $rules = [
            'service_type' => 'required|string',
            'notes' => 'nullable|string'
        ];

        // Add service-specific validation rules based on selected service type
        switch ($request->service_type) {
            case 'baptism':
                $rules += [
                    'baptism_type' => 'required|in:group,solo',
                    'child_name' => 'required|string|max:255',
                    'date_of_birth' => 'required|date',
                    'place_of_birth' => 'required|string|max:255',
                    'father_name' => 'required|string|max:255',
                    'mother_name' => 'required|string|max:255',
                    'nationality' => 'required|string|max:255'
                ];
                break;
            case 'wedding':
                $rules += [
                    'groom_name' => 'required|string|max:255',
                    'groom_age' => 'required|numeric',
                    'groom_religion' => 'required|string|max:255',
                    'bride_name' => 'required|string|max:255',
                    'bride_age' => 'required|numeric',
                    'bride_religion' => 'required|string|max:255'
                ];
                break;
            case 'mass_intention':
                $rules += [
                    'mass_type' => 'required|in:thanksgiving,special_intention,healing,repose_soul',
                    'mass_names' => 'required|string'
                ];
                break;
            case 'blessing':
                $rules += [
                    'blessing_type' => 'required|in:house,car',
                    'blessing_location' => 'required|string'
                ];
                break;
            case 'confirmation':
                $rules += [
                    'confirmand_name' => 'required|string|max:255',
                    'confirmand_dob' => 'required|date',
                    'baptism_place' => 'required|string|max:255',
                    'baptism_date' => 'required|date',
                    'sponsor_name' => 'required|string|max:255'
                ];
                break;
            case 'sick_call':
                $rules += [
                    'patient_name' => 'required|string|max:255',
                    'patient_age' => 'required|numeric',
                    'patient_condition' => 'required|string',
                    'location' => 'required|string|max:255',
                    'room_number' => 'required|string|max:255',
                    'contact_person' => 'required|string|max:255',
                    'emergency_contact' => 'required|string|max:255'
                ];
                break;
        }

        $validated = $request->validate($rules);

        // Store in session
        session(['booking_step1' => $validated]);

        // Redirect to calendar with serviceType parameter
        return redirect()->route('services.calendar', ['serviceType' => $validated['service_type']]);
    }

    public function showCalendar($serviceType)
    {
        // Get approved bookings for this service type
        $approvedBookings = ServiceBooking::where('type', $serviceType)
            ->where('status', 'approved')
            ->select('preferred_date', 'preferred_time', 'status')
            ->get();

        return view('services.calendar', compact('serviceType', 'approvedBookings'));
    }

    public function storeStep2(Request $request)
    {
        $validated = $request->validate([
            'service_type' => 'required|string',
            'selected_date' => 'required|date',
            'selected_time' => 'required|string'
        ]);

        // Merge with existing session data
        session(['booking_step2' => $validated]);

        // Redirect to document upload
        return redirect()->route('services.document-upload', ['service_type' => $validated['service_type']]);
    }

    public function finalizeBooking(Request $request)
    {
        // Combine all session data
        $step1 = session('booking_step1', []);
        $step2 = $request->only(['selected_date', 'selected_time']);

        // Generate unique ticket number
        $prefix = strtoupper(substr($step1['service_type'], 0, 3));
        $ticketNumber = $prefix . '-' . Str::random(8);

        // Set service prices
        $servicePrices = [
            'baptism' => 1000.00,
            'wedding' => 5000.00,
            'mass_intention' => 500.00,
            'blessing' => 1500.00,
            'confirmation' => 1000.00,
            'sick_call' => 1000.00
        ];

        // Create service booking with all required fields
        $booking = ServiceBooking::create([
            'user_id' => auth()->id(),
            'name' => ucfirst($step1['service_type']) . ' Service',
            'type' => $step1['service_type'],
            'ticket_number' => $ticketNumber,
            'preferred_date' => $step2['selected_date'],
            'preferred_time' => $step2['selected_time'],
            'notes' => $request->notes,
            'status' => 'pending',
            'amount' => $servicePrices[$step1['service_type']]
        ]);

        // Create service-specific details
        switch ($step1['service_type']) {
            case 'mass_intention':
                MassIntentionDetail::create([
                    'service_booking_id' => $booking->id,
                    'mass_type' => $step1['mass_type'],
                    'mass_names' => $step1['mass_names']
                ]);
                break;
            case 'blessing':
                BlessingDetail::create([
                    'service_booking_id' => $booking->id,
                    'blessing_type' => $step1['blessing_type'],
                    'blessing_location' => $step1['blessing_location']
                ]);
                break;
            case 'sick_call':
                SickCallDetail::create([
                    'service_booking_id' => $booking->id,
                    'patient_name' => $step1['patient_name'],
                    'patient_address' => $step1['patient_address'],
                    'patient_condition' => $step1['patient_condition']
                ]);
                break;
        }

        // Clear session data
        session()->forget(['booking_step1']);

        return redirect()->route('services.my-bookings')
            ->with('success', 'Service booking created successfully. Your ticket number is ' . $ticketNumber);
    }

    public function showDocumentUpload(Request $request)
    {
        $serviceType = session('booking_step1.service_type');
        if (!$serviceType) {
            return redirect()->route('services.book')
                ->with('error', 'Please complete the booking details first.');
        }

        return view('services.document-upload', [
            'service_type' => $serviceType
        ]);
    }

    public function uploadDocuments(Request $request)
    {
        // Validate the request
        $request->validate([
            'service_type' => 'required|string',
            'birth_certificate' => 'required_if:service_type,baptism|file|mimes:pdf,jpg,jpeg,png|max:5120',
            'marriage_certificate' => 'required_if:parents_married,yes|file|mimes:pdf,jpg,jpeg,png|max:5120',
            'baptismal_permit' => 'required_if:other_parish,yes|file|mimes:pdf,jpg,jpeg,png|max:5120',
            'baptismal_cert' => 'required_if:service_type,wedding|file|mimes:pdf,jpg,jpeg,png|max:5120',
            'confirmation_cert' => 'required_if:service_type,wedding|file|mimes:pdf,jpg,jpeg,png|max:5120',
            'cenomar' => 'required_if:service_type,wedding|file|mimes:pdf,jpg,jpeg,png|max:5120',
            'marriage_license' => 'required_if:service_type,wedding|file|mimes:pdf,jpg,jpeg,png|max:5120',
            'baptismal_certificate' => 'required_if:service_type,confirmation|file|mimes:pdf,jpg,jpeg,png|max:5120',
            'communion_certificate' => 'required_if:service_type,confirmation|file|mimes:pdf,jpg,jpeg,png|max:5120',
            'attendance_certificate' => 'required_if:service_type,confirmation|file|mimes:pdf,jpg,jpeg,png|max:5120',
            'sponsor_certificate' => 'required_if:service_type,confirmation|file|mimes:pdf,jpg,jpeg,png|max:5120'
        ]);

        $step1 = session('booking_step1', []);
        $step2 = session('booking_step2', []);

        if (empty($step1) || empty($step2)) {
            return redirect()->route('services.book')
                ->with('error', 'Please complete the booking details first.');
        }

        // Generate unique ticket number
        $prefix = strtoupper(substr($step1['service_type'], 0, 3));
        $ticketNumber = $prefix . '-' . Str::random(8);

        // Set service prices
        $servicePrices = [
            'baptism' => 1000.00,
            'wedding' => 5000.00,
            'mass_intention' => 500.00,
            'blessing' => 1500.00,
            'confirmation' => 1000.00,
            'sick_call' => 1000.00
        ];

        // Create service booking
        $serviceBooking = ServiceBooking::create([
            'user_id' => auth()->id(),
            'name' => ucfirst($step1['service_type']) . ' Service',
            'type' => $step1['service_type'],
            'ticket_number' => $ticketNumber,
            'preferred_date' => $step2['selected_date'],
            'preferred_time' => $step2['selected_time'],
            'notes' => $step1['notes'] ?? null,
            'status' => 'pending',
            'amount' => $servicePrices[$step1['service_type']]
        ]);

        // Store service-specific details
        switch ($step1['service_type']) {
            case 'baptism':
                BaptismDetail::create([
                    'service_booking_id' => $serviceBooking->id,
                    'baptism_type' => $step1['baptism_type'],
                    'child_name' => $step1['child_name'],
                    'date_of_birth' => $step1['date_of_birth'],
                    'place_of_birth' => $step1['place_of_birth'],
                    'father_name' => $step1['father_name'],
                    'mother_name' => $step1['mother_name'],
                    'nationality' => $step1['nationality']
                ]);
                break;
            case 'wedding':
                WeddingDetail::create([
                    'service_booking_id' => $serviceBooking->id,
                    'groom_name' => $step1['groom_name'],
                    'groom_age' => $step1['groom_age'],
                    'groom_religion' => $step1['groom_religion'],
                    'bride_name' => $step1['bride_name'],
                    'bride_age' => $step1['bride_age'],
                    'bride_religion' => $step1['bride_religion']
                ]);
                break;
            case 'mass_intention':
                MassIntentionDetail::create([
                    'service_booking_id' => $serviceBooking->id,
                    'mass_type' => $step1['mass_type'],
                    'mass_names' => $step1['mass_names']
                ]);
                break;
            case 'blessing':
                BlessingDetail::create([
                    'service_booking_id' => $serviceBooking->id,
                    'blessing_type' => $step1['blessing_type'],
                    'blessing_location' => $step1['blessing_location']
                ]);
                break;
            case 'confirmation':
                ConfirmationDetail::create([
                    'service_booking_id' => $serviceBooking->id,
                    'confirmand_name' => $step1['confirmand_name'],
                    'confirmand_dob' => $step1['confirmand_dob'],
                    'baptism_place' => $step1['baptism_place'],
                    'baptism_date' => $step1['baptism_date'],
                    'sponsor_name' => $step1['sponsor_name']
                ]);
                break;
            case 'sick_call':
                SickCallDetail::create([
                    'service_booking_id' => $serviceBooking->id,
                    'patient_name' => $step1['patient_name'],
                    'patient_age' => $step1['patient_age'],
                    'patient_condition' => $step1['patient_condition'],
                    'location' => $step1['location'],
                    'room_number' => $step1['room_number'],
                    'contact_person' => $step1['contact_person'],
                    'emergency_contact' => $step1['emergency_contact']
                ]);
                break;
        }

        // Store uploaded documents
        foreach ($request->allFiles() as $key => $file) {
            $path = $file->store('documents/' . $step1['service_type'], 'public');
            ServiceDocument::create([
                'user_id' => auth()->id(),
                'service_type' => $step1['service_type'],
                'service_booking_id' => $serviceBooking->id,
                'document_type' => $key,
                'file_path' => $path,
                'status' => 'pending'
            ]);
        }

        // Send email notification
        auth()->user()->notify(new ServiceBookingNotification($serviceBooking));

        // Clear session data
        session()->forget(['booking_step1', 'booking_step2']);

        return redirect()->route('services.payment', $serviceBooking->id)
            ->with('success', 'Documents uploaded successfully. Please proceed with payment.');
    }

    public function releaseDocument(ServiceBooking $booking)
    {
        // Check if booking is approved/completed
        if (!in_array($booking->status, ['approved', 'completed'])) {
            return back()->with('error', 'Cannot generate certificate for unapproved booking.');
        }

        // Get the specific service details based on type
        $details = null;
        switch ($booking->type) {
            case 'baptism':
                $details = $booking->baptismDetail;
                break;
            case 'wedding':
                $details = $booking->weddingDetail;
                break;
            case 'confirmation':
                $details = $booking->confirmationDetail;
                break;
                // Add other cases as needed
        }

        // Load the appropriate certificate template
        $view = view('certificates.' . $booking->type, [
            'booking' => $booking,
            'details' => $details,
            'date' => Carbon::now()->format('F d, Y'),
            'logo1' => public_path('images/LOGO-1.png'),
            'logo2' => public_path('images/LOGO-2.png')
        ]);

        // Generate PDF
        $pdf = PDF::loadHTML($view->render());
        $pdf->setPaper('a4', 'landscape');

        // Generate filename
        $filename = $booking->type . '_certificate_' . $booking->ticket_number . '.pdf';

        // Set cookie to track download start
        cookie()->queue('document_download_started', '1', 1);

        // Return the PDF for download
        return $pdf->download($filename);
    }

    public function showPaymentReceipt(ServiceBooking $booking)
    {
        // Check if the booking belongs to the authenticated user
        if ($booking->user_id !== auth()->id()) {
            abort(403, 'Unauthorized action.');
        }

        // Check if payment exists
        if ($booking->payment_status !== 'paid') {
            return redirect()->route('services.my-bookings')
                ->with('error', 'No payment receipt available for this booking.');
        }

        return view('services.payment-receipt', compact('booking'));
    }

    public function calendarView()
    {
        $approvedBookings = ServiceBooking::with('user')
            ->get()
            ->map(function ($booking) {
                return [
                    'id' => $booking->id,
                    'type' => $booking->type,
                    'ticket_number' => $booking->ticket_number,
                    'preferred_date' => $booking->preferred_date,
                    'preferred_time' => $booking->preferred_time,
                    'status' => $booking->status,
                    'user' => [
                        'name' => $booking->user->name
                    ]
                ];
            });

        return view('admin.calendar', compact('approvedBookings'));
    }
}
