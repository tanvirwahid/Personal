<?php

namespace App\Http\Controllers;

use App\Enums\TransactionTypes;
use App\FeeCalculators\Factory\FeeCalculatorFactory;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class TransactionController extends Controller
{
    const DEPOSIT = 'deposit';
    const WIDRAWAL = 'widrawal';

    private FeeCalculatorFactory $feeCalculatorFactory;

    /**
     * @param FeeCalculatorFactory $feeCalculatorFactory
     */
    public function __construct(FeeCalculatorFactory $feeCalculatorFactory)
    {
        $this->feeCalculatorFactory = $feeCalculatorFactory;
    }


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

    public function addDeposit(Request $request)
    {
        try {

            $request->validate([
                'user_id' => 'required|exists:users,id',
                'amount' => 'required|numeric'
            ]);

            $user = User::find($request->get('user_id'));

            $transaction = Transaction::create([
                'amount' => $request->get('amount'),
                'user_id' => $user->id,
                'fee' => $this->feeCalculatorFactory
                    ->getFeeCalculator($this->getAccountType($user), self::DEPOSIT)
                    ->calculateFee($request->get('amount')),
                'transaction_type' => TransactionTypes::deposit()->value
            ]);

            $user->balance = $user->balance + $request->get('amount');
            $user->save();

            return response()->json($transaction);
        } catch (\Exception $exception)
        {
            Log::error($exception);
            return response()->json('Internal Server Error', 500);
        }
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

    private function getAccountType(User $user)
    {
        if($user->account)
        {
            return 'individual';
        }

        return 'business';
    }
}
