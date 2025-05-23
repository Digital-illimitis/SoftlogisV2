<?php
namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Queue\SerializesModels;

class LogisticaMail extends Mailable
{
    use Queueable, SerializesModels;

    public $mailData;
    public $emailSubject;
    public $attachments;

    /**
     * Create a new message instance.
     */
    public function __construct($mailData, $emailSubject, $attachments = [])
    {
        $this->mailData = $mailData;
        $this->emailSubject = $emailSubject;
        $this->attachments = $attachments;
    }
    
    public function build()
{
   
    $email = $this->view('email.demoMail') 
                ->subject($this->emailSubject)
                ->with(['mailData' => $this->mailData]);

    foreach ($this->attachments as $filePath) {
            $email->attach($filePath);
        }

    return $email;
}



    /**
     * Get the message envelope.
     */
   /* public function envelope(): Envelope
    {
        return new Envelope(
            subject: $this->emailSubject,
        );
    }  */

    /**
     * Get the message content definition.
     */
  /*  public function content(): Content
    {
        return new Content(
            view: 'email.demoMail',
            with: [
                'mailData' => $this->mailData,
                'attachments' => $this->attachments // Passer les pièces jointes à la vue
            ]
        );
    } */

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
   /* public function attachments(): array
    {
        $attachments = [];
        foreach ($this->attachments as $attachment) {
            // Utiliser directement le chemin du fichier si $attachment est une chaîne (le chemin du fichier)
            if (is_string($attachment) && file_exists($attachment)) {
                $attachments[] = Attachment::fromPath($attachment)  // Utiliser directement le chemin
                    ->as(pathinfo($attachment, PATHINFO_BASENAME))  // Nom du fichier
                    ->withMime(mime_content_type($attachment));  // Mime type
            }
        }
    
        return $attachments;
    } */
    

    // public function build()
    // {
    //     $email = $this->view('emails.logistica')
    //                 ->with($this->mailData)
    //                 ->subject($this->emailSubject);

    //     // Ajouter les pièces jointes
    //     if (isset($this->attachments)) {
    //         foreach ($this->attachments as $attachment) {
    //             if (file_exists($attachment)) {
    //                 $email->attach($attachment);
    //             }
    //         }
    //     }

    //     return $email;
    // }

}




