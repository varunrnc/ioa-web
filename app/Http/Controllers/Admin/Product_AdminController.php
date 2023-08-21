<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Helpers\Classes\EasyData;
use App\Helpers\Classes\EasyImage;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Support\Str;
use Hpx;

class Product_AdminController extends Controller
{
    // ======== Settings ===========

    public $image_width = 570;
    public $image_height = 550;
    public $thumb_width = 270;
    public $thumb_height = 256;
    public $dir_name = 'product';
    public $msg_txt = 'Product';

    // ======== End Settings ===========

    public function index(Request $request)
    {   
        $data_list = '';
        if(!empty($request->q)){
            $search = $request->q;
            $data_list = Product::where('title','LIKE','%'.$search.'%')
                ->orWhere('category','LIKE','%'.$search.'%');
        }else{
            $data_list = Product::orderBy('id','DESC');
        }
        $data_list = $data_list->paginate(50);
        return view('admin.'.$this->dir_name.'.index',compact('data_list'));
    }


    public function create()
    {
        $categories = Category::all();
        return view('admin.'.$this->dir_name.'.create',compact('categories'));
    }


    public function store(Request $request)
    {        

        if($request->action == 'CREATE'){
            $x = new EasyData;
            $x->request = $request; 
            $x->model = new Product;
            $x->data('title','title','required|string|max:255|unique:products,title');
            $x->datax('slug',Str::of($request->title)->slug('-'));
            $x->data('description','description','required|string');
            $x->data('html_content','html_content','required|string');
            $x->data('regular_price','regular_price','required|numeric');
            $x->data('selling_price','selling_price','required|numeric');
            $x->datax('discount',Hpx::discount_x($request->regular_price,$request->selling_price));
            $x->data('category','category','required|string');
            $x->data('ogd_no','ogd_no','required|integer');
            $x->data('image1','image1','required|image');
            $x->data('weight','weight','nullable|numeric');
            $x->data('shipping_charge','shipping_charge','nullable|numeric');
            $x->data('status','status','nullable|numeric');

            if($x->save()){

                if(!empty($request->image1)){
                    $image_name = Str::of($request->title)->slug('-').'_'.$x->saved_id.'1';
                    $image = EasyImage::image($request,'image1')
                            ->path('assets/img/'.$this->dir_name.'/')
                            ->name($image_name)
                            ->crop($this->image_width,$this->image_height)
                            ->save();

                    EasyImage::image_path('assets/img/'.$this->dir_name.'/'.$image_name.'.jpg')
                    ->path('assets/img/'.$this->dir_name.'/thumbnail/')
                    ->name($image_name)
                    ->resize($this->thumb_width,$this->thumb_height)
                    ->save();

                    // Update Image Name
                    $tb = Product::find($x->saved_id);
                    $tb->image1 = $image_name.'.jpg';
                    $tb->save();
                }

                if(!empty($request->image2)){
                    $image_name = Str::of($request->title)->slug('-').'_'.$x->saved_id.'2';
                    $image = EasyImage::image($request,'image2')
                            ->path('assets/img/'.$this->dir_name.'/')
                            ->name($image_name)
                            ->crop($this->image_width,$this->image_height)
                            ->save();

                    // Update Image Name
                    $tb = Product::find($x->saved_id);
                    $tb->image2 = $image_name.'.jpg';
                    $tb->save();
                }

                if(!empty($request->image3)){
                    $image_name = Str::of($request->title)->slug('-').'_'.$x->saved_id.'3';
                    $image = EasyImage::image($request,'image3')
                            ->path('assets/img/'.$this->dir_name.'/')
                            ->name($image_name)
                            ->crop($this->image_width,$this->image_height)
                            ->save();

                    // Update Image Name
                    $tb = Product::find($x->saved_id);
                    $tb->image3 = $image_name.'.jpg';
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
            $x->model = Product::find($request->id);
            if(!empty($x->model)){
                $x->data('title','title','required|string|max:255|unique:products,title,'.$request->id);
                $x->datax('slug',Str::of($request->title)->slug('-'));
                $x->data('description','description','required|string');
                $x->data('html_content','html_content','required|string');
                $x->data('regular_price','regular_price','required|numeric');
                $x->data('selling_price','selling_price','required|numeric');
                $x->datax('discount',Hpx::discount_x($request->regular_price,$request->selling_price));
                $x->data('category','category','required|string');
                $x->data('ogd_no','ogd_no','required|integer');
                $x->data('weight','weight','nullable|numeric');
                $x->data('shipping_charge','shipping_charge','nullable|numeric');
                $x->data('status','status','nullable|numeric');

                $x->data('status','status','required|numeric');
                if($x->save()){

                    if(!empty($request->image1)){
                        $image_name = Str::of($request->title)->slug('-').'_'.$x->saved_id.'1';
                        $image = EasyImage::image($request,'image1')
                                ->path('assets/img/'.$this->dir_name.'/')
                                ->name($image_name)
                                ->crop($this->image_width,$this->image_height)
                                ->save();

                        EasyImage::image_path('assets/img/'.$this->dir_name.'/'.$image_name.'.jpg')
                        ->path('assets/img/'.$this->dir_name.'/thumbnail/')
                        ->name($image_name)
                        ->resize($this->thumb_width,$this->thumb_height)
                        ->save();

                        // Update Image Name
                        $tb = Product::find($x->saved_id);
                        $tb->image1 = $image_name.'.jpg';
                        $tb->save();
                    }

                    if(!empty($request->image2)){
                        $image_name = Str::of($request->title)->slug('-').'_'.$x->saved_id.'2';
                        $image = EasyImage::image($request,'image2')
                                ->path('assets/img/'.$this->dir_name.'/')
                                ->name($image_name)
                                ->crop($this->image_width,$this->image_height)
                                ->save();

                        // Update Image Name
                        $tb = Product::find($x->saved_id);
                        $tb->image2 = $image_name.'.jpg';
                        $tb->save();
                    }

                    if(!empty($request->image3)){
                        $image_name = Str::of($request->title)->slug('-').'_'.$x->saved_id.'3';
                        $image = EasyImage::image($request,'image3')
                                ->path('assets/img/'.$this->dir_name.'/')
                                ->name($image_name)
                                ->crop($this->image_width,$this->image_height)
                                ->save();

                        // Update Image Name
                        $tb = Product::find($x->saved_id);
                        $tb->image3 = $image_name.'.jpg';
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
            $x->model = Product::find($request->id);
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
            $x->model = Product::find($request->id);
            if(!empty($x->model)){

                // ======== Delete Image =========
                $delete_dir = 'assets/img/'.$this->dir_name.'/';
                $delete_file = $x->model->image1;
                $x->delete_file($delete_dir,$delete_file);                

                $delete_file = $x->model->image2;
                $x->delete_file($delete_dir,$delete_file);

                $delete_file = $x->model->image3;
                $x->delete_file($delete_dir,$delete_file);
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
            $x->model = Product::find($request->id);
            $image_name = '';
            if(!empty($x->model)){
                if(!empty($request->column)){
                    switch ($request->column) {
                        case 'image1':
                            $image_name = $x->model->image1;
                            $x->model->image1 = null;
                            $x->save();
                            $delete_dir = 'assets/img/'.$this->dir_name.'/thumbnail/';
                            $delete_file = $x->model->image1;
                            $x->delete_file($delete_dir,$delete_file);
                            break;

                        case 'image2':
                            $image_name = $x->model->image2;
                            $x->model->image2 = null;
                            $x->save();
                            break;

                        case 'image3':
                            $image_name = $x->model->image3;
                            $x->model->image3 = null;
                            $x->save();
                            break;
                    }
                }
                // ======== Delete Image =========
                $delete_dir = 'assets/img/'.$this->dir_name.'/';
                $delete_file = $image_name;
                $x->delete_file($delete_dir,$delete_file);
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
        $data = Product::find($id);
        $categories = Category::all();
        if(!empty($data)){
            return view('admin.'.$this->dir_name.'.edit',compact('data','categories'));
        }else{
            return abort('403','Id Not Found');
        }
    }

}
