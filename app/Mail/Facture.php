<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class Facture extends Mailable
{
    use Queueable, SerializesModels;

    public $refacturation;
    public $prestations;
    public $prestations_debours;
    public $prestations_totals;
    public $prestations_totals_debours;
    public $user;
    public $total_ht;
    public $tva;
    public $total_xof;

    /**
     * Create a new message instance.
     */
    public function __construct($refacturation,$prestations,$prestations_debours,$prestations_totals,$prestations_totals_debours,$user,$total_ht,$tva,$total_xof)
    {
        //

        $this->refacturation = $refacturation;
        $this->prestations = $prestations;
        $this->prestations_debours = $prestations_debours;
        $this->prestations_totals = $prestations_totals;
        $this->prestations_totals_debours = $prestations_totals_debours;
        $this->user = $user;
        $this->total_ht = $total_ht;
        $this->tva = $tva;
        $this->total_xof = $total_xof;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'SOFTLOGIS REFACTURATION',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'email.sendfacture',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
