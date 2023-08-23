<?php

namespace App\Service;

class Invoice
{
    private $emailService;

    public function __construct(EmailService $emailService)
    {
        $this->emailService = $emailService;
    }

    public function process(float $amount, string $recipientEmail): bool
    {
        $message = "Votre commande d'un montant de {$amount}€ est confirmée.";

        return $this->emailService->send($recipientEmail, $message);
    }
}
