<?php

namespace App\Http\Controllers\Admin\Mplant;

use App\Helpers\ApiRes;
use App\Http\Controllers\Controller;
use App\Models\Mplant;
use App\Models\MplantCategory;
use App\Models\MplantSubCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Intervention\Image\Facades\Image;


class AdminMplantController extends Controller
{
    private  $iconPath = 'public/img/mplant/icon/';
    private  $imgPath = 'public/img/mplant/';
    public function index()
    {
        $data = Mplant::latest()->get();
        return view('admin.mplant.index', compact('data'));
    }
    public function create()
    {
        $cat = MplantCategory::all();
        return view('admin.mplant.create', compact('cat'));
    }
    public function category(Request $req)
    {
        $data =   MplantSubCategory::where('category', $req->category)->get("sub_category");
        return ApiRes::data($data);
    }
    public function save(Request $req)
    {
        $req->validate([
            'title' => 'required|string|max:225',
            'category' => 'required|string|max:225',
            'sub_category' => 'required|string|max:225',
            // 'image1' => 'required|image|mimes:jpeg,jpg,png',
            // 'image2' => 'required|image|mimes:jpeg,jpg,png',
        ]);

        $obj = new Mplant();
        $obj->title = $req->title;
        $obj->category = $req->category;
        $obj->sub_category = $req->sub_category;
        $obj->description = $req->description;
        $obj->soil = $req->soil;
        $obj->time_of_showing = $req->time_of_showing;
        $obj->watering = $req->watering;
        $obj->fertilizer_requirement = $req->fertilizer_requirement;
        $obj->pest_and_diseases = $req->pest_and_diseases;
        $obj->special_care = $req->special_care;
        $obj->status = $req->status;
        $status = $obj->save();

        if ($req->hasFile('image1')) {

            $req->validate([

                'image1' => 'required|image|mimes:jpeg,jpg,png',

            ]);

            $picName =  uniqid() . ".webp";
            Image::make($req->image1->getRealPath())->resize('512', '512')->save($this->iconPath . $picName);
            $obj->icon = $this->iconPath . $picName;
            $status = $obj->save();
        }
        if ($req->hasFile('image2')) {
            $req->validate([

                'image2' => 'required|image|mimes:jpeg,jpg,png',

            ]);
            $picName =  uniqid() . ".webp";
            Image::make($req->image2->getRealPath())->resize('640', '480')->save($this->imgPath . $picName);
            $obj->img = $this->imgPath . $picName;
            $status = $obj->save();
        }

        if ($status) {
            return redirect()->back()->with('success', 'Data saved successfully !');
        } else {
            return redirect()->back()->with('error', 'Error, try again later.');
        }
    }
    public function edit(Request $req)
    {
        $data = Mplant::where('id', $req->id)->first();
        $cat = MplantCategory::all();
        $subcat = MplantSubCategory::all();
        return view('admin.mplant.edit', compact('data', 'cat', 'subcat'));
    }
    public function update(Request $req)
    {
        $req->validate([
            'title' => 'required|string|max:225',
            'category' => 'required|string|max:225',
            'sub_category' => 'required|string|max:225',
            // 'image1' => 'required|image|mimes:jpeg,jpg,png',
            // 'image2' => 'required|image|mimes:jpeg,jpg,png',
        ]);
        $obj = Mplant::where('id', $req->id)->first();
        $obj->title = $req->title;
        $obj->category = $req->category;
        $obj->sub_category = $req->sub_category;
        $obj->description = $req->description;
        $obj->soil = $req->soil;
        $obj->time_of_showing = $req->time_of_showing;
        $obj->watering = $req->watering;
        $obj->fertilizer_requirement = $req->fertilizer_requirement;
        $obj->pest_and_diseases = $req->pest_and_diseases;
        $obj->special_care = $req->special_care;
        $obj->status = $req->status;
        $status = $obj->update();
        if ($req->hasFile('image1')) {
            File::delete($obj->icon);
            $picName =  uniqid() . ".webp";
            Image::make($req->image1->getRealPath())->resize('512', '512')->save($this->iconPath . $picName);
            $obj->icon = $this->iconPath . $picName;
            $status = $obj->update();
        }
        if ($req->hasFile('image2')) {

            File::delete($obj->img);

            $picName =  uniqid() . ".webp";
            Image::make($req->image2->getRealPath())->resize('640', '480')->save($this->imgPath . $picName);
            $obj->img = $this->imgPath . $picName;
            $status = $obj->update();
        }

        if ($status) {
            return redirect()->back()->with('success', 'Data updated successfully !');
        } else {
            return redirect()->back()->with('error', 'Error, try again later.');
        }
    }
    public function status(Request $req)
    {
        $obj = Mplant::Where('id', $req->id)->first();
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
        $obj = Mplant::Where('id', $req->id)->first();
        unlink($obj->icon);
        unlink($obj->img);
        $status = $obj->delete();
        if ($status) {
            return  ApiRes::success('Data Deleted Successfully ! ');
        } else {
            return  ApiRes::error();
        }
    }
}
