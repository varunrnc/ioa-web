<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Helpers\Classes\EasyData;
use Illuminate\Http\Request;
use App\Models\Video;

class Video_ApiController extends Controller
{
    public $dir_name = 'video';
    public $msg_txt = 'Video';

    public function index(Request $request)
    {
        if($request->action == 'GET'){
            $x = new EasyData;
            $x->status(true); 
            $x->message($this->msg_txt.' List');  
            $data = Video::orderBy('id','DESC')->where('status',1);
            if(!empty($request->type)){
                $data = $data->where('type',$request->type);
            }
            $data = $data->take(100)->get();
            return $x->json_output(['data'=>$data]);
        }

        $ob = new EasyData;
        $ob->message('Invalid action type');
        $ob->json_output();
    }


}
