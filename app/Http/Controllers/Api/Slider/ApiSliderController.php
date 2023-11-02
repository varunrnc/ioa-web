<?php

namespace App\Http\Controllers\Api\Slider;

use App\Helpers\ApiRes;
use App\Http\Controllers\Controller;
use App\Models\MainSlider;
use Illuminate\Http\Request;

class ApiSliderController extends Controller
{
    public function main()
    {
        $data = MainSlider::where('status', '1')->orderBy('order_no')->get();
        return ApiRes::data($data);
    }
    public function nursery()
    {
        $data = MainSlider::where('status', '1')->orderBy('order_no')->get();
        return ApiRes::data($data);
    }
}
