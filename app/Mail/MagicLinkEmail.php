<?php 
namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contacts\Queue\ShouldQueues;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class MagicLinkEmail extends Mailable {
    use Queueable, SerializesModels;

    public $magicLink;

    /**
     * Create a new message instance.
     * 
     */
    public function __construct(string $magicLink) {
        $this->magicLink = $magicLink;
    }

    /**
     * Build the message
     */

     public function build() {
        return $this->markdown('emails.magic-link')
            ->subject('Your Magic Link')
            ->with([
                'magicLink' => $this->magicLink
            ]);
     }
}