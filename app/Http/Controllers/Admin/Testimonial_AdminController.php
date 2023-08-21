<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Helpers\Classes\EasyData;
use App\Helpers\Classes\EasyImage;
use App\Models\Testimonial;

class Testimonial_AdminController extends Controller
{

    // ======== Settings ===========

    public $image_width = '124';
    public $image_height = '124';
    public $dir_name = 'testimonial';
    public $msg_txt = 'Testimonial';

    // ======== End Settings =======

    public function index(Request $request)
    {    
        $data_list = '';
        if(!empty($request->q)){
            $search = $request->q;
            $data_list = Testimonial::where('name','LIKE','%'.$search.'%')
                ->orWhere('place','LIKE','%'.$search.'%');
        }else{ $data_list = Testimonial::orderBy('id','DESC'); }
        $data_list = $data_list->paginate(50);        
        return view('admin.'.$this->dir_name.'.index',compact('data_list')); 
    }


    public function create()
    {
        return view('admin.'.$this->dir_name.'.create');
    }


    public function store(Request $request)
    {        
        if($request->action == 'CREATE'){
            $x = new EasyData;
            $x->request = $request;
            $x->model = new Testimonial;
            $x->data('name','name','required|string|max:255');
            $x->data('place','place','required|string|max:255');
            $x->data('message','message','required|string|max:255');
            $x->data('status','status','required|numeric');
            if($x->save()){
                if(!empty($request->image)){
                    $image_name = $this->dir_name.$x->saved_id;
                    EasyImage::image($request,'image')
                    ->path('assets/img/'.$this->dir_name.'/')
                    ->name($image_name)
                    ->crop($this->image_width,$this->image_height)
                    ->save();
                    // Update Image Name
                    $tb = Testimonial::find($x->saved_id);
                    $tb->image = $image_name.'.jpg';
                    $tb->save();
                }
                $x->status(true);
                $x->message($this->msg_txt.' Added Successfully');
            }
            return $x->json_output();
        }


        if($request->action == 'UPDATE'){

            $x = new EasyData;
            $x->request = $request;
            $x->model = Testimonial::find($request->id);
            if(!empty($x->model)){
                $x->data('name','name','required|string|max:255');
                $x->data('place','place','required|string|max:255');
                $x->data('message','message','required|string|max:255');
                $x->data('status','status','required|numeric');
                if($x->save()){
                    if(!empty($request->image)){
                        $image_name = $this->dir_name.$x->saved_id;
                        EasyImage::image($request,'image')
                        ->path('assets/img/'.$this->dir_name.'/')
                        ->name($image_name)
                        ->crop($this->image_width,$this->image_height)
                        ->save();
                        // Update Image Name
                        $tb = Testimonial::find($x->saved_id);
                        $tb->image = $image_name.'.jpg';
                        $tb->save();
                    }   
                    $x->status(true);
                    $x->message($this->msg_txt.' Updated Successfully');
                }
            }else{ $x->message('Something Error...!'); }
            return $x->json_output();
        }

        if($request->action == 'UPDATE_STATUS'){
            $x = new EasyData;
            $x->request = $request;
            $x->model = Testimonial::find($request->id);
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
            $x->model = Testimonial::find($request->id);
            if(!empty($x->model)){
                // ======== Delete Image =========
                $x->delete_file('assets/img/'.$this->dir_name.'/',$x->model->image);
                // ======= End Delete Image ======
                $x->model->delete();
                $x->status(true);
                $x->message($this->msg_txt.' Deleted Successfully');
            }else{
                $x->message('Something Error...!');
            }
            return $x->json_output();
        }

        if($request->action == 'DELETE_IMAGE'){
            $x = new EasyData;
            $x->request = $request;
            $x->model = Testimonial::find($request->id);
            $image_name = '';
            if(!empty($x->model)){
                if(!empty($request->column)){
                    switch ($request->column) {
                        case 'image':
                            $image_name = $x->model->image;
                            $x->model->image = null;
                            $x->save();
                            break;
                    }
                }                
                // ======== Delete Image =========
                $x->delete_file('assets/img/'.$this->dir_name.'/',$x->model->image);
                // ======= End Delete Image ======
                $x->status(true);
                $x->message('Image deleted successfully');
            }else{
                $x->message('Something Error...!');
            }
            return $x->json_output();
        }  

        $ob = new EasyData;
        $ob->message('Invalid action type');
        return $ob->json_output();     

    }

    public function edit($id)
    {
        $data = Testimonial::find($id);
        if(!empty($data)){
            return view('admin.'.$this->dir_name.'.edit',compact('data'));
        }else{
            return abort('403','Id Not Found');
        }
    }
}
