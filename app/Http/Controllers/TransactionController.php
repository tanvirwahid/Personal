<?php

namespace App\Http\Controllers;

use App\Enums\TransactionTypes;
use App\Models\Transaction;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TransactionController extends Controller
{
    const DEPOSIT = 'deposit';
    const WIDRAWAL = 'widrawal';


    public function index()
    {
        $query = $this->getQuery();
        $transactions = $query->paginate(10)->withQueryString();
        $currentBalance = Auth::user()->balance;

        return response()->json(
            [
                'transactions' => $transactions,
                'current_balance' => $currentBalance
            ]);
    }

    public function deposits()
    {
        $query = $this->getQuery(self::DEPOSIT);
        $transactions = $query->paginate(10)->withQueryString();

        return response()->json($transactions);
    }

    public function widrawals()
    {
        $query = $this->getQuery(self::WIDRAWAL);
        $transactions = $query->paginate(10)->withQueryString();

        return response()->json($transactions);
    }

    private function getQuery(string $type = null):Builder
    {
        $query = Transaction::query()->where('user_id', Auth::user()->id);

        if($type == self::DEPOSIT)
        {
            $query->where('transaction_type', TransactionTypes::deposit()->value);
        }

        if($type == self::WIDRAWAL)
        {
            $query->where('transaction_type', TransactionTypes::widrawal()->value);
        }

        return $query;
    }
}
