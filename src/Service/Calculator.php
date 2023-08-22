<?php

namespace App\Service;

class Calculator
{
    public function getTotalHT($products)
    {
        $totalHT = 0;
        
        foreach ($products as $product) {
            $totalHT += $product['product']->getPrice() * $product['quantity'];
        }
        
        return $totalHT;
    }

    public function getTotalTTC($products, $tva)
    {
        $totalTTC = 0;

        foreach ($products as $product) {
            $totalTTC += ($product['product']->getPrice() * $product['quantity']) * (1 + ($tva / 100));
        }

        return $totalTTC;
    }
}
