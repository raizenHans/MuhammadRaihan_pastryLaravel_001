<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaction;
use Illuminate\Support\Facades\Log;

class MidtransController extends Controller
{
    public function webhook(Request $request)
    {
        $serverKey = config('midtrans.server_key');
        $hashed = hash("sha512", $request->order_id . $request->status_code . $request->gross_amount . $serverKey);
        
        if ($hashed == $request->signature_key) {
            // Transaction Code prefix logic
            $orderIdParts = explode('-', $request->order_id);
            $transactionCode = $orderIdParts[0];

            $transaction = Transaction::where('transaction_code', $transactionCode)->first();
            if (!$transaction) {
                return response()->json(['message' => 'Transaction not found'], 404);
            }

            if ($request->transaction_status == 'capture' || $request->transaction_status == 'settlement') {
                $transaction->update([
                    'payment_status' => 'lunas',
                    'order_status' => 'diproses',
                    'paid_amount' => $transaction->final_total,
                ]);
            } elseif ($request->transaction_status == 'expire' || $request->transaction_status == 'cancel' || $request->transaction_status == 'deny') {
                $transaction->update([
                    'payment_status' => 'gagal',
                ]);
            }
            
            return response()->json(['message' => 'Success']);
        }

        return response()->json(['message' => 'Invalid signature'], 403);
    }
}
