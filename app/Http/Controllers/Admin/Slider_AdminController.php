<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Helpers\Classes\EasyData;
use App\Helpers\Classes\EasyImage;
use App\Models\Slider;
use Illuminate\Support\Str;

class Slider_AdminController extends Controller
{
    // ======== Settings ===========

    public $image_width = 650;
    public $image_height = 350;
    public $thumb_width = 370;
    public $thumb_height = 199;
    public $dir_name = 'slider';
    public $msg_txt = 'Slider';

    // ======== End Settings =======

    public function index(Request $request)
    {     
        $data_list = '';
        if(!empty($request->q)){
            $search = $request->q;
            $data_list = Slider::where('slider_name','LIKE','%'.$search.'%')
                ->orWhere('title','LIKE','%'.$search.'%');
        }else{ $data_list = Slider::orderBy('order_no','ASC'); }
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
            $x->model = new Slider;

            $x->data('slider_name','slider_name','required|string|max:255');
            $x->data('title','title','required|string|max:255');
            $x->data('description','description','required|string|max:255');
            $x->data('button_name','button_name','required|string|max:255');
            $x->data('button_link','button_link','nullable|string|max:255');
            $x->data('order_no','order_no','nullable|numeric');
            $x->data('status','status','required|numeric');

            if($x->save()){
                if(!empty($request->image)){
                    
                    $image_name = Str::of($request->title)->slug('-').'_'.$x->saved_id;
                    
                    EasyImage::image($request,'image')
                    ->path('assets/img/'.$this->dir_name.'/')
                    ->crop($this->image_width,$this->image_height)
                    ->name($image_name)
                    ->save();

                    EasyImage::image_path('assets/img/'.$this->dir_name.'/'.$image_name.'.jpg')
                    ->path('assets/img/'.$this->dir_name.'/thumbnail/')
                    ->name($image_name)
                    ->resize($this->thumb_width,$this->thumb_height)
                    ->save();

                    // Update Image Name
                    $tb = Slider::find($x->saved_id);
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
            $x->model = Slider::find($request->id);
            if(!empty($x->model)){
                $x->data('slider_name','slider_name','required|string|max:255');
                $x->data('title','title','required|string|max:255');
                $x->data('description','description','required|string|max:255');
                $x->data('button_name','button_name','required|string|max:255');
                $x->data('button_link','button_link','nullable|string|max:255');
                $x->data('order_no','order_no','nullable|numeric');
                $x->data('status','status','required|numeric');

                if($x->save()){

                    if(!empty($request->image)){
                    
                        $image_name = Str::of($request->title)->slug('-').'_'.$x->saved_id;
                        
                        EasyImage::image($request,'image')
                        ->path('assets/img/'.$this->dir_name.'/')
                        ->crop($this->image_width,$this->image_height)
                        ->name($image_name)
                        ->save();

                        EasyImage::image_path('assets/img/'.$this->dir_name.'/'.$image_name.'.jpg')
                        ->path('assets/img/'.$this->dir_name.'/thumbnail/')
                        ->name($image_name)
                        ->crop($this->thumb_width,$this->thumb_height)
                        ->save();

                        // Update Image Name
                        $tb = Slider::find($x->saved_id);
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
            $x->model = Slider::find($request->id);
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
            $x->model = Slider::find($request->id);
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
            $x->model = Slider::find($request->id);
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

        if($request->action == 'REORDER_SLIDER'){

            $x = new EasyData;
            $x->request = $request;
            $x->vdata('id','required|numeric');
            $x->vdata('order_no','required|numeric');
            if($x->validate()){
                $this->re_order($request->id,$request->order_no);       
                $x->status(true);
                $x->message('Slider Reorded Successfully');
            }
            return $x->json_output();
        } 

        $ob = new EasyData;
        $ob->message('Invalid action type');
        return $ob->json_output();     

    }

    public function edit($id)
    {
        $data = Slider::find($id);
        if(!empty($data)){
            return view('admin.'.$this->dir_name.'.edit',compact('data'));
        }else{
            return abort('403','Id Not Found');
        }
    }

    public function re_order($id,$order_no){
        $slider = Slider::find($id);
        if(!empty($slider)){
            $orderx = $slider->order_no;
            $slider->order_no = $order_no;
            $slider->save();
            if(!empty($orderx)){
                $slider2 = Slider::where('id','!=',$slider->id)->where('order_no',$order_no)->first();
                if(!empty($slider2)){
                    $slider2->order_no = $orderx;
                    $slider2->save();
                }
            }
        }
    }
}

