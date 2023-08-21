<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Helpers\Classes\EasyData;
use App\Models\Userdetail;
use App\Models\User;
use Hpx;


class Customer_AdminController extends Controller
{
    // ======== Settings ===========
    public $image_width = '';
    public $image_height = '';
    public $dir_name = 'customer';
    public $msg_txt = 'Customer';
    // ======== End Settings ===========

    public function index(Request $request)
    {
        $data_list = Userdetail::orderBy('id','DESC');
        if(!empty($request->q)){
            $search = $request->q;
            $data_list->where(function($query) use ($search){
                $query->where('name','LIKE','%'.$search.'%');
                $query->orWhere('email','LIKE','%'.$search.'%');
                $query->orWhere('mobile','LIKE','%'.$search.'%');

            });
        }
        $data_list = $data_list->paginate(50);
        return view('admin.'.$this->dir_name.'.index',compact('data_list'));
    }


    public function store(Request $request)
    {

        if($request->action == 'UPDATE_STATUS'){
            $x = new EasyData;
            $x->request = $request;
            $x->model = Userdetail::find($request->id);
            if(!empty($x->model)){
                $x->data('status','status','required|numeric');
                if($x->save()){
                    $x->status(true);
                    $x->message('Status Updated Successfully');
                }
            }else{
                $x->message('Something Error...!');
            }
            return $x->json_output();
        }

        if($request->action == 'DELETE'){
            $x = new EasyData;
            $x->request = $request;
            $x->model = Userdetail::find($request->id);
            if(!empty($x->model)){
                $uid = $x->model->uid;
                if(!empty($uid)){
                    $x->model->delete();
                    User::where('uid',$uid)->delete();
                }

                // ======== Delete Image =========
                $x->delete_file('assets/img/'.$this->dir_name.'/',$x->model->image);
                // ======= End Delete Image ======

                $x->status(true);
                $x->message($this->msg_txt.' Deleted Successfully');
            }else{
                $x->message('Something Error...!');
            }
            return $x->json_output();
        }

        $ob = new EasyData;
        $ob->message('Invalid action type');
        return $ob->json_output();

    }

    public function show($id)
    {
        $data = Userdetail::find($id);
        if(!empty($data)){
            return view('admin.'.$this->dir_name.'.show',compact('data'));
        }else{
            return abort('403','Id Not Found');
        }
    }

}
