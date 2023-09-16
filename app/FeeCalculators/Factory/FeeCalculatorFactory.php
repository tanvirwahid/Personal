<?php

namespace App\FeeCalculators\Factory;

use App\Contrancts\FeeCalculatorInterface;
use App\FeeCalculators\DepositFeeCalculator;
use App\FeeCalculators\WidrawalFeeCalculators\AbstractWidrawalFeeCalculator;
use App\FeeCalculators\WidrawalFeeCalculators\BusinessAccountFeeCalculator;
use App\FeeCalculators\WidrawalFeeCalculators\IndividualAccountFeeCalculator;

class FeeCalculatorFactory
{
    const WIDRAWAL_FEE_CALCULATORS = [
        'business' => BusinessAccountFeeCalculator::class,
        'individual' => IndividualAccountFeeCalculator::class
    ];

    public function getFeeCalculator(string $accountType, string $transactionType): FeeCalculatorInterface
    {
        if($transactionType == 'deposit')
        {
            return app()->make(DepositFeeCalculator::class);
        }

        return $this->getWidrawalFeeCalculator($accountType);
    }

    private function getWidrawalFeeCalculator(string $accountType): AbstractWidrawalFeeCalculator
    {
        return app()->make(
            self::WIDRAWAL_FEE_CALCULATORS[$accountType]
        );
    }
}
