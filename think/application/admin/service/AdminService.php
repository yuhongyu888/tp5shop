<?php

namespace app\admin\service;
use app\admin\model\AdminRole;
use app\admin\model\Role;
use think\Model;

class AdminService
{
    public function getLimits($admin_id){
        $adminModel=new AdminRole();
        $role_id=$adminModel->where("admin_id",$admin_id)->column("role_id");
        $roleModel=new Role();
        $limits=[];
        foreach($role_id as $key=>$val){
            $role=$roleModel::get($val);
            $limits[]=$role->limits;
        }
        $data=[];
        foreach($limits as $key=>$val){
            foreach($val as $k=>$v){
                $data[]=$v;
            }
        }
        $limits=array_unique($data);
        return $limits;
    }

    public function sonLimit($imits,$pid=0){
        $arr=[];
        foreach($imits as $key=>$val){
            if($val["limit_pid"]==$pid){
                $son=self::sonLimit($imits,$val["limit_id"]);
                if($son){
                    $val["child"]=$son;
                }
                $arr[]=$val;
            }
        }
        return $arr;
    }
}
