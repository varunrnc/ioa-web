<?php

namespace App\Http\Controllers\Admin\Order;

use App\Http\Controllers\Controller;
use App\Models\Address;
use App\Models\Morder;
use App\Models\OrderedItem;
use App\Models\Plant;
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

    public function byId(Request $req)
    {

        $datalist = Morder::where('orderid', $req->id)->first();
        $address = Address::where('id', $datalist->address_id)->first();
        $items = OrderedItem::where('orderid', $req->id)->get();
        $data = collect([]);
        foreach ($items as $item) {
            $plant = Plant::where('pid', $item->pid)->first();
            $item['plant'] = $plant;
            $data->push($item);
            $datalist['items'] = $data;
        }
        $datalist['address'] = $address;

        return  view('admin.morder.details', compact('datalist'));
    }
}
