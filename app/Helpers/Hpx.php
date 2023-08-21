<?php
namespace App\Helpers;
use App\Models\OrderSetting;
use App\Models\Order;

class Hpx{

public static function order_status_list(){
    $status = array('placed','dispatched','completed','cancelled','refunded','payment pending','payment failed');
    return $status;
}

public static function twodigit($value='')
{
    return number_format((float)$value,'2','.','');
}

public static function total_amount($cart_id='',$amt_type='')
{
    $data = [];
    if(auth()->check()){
        $data = Order::where('uid',auth()->user()->uid)
        ->where('invoice_no',null)
        ->where('status','added')
        ->get();
    }
    if(!empty($cart_id)){
        $data_list = Order::where('cart_id',$cart_id)->get();
        if($data_list->count() > 0){
            $data = $data_list;
        }else{
            if(!empty($data)){
                $amt_type = $cart_id;
            }
        }
    }
    
    $sub_total = 0;
    $shipping_charge = 0;
    $shipping_amount = 0;
    $coupon_code = '';
    $coupon_discount = 0;
    $total_amount = 0;
    foreach($data as $row){
        $sub_total += ($row->selling_price*$row->quantity);
        $shipping_charge = $shipping_charge == 0 ? $row->shipping_charge : $shipping_charge;
        $shipping_amount += ($row->weight*$row->quantity)*$row->shipping_charge;        
        $coupon_discount = $coupon_discount == 0 ? $row->coupon_discount_price : $coupon_discount;
        $coupon_code = $row->coupon_code;
    }
    
    $total_amount = round(($sub_total+$shipping_amount)-$coupon_discount);

    if($amt_type == 'sub_total'){
        $total_amount = $sub_total;
    }
    if($amt_type == 'shipping_charge'){
        $total_amount = $shipping_charge;
    }
    if($amt_type == 'shipping_amount'){
        $total_amount = $shipping_amount;
    }
    if($amt_type == 'coupon_discount'){
        $total_amount = $coupon_discount;
    }
    if($amt_type == 'coupon_code'){
        $total_amount = $coupon_code;
    }
    
    return number_format((float)$total_amount,'2','.','');
}

public static function shipping_charge()
{
    $shipping_charge = OrderSetting::where('setting','shipping_charge')->first();
    if(!empty($shipping_charge)){
        return number_format((float)$shipping_charge->value,'2','.','');
    }else{
        return 0.00;
    }
}

public static function refresh_id($value='')
{
    $refresh_id = '';
    if(!empty($value)){
        $myfile = fopen("refresh_id.txt", "w+");
        fwrite($myfile, $value);
        fclose($myfile);
    }else{
        if(file_exists('refresh_id.txt')){
            return file_get_contents('refresh_id.txt');
        }else{
            $myfile = fopen("refresh_id.txt", "w+");
            fwrite($myfile, rand());
            fclose($myfile);
            return rand();
        }
    }
}

public static function mydate_month($date,$format=false){
    if($format == false){
        return date('d M Y',strtotime($date));
    }elseif ($format == 'date-time') {
        return date('d M Y h:i A',strtotime($date));
    }elseif ($format == 'time') {
        return date('h:i A',strtotime($date));
    }
}

public static function spinner($display='',$size='spinner-s1'){
    if(empty($display)){ $display = 'none'; }
    return '<span class="spinner-border '.$size.' loaderx" style="display:'.$display.';" role="status" aria-hidden="true"></span>';
}

public static function image_src($image_path,$dummy_path){
    $src = $dummy_path;
    if(file_exists($image_path)){
        if(is_dir($image_path) == false){
            $src = $image_path.'?'.self::refresh_id();
        }
    }
    return asset($src);
}

public static function discount_x($regular_price,$discount_price){
    if(!empty($regular_price) and !empty($discount_price)){
        return 100-round($discount_price/$regular_price*100);
    }
}


// ====================== Layouts =======================

public static function table_headings($th=[]){
    $i = 1;
    $html = '<thead class="cart__table--header"><tr class="cart__table--header__items">';
    foreach ($th as $heading) {
        $strx = explode(":", $heading);
        $cls = '';
        if(count($strx) > 1){ $heading = $strx[0]; $cls = $strx[1]; }
        $html .= '<th class="cart__table--header__list '.$cls.' th__'.$i.'">'.$heading.'</th>';
        $i++;
    }
    $html .= '</tr></thead>';
    return $html;
}

public static function table_data($txt='',$classes=''){
    return '<td class="cart__table--body__list '.$classes.'">'.$txt.'</td>';
}


public static function status_btn($id,$status_is){
    return '<label class="switchz">
              <input type="checkbox" onclick="change_status(this,'.$id.')" '.($status_is == 1 ? 'checked' : null).'>
              <span class="sliderz round"></span>
            </label>';
}

public static function edit_btn($href=''){
    return '<a class="btn btn-sm fs-4 btn-outline-secondary edit__btn" href="'.$href.'">Edit</a>';
}

public static function view_btn($href='',$target=''){
    return '<a class="btn btn-sm fs-4 px-3 btn-outline-secondary view__btn" target="'.$target.'" href="'.$href.'">View</a>';
}

public static function delete_btn($id){
    return '<a class="btn btn-sm btn-outline-danger fs-4 delete__btn" onclick="delete_id('.$id.')">Delete</a>';
}

public static function paginator($data_list,$eachside = 5){
    $prev_url = $data_list->previousPageUrl();
    $next_url = $data_list->nextPageUrl();
    $current_page = $data_list->currentPage();
    $current_url = $data_list->url($current_page);
    $url_list = $data_list->links()->getData()['elements'];
    $list = '';
    $i = 1;
    foreach ($url_list[0] as $url) {
        $list .= '<li class="pagination__list">'.($current_page == $i ? '<span class="pagination__item pagination__item--current">'.$i++.'</span>' : '<a href="'.$url.'" class="pagination__item link">'.$i++.'</a>').'</li>';
    }

    $paginator = '<div class="pagination__area bg__gray--color mt-0">
                    <nav class="pagination justify-content-center">
                            <ul class="pagination__wrapper d-flex align-items-center justify-content-center">
                                <li class="pagination__list">
                                    <a href="'.$prev_url.'" class="pagination__item--arrow  link ">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="22.51" height="20.443" viewBox="0 0 512 512">
                                            <path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="48" d="M244 400L100 256l144-144M120 256h292" />
                                        </svg>
                                        <span class="visually-hidden">page left arrow</span>
                                    </a>
                                <li>
                                '.$list.'
                                <li class="pagination__list">
                                    <a href="'.$next_url.'" class="pagination__item--arrow  link ">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="22.51" height="20.443" viewBox="0 0 512 512">
                                            <path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="48" d="M268 112l144 144-144 144M392 256H100" />
                                        </svg>
                                        <span class="visually-hidden">page right arrow</span>
                                    </a>
                                <li>
                            </ul>
                        </nav>
                    </div>';
    
    return $paginator;
}

}

?>
