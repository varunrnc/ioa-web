<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Helpers\Classes\EasyData;
use App\Helpers\Classes\EasyImage;
use App\Models\Userdetail;
use App\Models\User;

class User_ApiController extends Controller
{
    public $dir_name = 'userprofile';
    public $msg_txt = 'User details';

    public function index(Request $request)
    {
        if($request->action == 'GET'){
            $x = new EasyData;
            $x->status(true); 
            $x->message($this->msg_txt);  
            $data = Userdetail::where('uid',auth()->user()->uid)->first();
            return $x->json_output(['data'=>$data]);
        }

        $ob = new EasyData;
        $ob->message('Invalid action type');
        return $ob->json_output();
    }

    public function store(Request $request)
    {      
        if($request->action == 'UPDATE'){

            $x = new EasyData;
            $x->request = $request;
            $data = '';

            // check User details available or not
            $x->model = Userdetail::where('uid',auth()->user()->uid)->first();
            if(empty($x->model)){ 
                $x->model = new Userdetail;
            }       

            $x->datax('uid',$x->uid());
            $x->data('name','name','nullable|string|max:30');
            $x->data('dob','dob','nullable|date');
            $x->data('gender','gender','nullable|string');
            $x->datax('mobile',auth()->user()->mobile);
            $x->data('email','email','nullable|email|string|max:200');
            $x->data('city','city','nullable|string|max:50');
            $x->data('state','state','nullable|string|max:100');
            $x->data('pincode','pincode','nullable|numeric|digits:6');

            if($x->save()){
                $user = User::find(auth()->user()->id);
                if(!empty($user)){
                    $user->name = $request->name;
                    $user->save();
                }
               $x->status(true);
               $x->message($this->msg_txt.' updated'); 
            }

            $output_data = Userdetail::where('uid',auth()->user()->uid)->first();

            return $x->json_output(['data'=>$output_data]);
        }

        if($request->action == 'UPDATE_PRO_IMG'){
            $x = new EasyData;
            $x->request = $request;
            $x->model = Userdetail::where('uid',auth()->user()->uid)->first();
            $data = '';
            if(!empty($x->model)){
                if(!empty($request->image)){
                    $image_name = 'pro_image_'.auth()->user()->uid;
                    $image = EasyImage::image($request,'image')->path('assets/img/'.$this->dir_name.'/')->name($image_name)->crop(100,100)->save();
                    if($image->status == true){
                        // Update Image Name
                        $x->datax('image',$image_name.'.jpg');
                        if($x->save()){
                            $data = $image_name.'.jpg';
                            $x->status(true);
                            $x->message('Profile Image Updated Successfully');
                        }
                    }else{ $x->message($image->message); }
                }else{ $x->message('Image required..!'); }
            }else{ $x->message('Invalid User..!'); }
            return $x->json_output();
        }

        $ob = new EasyData;
        $ob->message('Invalid action type');
        return $ob->json_output();
    }
}
