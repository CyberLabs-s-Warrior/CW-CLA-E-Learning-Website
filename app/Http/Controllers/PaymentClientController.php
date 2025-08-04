<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PaymentClientController extends Controller
{
    public function index()
    {
        return view('clients.payment.index');
    }
}
