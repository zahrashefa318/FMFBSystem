<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Mailables\Attachment;
use Barryvdh\DomPDF\Facade\Pdf;

class LoanScheduleMailable extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    
    public $loan;
    public $schedule;
    public $monthlyPayment;

    public function __construct($loan, array $schedule, float $monthlyPayment)
    {
        
        $this->loan           = $loan;
        $this->schedule       = $schedule;
        $this->monthlyPayment = $monthlyPayment;
    }

    /**
     * Get the message envelope.
     *
     * @return \Illuminate\Mail\Mailables\Envelope
     */
    public function envelope()
    {
        return new Envelope(
             subject: 'Your Loan Repayment Schedule'
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
            markdown: 'emails.schedule',
            with: [
                'loan'           => $this->loan,
                'schedule'       => $this->schedule,
                'monthlyPayment' => $this->monthlyPayment,
            ],
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array
     */
    public function attachments()
    {   
        $pdf = Pdf::loadView('pdf.schedule', [
        'loan'           => $this->loan,
        'schedule'       => $this->schedule,
        'monthlyPayment' => $this->monthlyPayment,
         ]);
        return [
            Attachment::fromData(fn () => $pdf->output(), 'Loan-Schedule.pdf')
            ->withMime('application/pdf'),
        ];// add Attachment::fromPath(...) here if needed
    }
}
?>