<?php

namespace App\Http\Controllers\Api\SubCategory;

use App\Helpers\ApiRes;
use App\Http\Controllers\Controller;
use App\Models\SubCategory;
use Illuminate\Http\Request;

class ApiSubCategoryController extends Controller
{
    public function data(Request $req)
    {
        // $data = SubCategory::select('name')->where('category', $req->category)->get();
        return $req->category;
    }
}
