<?php

namespace App\FeeCalculators\WidrawalFeeCalculators;

use App\Contrancts\FeeCalculatorInterface;

abstract class AbstractWidrawalFeeCalculator implements FeeCalculatorInterface
{
    abstract public function calculateFee($amount);
}
