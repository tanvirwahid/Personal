<?php

namespace App\FeeCalculators\WidrawalFeeCalculators;

use App\Contrancts\FeeCalculatorInterface;
use App\Enums\TransactionTypes;
use App\Models\User;
use Carbon\Carbon;

abstract class AbstractWidrawalFeeCalculator implements FeeCalculatorInterface
{
    public function getFee(User $user, $amount)
    {
        if($this->isFriday())
        {
            return 0;
        }
        $currentDate = Carbon::now();
        $firstDayOfMonth = $currentDate->startOfMonth();
        $lastDayOfMonth = $currentDate->endOfMonth();

        $transactionThisMonth = $user->transactions()
            ->where('transaction_type', TransactionTypes::widrawal())
            ->whereBetween('created_at', [$firstDayOfMonth, $lastDayOfMonth])
            ->sum('amount');

        $freeTransaction = $this->getFreeTransaction($transactionThisMonth);

        if($amount <= $freeTransaction)
        {
            return 0;
        }

        $amount-= $freeTransaction;

        return $this->totalFee($user, $amount);

    }

    private function getFreeTransaction($transactionThisMonth)
    {
        if($transactionThisMonth < 4000)
        {
            return 5000 - $transactionThisMonth;
        }

        return 1000;
    }

    private function isFriday()
    {
        return Carbon::now()->dayOfWeek == Carbon::FRIDAY;
    }

    abstract public function calculateFee(User $user, $amount);
    abstract public function totalFee(User $user, $amount);
}
