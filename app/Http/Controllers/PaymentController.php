<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Midtrans\Config;
use Midtrans\Snap;
use App\Models\Course;
use App\Models\User;
use App\Models\Transaction;

class PaymentController extends Controller
{
    public function checkout(Request $request)
    {
        $course = Course::findOrFail($request->course_id);

        // Setup Midtrans
        Config::$serverKey = config('midtrans.serverKey');
        Config::$isProduction = config('midtrans.isProduction');
        Config::$isSanitized = config('midtrans.isSanitized');
        Config::$is3ds = config('midtrans.is3ds');

        $params = [
            'transaction_details' => [
                'order_id' => 'ORDER-' . rand(),
                'gross_amount' => $course->price ?? 0,
            ],
            'item_details' => [
                [
                    'id' => $course->id,
                    'price' => $course->price ?? 0,
                    'quantity' => 1,
                    'name' => $course->name,
                ]
            ],
        ];

        try {
            $snapToken = Snap::getSnapToken($params);
            return response()->json(['snap_token' => $snapToken]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()]);
        }
    }

    public function process(Transaction $transaction)
    {
        \Midtrans\Config::$serverKey = config('midtrans.serverKey');
        \Midtrans\Config::$isProduction = config('midtrans.isProduction');
        \Midtrans\Config::$isSanitized = config('midtrans.isSanitized');
        \Midtrans\Config::$is3ds = config('midtrans.is3ds');

        $params = [
            'transaction_details' => [
                'order_id' => $transaction->order_id,
                'gross_amount' => (int) $transaction->course->price,
            ],
            'item_details' => [
                [
                    'id' => $transaction->course->id,
                    'price' => (int) $transaction->course->price,
                    'quantity' => 1,
                    'name' => $transaction->course->title ?? 'Course',
                ]
            ],
        ];


        $snapToken = \Midtrans\Snap::getSnapToken($params);

        return view('student.checkout.payment', compact('snapToken', 'transaction'));
    }


}

