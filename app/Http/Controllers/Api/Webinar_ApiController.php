<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Helpers\Classes\EasyData;
use App\Models\Webinar;

class Webinar_ApiController extends Controller
{
    public $dir_name = 'webinar';
    public $msg_txt = 'Webinar';

    public function index(Request $request)
    {
        if($request->action == 'GET'){
            $x = new EasyData;
            $x->status(true); 
            $x->message($this->msg_txt.' List');  
            $data = Webinar::orderBy('id','DESC');
            if(!empty($request->type)){
                $data = $data->where('type',$request->type);
            }
            $data = $data->take(50)->get();
            return $x->json_output(['data'=>$data]);
        }

        $ob = new EasyData;
        $ob->message('Invalid action type');
        $ob->json_output();
    }

}
