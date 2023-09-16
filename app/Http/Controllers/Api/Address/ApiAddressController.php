<?php

namespace App\Http\Controllers\Api\Address;

use App\Helpers\ApiRes;
use App\Http\Controllers\Controller;
use App\Models\Address;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

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
        $validator = Validator::make($req->all(), [
            'name' => 'required|string|max:255',
            'mobile' => 'required|numeric|digits:10',
            'pincode' => 'required|numeric|digits:6',
            'state' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'address_line_1' => 'required|string|max:255',
            'address_line_2' => 'required|string|max:255',
            'address_notes' => 'required|string|max:255',
        ]);
        if ($validator->fails()) {
            $errors = $validator->errors();
            if ($errors->first('name')) {
                return ApiRes::failed($errors->first('name'));
            } elseif ($errors->first('mobile')) {
                return ApiRes::failed($errors->first('mobile'));
            } elseif ($errors->first('pincode')) {
                return ApiRes::failed($errors->first('pincode'));
            } elseif ($errors->first('state')) {
                return ApiRes::failed($errors->first('state'));
            } elseif ($errors->first('city')) {
                return ApiRes::failed($errors->first('city'));
            } elseif ($errors->first('address_line_1')) {
                return ApiRes::failed($errors->first('address_line_1'));
            } elseif ($errors->first('address_line_2')) {
                return ApiRes::failed($errors->first('address_line_2'));
            } elseif ($errors->first('address_notes')) {
                return ApiRes::failed($errors->first('address_notes'));
            }
        }
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
            $this->autoActive();
            return ApiRes::success("Data saved successfully !");
        } else {
            return ApiRes::error();
        }
    }
    public function update(Request $req)
    {
        $validator = Validator::make($req->all(), [
            'name' => 'required|string|max:255',
            'mobile' => 'required|numeric|digits:10',
            'pincode' => 'required|numeric|digits:6',
            'state' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'address_line_1' => 'required|string|max:255',
            'address_line_2' => 'required|string|max:255',
            'address_notes' => 'required|string|max:255',
        ]);
        if ($validator->fails()) {
            $errors = $validator->errors();
            if ($errors->first('name')) {
                return ApiRes::failed($errors->first('name'));
            } elseif ($errors->first('mobile')) {
                return ApiRes::failed($errors->first('mobile'));
            } elseif ($errors->first('pincode')) {
                return ApiRes::failed($errors->first('pincode'));
            } elseif ($errors->first('state')) {
                return ApiRes::failed($errors->first('state'));
            } elseif ($errors->first('city')) {
                return ApiRes::failed($errors->first('city'));
            } elseif ($errors->first('address_line_1')) {
                return ApiRes::failed($errors->first('address_line_1'));
            } elseif ($errors->first('address_line_2')) {
                return ApiRes::failed($errors->first('address_line_2'));
            } elseif ($errors->first('address_notes')) {
                return ApiRes::failed($errors->first('address_notes'));
            }
        }
        $obj = Address::where('id', $req->id)->where('uid', auth()->user()->uid)->first();
        $obj->uid = auth()->user()->uid;
        $obj->name = $req->name;
        $obj->mobile = $req->mobile;
        $obj->state = $req->state;
        $obj->city = $req->city;
        $obj->pincode = $req->pincode;
        $obj->address_line_1 = $req->address_line_1;
        $obj->address_line_2 = $req->address_line_2;
        $obj->address_notes = $req->address_notes;
        $status = $obj->update();
        if ($status) {
            $this->autoActive();
            return ApiRes::success("Data updated successfully !");
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
            $this->autoActive();
            return ApiRes::success("Address delete successfully !");
        } else {
            return ApiRes::error();
        }
    }
    public function autoActive()
    {
        $data = Address::where('uid', auth()->user()->uid)->get();
        if ($data->count() == 1) {
            $obj =  $data->first();
            $obj->active = "1";
            $obj->update();
        }
    }
}
