<?php

namespace App\Http\Controllers\Api\Address;

use App\Helpers\ApiRes;
use App\Http\Controllers\Controller;
use App\Models\Address;
use Illuminate\Http\Request;

class ApiAddressController extends Controller
{
    public function data()
    {
        $data = Address::where('uid', auth()->user()->uid)->get();
        return ApiRes::data($data);
    }
    public function getActive(Request $req)
    {
        $data = Address::where('uid', auth()->user()->uid)->where('active', '1')->get();
        return ApiRes::data($data);
    }
    public function save(Request $req)
    {
        $obj = new Address();
        $obj->uid = auth()->user()->uid;
        $obj->name = $req->name;
        $obj->mobile = $req->mobile;
        $obj->state = $req->state;
        $obj->city = $req->city;
        $obj->pincode = $req->pincode;
        $obj->address_line_1 = $req->address_line_1;
        $obj->address_line_2 = $req->address_line_2;
        $obj->address_notes = $req->address_notes;
        $status = $obj->save();
        if ($status) {
            return ApiRes::success("Data saved successfully !");
        } else {
            return ApiRes::error();
        }
    }
    public function setActive(Request $req)
    {
        $obj = Address::where('uid', auth()->user()->uid)->update(['active' => '0']);
        $obj = Address::where('id', $req->id)->where('uid', auth()->user()->uid)->first();
        $obj->active = "1";
        $status = $obj->update();
        if ($status) {
            return ApiRes::success("Address active successfully !");
        } else {
            return ApiRes::error();
        }
    }
    public function delete(Request $req)
    {
        $obj = Address::where('id', $req->id)->where('uid', auth()->user()->uid)->first();
        $status = $obj->delete();
        if ($status) {
            return ApiRes::success("Address delete successfully !");
        } else {
            return ApiRes::error();
        }
    }
}
