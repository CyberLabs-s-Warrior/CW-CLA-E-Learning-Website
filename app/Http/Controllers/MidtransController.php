<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaction;

class MidtransController extends Controller
{
    public function notification(Request $request)
    {
        // Log untuk debugging
        \Log::info('=== MIDTRANS NOTIFICATION MASUK ===');

        // Ambil JSON mentah dari Midtrans
        $notif = json_decode(file_get_contents('php://input'), true);
        \Log::info($notif);

        // Cari transaksi berdasarkan order_id
        $transaction = Transaction::where('order_id', $notif['order_id'] ?? '')->first();

        if ($transaction) {
            // Update status umum
            if ($notif['transaction_status'] === 'settlement') {
                $transaction->update([
                    'status' => 'paid',
                    'transaction_id' => $notif['transaction_id'],
                    'payment_type' => $notif['payment_type'],
                    'gross_amount' => $notif['gross_amount'],
                    'fraud_status' => $notif['fraud_status'],
                    'biller_code' => $notif['biller_code'] ?? null,
                    'bill_key' => $notif['bill_key'] ?? null,
                    'expiry_time' => $notif['expiry_time'] ?? null,
                ]);
            } elseif ($notif['transaction_status'] === 'pending') {
                $transaction->update(['status' => 'pending']);
            } elseif (in_array($notif['transaction_status'], ['deny', 'expire', 'cancel'])) {
                $transaction->update(['status' => 'failed']);
            }
        }

        return response()->json(['message' => 'ok']);
    }
}
