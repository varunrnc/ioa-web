<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Helpers\Classes\EasyData;
use App\Helpers\Classes\EasyImage;
use App\Models\Category;
use Illuminate\Support\Str;

class Category_AdminController extends Controller
{
    // ======== Settings ===========

    public $image_width = 162;
    public $image_height = 162;
    public $dir_name = 'category';
    public $msg_txt = 'Category';

    // ======== End Settings ===========

    public function index(Request $request)
    {
        $data_list = '';
        if (!empty($request->q)) {
            $search = $request->q;
            $data_list = Category::where('name', 'LIKE', '%' . $search . '%')
                ->orWhere('description', 'LIKE', '%' . $search . '%');
        } else {
            $data_list = Category::orderBy('id', 'DESC');
        }
        $data_list = $data_list->paginate(50);
        return view('admin.' . $this->dir_name . '.index', compact('data_list'));
    }

    public function create()
    {
        return view('admin.' . $this->dir_name . '.create');
    }


    public function store(Request $request)
    {
        if ($request->action == 'CREATE') {
            $x = new EasyData;
            $x->request = $request;
            $x->model = new Category;
            $x->data('name', 'name', 'required|string|max:255|unique:categories,name');
            $x->datax('slug', Str::of($request->name)->slug('-'));
            $x->data('description', 'description', 'required|string|max:255');
            $x->data('status', 'status', 'required|numeric');
            $x->vdata('image', 'required|image|mimes:jpeg,jpg,png');
            if ($x->save()) {
                if (!empty($request->image)) {
                    $image = EasyImage::image($request, 'image')
                        ->model('categories', 'image', $x->saved_id)
                        ->path('assets/img/' . $this->dir_name . '/')
                        ->name($x->saved_id)
                        ->crop($this->image_width, $this->image_height)
                        ->save();
                }
                $x->status(true);
                $x->message($this->msg_txt . ' Added Successfully');
            }
            return $x->json_output();
        }


        if ($request->action == 'UPDATE') {

            $x = new EasyData;
            $x->request = $request;
            $x->model = Category::find($request->id);
            if (!empty($x->model)) {
                $x->data('name', 'name', 'required|string|max:255|unique:categories,name,' . $request->id);
                $x->datax('slug', Str::of($request->name)->slug('-'));
                $x->data('description', 'description', 'required|string|max:255');
                $x->data('status', 'status', 'required|numeric');
                if ($x->save()) {
                    if (!empty($request->image)) {
                        $image = EasyImage::image($request, 'image')
                            ->model('categories', 'image', $x->saved_id)
                            ->path('assets/img/' . $this->dir_name . '/')
                            ->name($x->saved_id)
                            ->crop($this->image_width, $this->image_height)
                            ->save();
                    }
                    $x->status(true);
                    $x->message($this->msg_txt . ' Added Successfully');
                }
            } else {
                $x->message('Something Error...!');
            }
            return $x->json_output();
        }

        if ($request->action == 'UPDATE_STATUS') {
            $x = new EasyData;
            $x->request = $request;
            $x->model = Category::find($request->id);
            if (!empty($x->model)) {
                $x->data('status', 'status', 'required|numeric');
                if ($x->save()) {
                    $x->status(true);
                    $x->message('Status Updated Successfully');
                }
            } else {
                $x->message('Something Error...!');
            }
            return $x->json_output();
        }

        if ($request->action == 'DELETE') {
            $x = new EasyData;
            $x->request = $request;
            $x->model = Category::find($request->id);
            if (!empty($x->model)) {

                // ======== Delete Image =========
                $delete_dir = 'assets/img/' . $this->dir_name . '/';
                $delete_file = $x->model->image;
                $x->delete_file($delete_dir, $delete_file);
                // ======= End Delete Image ======

                $x->model->delete();
                $x->status(true);
                $x->message($this->msg_txt . ' deleted successfully');
            } else {
                $x->message('Something Error...!');
            }
            return $x->json_output();
        }

        if ($request->action == 'DELETE_IMAGE') {
            $x = new EasyData;
            $x->request = $request;
            $x->model = Category::find($request->id);
            if (!empty($request->image_name) and !empty($x->model)) {
                $x->model->image = null;
                $x->save();
                // ======== Delete Image =========
                $delete_dir = 'assets/img/' . $this->dir_name . '/';
                $delete_file = $request->image_name;
                $x->delete_file($delete_dir, $delete_file);
                $x->status(true);
                $x->message('Image deleted successfully');
            } else {
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
        $data = Category::find($id);
        if (!empty($data)) {
            return view('admin.' . $this->dir_name . '.edit', compact('data'));
        } else {
            return abort('403', 'Id Not Found');
        }
    }
}
