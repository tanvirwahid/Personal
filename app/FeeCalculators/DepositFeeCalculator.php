<?php

namespace App\FeeCalculators;

use App\Contrancts\FeeCalculatorInterface;
use App\Models\User;

class DepositFeeCalculator implements FeeCalculatorInterface
{
    public function calculateFee(User $user,$amount)
    {
        return 0;
    }

}
