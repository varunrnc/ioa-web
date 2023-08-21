<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Helpers\Classes\EasyData;
use App\Helpers\Classes\EasyImage;
use App\Models\Post;
use App\Models\PostCategory;
use Illuminate\Support\Str;

class Post_AdminController extends Controller
{
    // ======== Settings ===========

    public $image_width = 650;
    public $image_height = 350;
    public $thumb_width = 370;
    public $thumb_height = 199;
    public $dir_name = 'post';
    public $msg_txt = 'Post';

    // ======== End Settings ===========


    public function index()
    {
        $data_list = '';
        if(!empty($request->q)){
            $search = $request->q;
            $data_list = Post::where('title','LIKE','%'.$search.'%')
                ->orWhere('category','LIKE','%'.$search.'%');
        }else{
            $data_list = Post::orderBy('id','DESC');
        }
        $data_list = $data_list->paginate(50);
        return view('admin.'.$this->dir_name.'.index',compact('data_list'));
    }

    public function create()
    {
        $categories = PostCategory::all();
        return view('admin.'.$this->dir_name.'.create',compact('categories'));
    }

    public function store(Request $request)
    {
        if($request->action == 'CREATE'){
            $x = new EasyData;
            $x->request = $request;
            $x->model = new Post;
            $x->data('title','title','required|string|max:255|unique:posts,title');
            $x->datax('slug',Str::of($request->title)->slug('-'));
            $x->data('content','content','required');
            $x->data('meta_title','meta_title','nullable|string|max:255');
            $x->data('meta_description','meta_description','nullable|string|max:255');
            $x->data('meta_keywords','meta_keywords','nullable|string|max:255');
            $x->data('author_name','author_name','nullable|string|max:255');
            $x->data('category','category','required|string');
            $x->data('status','status','required|numeric');
            if($x->save()){

                $image_name = Str::of($request->title)->slug('-').'_'.$x->saved_id;

                if(!empty($request->image)){
            
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
                    $tb = Post::find($x->saved_id);
                    $tb->image = $image_name.'.jpg';
                    $tb->save();
                }

                $x->status(true);
                $x->message($this->msg_txt.' Created Successfully');
            }
            return $x->json_output();
        }


        if($request->action == 'UPDATE'){
            $x = new EasyData;
            $x->request = $request;
            $x->model = Post::find($request->id);
            if(!empty($x->model)){
                $x->data('title','title','required|string|max:255|unique:posts,title,'.$request->id);
                $x->datax('slug',Str::of($request->title)->slug('-'));
                $x->data('content','content','required');
                $x->data('meta_title','meta_title','nullable|string|max:255');
                $x->data('meta_description','meta_description','nullable|string|max:255');
                $x->data('meta_keywords','meta_keywords','nullable|string|max:255');
                $x->data('author_name','author_name','nullable|string|max:255');
                $x->data('category','category','required|string');
                $x->data('status','status','required|numeric');
                if($x->save()){

                    $image_name = Str::of($request->title)->slug('-').'_'.$x->saved_id;

                    if(!empty($request->image)){
                
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
                        $tb = Post::find($x->saved_id);
                        $tb->image = $image_name.'.jpg';
                        $tb->save();
                    }
                    
                    $x->status(true);
                    $x->message($this->msg_txt.' Updated Successfully');
                }
            }else{
                $x->message('Something Error...!');
            }
            return $x->json_output();
        }

        if($request->action == 'UPDATE_STATUS'){
            $x = new EasyData;
            $x->request = $request;
            $x->model = Post::find($request->id);
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
            $x->model = Post::find($request->id);
            if(!empty($x->model)){
                $x->delete_file('assets/img/'.$this->dir_name.'/',$x->model->image);
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
            $x->model = Post::find($request->id);
            $image_name = '';
            if(!empty($x->model)){                
                if(!empty($request->column)){
                    $image_name = $x->model->image;
                    $x->model->image = null;
                    $x->save();
                }
                $x->delete_file('assets/img/'.$this->dir_name.'/',$image_name);
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
        $data = Post::find($id);
        $categories = PostCategory::all();
        if(!empty($data)){
            return view('admin.'.$this->dir_name.'.edit',compact('data','categories'));
        }else{
            return abort('403','Id Not Found');
        }
    }
}
