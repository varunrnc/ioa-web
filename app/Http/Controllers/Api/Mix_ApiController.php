<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Helpers\Classes\EasyData;
use App\Helpers\Classes\EasyImage;
use App\Models\Slider;
use App\Models\Message;
use App\Models\Userdetail;
use App\Models\ChatUser;

class Mix_ApiController extends Controller
{
    public function refresh_chat_id($value='')
    {
        $refresh_id = '';
        if(!empty($value)){
            $myfile = fopen("chat_id.txt", "w+");
            fwrite($myfile, $value);
            fclose($myfile);
        }else{
            if(file_exists('chat_id.txt')){
                return file_get_contents('chat_id.txt');
            }else{
                $myfile = fopen("chat_id.txt", "w+");
                fwrite($myfile, rand());
                fclose($myfile);
                return rand();
            }
        }
    }

    public function index(Request $request)
    {     
        if($request->action == 'SLIDER'){
            $x = new EasyData;
            $x->status(true);
            $x->request = $request;
            $data_list = Slider::where('status',true)->orderBy('order_no','ASC')->get();    
            return $x->json_output(['data'=>$data_list]);
        }

        if($request->action == 'MESSAGE_GET'){
            $x = new EasyData;
            $x->request = $request;
            $dir_name = 'message';
            $uid = auth()->user()->uid;
            $message = '';
            $limit = !empty($request->limit) ? $request->limit : 50; 
            if(!empty($uid)){
                $message = Message::where('send_id',$uid)->orWhere('recevied_id',$uid)->orderBy('id','DESC')->take($limit)->get();
                $message = $message->toArray();
                $message = array_reverse($message);
                $x->status(true);
                $x->message('Messages');
            }
            return $x->json_output(['data'=>$message]);
        }

        $ob = new EasyData;
        $ob->message('Invalid action type');
        return $ob->json_output();  
    }

    public function store(Request $request)
    {        
        if($request->action == 'MESSAGE_SET'){
            $x = new EasyData;
            $x->request = $request;
            $x->model = new Message;
            $dir_name = 'message';
            $user = Userdetail::where('uid',auth()->user()->uid)->first();
            if(!empty($user)){
                $request->send_id = $user->uid;
                $request->recevied_id = 'admin';
                $x->data('send_id','send_id','nullable|string|max:255');
                $x->data('recevied_id','recevied_id','nullable|string|max:255');
                $x->data('message','message','nullable|string|max:255');
                $x->datax('msg_date',date('d/m/Y'));
                $x->datax('msg_time',date('h:i A'));
                $x->vdata('image','nullable|image');            

                if($x->save()){
                    if(!empty($request->image)){

                        $image_name = $dir_name.$x->saved_id;
                        EasyImage::image($request,'image')
                        ->path('assets/img/'.$dir_name.'/')
                        ->name($image_name)
                        ->save();

                        // Update Image Name
                        $tb = Message::find($x->saved_id);
                        $tb->image = $image_name.'.jpg';
                        $tb->save();
                    }

                    $chat_user = ChatUser::where('uid',$user->uid)->first();
                    if(empty($chat_user)){
                        $chat_user = new ChatUser;
                    }
                    
                    $chat_user->uid = $user->uid;
                    $chat_user->name = $user->name;
                    $chat_user->mobile = $user->mobile;
                    $chat_user->profile_image = !empty($user->image) ? $user->image : 'user.png';
                    $chat_user->last_date = date('d/m/Y');
                    $chat_user->last_time = date('h:i A');
                    $chat_user->last_msg = $request->message;
                    $chat_user->seen = false;
                    $chat_user->msg_count = $chat_user->msg_count+1;
                    $chat_user->save();

                    $this->refresh_chat_id($x->saved_id);
                    $x->status(true);
                    $x->message('Message Sent Successfully');
                }
            }else{ $x->message('Please Update Your Name.'); }
            return $x->json_output();
        }

        $ob = new EasyData;
        $ob->message('Invalid action type');
        return $ob->json_output();     

    }


}

