<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use Sichikawa\LaravelSendgridDriver\SendGrid;

class PaymentNotification extends Mailable
{
    use Queueable, SerializesModels, SendGrid;


    public function __construct()
    {
    }

    public function build()
    {
        $from = config('mail.kane_mail');

        if (config('app.env') != 'production') {
            $from = config('mail.test_mail');
        }

        return $this
            ->view('emails.payment')
            ->subject('subject')
            ->from($from)
            ->sendgrid([
                'personalizations' => [
                    [
                        'dynamic_template_data' => [
                            'name'  => 'Karl',
                            'date' => 'Dec 15, 2022',
                            'amount' => '3,500',
                        ],
                    ],
                ],
                'template_id' => 'd-76d048b736f7457db80bbe514d4ff324'
            ]);
    }
}