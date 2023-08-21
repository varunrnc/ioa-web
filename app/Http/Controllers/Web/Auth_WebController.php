<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Helpers\Classes\EasyData;

use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules;

class Auth_WebController extends Controller
{
    public function register(Request $request){
        $x = new EasyData;
        $x->request = $request;
        $x->vdata('name','required|string|max:35');
        $x->vdata('email','email|string|max:255|unique:users,email');
        $x->vdata('mobile','required|numeric|digits:10|unique:users,mobile');
        $x->vdata('password',['required','confirmed',Rules\Password::defaults()]);
        if($x->validate() == true){
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'mobile' => $request->mobile,
                'password' => Hash::make($request->password),
            ]);
            if(!empty($user)){
                    $userx = User::find($user->id);
                    $userx->uid = date('ymd').$user->id;
                    if($userx->save()){
                        event(new Registered($user));
                        Auth::login($user);
                        $x->status(true);
                        $x->message('Registered in Successfully.');
                    }
            }
        }
        return $x->json_output();
    }

    public function login(Request $request){
        $x = new EasyData;
        $x->request = $request;
        $x->vdata('email_or_mobile','string|max:255');
        $x->vdata('password','required|string');
        $x->message('Invalid User or Password.');
        if($x->validate() == true){
            $user = User::where('email',$request->email_or_mobile)->orWhere('mobile',$request->email_or_mobile)->first();
            if(!empty($user)){
                if (Hash::check($request->password, $user->password)) {
                    $remember = $request->remember == true ? true : false;
                    Auth::login($user,$remember);
                    $x->status(true);
                    $x->message('Logged in Successfully');
                }
            }
        }
        return $x->json_output();
    }

    public function logout(Request $request)
    {
        $x = new EasyData;
        Auth::guard('web')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        $x->status(true);
        $x->message('Logout Successfully.');
    }
}
