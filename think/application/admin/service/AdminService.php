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
            $role=$roleModel::get($val)->toArray();
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

    public function sonLimit($limits,$pid=0){
        $arr=[];
        foreach($limits as $key=>$val){
            if($val["limit_pid"]==$pid){
                $val["child"]=[];
                $son=self::sonLimit($limits,$val["limit_id"]);
                if($son){
                    $val["child"]=$son;
                }
                $arr[]=$val;
            }
        }
        return $arr;
    }

    public function getLeftLimits($admin_id){
        $adminModel=new AdminRole();
        $role_id=$adminModel->where("admin_id",$admin_id)->column("role_id");
        $roleModel=new Role();
        $limits=[];
        foreach($role_id as $key=>$val){
            $role=$roleModel::get($val);
            $limits[]=$role->limits->where("limit_left_show",1);
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
}
