<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Midtrans\Config;
use Midtrans\Snap;
use App\Models\Course;
use App\Models\User;

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

}

