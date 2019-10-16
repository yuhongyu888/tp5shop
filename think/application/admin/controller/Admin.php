<?php
namespace app\admin\controller;
use think\Validate;

class Admin extends Common{
    public function show(){
        $adminModel=new \app\admin\model\Admin();
        $admin=$adminModel::all();
        return view("",["admin"=>$admin]);
    }
    public function add(){
        if(request()->isGet()){
            return view();
        }
        if(request()->isPost()){
            $admin_name=request()->post("admin_name");
            $admin_email=request()->post("admin_email");
            $admin_pwd=request()->post("admin_pwd");
            $admin_repwd=request()->post("admin_repwd");
            if($admin_pwd!=$admin_repwd){
                $this->error("两次密码填入不一致");
            }
            $validate = Validate::make([
                'admin_name'  => 'require',
                'admin_email' => 'require',
                'admin_pwd' => 'require',
                'admin_repwd' => 'require'
            ]);
            $data = [
                'admin_name'  => $admin_name,
                'admin_email' => $admin_email,
                'admin_pwd' => $admin_pwd,
                'admin_repwd' => $admin_repwd
            ];
            if (!$validate->check($data)) {
                $this->error($validate->getError());
            }
            $admin["admin_name"]=$admin_name;
            $admin["admin_email"]=$admin_email;
            $admin["admin_pwd"]=$admin_pwd;
            $admin["admin_time"]=time();
            if(\app\admin\model\Admin::add_admin($admin)){
                $this->success("添加成功","Admin/show");
            }else{
                $this->error("添加失败");
            }
        }
    }
    public function update(){
        echo "我是管理员的修改";
    }
    public function delete(){
        echo "我是管理员的删除";
    }
}