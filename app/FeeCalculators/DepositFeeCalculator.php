<?php

namespace App\FeeCalculators;

use App\Contrancts\FeeCalculatorInterface;

class DepositFeeCalculator implements FeeCalculatorInterface
{
    public function calculateFee($amount)
    {
        return 0;
    }

}
