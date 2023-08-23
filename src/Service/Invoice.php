<?php

namespace App\Service;

use App\Service\EmailService;

class Invoice
{
    private $emailService;

    public function __construct(EmailService $emailService)
    {
        $this->emailService = $emailService;
    }

    public function process($email, $message)
    {
        $emailSent = $this->emailService->send($email, $message);
        
        if ($emailSent) {
            return 'Mail envoyé';
        } else {
            return 'Mail pas envoyé';
        }
    }
}

