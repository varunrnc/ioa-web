<?php

namespace App\Http\Controllers\Api\User;

use App\Helpers\ApiRes;
use App\Http\Controllers\Controller;
use App\Mail\WelcomeEmail;
use App\Models\User;
use App\Models\Userdetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\Facades\Image;

class ApiUserController extends Controller
{
    public function sendEmail()
    {
        $data = [
            'title' => 'Test Email',
            'body' => 'This is a Test Email'
        ];
        Mail::to('jisramkumarbedia@gmail.com')->send(new WelcomeEmail($data));
        return ApiRes::success('email sent');
    }

    public function data()
    {
        $data = Userdetail::where('uid', auth()->user()->uid)->get();
        return  ApiRes::data($data);
    }

    public function sendOTP(Request $req)
    {
        // 'mobile' => 'required|numeric|digits:10|unique:users',
        $validator = Validator::make($req->all(), [
            'mobile' => 'required|numeric|digits:10',
            'country_code' => 'required|string|max:255',
        ]);
        if ($validator->fails()) {
            $errors = $validator->errors();
            if ($errors->first('mobile')) {
                return ApiRes::failed($errors->first('mobile'));
            } elseif ($errors->first('country_code')) {
                return ApiRes::failed($errors->first('country_code'));
            }
        }
        $user = User::where('mobile', $req->mobile)->first();
        $uid = mt_rand(10000000, 99999999);
        if ($user == null) {
            $user = new User();
            $user->uid = $uid;
            $user->mobile = $req->mobile;
            $user->otp = "1234";
            $status = $user->save();
            $user = new  Userdetail();
            $user->uid = $uid;
            $user->dob = "1000-01-01";
            $user->country_code = $req->country_code;
            $user->mobile = $req->mobile;
            $status = $user->save();
            if ($status) {
                return ApiRes::success('OTP sent successfully.');
            } else {
                return ApiRes::error();
            }
        } else {
            $user->otp = "1234";
            $status =  $user->update();
            if ($status) {
                return ApiRes::success('OTP sent successfully.');
            } else {
                return ApiRes::error();
            }
        }
    }
    public function verfyOTP(Request $req)
    {
        $validator = Validator::make($req->all(), [
            'mobile' => 'required|numeric|digits:10',
            'otp' => 'required|numeric',
        ]);
        if ($validator->fails()) {
            $errors = $validator->errors();
            if ($errors->first('mobile')) {
                return ApiRes::failed($errors->first('mobile'));
            } elseif ($errors->first('otp')) {
                return ApiRes::failed($errors->first('otp'));
            }
        }
        $user  = User::Where('mobile', $req->mobile)->first();
        if ($user->otp == $req->otp) {
            $token = $user->createToken($user->mobile)->plainTextToken;

            return ApiRes::rlMsg("You login successfully !.", $user->uid, $token);
        } else {
            return ApiRes::failed("OTP not matched !.");
        }
    }
    public function update(Request $req)
    {
        $validator = Validator::make($req->all(), [
            'name' => 'required|string|max:255',
            'dob' => 'date_format:Y-m-d|before:today',
            'gender' => 'required|in:Male,Female',
            'email' => 'required|email|max:255',
            'city' => 'required|string|max:255',
            'state' => 'required|string|max:255',
            'country' => 'required|string|max:255',
            'pincode' => 'required|numeric|digits:6',

        ]);
        if ($validator->fails()) {
            $errors = $validator->errors();
            if ($errors->first('name')) {
                return ApiRes::failed($errors->first('name'));
            } elseif ($errors->first('dob')) {
                return ApiRes::failed($errors->first('dob'));
            } elseif ($errors->first('gender')) {
                return ApiRes::failed($errors->first('gender'));
            } elseif ($errors->first('email')) {
                return ApiRes::failed($errors->first('email'));
            } elseif ($errors->first('city')) {
                return ApiRes::failed($errors->first('city'));
            } elseif ($errors->first('state')) {
                return ApiRes::failed($errors->first('state'));
            } elseif ($errors->first('country')) {
                return ApiRes::failed($errors->first('country'));
            } elseif ($errors->first('pincode')) {
                return ApiRes::failed($errors->first('pincode'));
            }
        }
        $user = User::where('id', auth()->user()->id)->first();
        $user->name = $req->name;
        $user->email = $req->email;
        $status = $user->update();
        $user = Userdetail::where('uid', auth()->user()->uid)->first();
        $user->name = $req->name;
        $user->dob = $req->dob;
        $user->gender = $req->gender;
        $user->email = $req->email;
        $user->city = $req->city;
        $user->state = $req->state;
        $user->country = $req->country;
        $user->pincode = $req->pincode;

        $status = $user->update();
        if ($status) {
            return ApiRes::success('Profile updated successfully !');
        } else {
            return ApiRes::error();
        }
    }
    public function image(Request $req)
    {
        $validator = Validator::make($req->all(), [
            'image' => 'required|image|mimes:jpeg,jpg,png',

        ]);
        if ($validator->fails()) {
            $errors = $validator->errors();
            if ($errors->first('image')) {
                return ApiRes::failed($errors->first('image'));
            }
        }
        $path = 'public/img/user/';
        $picName1 =  uniqid() . ".webp";
        $picName2 =  uniqid() . ".webp";
        $imgSm = $path . $picName1;
        $imgLg = $path . $picName2;
        Image::make($req->image->getRealPath())->resize('480', '360')->save($imgSm);
        Image::make($req->image->getRealPath())->resize('640', '480')->save($imgLg);
        $user = Userdetail::where('uid', auth()->user()->uid)->first();
        $user->img_sm =  $imgSm;
        $user->img_lg =  $imgLg;
        $status = $user->update();
        if ($status) {
            return ApiRes::success('Profile updated successfully !');
        } else {
            return ApiRes::error();
        }
    }
}
