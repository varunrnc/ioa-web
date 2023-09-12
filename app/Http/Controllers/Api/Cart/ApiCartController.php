<?php

namespace App\Http\Controllers\Api\Cart;

use App\Helpers\ApiRes;
use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\ShippingCharges;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ApiCartController extends Controller
{

    public function count(): JsonResponse
    {

        $obj = Cart::count();
        return ApiRes::count($obj);
        //        testing
    }

    public function data()
    {
        $obj = Cart::Where('uid', auth()->user()->id)->with('plant')->with('img')->get();

        return ApiRes::data($obj);
    }


    public function add(Request $req): JsonResponse
    {
        $obj = Cart::Where('uid', auth()->user()->id)->Where('pid', $req->pid)->first();
        if ($obj == null) {
            $obj = new Cart();
            $obj->uid = auth()->user()->id;
            $obj->pid = $req->pid;
            $status = $obj->save();
            if ($status) {
                return ApiRes::success("Item added into cart.");
            } else {
                return ApiRes::error();
            }
        } else {
            $obj->qty = $obj->qty += 1;
            $status = $obj->update();
            if ($status) {
                return ApiRes::success("Item qty updated.");
            } else {
                return ApiRes::error();
            }
        }
    }
    public function qtyUpdate(Request $req): JsonResponse
    {
        $obj = Cart::Where('uid', auth()->user()->id)->Where('pid', $req->pid)->first();
        $obj->qty = $req->qty;
        $status = $obj->update();
        if ($status) {
            return ApiRes::success("Item qty updated.");
        } else {
            return ApiRes::error();
        }
    }

    public function remove(Request $req): JsonResponse
    {
        $obj = Cart::Where('uid', auth()->user()->id)->Where('pid', $req->pid)->first();
        if ($obj->qty == 1) {
            $status = $obj->delete();
            if ($status) {
                return ApiRes::success("Item qty updated.");
            } else {
                return ApiRes::error();
            }
        } else {
            $obj->qty = $obj->qty -= 1;
            $status = $obj->update();
            if ($status) {
                return ApiRes::success("Item qty updated.");
            } else {
                return ApiRes::error();
            }
        }
    }

    public function delete(Request $req): JsonResponse
    {
        $obj = Cart::Where('uid', auth()->user()->id)->Where('pid', $req->pid)->first();
        $status = $obj->delete();
        if ($status) {
            return ApiRes::success("Item removed from cart.");
        } else {
            return ApiRes::error();
        }
    }
}
