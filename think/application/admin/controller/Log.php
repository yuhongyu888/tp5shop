<?php
namespace app\admin\controller;
use think\Db;

class Log extends Common{
    public function show(){
        $log=Db::table("shop_log")->limit(0,2)->order("log_time desc")->select();
        $count=Db::table("shop_log")->count();
        $pagelast=ceil($count/2);
        return view("",["log"=>$log,"count"=>$count,"pagelast"=>$pagelast]);
    }
    public function page(){
        $page=request()->post("page");
        $offset=($page-1)*2;
        $log=Db::table("shop_log")->limit($offset,2)->order("log_time desc")->select();
        if($log){
            echo json_encode(["status"=>1,"msg"=>"ok","content"=>$log,"page"=>$page]);
        }else{
            echo json_encode(["status"=>0,"msg"=>"not ok"]);
        }
    }
}