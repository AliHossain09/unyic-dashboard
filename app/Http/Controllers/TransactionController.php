<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function index01(Request $request)
    {
        return view('pages/finance/credit-cards');
    }

    public function index02(Request $request)
    {
        return view('pages/finance/transaction-details');
    }
}
