<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Helpers\Classes\EasyData;
use App\Helpers\Classes\EasyImage;
use App\Models\PostCategory;
use Illuminate\Support\Str;

class PostCategory_AdminController extends Controller
{

    public function index()
    {
        $categories = PostCategory::orderBy('created_at','DESC')->get();
        return view('admin.post-category.index',compact('categories'));
    }

    public function create()
    {
        return view('admin.post-category.create');
    }

    public function store(Request $request)
    {
        if($request->action == 'CREATE_CATEGORY'){
            $x = new EasyData;
            $x->request = $request;
            $x->model = new PostCategory;
            $x->data('name','name','required|string|max:255|unique:post_categories,name');
            $x->datax('slug',Str::of($request->name)->slug('-'));
            $x->data('description','description','required|string|max:255');
            $x->data('status','status','required|numeric');
            if($x->save()){
                if(!empty($request->image)){
                    $image_name = 'post-category'.$x->saved_id;
                    EasyImage::image($request,'image')->path('assets/img/post-category/')->name($image_name)->crop(170,170)->save();                    
                    // Update Image Name
                    $category = PostCategory::find($x->saved_id);
                    $category->image = $image_name.'.jpg';
                    $category->save();
                }
                $x->status(true);
                $x->message('Category Added Successfully');
            }
            return $x->json_output();
        }


        if($request->action == 'UPDATE_CATEGORY'){

            $x = new EasyData;
            $x->request = $request;
            $x->model = PostCategory::find($request->id);
            if(!empty($x->model)){
                $x->data('name','name','required|string|max:255|unique:categories,name,'.$request->id);
                $x->datax('slug',Str::of($request->name)->slug('-'));
                $x->data('description','description','required|string|max:255');
                $x->data('status','status','required|numeric');

                if($x->save()){
                    if(!empty($request->image)){
                        $image_name = 'post-category'.$x->saved_id;
                        EasyImage::image($request,'image')->path('assets/img/post-category/')->name($image_name)->crop(170,170)->save();                    
                        // Update Image Name
                        $update_data = PostCategory::find($x->saved_id);
                        $update_data->image = $image_name.'.jpg';
                        $update_data->save();
                    }
                    $x->status(true);
                    $x->message('Category Updated Successfully');
                }
            }else{
                $x->message('Something Error...!');
            }
            return $x->json_output();
        }

        if($request->action == 'UPDATE_CATEGORY_STATUS'){

            $x = new EasyData;
            $x->request = $request;
            $x->model = PostCategory::find($request->id);
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

        if($request->action == 'DELETE_CATEGORY'){

            $x = new EasyData;
            $x->request = $request;
            $x->model = PostCategory::find($request->id);
            if(!empty($x->model)){
                
                // ======== Delete Image =========
                $delete_dir = 'assets/img/post-category/';
                $delete_file = $x->model->image;
                $x->delete_file($delete_dir,$delete_file);
                // ======= End Delete Image ======

                $x->model->delete();
                $x->status(true);
                $x->message('Category deleted Successfully');
            }else{
                $x->message('Something Error...!');
            }
            return $x->json_output();
        }  

    }

    public function edit($id)
    {
        $category = PostCategory::find($id);
        if(!empty($category)){
            return view('admin.post-category.edit',compact('category'));
        }else{
            return abort('403','Id Not Found');
        }
    }

}
