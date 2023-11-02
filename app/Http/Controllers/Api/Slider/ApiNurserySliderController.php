<?php

namespace App\Http\Controllers\Api\Slider;

use App\Helpers\ApiRes;
use App\Http\Controllers\Controller;
use App\Models\NurserySlider;
use Illuminate\Http\Request;

class ApiNurserySliderController extends Controller
{
    public function data()
    {
        $data = NurserySlider::where('status', '1')->orderBy('order_no')->get();
        return ApiRes::data($data);
    }
}
