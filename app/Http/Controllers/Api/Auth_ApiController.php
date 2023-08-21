<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Helpers\Classes\EasyData;

class Auth_ApiController extends Controller
{
    public function login(Request $request){
        $x = new EasyData;
        $x->request = $request;
        $x->vdata('mobile',['required', 'numeric', 'digits:10']);
        $token = '';
        $uidx = '';
        $exist = false;
        if($x->validate() == true){
            $user = User::where('mobile', $request->mobile)->first();
            if (!empty($user) and $user->mobile == $request->mobile){
                $user->otp = 1234;
                $user->save();
                $uidx = $user->uid;
                $exist = true;
            }else{
                // if User not registered
                $userx = new User;
                $userx->mobile = $request->mobile;
                $userx->status = 'unverified';
                $userx->otp = 1234;
                if($userx->save()){
                    $user = User::find($userx->id);
                    $user->uid = $uidx = date('ymd').$userx->id;
                    $user->save();
                }
            }
            if(!empty($user)){
                $token = $user->createToken($request->mobile)->plainTextToken;
                $x->status(true);
                $x->message('Login Initiated');
            }
        }
        return $x->json_output(['uid'=>$uidx,'token'=>$token, 'exist'=>$exist]);
    }

    public function logout(Request $request){
        $x = new EasyData;
        $uidx = '';
        if(Auth::check()){
            $uidx = $x->uid();
            $request->user()->currentAccessToken()->delete();
            $x->status(true);
            $x->message('Logout Successfully');
        }
        return $x->json_output(['uid'=>$uidx]);
    }

    public function verify_otp(Request $request){
        $otp = auth()->user()->otp;
        $x = new EasyData;
        $x->request = $request;
        $x->vdata('otp','required|numeric');
        if($x->validate() == true){
            if(1234 == $request->otp){
                User::where('id',auth()->user()->id)->update(['otp'=>null,'status'=>'verified']);
                $x->status(true);
                $x->message('OTP Verified');
            }else{
                $x->message('Invalid OTP');
            }
        }
        return $x->json_output();
    }
}
