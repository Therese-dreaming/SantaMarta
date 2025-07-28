<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\ServiceBooking;
use Carbon\Carbon;

class BookingCancelledConflictNotification extends Notification
{
    use Queueable;

    protected $cancelledBooking;
    protected $approvedBookingTicket;

    public function __construct(ServiceBooking $cancelledBooking, string $approvedBookingTicket)
    {
        $this->cancelledBooking = $cancelledBooking;
        $this->approvedBookingTicket = $approvedBookingTicket;
    }

    public function via($notifiable)
    {
        \Log::info('BookingCancelledConflictNotification::via called for user: ' . $notifiable->email . ' for booking #' . $this->cancelledBooking->ticket_number);
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        \Log::info('BookingCancelledConflictNotification::toMail called for user: ' . $notifiable->email);
        
        $serviceTypeName = $this->getServiceTypeName($this->cancelledBooking->type);
        $originalDateTime = Carbon::parse($this->cancelledBooking->preferred_date)->format('F d, Y') . ' at ' . 
                           Carbon::parse($this->cancelledBooking->preferred_time)->format('g:i A');

        $mailMessage = (new MailMessage)
            ->subject('Booking Cancellation Notice - ' . $this->cancelledBooking->ticket_number)
            ->greeting('Hello ' . $notifiable->name . ',')
            ->line('We regret to inform you that your service booking has been cancelled due to a scheduling conflict.')
            ->line('')
            ->line('**Cancelled Booking Details:**')
            ->line('- Service Type: ' . $serviceTypeName)
            ->line('- Ticket Number: ' . $this->cancelledBooking->ticket_number)
            ->line('- Original Date & Time: ' . $originalDateTime)
            ->line('- Amount: ₱' . number_format($this->cancelledBooking->amount, 2))
            ->line('')
            ->line('**Reason for Cancellation:**')
            ->line('Another booking for the same service type has been approved for your requested time slot (Booking #' . $this->approvedBookingTicket . ').')
            ->line('')
            ->line('**What happens next:**')
            ->line('• Your original booking has been cancelled automatically')
            ->line('• No payment is required as the booking was not confirmed')
            ->line('• You can book a new appointment for any available time slot')
            ->line('')
            ->line('**To book a new appointment:**')
            ->action('Book New Appointment', route('userServices'))
            ->line('')
            ->line('We sincerely apologize for any inconvenience caused by this scheduling conflict.')
            ->line('Our staff will be happy to assist you in finding a suitable alternative time.')
            ->line('')
            ->line('For any questions or to speak with our staff, please contact us directly.')
            ->line('')
            ->line('Thank you for your understanding.')
            ->salutation('Best regards, Santa Marta Parish Church');

        \Log::info('BookingCancelledConflictNotification::toMail completed for user: ' . $notifiable->email);
        return $mailMessage;
    }

    /**
     * Get a human-readable service type name
     */
    private function getServiceTypeName($type)
    {
        $serviceNames = [
            'baptism' => 'Baptism',
            'wedding' => 'Wedding',
            'mass_intention' => 'Mass Intention',
            'blessing' => 'House/Car Blessing',
            'confirmation' => 'Confirmation',
            'sick_call' => 'Sick Call'
        ];

        return $serviceNames[$type] ?? ucfirst(str_replace('_', ' ', $type));
    }
}
