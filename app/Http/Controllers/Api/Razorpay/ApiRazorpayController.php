<?php

namespace App\Http\Controllers\Api\Razorpay;

use App\Helpers\ApiRes;
use App\Http\Controllers\Controller;
use App\Models\Address;
use App\Models\Cart;
use App\Models\Morder;
use App\Models\Mpayment;
use App\Models\OrderedItem;
use App\Models\Plant;
use App\Models\Userdetail;
use Illuminate\Http\Request;
use Razorpay\Api\Api;

class ApiRazorpayController extends Controller
{
    public function genOrderId(Request $req)
    {
        $uid = auth()->user()->uid;
        $user = Userdetail::where('uid', $uid)->first();
        $api = new Api(env('MRAZORPAY_KEY'), env('MRAZORPAY_SECRET'));
        $receipt = uniqid();
        $orderData = [
            'receipt'         => $receipt,
            'amount'          => $req->amt * 100,
            'currency'        => 'INR'
        ];

        $orderRes = $api->order->create($orderData);
        $data = [
            'key_id' => env('MRAZORPAY_KEY'),
            'orderid' => $orderRes->id,
            'amount' => $orderRes->amount,
            'name' => $user->name,
            'email' => $user->email,
            'mobile' =>  "+91" . $user->mobile,
        ];
        if ($orderRes) {
            return ApiRes::mapData($data);
        } else {
            return ApiRes::error();
        }
    }
    public function payment(Request $req)
    {
        $orderid = "OGD000";
        $orderid = $orderid . Morder::max('id') + 1;
        $totalAmt = null;
        $discountAmt = null;
        $shippingAmt = null;
        $api = new Api(env('MRAZORPAY_KEY'), env('MRAZORPAY_SECRET'));
        $pay = $api->payment->fetch($req->payment_id);

        if ($pay->status == "captured" && $pay->captured == true) {
            $payment = new Mpayment();
            $payment->uid = auth()->user()->id;
            $payment->payment_id = $pay->id;
            $payment->order_id = $pay->order_id;
            $payment->email = $pay->email;
            $payment->contact = $pay->contact;
            $payment->amount = ($pay->amount / 100);
            $payment->method = $pay->method;
            $payment->currency = $pay->currency;
            $payment->status = $pay->status;
            $status = $payment->save();
        }
        if ($status) {
            $items = Cart::where('uid', auth()->user()->id)->get();
            foreach ($items as $item) {
                $obj = new OrderedItem();
                $obj->uid = auth()->user()->id;
                $obj->orderid = $orderid;
                $obj->pid = $item->pid;
                $obj->qty = $item->qty;
                $obj->shipping_charges = $item->shipping_charges;
                $status = $obj->save();
            }
        }
        if ($status) {
            $items = Cart::where('uid', auth()->user()->id)->get();
            $addressId = Address::where('uid', auth()->user()->uid)->where('active', '1')->first()->id;
            foreach ($items as $item) {
                $selling_price =  Plant::where('pid', $item->pid)->first()->selling_price;
                $regular_price =  Plant::where('pid', $item->pid)->first()->regular_price;
                $discount =  Plant::where('pid', $item->pid)->first()->discount;
                $totalAmt += $selling_price * $item->qty;
                $discountAmt += (($regular_price - $selling_price) * $item->qty);
                $shippingAmt += $item->shipping_charges;
            }
            $obj = new Morder();
            $obj->uid = auth()->user()->id;
            $obj->orderid = $orderid;
            $obj->address_id = $addressId;
            $obj->payment_id = $req->payment_id;
            $obj->discount = $discountAmt;
            $obj->shipping_charges = $shippingAmt;
            $obj->total_amt = ($pay->amount / 100);
            $obj->status = "Confirmed";
            $status = $obj->save();
        }
        $status = Cart::where('uid', auth()->user()->id)->delete();
        if ($status) {
            return ApiRes::success('Payment Successfully !');
        } else {
            return ApiRes::error();
        }
    }
}
