<?php
namespace app\admin\controller;

use think\Controller;
use think\Db;
use think\Validate;

class Login extends Controller{
    public function login(){
        if(request()->isGet()){
            return view();
        }
        if(request()->isPost()){
            $admin_name=request()->post("admin_name");
            $admin_pwd=request()->post("admin_pwd");
            $validate = Validate::make([
                'admin_name'  => 'require',
                'admin_pwd' => 'require'
            ]);
            $data = [
                'admin_name'  => $admin_name,
                'admin_pwd' => $admin_pwd
            ];
            if (!$validate->check($data)) {
                $this->error($validate->getError());
            }
            $admin=Db::table("shop_admin")->where("admin_name",$admin_name)->find();
            if($admin["admin_pwd"]!=$admin_pwd){
                $this->error("管理员账号或密码错误");
            }else{
                $log["log_content"]="登录了后台管理系统";
                $log["log_time"]=time();
                $log["admin_name"]=$admin_name;
                $log["admin_ip"]=$_SERVER["REMOTE_ADDR"];
                Db::table("shop_log")->insert($log);
                cookie("admin",$admin);
                $this->success("登录成功","Index/index");
            }
        }
    }
    public function logout(){
        session("admin",null);
        cookie("admin",null);
        $this->success("退出成功","Login/login");
    }
}