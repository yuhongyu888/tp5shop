<?php
namespace app\admin\model;
use think\Model;

class Admin extends Model{
    public static function get_admin(){
        return self::table("shop_admin")->select();
    }
    public static function add_admin($data){
        if(self::table("shop_admin")->insert($data)){
            return true;
        }else{
            return false;
        }
    }
}