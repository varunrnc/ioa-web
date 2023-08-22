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
        $obj = Wishlist::Where('uid', auth()->user()->id)->get();
        return ApiRes::data('Datalist', $obj);
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
                return ApiRes::success('Plant added to wishlist.');
            } else {
                return ApiRes::error();
            }
        } else {

            $status = $obj->delete();
            if ($status) {
                return ApiRes::success('Plant removed from wishlist.');
            } else {
                return ApiRes::error();
            }
        }
    }
}
