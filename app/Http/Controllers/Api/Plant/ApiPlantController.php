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
        if ($req->id == null || $req->id == "") {
            $plant = Plant::select('*')
                ->where('id', '>', '5')
                ->latest()
                ->limit(6)
                ->with('img')
                ->get();
            if ($plant) {
                return ApiRes::data("Plant List", $plant);
            } else {
                return ApiRes::error();
            }
        } else {
            $plant = Plant::select('*')
                ->where('id', '>', $req->id)
                ->latest()
                ->limit(6)
                ->with('img')
                ->get();
            if ($plant) {
                return ApiRes::data("Plant List", $plant);
            } else {
                return ApiRes::error();
            }
        }
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
        $plant = Plant::Where('sub_category', $req->sub_category)->with('imglg')->get();
        if ($plant) {
            return ApiRes::data("Datalist", $plant);
        } else {
            return ApiRes::error();
        }
    }
}
