<?php

namespace App\Http\Controllers;

use App\Transaction;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function addTransaction(Request $request)
    {
        $transaction = new Transaction();
        $transaction->trans_id = $request->trans_id;
        $transaction->amount = $request->amount;
        $transaction->currency = $request->currency;
        $transaction->trans_time = $request->trans_time;
        $transaction->account_id = $request->account_id;
        $transaction->approval_code = $request->approval_code;
        $transaction->pay_type = $request->pay_type;
        $transaction->order_id = $request->order_id;
        $transaction->status = $request->status;
        $transaction->mac_string = $request->mac_string;
        $transaction->save();
    }

    public function viewTransactions(Request $request)
    {
        $allTransactions = Transaction::all();

        return $this->sendResponse($allTransactions->toArray(), 'Transactions retrieved');
    }
}
