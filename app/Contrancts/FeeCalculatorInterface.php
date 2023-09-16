<?php

namespace App\Contrancts;

use App\Models\User;

interface FeeCalculatorInterface
{
    public function calculateFee(User $user, $amount);
}
