<?php

namespace app\admin\model;


use think\Model;

class Role extends Model
{
    protected $pk="role_id";
    public function limits()
    {
        return $this->belongsToMany('Limit',"role_limit","limit_id","role_id");
    }

    public static function addAdminRole($data){
        if(self::table("shop_admin_role")->insert($data)){
            return true;
        }else{
            return false;
        }
    }
    public static function addRoleGetId($data){
        if($role_id=self::table("shop_role")->insertGetId($data)){
            return $role_id;
        }else{
            return false;
        }
    }
    public static function getAllRoles(){
        return self::table("shop_role")->select();
    }
}