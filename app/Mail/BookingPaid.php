<?php

namespace App\Mail;

use App\Models\Booking;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Barryvdh\DomPDF\Facade\Pdf;

class BookingPaid extends Mailable
{
    use Queueable, SerializesModels;

    public $booking;

    public function __construct(Booking $booking)
    {
        $this->booking = $booking;
    }

    public function build()
    {
        $pdf = Pdf::loadView('tickets.eticket', ['booking' => $this->booking]);

        return $this->subject('E-Ticket Pendakian Anda - ' . $this->booking->booking_code)
                    ->view('emails.booking_paid') // View untuk isi email
                    ->attachData($pdf->output(), 'e-ticket.pdf', [
                        'mime' => 'application/pdf',
                    ]);
    }
}