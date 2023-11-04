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
    public function category(Request $req)
    {
        if ($req->category == null) {
            $data =  MplantCategory::where('status', '1')->get();
            return ApiRes::data($data);
        } else {
            $data =  Mplant::groupBy('title')->where('category', $req->category)->where('status', '1')->get();
            return ApiRes::data($data);
        }
    }
    public function subcategory(Request $req)
    {
        $data =  MplantSubCategory::where('category', $req->category)->where('status', '1')->get();
        return ApiRes::data($data);
    }

    public function data(Request $req)
    {
        if ($req->sub_category != null && $req->category != null) {
            $data =  Mplant::groupBy('title')->where('category', $req->category)->where('sub_category', $req->sub_category)->where('status', '1')->get();
            return ApiRes::data($data);
        } else if ($req->category != null) {
            $data =  Mplant::groupBy('title')->where('category', $req->category)->where('status', '1')->get();
            return ApiRes::data($data);
        } else if ($req->sub_category != null) {
            $data =  Mplant::groupBy('title')->where('sub_category', $req->sub_category)->where('status', '1')->get();
            return ApiRes::data($data);
        } else {
            $data =  Mplant::groupBy('title')->where('status', '1')->get();
            return ApiRes::data($data);
        }
    }
}
