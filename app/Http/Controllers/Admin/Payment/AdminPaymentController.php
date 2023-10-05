<?php

namespace App\Http\Controllers\Admin\Payment;

use App\Http\Controllers\Controller;
use App\Models\Mpayment;
use Illuminate\Http\Request;

class AdminPaymentController extends Controller
{
    public function index(Request $req)
    {
        return  Mpayment::where('payment_id', $req->id)->first();
        return view('admin.payment.index', compact('datalist'));
    }
}
