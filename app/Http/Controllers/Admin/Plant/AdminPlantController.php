<?php

namespace App\Http\Controllers\Admin\Plant;

use App\Helpers\ApiRes;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Plant;
use App\Models\PlantImg;
use App\Models\SubCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;



class AdminPlantController extends Controller
{
    public function index(Request $request)
    {
        $data_list = '';
        if (!empty($request->q)) {
            $search = $request->q;
            $data_list = Plant::where('title', 'LIKE', '%' . $search . '%')
                ->orWhere('category', 'LIKE', '%' . $search . '%');
        } else {
            $data_list = Plant::orderBy('id', 'DESC');
        }
        $data_list =   $data_list->with('img')->paginate(50);

        return view('admin.plant.index', compact('data_list'));
    }
    public function create()
    {
        $categories = Category::all();
        $subCat = SubCategory::all();
        return view('admin.plant.create', compact('categories', 'subCat'));
    }
    public function save(Request $req)
    {

        $req->validate([
            'title' => 'required|string|max:225',
            'short_description' => 'required|string|max:225',
            'regular_price' => 'required|numeric|not_in:0',
            'selling_price' => 'required|numeric|not_in:0',
            'category' =>  'required|string|max:225',
            'sub_category' =>  'required|string|max:225',
            'rating' => 'digits_between:1,5',
            'image1' => 'required|image|mimes:jpeg,jpg,png',

        ]);
        if ($req->category == "Fertilizer") {
            $req->validate([
                'unit' => 'required|string|max:225',
                'weight' => 'required|numeric|min:1',
            ]);
        }
        $pid = uniqid();
        $plant = new Plant();
        $plant->pid = $pid;
        $plant->title = $req->title;
        $plant->slug = Str::slug($req->title);
        $plant->short_description = $req->short_description;
        $plant->long_description = $req->long_description;
        $plant->unit = $req->unit;
        $plant->weight = $req->weight;
        $plant->regular_price = $req->regular_price;
        $plant->selling_price = $req->selling_price;
        $plant->discount = $req->discount;
        $plant->category = $req->category;
        $plant->sub_category = $req->sub_category;
        $plant->rating = $req->rating;
        $plant->status = $req->status;
        $status =  $plant->save();

        if ($status) {
            $path = 'public/img/plants/';
            if ($req->hasFile('image1')) {
                $req->validate([
                    'image1' => 'required|image|mimes:jpeg,jpg,png',
                ]);
                $picName =  uniqid() . ".webp";

                Image::make($req->image1->getRealPath())->resize('480', '360')->save($path . $picName);
                $img = new PlantImg();
                $img->pid = $pid;
                $img->slno = '1';
                $img->type = "md";
                $img->image = $path . $picName;
                $status =  $img->save();

                $picName =  uniqid() . ".webp";
                Image::make($req->image1->getRealPath())->resize('640', '480')->save($path . $picName);
                $img = new PlantImg();
                $img->pid = $pid;
                $img->slno = '1';
                $img->type = "lg";
                $img->image = $path . $picName;
                $status =  $img->save();
            }
            if ($req->hasFile('image2')) {
                $req->validate([
                    'image2' => 'required|image|mimes:jpeg,jpg,png',
                ]);
                $picName =  uniqid() . ".webp";
                Image::make($req->image2->getRealPath())->resize('480', '360')->save($path . $picName);
                $img = new PlantImg();
                $img->pid = $pid;
                $img->slno = '2';
                $img->type = "md";
                $img->image = $path . $picName;
                $status =  $img->save();

                $picName =  uniqid() . ".webp";
                Image::make($req->image2->getRealPath())->resize('640', '480')->save($path . $picName);
                $img = new PlantImg();
                $img->pid = $pid;
                $img->slno = '2';
                $img->type = "lg";
                $img->image = $path . $picName;
                $status =  $img->save();
            }
            if ($req->hasFile('image3')) {
                $req->validate([
                    'image3' => 'required|image|mimes:jpeg,jpg,png',
                ]);
                $picName =  uniqid() . ".webp";
                Image::make($req->image3->getRealPath())->resize('480', '360')->save($path . $picName);
                $img = new PlantImg();
                $img->pid = $pid;
                $img->slno = '3';
                $img->type = "md";
                $img->image = $path . $picName;
                $status =  $img->save();

                $picName =  uniqid() . ".webp";
                Image::make($req->image2->getRealPath())->resize('640', '480')->save($path . $picName);
                $img = new PlantImg();
                $img->pid = $pid;
                $img->slno = '3';
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
        $data = Plant::Where('id', $req->id)->with('imgmd')->first();
        $categories = Category::all();
        $subCat = SubCategory::all();
        if (!empty($data)) {
            return view('admin.plant.edit', compact('data', 'categories', 'subCat'));
        } else {
            return abort('403', 'Id Not Found');
        }
    }
    public function update(Request $req)
    {
        $req->validate([
            'title' => 'required|string|max:225',
            'short_description' => 'required|string|max:225',
            'regular_price' => 'required|numeric|not_in:0',
            'selling_price' => 'required|numeric|not_in:0',
            'category' =>  'required|string|max:225',
            'sub_category' =>  'required|string|max:225',
            'rating' => 'digits_between:1,5',

        ]);
        if ($req->category == "Fertilizer") {
            $req->validate([
                'unit' => 'required|string|max:225',
                'weight' => 'required|numeric|min:1',
            ]);
        }
        $plant =  Plant::Where('id', $req->id)->first();
        $plant->title = $req->title;
        $plant->slug = Str::slug($req->title);
        $plant->short_description = $req->short_description;
        $plant->long_description = $req->long_description;
        $plant->regular_price = $req->regular_price;
        $plant->selling_price = $req->selling_price;
        $plant->unit = $req->unit;
        $plant->weight = $req->weight;
        $plant->discount = $req->discount;
        $plant->category = $req->category;
        $plant->sub_category = $req->sub_category;
        $plant->rating = $req->rating;
        $plant->status = $req->status;
        $status =  $plant->update();

        if ($status) {
            $path = 'public/img/plants/';
            if ($req->hasFile('image1')) {
                $req->validate([
                    'image1' => 'required|image|mimes:jpeg,jpg,png',
                ]);
                $picName =  uniqid() . ".webp";
                $img = PlantImg::where('pid', $plant->pid)->where('slno', '1')->where('type', 'md')->first();
                if ($img != null) {
                    unlink($img->image);
                    $status =  $img->delete();
                }
                $img = PlantImg::where('pid', $plant->pid)->where('slno', '1')->where('type', 'lg')->first();
                if ($img != null) {
                    unlink($img->image);
                    $status =  $img->delete();
                }
                Image::make($req->image1->getRealPath())->resize('480', '360')->save($path . $picName);
                $img = new PlantImg();
                $img->pid = $plant->pid;
                $img->slno = '1';
                $img->type = "md";
                $img->image = $path . $picName;
                $status =  $img->save();

                $picName =  uniqid() . ".webp";
                Image::make($req->image1->getRealPath())->resize('640', '480')->save($path . $picName);
                $img = new PlantImg();
                $img->pid = $plant->pid;
                $img->slno = '1';
                $img->type = "lg";
                $img->image = $path . $picName;
                $status =  $img->save();
            }
            if ($req->hasFile('image2')) {
                $req->validate([
                    'image2' => 'required|image|mimes:jpeg,jpg,png',
                ]);
                $img = PlantImg::where('pid', $plant->pid)->where('slno', '2')->where('type', 'md')->first();
                if ($img != null) {
                    unlink($img->image);
                    $status =  $img->delete();
                }
                $img = PlantImg::where('pid', $plant->pid)->where('slno', '2')->where('type', 'lg')->first();
                if ($img != null) {
                    unlink($img->image);
                    $status =  $img->delete();
                }
                $picName =  uniqid() . ".webp";
                Image::make($req->image2->getRealPath())->resize('480', '360')->save($path . $picName);
                $img = new PlantImg();
                $img->pid = $plant->pid;
                $img->slno = '2';
                $img->type = "md";
                $img->image = $path . $picName;
                $status =  $img->save();

                $picName =  uniqid() . ".webp";
                Image::make($req->image2->getRealPath())->resize('640', '480')->save($path . $picName);
                $img = new PlantImg();
                $img->pid = $plant->pid;
                $img->slno = '2';
                $img->type = "lg";
                $img->image = $path . $picName;
                $status =  $img->save();
            }
            if ($req->hasFile('image3')) {
                $req->validate([
                    'image3' => 'required|image|mimes:jpeg,jpg,png',
                ]);
                $img = PlantImg::where('pid', $plant->pid)->where('slno', '3')->where('type', 'md')->first();
                if ($img != null) {
                    unlink($img->image);
                    $status =  $img->delete();
                }
                $img = PlantImg::where('pid', $plant->pid)->where('slno', '3')->where('type', 'lg')->first();
                if ($img != null) {
                    unlink($img->image);
                    $status =  $img->delete();
                }
                $picName =  uniqid() . ".webp";
                Image::make($req->image3->getRealPath())->resize('480', '360')->save($path . $picName);
                $img = new PlantImg();
                $img->pid = $plant->pid;
                $img->slno = '3';
                $img->type = "md";
                $img->image = $path . $picName;
                $status =  $img->save();

                $picName =  uniqid() . ".webp";
                Image::make($req->image2->getRealPath())->resize('640', '480')->save($path . $picName);
                $img = new PlantImg();
                $img->pid = $plant->pid;
                $img->slno = '3';
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
        $plant = Plant::Where('id', $req->id)->first();
        if ($plant->status == '1') {
            $plant->status = "0";
            $status = $plant->update();
            if ($status) {

                return  ApiRes::success('Status Changed Successfully ! ');
            } else {
                return  ApiRes::error();
            }
        } else {
            $plant->status = "1";
            $status = $plant->update();
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
        $img = PlantImg::where('pid', $req->id)->where('slno', '1')->where('type', 'md')->first();
        if ($img != null) {
            unlink($path . $img->image);
        }
        $img = PlantImg::where('pid', $req->id)->where('slno', '1')->where('type', 'lg')->first();
        if ($img != null) {
            unlink($path . $img->image);
        }
        $img = PlantImg::where('pid', $req->id)->where('slno', '2')->where('type', 'md')->first();
        if ($img != null) {
            unlink($path . $img->image);
        }
        $img = PlantImg::where('pid', $req->id)->where('slno', '2')->where('type', 'lg')->first();
        if ($img != null) {
            unlink($path . $img->image);
        }
        $img = PlantImg::where('pid', $req->id)->where('slno', '3')->where('type', 'md')->first();
        if ($img != null) {
            unlink($path . $img->image);
        }
        $img = PlantImg::where('pid', $req->id)->where('slno', '3')->where('type', 'lg')->first();
        if ($img != null) {
            unlink($path . $img->image);
        }

        $status = PlantImg::where('pid', $req->id)->delete();
        $status = Plant::Where('pid', $req->id)->first()->delete();

        if ($status) {
            return ApiRes::success("Product Deleted Successfullly !");
        } else {
            return ApiRes::error();
        }
    }
}
