<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Helpers\Classes\EasyData;
use App\Helpers\Classes\EasyImage;
use App\Models\Address;

class Address_ApiController extends Controller
{
    public $msg_txt = 'Address';

    public function index(Request $request)
    {
        if($request->action == 'GET'){
            $x = new EasyData;
            $x->status(true); 
            $x->message($this->msg_txt.' List');
            $uid = auth()->user()->uid;  
            $data = Address::where('uid',$uid)->orderBy('id','DESC');
            if(!empty($request->id)){ $data = $data->where('id',$request->id); }
            $data = $data->get();
            return $x->json_output(['data'=>$data]);
        }

        $ob = new EasyData;
        $ob->message('Invalid action type');
        return $ob->json_output();
    }

    public function store(Request $request)
    {        
        if($request->action == 'CREATE'){
            $x = new EasyData;
            $x->request = $request; 
            $x->model = new Address;
            $uid = auth()->user()->uid;
            $max_address = Address::where('uid',$uid)->get();
            if(intval($max_address->count()) < 4){
                $x->datax('uid',$uid);
                $x->data('name','name','required|string|max:30');
                $x->data('mobile','mobile','required|numeric|digits:10');
                $x->data('pincode','pincode','required|numeric|digits:6');
                $x->data('state','state','required|string|max:255'); 
                $x->data('city','city','required|string|max:100');
                $x->data('address_line_1','address_line_1','required|string|max:255');
                $x->data('address_line_2','address_line_2','required|string|max:255');
                $x->data('address_notes','address_notes','required|string|max:255');
                if($x->save()){
                    $x->status(true);
                    $x->message  ($this->msg_txt.' Added Successfully');
                }
            }else{ $x->message('Maximum 4 address can Add'); }
            return $x->json_output();
        }

        if($request->action == 'UPDATE'){
            $x = new EasyData;
            $x->request = $request;
            $uid = auth()->user()->uid;
            $x->model = Address::where('id',$request->id)->where('uid',$uid)->first();
            $data = '';
            if(!empty($x->model)){
                $x->data('name','name','required|string|max:30');
                $x->data('mobile','mobile','required|numeric|digits:10');
                $x->data('pincode','pincode','required|numeric|digits:6');
                $x->data('state','state','required|string|max:255');
                $x->data('city','city','required|string|max:100');
                $x->data('address_line_1','address_line_1','required|string|max:255');
                $x->data('address_line_2','address_line_2','required|string|max:255');
                $x->data('address_notes','address_notes','required|string|max:255');
                if($x->save()){
                    $data = Address::find($request->id);
                    $x->status(true);
                    $x->message($this->msg_txt.' Updated Successfully');
                }
            }else{
                $x->message('Something Error...!');
            }
            return $x->json_output(['data'=>$data]);
        }

        if($request->action == 'DELETE'){
            $x = new EasyData;
            $x->request = $request;
            $uid = auth()->user()->uid;
            $x->model = Address::where('id',$request->id)->where('uid',$uid)->first();
            if(!empty($x->model)){
                $x->model->delete();
                $x->status(true);
                $x->message($this->msg_txt.' Deleted Successfully');
            }else{
                $x->message('Something Error...!');
            }
            return $x->json_output();
        }
    }
}
