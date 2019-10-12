<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/10/12
 * Time: 14:52
 */
namespace app\admin\controller;
use think\Controller;

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
    }
}