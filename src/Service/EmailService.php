<?php

namespace App\Service;

class EmailService
{
    public function send(string $recipientEmail, string $message): bool
    {
        return (bool) rand(0, 1);
    }
}
