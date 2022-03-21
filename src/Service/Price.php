<?php

namespace App\Service;

class Price
{

    public static function priceTTC(float $price, float $tva): string
    {
        $price = $price / 100;

        return number_format($price * $tva, 2);
    }
}