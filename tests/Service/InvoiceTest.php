<?php

namespace App\Tests\Service;


use App\Service\Invoice;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use App\Service\EmailService;

class InvoiceTest extends KernelTestCase
{
    public function testProcess()
    {
        $emailService = $this->getMockBuilder(EmailService::class)
            ->getMock();
        
        $emailService->expects($this->once())
            ->method('send')
            ->willReturn(true);
        
        $invoice = new Invoice($emailService);
        
        $result = $invoice->process('dorian@exemple.com', 'test');
        
        // Vérifie le résultat attendu
        $this->assertEquals('Mail envoyé', $result);
    }
}