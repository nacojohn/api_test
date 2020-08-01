<?php

namespace App\Http\Controllers;

use App\Donation;
use App\Transaction;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function addTransaction(Request $request)
    {
        $payload = file_get_contents('php://input');
        $data = json_decode($payload, true);
        // file_put_contents(time().'-webhook.php', $payload);

        if ($data['status']) {
            Donation::where('donation_ref', $data['order_id'])->update(['donation_status' => 'success']);
        } else {
            Donation::where('donation_ref', $data['order_id'])->update(['donation_status' => 'failed']);
        }

        $transaction = new Transaction();
        $transaction->trans_id = $data['trans_id'];
        $transaction->amount = $data['amount'];
        $transaction->currency = $data['currency'];
        $transaction->trans_time = $data['time'];
        $transaction->account_id = $data['paymentcccountid'];
        $transaction->approval_code = $data['approval_code'];
        $transaction->pay_type = $data['pay_method'];
        $transaction->order_id = $data['order_id'];
        $transaction->status = $data['status'];
        $transaction->mac_string = $data['mac_string'];
        $transaction->save();
    }

    public function viewTransactions(Request $request)
    {
        $allTransactions = Transaction::all();

        foreach ($allTransactions as $transaction) {
            $transaction->donation;
        }

        return $this->sendResponse($allTransactions->toArray(), 'Transactions retrieved');
    }
}
