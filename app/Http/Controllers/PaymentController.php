<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Midtrans\Config;
use Midtrans\Snap;
use App\Models\Payment;
use App\Models\Transaction;
use Illuminate\Support\Facades\Auth;

class PaymentController extends Controller
{
    public function __construct()
    {
        // Set Midtrans configuration
        Config::$serverKey = config('midtrans.server_key');
        Config::$isProduction = config('midtrans.is_production');
        Config::$isSanitized = config('midtrans.is_sanitized');
        Config::$is3ds = config('midtrans.is_3ds');
    }

    public function createTransaction(Request $request)
    {
        $params = [
            'transaction_details' => [
                'order_id' => $request->id,
                'gross_amount' => $request->gross_amount, // Total transaksi
            ],
            'customer_details' => [
                'first_name' => Auth::user()->username,
                'last_name' => '-',
                'email' => Auth::user()->email,
                'phone' => "-",
            ],
        ];

        try {
            $snapToken = Snap::getSnapToken($params);

            // Simpan informasi pembayaran ke dalam tabel payments
            Payment::create([
                'order_id' => $request->id,
                'gross_amount' => $request->gross_amount,
                'customer_name' => Auth::user()->username,
                'customer_email' => Auth::user()->email,
            ]);

            return response()->json(['snap_token' => $snapToken]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function notificationHandler(Request $request)
    {
        $notification = $request->input();

        $order_id = $notification['order_id'];
        $transaction_id = $notification['transaction_id'];
        $transaction_status = $notification['transaction_status'];
        $fraud_status = $notification['fraud_status'];

        $payment = Payment::where('order_id', $order_id)->first();

        Transaction::where('id', $order_id)->update([
            'status' => 2
        ]);

        if ($payment) {
            $payment->update([
                'transaction_id' => $transaction_id,
                'transaction_status' => $transaction_status,
                'fraud_status' => $fraud_status,
            ]);
        }
        
        return response()->json(['message' => 'Notification received successfully']);
    }
}
