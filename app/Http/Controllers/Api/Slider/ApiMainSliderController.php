<?php

namespace App\Http\Controllers\Api\Slider;

use App\Helpers\ApiRes;
use App\Http\Controllers\Controller;
use App\Models\MainSlider;
use Illuminate\Http\Request;

class ApiMainSliderController extends Controller
{
    public function data()
    {
        $data = MainSlider::where('status', '1')->orderBy('order_no')->get();
        return ApiRes::data($data);
    }
}
