<?php

namespace App\Service;

class EmailService
{
    public function send($email, $message)
    {
        return rand(0, 1) === 1;
    }
}