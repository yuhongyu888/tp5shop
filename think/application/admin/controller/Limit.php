<?php

namespace app\admin\controller;


class Limit extends Common
{
    public function show(){
        $limit=\app\admin\model\Limit::getAllLimit();
        $data=\app\admin\model\Limit::sonLimit($limit);
        return view("",["data"=>$data]);
    }
    public function add_user_limit(){
        if(request()->isGet()){
            $role_id=request()->param("role_id");
            $limit=\app\admin\model\Limit::sonLimit(\app\admin\model\Limit::getAllLimit());
            return view("",["limit"=>$limit,"role_id"=>$role_id]);
        }
        if(request()->isPost()){
            $limit_id=request()->post("limit_id");
            $role_id=request()->post("role_id");
            foreach($limit_id as $key=>$val){
                $data["limit_id"]=$val;
                $data["role_id"]=$role_id;
                \app\admin\model\Limit::addRoleLimit($data);
            }
            $this->success("添加成功","Role/show");
        }
    }
    public function add_limit(){
        if(request()->isGet()){
            $limit=\app\admin\model\Limit::getAllLimit();
            $limits=\app\admin\model\Limit::orderLimit($limit);
            return view("",["limits"=>$limits]);
        }
        if(request()->isPost()){
            $limit_pid=request()->post("limit_pid");
            $limit_name=request()->post("limit_name");
            $limit_order=request()->post("limit_order");
            $left_show=request()->post("left_show");
            $limit_controller=request()->post("limit_controller");
            $limit_acction=request()->post("limit_acction");
            $data["limit_name"]=$limit_name;
            $data["limit_order"]=$limit_order;
            $data["limit_left_show"]=$left_show;
            $data["limit_pid"]=$limit_pid;
            $data["limit_controller"]=$limit_controller;
            $data["limit_acction"]=$limit_acction;
            if(\app\admin\model\Limit::addLimit($data)){
                $this->success("添加成功","Limit/show");
            }else{
                $this->error("添加失败");
            }
        }
    }
}