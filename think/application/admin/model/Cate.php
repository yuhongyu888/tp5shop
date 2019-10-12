<?php
namespace app\admin\model;
use think\Db;
use think\Model;

class Cate extends Model{
    public static function getCates(){
        return Db::table("shop_cate")->select();
    }
    public static function cateOrder($cates,$pid=0,$level=0){
        static $cate=[];
        foreach($cates as $key=>$val){
            if($val["cate_pid"]==$pid){
                $val["level"]=$level;
                $cate[]=$val;
                self::cateOrder($cates,$val["cate_id"],$level+1);
            }
        }
        return $cate;
    }
}