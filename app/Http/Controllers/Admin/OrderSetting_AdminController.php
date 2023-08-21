<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Helpers\Classes\EasyData;
use App\Models\OrderSetting;

class OrderSetting_AdminController extends Controller
{
    // ======== Settings ===========
    public $image_width = '';
    public $image_height = '';
    public $dir_name = 'order-setting';
    public $msg_txt = 'Setting';
    // ======== End Settings ===========

    public function index(Request $request)
    {     
        $shipping = OrderSetting::where('setting','shipping_charge')->first();     
        return view('admin.'.$this->dir_name.'.index',compact('shipping'));
    }

    public function store(Request $request)
    {        

        if($request->action == 'SHIPPING_CHARGE'){
            $x = new EasyData;
            $x->request = $request;
            $x->model = OrderSetting::where('setting','shipping_charge')->first();
            if(!empty($x->model)){
                $x->data('value','shipping_charge','required|numeric');
                if($x->save()){
                    $x->status(true);
                    $x->message('Shipping Charge Updated Successfully');
                }
            }else{
                $x->message('Something Error...!');
            }
            return $x->json_output();
        }

        $ob = new EasyData;
        $ob->message('Invalid action type');
        return $ob->json_output();     

    }




}
