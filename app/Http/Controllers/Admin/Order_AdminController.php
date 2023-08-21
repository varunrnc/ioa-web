<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Helpers\Classes\EasyData;
use App\Helpers\Classes\EasyImage;
use App\Models\Product;
use App\Models\Category;
use App\Models\Order;
use App\Models\Address;
use App\Models\InvoiceAddress;
use App\Models\Payment;
use App\Models\PlacedOrder;
use App\Http\Controllers\PaymentController;
use App\Mail\SendTrackingId;
use App\Mail\SendInvoice;
use Illuminate\Support\Facades\Mail;
use Hpx;
use PDF;



class Order_AdminController extends Controller
{
    // ======== Settings ===========
    public $image_width = '';
    public $image_height = '';
    public $dir_name = 'order';
    public $msg_txt = 'Order';
    // ======== End Settings ===========

    public function index(Request $request)
    {
        $data_list = PlacedOrder::orderBy('id','DESC');
        if(!empty($request->q)){
            $search = $request->q;
            $data_list->where(function($query) use ($search){
                $query->where('username','LIKE','%'.$search.'%');
                $query->orWhere('invoice_no','LIKE','%'.$search.'%');
            });
        }
        $data_list = $data_list->paginate(5);
        return view('admin.'.$this->dir_name.'.index',compact('data_list'));
    }


    public function create()
    {
        $categories = Category::all();
        return view('admin.'.$this->dir_name.'.create',compact('categories'));
    }


    public function store(Request $request)
    {

        if($request->action == 'SEND_INVOICE'){
            $x = new EasyData;
            $x->request = $request;
            $order = PlacedOrder::find($request->id);
            $order_list = !empty($order) ? Order::where('invoice_no',$order->invoice_no)->get() : null;
            if(!empty($order_list) and $order_list->count() > 0){                
                $address = InvoiceAddress::find($order->address_id);
                $pdf_name = $order->invoice_no.'.pdf';
                $pdf = PDF::loadView('admin.'.$this->dir_name.'.invoice',compact('order','order_list','address'))->output();
                Mail::to('jisvishalkumar@gmail.com')->send(new SendInvoice(compact('order','pdf','pdf_name')));
                $x->status(true);
                $x->message('Invoice has been sent.');
            }else{ $x->message('Order not found..!'); }
            return $x->json_output();
        }

        if($request->action == 'TRACKING_ID'){
            $x = new EasyData;
            $x->request = $request;
            $x->model = $order = PlacedOrder::find($request->id);
            $x->vdata('id','required|integer');
            $x->vdata('tracking_id','required|string');
            if($x->validate()){
                if(!empty($x->model)){
                    $order->tracking_id = $request->tracking_id;                    
                    if($order->save()){
                        $mail = Mail::to('jisvishalkumar@gmail.com')->send(new SendTrackingId($order));
                        $x->status(true);
                        $x->message('Tracking ID Updated Successfully');
                    }
                }else{
                    $x->message('Something Error...!');
                }
            }
            return $x->json_output();
        }

        if($request->action == 'UPDATE_STATUS'){
            $x = new EasyData;
            $x->request = $request;
            $x->model = PlacedOrder::find($request->id);
            if(!empty($x->model)){
                if(!empty($request->status) and $request->status != 'on'){
                    $request->status = strtolower($request->status);
                    $s = $x->model->status;
                    if($s != 'completed' and $s != 'cancelled' and $s != 'refunded'){
                        $x->data('status','status','required|string');
                        if($x->save()){
                            $x->status(true);
                            $x->message('Status Updated Successfully');
                        }
                    }else{
                        $x->message('Action not allowed..!');
                    }
                }
            }else{
                $x->message('Something Error...!');
            }
            return $x->json_output();
        }

        if($request->action == 'DELETE'){
            $x = new EasyData;
            $x->request = $request;
            $x->model = Order::find($request->id);
            if(!empty($x->model)){
                $x->model->delete();
                $x->status(true);
                $x->message($this->msg_txt.' Deleted Successfully');
            }else{
                $x->message('Something Error...!');
            }
            return $x->json_output();
        }

        if($request->action == 'PAYMENT_STATUS'){
            $x = new EasyData;
            $x->request = $request;
            $x->vdata('payment_id','required|string');
            $data = '';

            if($x->validate()){
                $payment = Payment::where('payment_id',$request->payment_id)->orderBy('id','DESC')->first();
                if(!empty($payment)){
                    $placed_order = PlacedOrder::find($payment->placed_order_id);
                    if(!empty($placed_order)){

                        $px = new PaymentController;
                        $response = $px->getPaymentById($request->payment_id);
                        $response = json_encode($response->json());
                        $response = json_decode($response);

                        if(isset($response->status)){

                            $payment->status = $response->status;
                            $payment->refund_status = $response->refund_status;
                            $payment->amount_refunded = $response->amount_refunded;
                            $payment->captured = $response->captured;
                            $payment->save();

                            $placed_order->payment_status = $response->status;
                            $placed_order->save();
                            $data = $response->status;
                            $x->status(true);
                            $x->message('Payment Status updated.');

                        }else{ $x->message('Payment Error..!'); }
                    }else{
                        $x->message('Order does not exist...!');
                    }

                }else{
                    $x->message('Payment id not found..!');
                }
            }
            return $x->json_output(['data'=>$data]);
        }

        $ob = new EasyData;
        $ob->message('Invalid action type');
        return $ob->json_output();

    }

    public function edit($id)
    {
        $data = Order::find($id);
        $categories = Category::all();
        if(!empty($data)){
            return view('admin.'.$this->dir_name.'.edit',compact('data','categories'));
        }else{
            return abort('403','Id Not Found');
        }
    }

    public function show($id,Request $request){

        if(!empty($request->invoice) and !empty($id)){

            $order = PlacedOrder::find($id);
            $order_list = !empty($order) ? Order::where('invoice_no',$order->invoice_no)->get() : null;
            if(!empty($order_list) and $order_list->count() > 0){
                $address = InvoiceAddress::find($order->address_id);
            }else{ return abort('403','Order Not Found'); }

            if($request->invoice == 'order_details'){                
                return view('admin.'.$this->dir_name.'.order_details',compact('order','order_list','address'));
            }
            elseif($request->invoice == 'view'){
                return view('admin.'.$this->dir_name.'.invoice',compact('order','order_list','address'));
            }
            elseif($request->invoice == 'download'){
                $pdf = PDF::loadView('admin.'.$this->dir_name.'.invoice',compact('order','order_list','address'));
                return $pdf->download('INVOICE-'.$order->invoice_no.'.pdf');
            }elseif($request->invoice == 'stream'){
                $pdf = PDF::loadView('admin.'.$this->dir_name.'.invoice',compact('order','order_list','address'));
                return $pdf->stream();
            }
        }
        
        $order = PlacedOrder::find($id);
        $order_list = !empty($order) ? Order::where('invoice_no',$order->invoice_no)->get() : null;
        if(!empty($order_list) and $order_list->count() > 0){
            $address = InvoiceAddress::find($order->address_id);
            return view('admin.'.$this->dir_name.'.show',compact('order','order_list','address'));
        }else{
            return abort('403','Id Not Found');
        }
    }

}
