<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Helpers\Classes\EasyData;
use App\Helpers\Classes\EasyImage;
use App\Models\Product;
use App\Models\Order;
use App\Models\Address;
use App\Models\InvoiceAddress;
use App\Models\PlacedOrder;
use App\Models\Payment;
use Hpx;

use Razorpay\Api\Api;

class Order_ApiController extends Controller
{

    public $dir_name = 'product';
    public $msg_txt = 'Product';

    public function index(Request $request)
    {

        if ($request->action == 'ORDER_LIST') {
            $x = new EasyData;
            $x->status(true);
            $x->message('Order List');
            $uid = auth()->user()->uid;
            $data = PlacedOrder::where('uid', $uid)
                ->orderBy('id', 'DESC')->get();
            return $x->json_output(['data' => $data]);
        }

        if ($request->action == 'ORDER_DETAILS') {

            $x = new EasyData;
            $x->request = $request;
            $x->vdata('id', 'required');
            $uid = auth()->user()->uid;

            $order = '';
            $order_list = '';
            $address = '';
            $payment = '';
            $total_amount = 0;
            $shipping_charge = 0;

            if ($x->validate()) {
                $order = PlacedOrder::find($request->id);
                if (!empty($order)) {
                    $order_list = Order::where('cart_id', $order->cart_id)
                        ->where('status', '!=', 'added')
                        ->orderBy('id', 'DESC')
                        ->get();
                    $address = InvoiceAddress::find($order->address_id);
                    $payment = Payment::where('placed_order_id', $order->id)
                        ->orderBy('id', 'DESC')
                        ->first();
                    $total_amount = Hpx::total_amount($order->cart_id);
                    $shipping_charge = Hpx::total_amount('shipping_charge');
                }

                $x->status(true);
                $x->message('Order Details');
            }
            return $x->json_output([
                'data' => [
                    'order' => $order,
                    'order_list' => $order_list,
                    'address' => $address,
                    'payment' => $payment,
                    'total_amount' => $total_amount,
                    'shipping_charge' => $shipping_charge
                ]
            ]);
        }

        if ($request->action == 'CART_LIST') {
            $x = new EasyData;
            $x->message('Cart List');
            $x->status(true);
            $uid = auth()->user()->uid;
            $data = Order::where('uid', $uid)
                ->where('invoice_no', null)
                ->where('status', 'added')
                ->orderBy('id', 'DESC')
                ->get();

            $address = '';
            // Get or Update Delivery Address
            if ($data->count() > 0) {
                $delivery = Address::find($data->first()->address_id ?? 0);
                if (!empty($data->first()->address_id) and !empty($delivery) and $data->first()->uid == $uid) {
                    $address = $delivery;
                } else {
                    $first_address = Address::where('uid', $uid)->first();
                    if (!empty($first_address)) {
                        $address = $first_address;
                        Order::where('uid', $uid)
                            ->where('invoice_no', null)
                            ->where('status', 'added')
                            ->update(['address_id' => $address->id]);
                        // fetch updated Cart List
                        $data = Order::where('uid', $uid)
                            ->where('invoice_no', null)
                            ->where('status', 'added')
                            ->orderBy('id', 'DESC')
                            ->get();
                    }
                }
            }

            // Calculate total price
            return $x->json_output([
                'data' => $data,
                'other_data' => [
                    'cart_count' => $data->count(),
                    'sub_total' => Hpx::total_amount('sub_total'),
                    'shipping_charge' => Hpx::total_amount('shipping_charge'),
                    'shipping_amount' => Hpx::total_amount('shipping_amount'),
                    'coupon_code' => Hpx::total_amount('coupon_code'),
                    'coupon_discount' => Hpx::total_amount('coupon_discount'),
                    'total_amount' => Hpx::total_amount(),
                    'address' => $address
                ]
            ]);
        }

        if ($request->action == 'CART_COUNT') {
            $x = new EasyData;
            $x->status(true);
            $x->message('Cart count');
            $uid = auth()->user()->uid;
            $data = Order::where('uid', $uid)
                ->where('invoice_no', null)
                ->where('status', 'added')
                ->orderBy('id', 'DESC')
                ->get();
            $data = $data->count();
            return $x->json_output(['data' => $data]);
        }

        $ob = new EasyData;
        $ob->message('Invalid action type');
        return $ob->json_output();
    }

    public function store(Request $request)
    {
        // Update Delivery Address Id
        if ($request->action == 'UPDATE_ADDRESS_ID') {
            $x = new EasyData;
            $x->request = $request;
            $x->vdata('address_id', 'required|integer');
            $uid = auth()->user()->uid;
            if ($x->validate()) {
                $data = Order::where('uid', $uid)
                    ->where('invoice_no', null)
                    ->where('status', 'added')
                    ->update(['address_id' => $request->address_id]);
                $x->status(true);
            }
            return $x->json_output();
        }

        // Order Status - added | cancelled | ordered
        if ($request->action == 'ADD_TO_CART') {
            $x = new EasyData;
            $x->request = $request;
            $x->model = new Order;
            $uid = auth()->user()->uid;
            $product = Product::find($request->id);
            $is_added = Order::where('product_id', $request->id)
                ->where('uid', $uid)
                ->where('status', 'added')
                ->first();

            if (!empty($product)) {
                if (empty($is_added)) {
                    $x->datax('uid', $uid);
                    $x->datax('product_id', $request->id);
                    $x->datax('product_name', $product->title);
                    $x->datax('image1', $product->image1);
                    $x->datax('image2', $product->image2);
                    $x->datax('image3', $product->image3);
                    $x->datax('regular_price', $product->regular_price);
                    $x->datax('selling_price', $product->selling_price);
                    $x->datax('discount', Hpx::discount_x($product->regular_price, $product->selling_price));
                    $x->datax('quantity', 1);
                    $x->datax('weight', $product->weight);
                    $x->datax('shipping_charge', $product->shipping_charge);
                    $x->datax('status', 'added');
                    if ($x->save()) {
                        $x->status(true);
                        $x->message($this->msg_txt . ' Added Successfully');
                    }
                } else {
                    $x->message('Product already added in your cart.');
                }
            } else {
                $x->message('Something Error...!');
            }
            return $x->json_output();
        }

        if ($request->action == 'REMOVE_FROM_CART') {
            $x = new EasyData;
            $x->request = $request;
            $uid = auth()->user()->uid;
            $x->model = Order::where('uid', $uid)->where('id', $request->id)->first();
            if (!empty($x->model)) {
                $x->model->delete();
                $x->status(true);
                $x->message($this->msg_txt . ' Removed Successfully');
            } else {
                $x->message('Something Error...!');
            }
            return $x->json_output();
        }

        // Click on Buy Button --> Validate Order & Address | Initialize Payment
        if ($request->action == 'BUY_CART_LIST') {
            $x = new EasyData;
            $x->request = $request;
            $x->model = new PlacedOrder;
            $uid = auth()->user()->uid;
            $username = auth()->user()->name;
            $pay_id = '';
            $total_amount = Hpx::total_amount();
            $orders = Order::where('uid', $uid)
                ->where('invoice_no', null)
                ->where('status', 'added')
                ->orderBy('id', 'ASC')->get();

            // Check delivery address
            $address = Address::where('uid', $uid)
                ->where('id', $request->address_id)->first();
            $response = '';
            $order_id = '';
            if ($orders->count() > 0) {
                if (!empty($address)) {
                    if (!empty($username)) {

                        $cart_id = 'CART' . str_pad($orders->first()->id, 5, "0", STR_PAD_LEFT);
                        foreach ($orders as $order) {
                            $ord = Order::find($order->id);
                            $ord->cart_id = $cart_id;
                            $ord->save();
                        }

                        // Save / Update Address for Invoice
                        $adx = InvoiceAddress::where('cart_id', $cart_id)->first();
                        if (empty($adx)) {
                            $adx = new InvoiceAddress;
                        }
                        $adx->uid = $address->uid;
                        $adx->cart_id = $cart_id;
                        $adx->name = $address->name;
                        $adx->mobile = $address->mobile;
                        $adx->pincode = $address->pincode;
                        $adx->state = $address->state;
                        $adx->city = $address->city;
                        $adx->address_line_1 = $address->address_line_1;
                        $adx->address_line_2 = $address->address_line_2;
                        $adx->address_notes = $address->address_notes;
                        $adx->save();

                        // Initialize New Payment
                        $api = new Api(env('RAZORPAY_KEY'), env('RAZORPAY_SECRET'));
                        $response = $api->order->create(array(
                            'receipt' => $cart_id,
                            'amount' => $total_amount*100,
                            'currency' => 'INR',
                            'notes' => array('uid' => $uid, 'cart_id' => $cart_id)
                        ));

                        if(!empty($response->id) and isset($response->id)){
                            $pay = new EasyData;
                            $pay->request = $request;
                            $pay->model = new Payment;
                            $pay->datax('uid', $uid);
                            $pay->datax('cart_id', $cart_id);
                            $pay->datax('order_id', $response->id);
                            $pay->datax('amount', $response->amount);
                            $pay->datax('status', 'created');
                            $pay->datax('address_id', $adx->id);
                            if ($pay->save()) {
                                $pay_id = $pay->saved_id;
                                $x->status(true);
                                $x->message($response);
                            }
                            $total_amount = $response->amount;
                            $order_id = $response->id;
                        }else{
                            $x->message('Order Creation Failed..!');
                        }
                    } else {
                        $x->message('Please Update your Profile info.');
                    }
                } else {
                    $x->message('Invalid delivery address..!');
                }
            } else {
                $x->message('Your cart is empty..!');
            }
             $x->message('ok');
            return $x->json_output([
                'data' => ['total_amount' => $total_amount, 'pay_id' => $pay_id, 'order_id' => $order_id],
            ]);
        }

        // Cart List to ---> Place Order
        if ($request->action == 'PAYMENT_STATUS'){
            $x = new EasyData;
            $x->request = $request;
            $x->model = $pay = Payment::find($request->pay_id);
            $uid = auth()->user()->uid;
            $username = auth()->user()->name;

            if (!empty($x->model) and !empty($request->payment_id)) {

                // Check Payment Status By Order Id
                $api = new Api(env('RAZORPAY_KEY'), env('RAZORPAY_SECRET'));
                $response = $api->payment->fetch($request->payment_id);

                if (!empty($response->id) and isset($response->id)) {
                    if ($response->status != 'failed') {
                        if (empty($pay->payment_id)) {

                            $x->data('placed_order_id', 'pay_id', 'required|integer');
                            $x->datax('payment_id', $response->id);
                            $x->datax('amount', $response->amount);
                            $x->datax('status', $response->status);
                            $x->datax('order_id', $response->order_id);
                            $x->datax('method', $response->method);
                            $x->datax('amount_refunded', $response->amount_refunded);
                            $x->datax('refund_status', $response->refund_status);
                            $x->datax('captured', $response->captured);
                            $x->datax('description', $response->description);
                            $x->datax('email', 'email', $response->email);
                            $x->datax('contact', $response->contact);

                            if ($x->save()) {

                                // Place New Order After Payment Success
                                $po = new EasyData;
                                $po->request = $request;
                                $po->model = new PlacedOrder;
                                $po->datax('uid', $uid);
                                $po->datax('username', $username);
                                $po->datax('order_title', 'Order #' . $response->id);
                                $po->datax('total_amount', $response->amount);
                                $po->datax('address_id', $pay->address_id);
                                $po->datax('payment_status', $response->status);
                                $po->datax('payment_id', $response->id);
                                $po->datax('status', 'placed');
                                if ($po->save()) {

                                    $orders = Order::where('uid', $uid)
                                        ->where('invoice_no', null)
                                        ->where('status', 'added')
                                        ->orderBy('id', 'DESC')->get();

                                    // Create Invoice No.
                                    $invoice_no = 'IOA' . str_pad($po->saved_id, 5, "0", STR_PAD_LEFT);

                                    // Update Invoice no. in PlacedOrder Table
                                    $pc_ord = PlacedOrder::find($po->saved_id);
                                    $pc_ord->invoice_no = $invoice_no;
                                    $pc_ord->cart_id = $orders->first()->cart_id;
                                    $pc_ord->save();

                                    // Update Invoice no. in Order Table
                                    foreach ($orders as $order) {
                                        $ord = Order::find($order->id);
                                        $ord->invoice_no = $invoice_no;
                                        $ord->status = 'placed';
                                        $ord->save();
                                    }
                                    $x->status(true);
                                    $x->message('Order Placed Successfully');
                                }
                            }
                        } else {
                            $x->message('Action not allowed..!');
                        }
                    } else {
                        $x->message('Payment Failed..!');
                    }
                } else {
                    $x->message('Payment Error..!');
                }
            } else {
                $x->message('Something Error...!');
            }
            return $x->json_output();
        }


        if ($request->action == 'UPDATE_QUANTITY') {
            $x = new EasyData;
            $x->request = $request;
            $x->model = Order::find($request->id);
            $data = '';
            if (!empty($x->model)) {
                $x->data('quantity', 'quantity', 'required|numeric|min:1');
                if ($x->save()) {
                    $data = $x->model->quantity;
                    $x->status(true);
                    $x->message($this->msg_txt . ' Quantity Updated Successfully');
                }
            } else {
                $x->message('Something Error...!');
            }
            return $x->json_output(['quantity' => $data]);
        }

        if ($request->action == 'UPDATE_COUPON_CODE') {
            $x = new EasyData;
            $x->request = $request;
            $uid = auth()->user()->uid;
            $x->vdata('coupon_code', 'required|string|max:10');
            // validate Coupon Code
            // After that Submit Code and and discount price
            if ($x->validate()) {
                $upd = Order::where('uid', $uid)
                    ->where('invoice_no', null)
                    ->where('status', 'added')->update(['coupon_code' => $request->coupon_code, 'coupon_discount_price' => 100]);
                $x->status(true);
                $x->message('Coupon Code Applied Successfully');
            }
            return $x->json_output();
        }

        $ob = new EasyData;
        $ob->message('Invalid action type');
        return $ob->json_output();
    }
}
