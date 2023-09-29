<?php

namespace App\Http\Controllers\Api\Wishlist;

use App\Helpers\ApiRes;
use App\Http\Controllers\Controller;
use App\Models\Wishlist;
use Illuminate\Http\Request;

class ApiWishlistController extends Controller
{
    public function data()
    {
        $obj = Wishlist::select('pid')->Where('uid', auth()->user()->id)->with('plant')->with('img')->with('wishlist')->get();
        return ApiRes::data($obj);
    }
    public function crud(Request $req)
    {
        $obj = Wishlist::Where('pid', $req->id)->first();
        if ($obj == null) {
            $obj = new Wishlist();
            $obj->uid = auth()->user()->id;
            $obj->pid = $req->id;
            $status = $obj->save();
            if ($status) {
                return ApiRes::success('Product added to wishlist.');
            } else {
                return ApiRes::error();
            }
        } else {

            $status = $obj->delete();
            if ($status) {
                return ApiRes::success('Product removed from wishlist.');
            } else {
                return ApiRes::error();
            }
        }
    }
}
