<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/10/12
 * Time: 14:52
 */
namespace app\admin\controller;

use app\admin\model\Admin;
use app\admin\model\Limit;
use app\admin\service\AdminService;
use think\Controller;
use think\facade\View;

class Common extends Controller{
    public function __construct()
    {
        parent::__construct();
        if(cookie("admin")&&!session("admin")){
            session("admin",cookie("admin"));
        }
        if(!session("admin")){
            $this->success("请先登录","Login/login");
        }
        //检测权限
        if(!$this->check_access()){
            $this->success("您没有权限操作","Index/index");
        }
        //左侧导航栏
        $this->left();
    }

    public function check_access(){
        if(in_array(session("admin")["admin_name"],config("access.super_admin"))){
            return true;
        }
        $controller=request()->controller();
        $action=request()->action();
        $new_url=ucfirst(strtolower($controller))."/".strtolower($action);
        if(in_array($new_url,config("access.admin_access"))){
            return true;
        }
        $admin_id=session("admin")["admin_id"];
        $adminService=new AdminService();
        $limits=$adminService->getLimits($admin_id);
        $access=[];
        foreach($limits as $key=>$val){
            $url=ucfirst(strtolower($val["limit_controller"]))."/".strtolower($val["limit_acction"]);
            $access[]=$url;
        }
        if(in_array($new_url,$access)){
            return true;
        }else{
            return false;
        }
    }
    public function left(){
        $adminService=new AdminService();
        if(in_array(session("admin")["admin_name"],config("access.super_admin"))){
            $limits=Limit::all();
            $limits=$adminService->sonLimit($limits);
            View::share("limits",$limits);
        }else{
            $admin_id=session("admin")["admin_id"];
            $limits=$adminService->getLimits($admin_id);
            $limits=$adminService->sonLimit($limits);
            View::share("limits",$limits);
        }
    }
}