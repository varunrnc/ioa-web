<?php

namespace App\Http\Controllers\Api\Mplant;

use App\Helpers\ApiRes;
use App\Http\Controllers\Controller;
use App\Models\Mplant;
use App\Models\MplantCategory;
use App\Models\MplantSubCategory;
use Illuminate\Http\Request;

class ApiSeasonWiseController extends Controller
{
    public function category(Request $req)
    {
        $data =  MplantCategory::where('category', '!=', "HARBALS")->where('status', '1')->get();
        return ApiRes::data($data);
    }
    public function subCategory(Request $req)
    {
        $data =  MplantSubCategory::where('category', $req->category)->where('status', '1')->get();
        return ApiRes::data($data);
    }
    public function data(Request $req)
    {
        $data =  Mplant::where('category', $req->category)->where('sub_category', $req->sub_category)->where('status', '1')->get();
        return ApiRes::data($data);
    }
}
