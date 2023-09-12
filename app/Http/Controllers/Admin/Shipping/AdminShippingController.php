<?php

namespace App\Http\Controllers\Admin\Shipping;

use App\Helpers\ApiRes;
use App\Http\Controllers\Controller;
use App\Models\ShippingCharges;
use Illuminate\Http\Request;

class AdminShippingController extends Controller
{
    public function index()
    {
        $data = ShippingCharges::latest()->get();
        return view('admin.shipping.index', compact('data'));
    }
    public function create()
    {
        return view('admin.shipping.create');
    }
    public function save(Request $req)
    {
        $req->validate([
            'product' => 'required|string|max:225',
            'shipping_charges' => 'required|numeric',
        ]);
        $obj = new ShippingCharges();
        $obj->product = $req->product;
        $obj->amount = $req->shipping_charges;
        $obj->status = $req->status;
        $status = $obj->save();
        if ($status) {
            return redirect()->back()->with('success', 'Data saved successfully !');
        } else {
            return redirect()->back()->with('error', 'Error, try again later.');
        }
    }
    public function edit(Request $req)
    {
        $data = ShippingCharges::Where('id', $req->id)->first();
        return view('admin.shipping.edit', compact('data'));
    }
    public function update(Request $req)
    {
        $req->validate([
            'product' => 'required|string|max:225',
            'shipping_charges' => 'required|numeric',
        ]);
        $obj = ShippingCharges::Where('id', $req->id)->first();
        $obj->product = $req->product;
        $obj->amount = $req->shipping_charges;
        $obj->status = $req->status;
        $status = $obj->update();
        if ($status) {
            return redirect()->back()->with('success', 'Data updated successfully !');
        } else {
            return redirect()->back()->with('error', 'Error, try again later.');
        }
    }
    public function status(Request $req)
    {
        $obj = ShippingCharges::Where('id', $req->id)->first();
        if ($obj->status == '1') {
            $obj->status = "0";
            $status = $obj->update();
            if ($status) {

                return  ApiRes::success('Status Changed Successfully ! ');
            } else {
                return  ApiRes::error();
            }
        } else {
            $obj->status = "1";
            $status = $obj->update();
            if ($status) {

                return  ApiRes::success('Status Changed Successfully ! ');
            } else {
                return  ApiRes::error();
            }
        }
    }
    public function delete(Request $req)
    {
        $status = ShippingCharges::where('id', $req->id)->delete();
        if ($status) {

            return  ApiRes::success('Data Deleted Successfully ! ');
        } else {
            return  ApiRes::error();
        }
    }
}
