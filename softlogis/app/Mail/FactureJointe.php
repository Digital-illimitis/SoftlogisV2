<?php
namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Queue\SerializesModels;

class FactureJointe extends Mailable
{
    use Queueable, SerializesModels;

    public $mailData;
    public $emailSubject;
    public $attachments;
    public $sourcing;

    /**
     * Create a new message instance.
     */
    public function __construct($mailData, $emailSubject, $attachments = [], $sourcing)
    {
        $this->mailData = $mailData;
        $this->emailSubject = $emailSubject;
        $this->attachments = $attachments;
        $this->sourcing = $sourcing;
    }
    
    public function build()
    {
        \Log::info('MailData contenu : ', $this->mailData); // ajoute ça pour être sûr
    
        return $this->view('email.jointe_facture')
                    ->subject($this->emailSubject)
                    ->with(['mailData' => $this->mailData, 'sourcing' => $this->sourcing])
                    ->withAttachments($this->attachments);
    }

}




