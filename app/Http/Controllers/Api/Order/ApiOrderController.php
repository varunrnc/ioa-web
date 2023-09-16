<?php

namespace App\Http\Controllers\Api\Order;

use App\Helpers\ApiRes;
use App\Http\Controllers\Controller;
use App\Models\Morder;
use App\Models\OrderedItem;
use App\Models\Plant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ApiOrderController extends Controller
{
    public function data()
    {
        $datalist = Morder::where('uid', auth()->user()->id)->latest()->get();
        $order = collect([]);
        foreach ($datalist as $data) {
            $items = OrderedItem::where('orderid', $data->orderid)->get();
            foreach ($items as $item) {
                
                $plant = Plant::where('pid', $item->pid)->first();
                $item['plant'] = $plant;
            }
            $data['items'] = $items;

            $order->push($data);
        }

        return ApiRes::data($order);
    }
}
