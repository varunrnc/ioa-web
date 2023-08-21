<?php
namespace App\Helpers\Classes;

class HpxString{

	public static function maxChar($string_val,$max,$last_string = ""){
        $retn_string = $string_val;
        if (strlen($string_val) > $max) {
            $stringCut = substr($string_val, 0, $max);
            $endPoint = strrpos($stringCut, ' ');
            $retn_string = $endPoint? substr($stringCut, 0, $endPoint) : substr($stringCut, 0);
            $retn_string .= $last_string;
        }
        return $retn_string;
    }

    public static function getUid($uid_type = ''){
        $retn_value = date('YmdHis').rand(101,999);
        return $retn_value;
    }
    
}

?>