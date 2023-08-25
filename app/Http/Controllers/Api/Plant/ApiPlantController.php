<?php

namespace App\Http\Controllers\Api\Plant;

use App\Helpers\ApiRes;
use App\Http\Controllers\Controller;
use App\Models\Plant;
use App\Models\SubCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ApiPlantController extends Controller
{
    public function data(Request $req)
    {
        $data = Plant::latest()->with('imglg')->with('wishlist', function ($wishlist) {
            return $wishlist->where('uid', auth()->user()->id)->get();
        })->get();
        return ApiRes::data($data);
    }
    public function category()
    {
        $subcat = SubCategory::Where('category', 'Plant')->with('imglg')->get()->map(function ($data) {
            if (is_null($data->description)) {
                $data->description = '';
            }

            return $data;
        });
        if ($subcat) {
            return ApiRes::data("Datalist", $subcat);
        } else {
            return ApiRes::error();
        }
    }
    public function byCategory(Request $req)
    {
        $validator =  Validator::make($req->all(), [
            'sub_category' => 'required|string|max:255',

        ]);
        if ($validator->fails()) {
            $errors = $validator->errors();
            if ($errors->first('sub_category')) {
                return ApiRes::failed($errors->first('sub_category'));
            }
        }
        $plant = Plant::Where('sub_category', $req->sub_category)->with('imglg')->with('wishlist', function ($wishlist) {
            return $wishlist->where('uid', auth()->user()->id)->get();
        })->get();
        if ($plant) {
            return ApiRes::data("Datalist", $plant);
        } else {
            return ApiRes::error();
        }
    }
}
