<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Helpers\Classes\EasyData;
use App\Helpers\Classes\EasyImage;
use App\Models\Product;
use App\Models\Order;
use App\Models\Address;
use Hpx;

class Product_ApiController extends Controller
{
    public $dir_name = 'product';
    public $msg_txt = 'Product';

    public function index(Request $request)
    {
        if($request->action == 'GET'){
            $x = new EasyData;
            $x->status(true); 
            $x->message($this->msg_txt.' List');  
            $data = Product::orderBy('id','DESC');
            if(!empty($request->id)){
                $data = $data->where('id',$request->id);
            }
            if(!empty($request->category)){
                $data = $data->where('category',$request->category);
            }
            $data = $data->take(100)->get();
            return $x->json_output(['data'=>$data]);
        }

        $ob = new EasyData;
        $ob->message('Invalid action type');
        $ob->json_output();
    }

    public function store(Request $request)
    {       

        

    }


}
