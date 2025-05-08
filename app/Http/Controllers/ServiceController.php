<?php

namespace App\Http\Controllers;

use App\Models\ServiceBooking;
use App\Models\BaptismDetail;
use App\Models\WeddingDetail;
use App\Models\ConfirmationDetail;
use App\Models\MassIntentionDetail;
use App\Models\BlessingDetail;
use App\Models\SickCallDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

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
    
        return redirect()->back()->with('success', 'Service booking is now on hold for payment.');
    }
}
