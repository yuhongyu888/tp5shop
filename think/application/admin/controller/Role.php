<?php

namespace app\admin\controller;

use app\admin\model\Admin;

class Role extends Common
{
    public function show(){
        $role=new \app\admin\model\Role();
        $roles = $role::all();
        // 获取用户的所有角色
        return view("",["roles"=>$roles]);
    }
    public function add(){
        if(request()->isGet()){
            $admin=Admin::get_admin();
            return view("",["admin"=>$admin]);
        }
        if(request()->isPost()){
            $role_name=request()->post("role_name");
            $role_desc=request()->post("role_desc");
            $admin_id=request()->post("admin_id");
            $admin_name=session("admin")["admin_name"];
            $role["role_name"]=$role_name;
            $role["role_desc"]=$role_desc;
            if($role_id=\app\admin\model\Role::addRoleGetId($role)){
                $d["admin_id"]=$admin_id;
                $d["role_id"]=$role_id;
                $d["admin_name"]=$admin_name;
                $d["role_name"]=$role_name;
                if(\app\admin\model\Role::addAdminRole($d)){
                    $this->success("添加成功","Role/show");
                }else{
                    $this->error("添加失败");
                }
            }else{
                $this->error("添加失败");
            }
        }
    }
    public function update(){
        echo "我是角色的修改";
    }
    public function delete(){
        echo "我是角色的删除";
    }
}