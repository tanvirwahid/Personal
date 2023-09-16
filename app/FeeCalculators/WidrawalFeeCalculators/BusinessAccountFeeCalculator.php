<?php

namespace App\FeeCalculators\WidrawalFeeCalculators;

use App\Enums\TransactionTypes;
use App\Models\User;

class BusinessAccountFeeCalculator extends AbstractWidrawalFeeCalculator
{
    public function calculateFee(User $user,$amount)
    {
        return $this->getFee($user, $amount);
    }

    public function totalFee(User $user, $amount)
    {
        $totalAmount = $user->transactions()
            ->where('transaction_type', TransactionTypes::widrawal())->sum('amount');

        if($totalAmount > 50000)
        {
            return ($amount * 0.015)/100;
        }

        if($totalAmount + $amount <= 50000)
        {
            return ($amount * 0.025)/100;
        }

        $newFee = (($totalAmount + $amount - 50000) * 0.015)/100;
        $oldFee = ((50000 - $totalAmount) * 0.025)/100;

        return $oldFee + $newFee;
    }


}
