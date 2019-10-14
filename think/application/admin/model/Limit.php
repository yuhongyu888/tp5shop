<?php

namespace app\admin\model;


use think\Model;

class Limit extends Model
{
    public static function getAllLimit(){
        return self::table("shop_limit")->select();
    }
    public static function addLimit($data){
        return self::table("shop_limit")->insert($data);
    }
    public static function addRoleLimit($data){
        return self::table("shop_role_limit")->insert($data);
    }
    public static function orderLimit($limits,$pid=0,$level=0){
        static $orderCate=[];
        foreach($limits as $key=>$val){
            if($val["limit_pid"]==$pid){
                $val["level"]=$level;
                $orderCate[]=$val;
                self::orderLimit($limits,$val["limit_id"],$level+1);
            }
        }
        return $orderCate;
    }
    public static function sonLimit($cates,$pid=0){
        $arr=[];
        foreach($cates as $key=>$val){
            if($val["limit_pid"]==$pid){
                $son=self::sonLimit($cates,$val["limit_id"]);
                if($son){
                    $val["child"]=$son;
                }
                $arr[]=$val;
            }
        }
        return $arr;
    }
}