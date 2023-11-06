<?php

namespace App\Http\Controllers\Admin\Slider;

use App\Helpers\ApiRes;
use App\Http\Controllers\Controller;
use App\Models\MainSlider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Intervention\Image\Facades\Image;

class AdminSliderController extends Controller
{
    private $path = "public/img/slider/main/";
    public function index(Request $req)
    {

        $datalist = null;
        if ($req->q != null) {
            $datalist = MainSlider::orWhere('slider_name', 'LIKE', '%' . $req->q . '%')
                ->orWhere('title', 'LIKE', '%' . $req->q . '%');
            return view('admin.slider.main.index', compact('datalist'));
        } else {
            $datalist =  MainSlider::orderBy('order_no', 'ASC');
            $datalist = $datalist->paginate(50);
            return view('admin.slider.main.index', compact('datalist'));
        }
    }
    public function create()
    {
        return view('admin.slider.main.create');
    }
    public function save(Request $req)
    {

        $req->validate([
            'slider_name' => 'required|string|max:225',
            'title' => 'required|string|max:225',
            // 'image' => 'required|image|mimes:jpeg,jpg,png|max:2048',
        ]);
        $orderNo = MainSlider::max('order_no') + 1;
        $obj = new MainSlider();
        $obj->slider_name = $req->slider_name;
        $obj->title = $req->title;
        $obj->description = $req->description;
        $obj->button_name = $req->button_name;
        $obj->button_link = $req->button_link;
        $obj->order_no = $orderNo;
        $status = $obj->save();

        if ($req->hasFile('image')) {
            $picName1 =  uniqid() . ".webp";
            $picName2 =  uniqid() . ".webp";

            $imgSm = $this->path . $picName1;
            $imgLg = $this->path . $picName2;
            Image::make($req->image->getRealPath())->resize('640', '480')->save($imgSm);
            Image::make($req->image->getRealPath())->resize('1280', '720')->save($imgLg);

            $obj->img_sm =  $imgSm;
            $obj->img_lg =  $imgLg;
            $status = $obj->save();
        }





        if ($status) {
            return ApiRes::success("Data saved successfully !");
            // return redirect()->back()->with('success', 'Data saved successfully !');
        } else {
            return ApiRes::error();
            // return redirect()->back()->with('error', 'Error, try again later.');
        }
    }
    public function  edit(Request $req)
    {
        $data = MainSlider::Where('id', $req->id)->first();
        return view('admin.slider.main.edit', compact('data'));
    }
    public function  update(Request $req)
    {
        $req->validate([
            'slider_name' => 'required|string|max:225',
            'title' => 'required|string|max:225',

        ]);
        $obj = MainSlider::Where('id', $req->id)->first();
        $obj->slider_name = $req->slider_name;
        $obj->title = $req->title;
        $obj->description = $req->description;
        $obj->button_name = $req->button_name;
        $obj->button_link = $req->button_link;
        $status = $obj->update();
        if ($req->hasFile('image')) {
            $req->validate([
                'image' => 'required|image|mimes:jpeg,jpg,png',

            ]);
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
            Image::make($req->image->getRealPath())->resize('640', '480')->save($imgSm);
            Image::make($req->image->getRealPath())->resize('1280', '720')->save($imgLg);

            $obj->img_sm =  $imgSm;
            $obj->img_lg =  $imgLg;
            $status = $obj->update();
        }

        if ($status) {
            return redirect()->back()->with('success', 'Data updated successfully !');
        } else {
            return redirect()->back()->with('error', 'Error, try again later.');
        }
    }
    public function reorder(Request $req)
    {
        $obj = MainSlider::Where('id', $req->id)->first();
        $obj->order_no =  $req->order_no;
        $status =  $obj->update();
        $datalist =  MainSlider::where('order_no', '>', $req->order_no)->orderBy('order_no')->get();

        $i = $req->order_no;
        foreach ($datalist as $item) {
            $i++;
            $item->order_no = $i;
            $item->update();
        }

        if ($status) {
            return  ApiRes::success('Reordered Successfully ! ');
        } else {
            return  ApiRes::error();
        }
    }
    public function status(Request $req)
    {
        $obj = MainSlider::Where('id', $req->id)->first();
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
        $obj = MainSlider::where('id', $req->id)->first();
        if ($obj->img_sm != null) {
            File::delete($obj->img_sm);
        }
        if ($obj->img_lg != null) {
            File::delete($obj->img_lg);
        }
        $status = MainSlider::where('id', $req->id)->delete();
        if ($status) {

            return  ApiRes::success('Data Deleted Successfully ! ');
        } else {
            return  ApiRes::error();
        }
    }
}
