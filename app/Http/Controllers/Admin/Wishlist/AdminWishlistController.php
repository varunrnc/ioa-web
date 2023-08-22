<?php

namespace App\Http\Controllers\Admin\Wishlist;

use App\Helpers\ApiRes;
use App\Http\Controllers\Controller;
use App\Models\Wishlist;
use Illuminate\Http\Request;

class AdminWishlistController extends Controller
{
    public function index()
    {
    }
    public function save(Request $req)
    {
        $obj = new Wishlist();
        $obj->uid = auth()->user()->id;
        $obj->pid = $req->id;
        $status = $obj->save();
        if ($status) {
            return ApiRes::success('Plant added to wishlist.');
        } else {
            return ApiRes::error();
        }
    }
    public function delete(Request $req)
    {
        $obj = Wishlist::Where('pid', $req->id)->first();
        $status = $obj->delete();
        if ($status) {
            return ApiRes::success('Plant removed from wishlist.');
        } else {
            return ApiRes::error();
        }
    }
}
