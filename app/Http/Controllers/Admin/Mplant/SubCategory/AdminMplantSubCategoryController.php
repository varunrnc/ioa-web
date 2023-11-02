<?php

namespace App\Http\Controllers\Admin\Mplant\SubCategory;

use App\Helpers\ApiRes;
use App\Http\Controllers\Controller;
use App\Models\MplantCategory;
use App\Models\MplantSubCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Intervention\Image\Facades\Image;

class AdminMplantSubCategoryController extends Controller
{
    private  $path = 'public/img/mplant/sub-category/';
    public function index()
    {
        $data = MplantSubCategory::all();
        return view('admin.mplant.sub-category.index', compact('data'));
    }

    public function create()
    {
        $cat = MplantCategory::all();
        return view('admin.mplant.sub-category.create', compact('cat'));
    }
    public function save(Request $req)
    {
        $status = null;
        $req->validate([
            'category' => 'required|string|max:225',
            'sub_category' => 'required|string|max:225',
            'image' => 'required|image|mimes:jpeg,jpg,png',
        ]);
        $cate = new MplantSubCategory();
        $cate->category = $req->category;
        $cate->sub_category = $req->sub_category;
        $cate->description = $req->description;
        if ($req->hasFile('image')) {

            $picName1 =  uniqid() . ".webp";
            $picName2 =  uniqid() . ".webp";
            $imgSm = $this->path . $picName1;
            $imgLg = $this->path . $picName2;

            Image::make($req->image->getRealPath())->resize('480', '360')->save($imgSm);
            Image::make($req->image->getRealPath())->resize('640', '480')->save($imgLg);
            $cate->img_sm = $imgSm;
            $cate->img_lg = $imgLg;
        }
        $status = $cate->save();
        if ($status) {
            return redirect()->back()->with('success', 'Data saved successfully !');
        } else {
            return redirect()->back()->with('error', 'Error, try again later.');
        }
    }

    public function edit(Request $req)
    {
        $data = MplantSubCategory::where('id', $req->id)->first();
        $cat = MplantCategory::all();
        return view('admin.mplant.sub-category.edit', compact('data', 'cat'));
    }
    public function update(Request $req)
    {
        $obj = MplantSubCategory::where('id', $req->id)->first();
        $status = null;
        $req->validate([
            'category' => 'required|string|max:225',
            'sub_category' => 'required|string|max:225',

        ]);
        $obj->category = $req->category;
        $obj->sub_category = $req->sub_category;
        $obj->description = $req->description;
        $obj->status = $req->status;

        if ($req->hasFile('image')) {
            if ($obj->img_sm != null) {
                File::delete($obj->img_sm);
            }
            if ($obj->img_lg != null) {
                File::delete($obj->img_lg);
            }

            $picName1 =  uniqid() . ".webp";
            $picName2 =  uniqid() . ".webp";
            $imgSm = $this->path . $picName1;
            $imgLg = $this->path . $picName2;

            Image::make($req->image->getRealPath())->resize('480', '360')->save($imgSm);
            Image::make($req->image->getRealPath())->resize('640', '480')->save($imgLg);
            $obj->img_sm = $imgSm;
            $obj->img_lg = $imgLg;
        }
        $status = $obj->save();
        if ($status) {
            return redirect()->back()->with('success', 'Data updated successfully !');
        } else {
            return redirect()->back()->with('error', 'Error, try again later.');
        }
    }

    public function status(Request $req)
    {
        $obj = MplantSubCategory::Where('id', $req->id)->first();
        if ($obj->status == '1') {
            $obj->status = "0";
            $status = $obj->update();
            if ($status) {

                return  ApiRes::success('Status Changed Successfully ! ');
            } else {
                return  ApiRes::error();
            }
        } else {
            $obj->status = "1";
            $status = $obj->update();
            if ($status) {

                return  ApiRes::success('Status Changed Successfully ! ');
            } else {
                return  ApiRes::error();
            }
        }
    }
    public function delete(Request $req)
    {
        $obj = MplantSubCategory::Where('id', $req->id)->first();
        File::delete($obj->img_sm);
        File::delete($obj->img_lg);
        $status = $obj->delete();
        if ($status) {
            return  ApiRes::success('Data Deleted Successfully ! ');
        } else {
            return  ApiRes::error();
        }
    }
}
