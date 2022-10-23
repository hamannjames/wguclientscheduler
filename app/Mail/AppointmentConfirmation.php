<?php

namespace App\Mail;

use App\Models\Appointment;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Services\Helpers\TimeHelper;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Contracts\Queue\ShouldQueue;

class AppointmentConfirmation extends Mailable
{
    use Queueable, SerializesModels;

    protected $appointment;
    protected $timeHelper;
    protected $customerName;
    protected $repEmail;
    protected $repName;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Appointment $appointment, $customerName, $repName, $repEmail)
    {
        $this->appointment = $appointment;
        $this->timeHelper = TimeHelper::get();
        $this->customerName = $customerName;
        $this->repEmail = $repEmail;
        $this->repName = $repName;
    }

    /**
     * Get the message envelope.
     *
     * @return \Illuminate\Mail\Mailables\Envelope
     */
    public function envelope()
    {
        return new Envelope(
            subject: 'Appointment Confirmation',
            from: new Address('marinelogistics@mg.jameshamann.net', 'Marine Logistics'),
        );
    }

    /**
     * Get the message content definition.
     *
     * @return \Illuminate\Mail\Mailables\Content
     */
    public function content()
    {
        return new Content(
            markdown: 'emails.appointment.confirmation',
            with: [
                'appointment' => $this->appointment,
                'timeHelper' => $this->timeHelper,
                'customerName' => $this->customerName,
                'repName' => $this->repName,
                'repEmail' => $this->repEmail
            ]
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array
     */
    public function attachments()
    {
        return [];
    }
}
