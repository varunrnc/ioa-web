<?php

namespace App\Helpers;

class ApiRes
{
    public static function invalidAction()
    {

        return response()->json(["status" => false, "message" => "Invalid action type"]);
    }
    public static function invalidUser()
    {
        return response()->json(["status" => false, "message" => "Invalid user"]);
    }
    public static function credentials()
    {

        return response()->json(["status" => false, "message" => "Invalid login credentials"]);
    }
    public static function error()
    {
        return response()->json(["status" => false, "message" => "Error ! please try again later."]);
    }
    public static function failed($msg)
    {

        return response()->json(["status" => false, "message" => $msg]);
    }
    public static function inactiveUser()
    {
        return response()->json(["status" => false, "message" => "Account deactived !"]);
    }
    public static function rlMsg($msg, $token)
    {
        return response()->json(["status" => true, "message" => $msg,  "token" => $token]);
    }
    public static function data($msg, $data)
    {
        return response()->json(["status" => true, "message" => $msg, "data" => $data]);
    }
    public static function otp($msg, $otp)
    {

        return response()->json(["status" => true, "message" => $msg, "otp" => $otp]);
    }
    public static function success($msg)
    {

        return response()->json(["status" => true, "message" => $msg]);
    }
    public static function logout()
    {

        return response()->json(["status" => true, "message" => "You logout successfully !"]);
    }
    public static function exception($msg)
    {

        return response()->json(["status" => false, "message" => $msg]);
    }

    public static function IndMoneyFormat($money)
    {

        $decimal = (string)($money - floor($money));
        $money = floor($money);
        $length = strlen($money);
        $m = '';
        $money = strrev($money);
        for ($i = 0; $i < $length; $i++) {
            if (($i == 3 || ($i > 3 && ($i - 1) % 2 == 0)) && $i != $length) {
                $m .= ',';
            }
            $m .= $money[$i];
        }
        $result = strrev($m);
        $decimal = preg_replace("/0\./i", ".", $decimal);
        $decimal = substr($decimal, 0, 3);
        if ($decimal != '0') {
            $result = $result . $decimal;
        }
        return $result;
    }
}
