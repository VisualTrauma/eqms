<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class CparReviewed extends Mailable
{
    use Queueable, SerializesModels;

    public $cpar;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($cpar)
    {
        $this->cpar = \App\Cpar::find($cpar);
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('no-reply@newsim.ph')
                    ->markdown('emails.cpars.cpar-reviewed');
    }
}
