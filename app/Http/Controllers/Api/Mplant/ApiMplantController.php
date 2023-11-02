<?php

namespace App\Http\Controllers\Api\Mplant;

use App\Helpers\ApiRes;
use App\Http\Controllers\Controller;
use App\Models\Mplant;
use App\Models\MplantCategory;
use App\Models\MplantSubCategory;
use Illuminate\Http\Request;

class ApiMplantController extends Controller
{
    public function category()
    {
        $data =  MplantCategory::where('status', '1')->get();
        return ApiRes::data($data);
    }
    public function subcategory(Request $req)
    {
        $data =  MplantSubCategory::where('category', $req->category)->where('status', '1')->get();
        return ApiRes::data($data);
    }

    public function data(Request $req)
    {
        if ($req->sub_category == null) {
            $data =  Mplant::where('status', '1')->latest()->get();
            return ApiRes::data($data);
        } else {
            $data =  Mplant::where('sub_category', $req->sub_category)->where('status', '1')->get();
            return ApiRes::data($data);
        }
    }
}
