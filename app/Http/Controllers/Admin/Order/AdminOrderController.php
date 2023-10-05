<?php

namespace App\Http\Controllers\Admin\Order;

use App\Http\Controllers\Controller;
use App\Models\Morder;
use Illuminate\Http\Request;

class AdminOrderController extends Controller
{
    public function index(Request $req)
    {
        if ($req->q == null && $req->date == null) {
            $datalist = Morder::latest()->paginate(5);
            return view('admin.morder.index', compact('datalist'));
        } elseif ($req->q != null) {
            $datalist = Morder::orwhere('orderid', 'LIKE', '%' . $req->q . '%')->orwhere('payment_id', 'LIKE', '%' . $req->q . '%')->paginate(5);
            return view('admin.morder.index', compact('datalist'));
        } elseif ($req->date != null) {
            $datalist = Morder::whereDate('created_at', '=', date($req->date))->paginate(5);
            return view('admin.morder.index', compact('datalist'));
        }
    }
}
