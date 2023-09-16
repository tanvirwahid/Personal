<?php

namespace App\FeeCalculators\WidrawalFeeCalculators;

use App\Models\User;

class IndividualAccountFeeCalculator extends AbstractWidrawalFeeCalculator
{
    public function calculateFee(User $user, $amount)
    {
        return $this->getFee($user, $amount);
    }

    public function totalFee(User $user, $amount)
    {
        return ($amount * 0.015)/100;
    }


}
