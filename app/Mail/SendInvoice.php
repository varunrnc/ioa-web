<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SendInvoice extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public $data = '';
    public $pdf = '';
    public $pdf_name = '';

    public function __construct($data)
    {
        $this->data = $data['order'];
        $this->pdf = $data['pdf'];
        $this->pdf_name = $data['pdf_name'];
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('admin.emails.send_invoice',['data'=>$this->data])->attachData($this->pdf, $this->pdf_name, ['mime' => 'application/pdf'])->subject('IOA Order Invoice');
    }
}
