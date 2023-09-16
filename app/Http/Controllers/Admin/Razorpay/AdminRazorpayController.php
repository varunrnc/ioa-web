<?php

namespace App\Http\Controllers\Admin\Razorpay;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Razorpay\Api\Api;

class AdminRazorpayController extends Controller
{
    public function refund(Request $req)
    {
        $api = new Api(env('MRAZORPAY_KEY'), env('MRAZORPAY_SECRET'));
        // $refund = $api->payment->fetch($req->payment_id);
        $refund = $api->refund->create(array('payment_id' => "pay_McWH4TsHh4HUMV"));
        return dd($refund);
    }
}
