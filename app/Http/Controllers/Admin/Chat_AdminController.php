<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Helpers\Classes\EasyData;
use App\Helpers\Classes\EasyImage;
use App\Models\Message;
use App\Models\Userdetail;
use App\Models\ChatUser;
use App\Helpers\Classes\FcmNotification;


class Chat_AdminController extends Controller
{
    public function totalMsgCount()
    {
        $x = new EasyData;
        $x->status(true);
        $data = ChatUser::sum('msg_count');
        return $x->json_output(['data'=>$data]);
    }

    public function getUserDetails(Request $request)
    {
        $x = new EasyData;
        $x->request = $request;
        $data = [];
        if(!empty($request->active_uid) and $request->active_uid != 'undefined'){
            $active_uid = $request->active_uid;
            $data = Userdetail::where('uid',$active_uid)->first();
            if(!empty($data)){
                $x->status(true);
            }else{
                $x->message('Please Update Your Profile');
            }
        }
        return $x->json_output(['data'=>$data]);
    }

    public function loadMessages(Request $request)
    {
        $x = new EasyData;
        $x->request = $request;
        $chat_list = '';
        $messages = '';
        // Get Active User Message
        if(!empty($request->active_uid) and $request->active_uid != 'undefined'){
            $active_uid = $request->active_uid;
            $messages = Message::where('send_id',$active_uid)->orWhere('recevied_id',$active_uid)->orderBy('id','DESC')->take('100')->get();
            $chat_user = ChatUser::where('uid',$active_uid)->first();
            $chat_user->seen = 1;
            $chat_user->msg_count = null;
            $chat_user->save();
        }
        return $x->json_output(['chat_list'=>$chat_list,'messages'=>$messages]);
    }

    public function getChatUsers(Request $request)
    {
        $x = new EasyData;
        $x->request = $request;
        $chat_list = '';
        $messages = [];

        $chat_list = ChatUser::orderBy('updated_at','DESC')->take(50)->get();
        if(!empty($request->active_uid)){
            $last_id = 0;
            if(!empty($request->last_id)){
                $last_id = $request->last_id;
            }
            $active_uid = $request->active_uid;
            $messages = Message::where('id','>',$last_id)->where(function($query) use ($active_uid){
                $query->where('send_id',$active_uid)->orWhere('recevied_id',$active_uid);
            })->orderBy('id','DESC')->take(50)->get();
            if(!empty($messages)){ $messages = $messages->toArray(); $messages = array_reverse($messages); }

            $chat_user = ChatUser::where('uid',$active_uid)->first();
            $chat_user->seen = true;
            $chat_user->msg_count = null;
            $chat_user->save();

            $x->status(true);
        }
        return $x->json_output(['chat_list'=>$chat_list,'messages'=>$messages]);
    }


    public function sendMessage(Request $request)
    {
        $x = new EasyData;
        $x->request = $request;
        $x->model = new Message;
        $fcm_message = '';

        if(!empty($request->recevied_id)){
            $user = Userdetail::where('uid',$request->recevied_id)->first();
            if(!empty($user)){

                if(!empty($request->image)){
                    $x->data('message','message','nullable|string|max:255');
                }else{
                    $x->data('message','message','required|string|max:255');
                }

                $x->datax('send_id','admin');
                $x->datax('recevied_id',$user->uid);
                $x->datax('msg_date',date('d/m/Y'));
                $x->datax('msg_time',date('h:i A'));
                $fcm_message = $request->message;

                if($x->save()){
                    if(!empty($request->image)){
                        $image_name = $x->saved_id;

                        EasyImage::image($request,'image')
                        ->path('assets/img/message/')
                        ->name($image_name)
                        ->save();

                        $fcm_message = asset('assets/img/message/'.$image_name.'.jpg');
                        // Update Image Name
                        $tb = Message::find($x->saved_id);
                        $tb->image = $image_name.'.jpg';
                        $tb->save();
                    }

                    $notification = new FcmNotification;
                    $notification->topic($request->recevied_id);
                    $notification->title('IOA Message');
                    $notification->body($fcm_message);
                    $notification->type('chat');
                    $notify = $notification->send();
                    $x->status(true);
                    $x->message($notify);
                    $this->refresh_chat_id($x->saved_id);
                }
            }
        }

        return $x->json_output();
    }

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

}
