<?php

namespace App\Http\Controllers\Admin\SubCategory;

use App\Helpers\ApiRes;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\SubCategory;
use App\Models\SubCategoryImg;
use Illuminate\Http\Request;
use Image;

class AdminSubCategoryController extends Controller
{
    public function index()
    {
        $data = SubCategory::latest()->with('img')->get();
        return view('admin.sub-category.index', compact('data'));
    }
    public function create()
    {
        $cat = Category::all();
        return view('admin.sub-category.create', compact('cat'));
    }
    public function save(Request $req)
    {
        $req->validate([
            'sub_category' => 'required|string|max:225',
            'category' => 'required|string|max:225',



        ]);
        $status = null;
        $cat = new SubCategory();
        $cat->category = $req->category;
        $cat->name = $req->sub_category;
        $cat->description = $req->description;
        $cat->status = $req->status;
        $status = $cat->save();

        if ($status) {
            $id = SubCategory::max('id');
            $path = 'public/img/sub-category/';
            if ($req->hasFile('image')) {
                $req->validate([
                    'image' => 'required|image|mimes:jpeg,jpg,png',
                ]);
                $picName =  uniqid() . ".webp";

                Image::make($req->image->getRealPath())->resize('320', '180')->save($path . $picName);
                $img = new SubCategoryImg();
                $img->sub_cat_id = $id;
                $img->slno = '1';
                $img->type = "md";
                $img->image = $path . $picName;
                $status =  $img->save();

                $picName =  uniqid() . ".webp";
                Image::make($req->image->getRealPath())->resize('480', '360')->save($path . $picName);
                $img = new SubCategoryImg();
                $img->sub_cat_id = $id;
                $img->slno = '2';
                $img->type = "lg";
                $img->image = $path . $picName;
                $status =  $img->save();
            }
            if ($status) {
                return redirect()->back()->with('success', 'Data saved successfully !');
            } else {
                return redirect()->back()->with('error', 'Error, try again later.');
            }
        } else {
            return redirect()->back()->with('error', 'Error, try again later.');
        }
    }
    public function edit(Request $req)
    {

        $data = SubCategory::Where('id', $req->id)->with('img')->first();
        $cat = Category::all();
        if (!empty($data)) {
            return view('admin.sub-category.edit', compact('data', 'cat'));
        } else {
            return abort('403', 'Id Not Found');
        }
    }
    public function update(Request $req)
    {
        $req->validate([
            'sub_category' => 'required|string|max:225',
            'category' => 'required|string|max:225',



        ]);
        $status = null;
        $item = SubCategory::Where('id', $req->id)->first();
        $item->category = $req->category;
        $item->name = $req->sub_category;
        $item->description = $req->description;
        $item->status = $req->status;
        $status = $item->update();
        if ($status) {

            $path = 'public/img/sub-category/';
            if ($req->hasFile('image')) {
                $req->validate([
                    'image' => 'required|image|mimes:jpeg,jpg,png',
                ]);



                $img = SubCategoryImg::Where('sub_cat_id', $req->id)->where('slno', '1')->where('type', 'md')->first();
                if ($img != null) {
                    $status =  unlink($img->image);
                    if ($status) {
                        $status =   $img->delete();
                    }
                }
                $picName =  uniqid() . ".webp";

                Image::make($req->image->getRealPath())->resize('320', '180')->save($path . $picName);
                $img = new SubCategoryImg();
                $img->sub_cat_id = $req->id;
                $img->slno = '1';
                $img->type = "md";
                $img->image = $path . $picName;
                $status =  $img->save();

                $img = SubCategoryImg::Where('sub_cat_id', $req->id)->where('slno', '2')->where('type', 'lg')->first();
                if ($img != null) {
                    $status =  unlink($img->image);
                    if ($status) {
                        $status =   $img->delete();
                    }
                }

                $picName =  uniqid() . ".webp";
                Image::make($req->image->getRealPath())->resize('480', '360')->save($path . $picName);
                $img = new SubCategoryImg();
                $img->sub_cat_id = $req->id;
                $img->slno = '2';
                $img->type = "lg";
                $img->image = $path . $picName;
                $status =  $img->save();
            }
            if ($status) {
                return redirect()->back()->with('success', 'Data updated successfully !');
            } else {
                return redirect()->back()->with('error', 'Error, try again later.');
            }
        } else {
            return redirect()->back()->with('error', 'Error, try again later.');
        }
    }
    public function status(Request $req)
    {
        $item = SubCategory::Where('id', $req->id)->first();
        if ($item->status == '1') {
            $item->status = "0";
            $status = $item->update();
            if ($status) {

                return  ApiRes::success('Status Changed Successfully ! ');
            } else {
                return  ApiRes::error();
            }
        } else {
            $item->status = "1";
            $status = $item->update();
            if ($status) {

                return  ApiRes::success('Status Changed Successfully ! ');
            } else {
                return  ApiRes::error();
            }
        }
    }
    public function delete(Request $req)
    {
        $path = './';
        $img = SubCategoryImg::where('sub_cat_id', $req->id)->where('slno', '1')->where('type', 'md')->first();
        if ($img != null) {
            unlink($path . $img->image);
        }
        $img = SubCategoryImg::where('sub_cat_id', $req->id)->where('slno', '1')->where('type', 'lg')->first();
        if ($img != null) {
            unlink($path . $img->image);
        }
        $img = SubCategoryImg::where('sub_cat_id', $req->id)->where('slno', '2')->where('type', 'md')->first();
        if ($img != null) {
            unlink($path . $img->image);
        }
        $img = SubCategoryImg::where('sub_cat_id', $req->id)->where('slno', '2')->where('type', 'lg')->first();
        if ($img != null) {
            unlink($path . $img->image);
        }


        $status = SubCategoryImg::where('sub_cat_id', $req->id)->delete();
        $status = SubCategory::Where('id', $req->id)->first()->delete();

        if ($status) {
            return ApiRes::success("Data Deleted Successfullly !");
        } else {
            return ApiRes::error();
        }
    }
}
