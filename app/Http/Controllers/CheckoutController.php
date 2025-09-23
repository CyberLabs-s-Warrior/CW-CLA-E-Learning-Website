<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Transaction;
use Illuminate\Support\Str;

class CheckoutController extends Controller
{
    // bikin transaksi baru
    public function start(Course $course)
    {
        // kalau user sudah pernah beli course ini
        if (
            Transaction::where('user_id', auth()->id())
                ->where('course_id', $course->id)
                ->where('status', 'paid')
                ->exists()
        ) {
            return redirect()->route( route('detail.index', $course->slug) )
                ->with('info', 'Kamu sudah membeli course ini.');
        }

        // bikin transaksi pending
        $transaction = Transaction::create([
            'user_id' => auth()->id(),
            'course_id' => $course->id,
            'order_id' => 'ORDER-' . Str::uuid(),
            'gross_amount' => $course->price,
            'status' => 'pending',
        ]);

        // redirect ke halaman checkout
        return redirect()->route('student.checkout.show', $transaction->id);
    }

    // tampilkan halaman checkout
    public function show(Transaction $transaction)
    {
        if ($transaction->user_id !== auth()->id()) {
            abort(403);
        }

        $course = $transaction->course;

        return view('student.checkout.show', compact('course', 'transaction'));
    }

    public function showForm(Course $course)
    {
        return view('student.checkout.show', compact('course'));
    }

}
