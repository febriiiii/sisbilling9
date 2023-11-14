<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class SendMail extends Mailable
{
    use Queueable, SerializesModels;
    protected $data;
    /**
     * Create a new message instance.
     */
    public function __construct($data)
    {
        $this->data = $data;
    }
    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        if($this->data['type'] == 'otp'){
            return new Envelope(
                subject: 'One Time-Password',
            );
        }else if($this->data['type'] == 'otpLogin'){
            return new Envelope(
                subject: 'One Time-Password',
            );
        }else if($this->data['type'] == 'subscribe'){
            return new Envelope(
                subject: 'Company Subscribe',
            );
        }else if($this->data['type'] == 'mailpayment'){
            return new Envelope(
                subject: 'Notifikasi Pembayaran',
            );
        }else if($this->data['type'] == 'mailaprovepayment'){
            return new Envelope(
                subject: 'Pembayaran Menunggu Persetujuan',
            );
        }else if($this->data['type'] == 'mailarejectpayment'){
            return new Envelope(
                subject: 'Pembayaran Tidak Berhasil',
            );
        }else if($this->data['type'] == 'reminderTagihan'){
            return new Envelope(
                subject: 'Reminder Tagihan SisBilling',
            );
        }
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        if($this->data['type'] == 'otp'){
            return new Content(
                view: 'MailOtp',
                with: $this->data,
            );
        }else if($this->data['type'] == 'otpLogin'){
            return new Content(
                view: 'MailOtp',
                with: $this->data,
            );
        }else if($this->data['type'] == 'subscribe'){
            return new Content(
                view: 'MailSubscribe',
                with: $this->data,
            );
        }else if($this->data['type'] == 'mailpayment'){
            return new Content(
                view: 'receipt',
                with: $this->data,
            );
        }else if($this->data['type'] == 'mailaprovepayment'){
            return new Content(
                view: 'MailPaymentaprove',
                with: $this->data,
            );
        }else if($this->data['type'] == 'mailarejectpayment'){
            return new Content(
                view: 'MailPaymentreject',
                with: $this->data,
            );
        }else if($this->data['type'] == 'reminderTagihan'){
            return new Content(
                view: 'MailTagihan',
                with: $this->data,
            );
        }
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
