<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Helpers\Classes\EasyData;
use App\Models\Payment;
use Illuminate\Support\Facades\Http;
use Hpx;

class PaymentController extends Controller
{
    private $key_id = 'rzp_test_bFEm9cZq6J8nAJ';
    private $key_secret = 'uUQdcIRURoUiwezYTojpqF3M';

    public function getPaymentById($payment_id=''){
        $data = false;
        if(!empty($payment_id)){
            $response = Http::withBasicAuth($this->key_id, $this->key_secret)
            ->get('https://api.razorpay.com/v1/payments/'.$payment_id);
            $data = $response;
        }
        return $data;
    }
}
