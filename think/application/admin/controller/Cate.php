<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/10/12
 * Time: 14:58
 */
namespace app\admin\controller;
use think\Db;
use think\Validate;

class Cate extends Common{
    public function show_cate(){
        $cates=\app\admin\model\Cate::cateOrder(\app\admin\model\Cate::getCates());
        return view("",["cates"=>$cates]);
    }
    public function add_cate(){
        if(request()->isGet()){
            $c=\app\admin\model\Cate::getCates();
            $cate=\app\admin\model\Cate::cateOrder($c);
            return view("",["cate"=>$cate]);
        }
        if(request()->isPost()){
            $cate_name=request()->post("cate_name");
            $cate_order=request()->post("cate_order");
            $cate_pid=request()->post("cate_pid");
            $validate = Validate::make([
                'cate_name'  => 'require',
            ]);
            $data = [
                'cate_name'  => $cate_name,
            ];
            if (!$validate->check($data)) {
                $this->error("分类名称不能为空");
            }
            $cate["cate_name"]=$cate_name;
            $cate["cate_order"]=$cate_order;
            $cate["cate_pid"]=$cate_pid;
            if(Db::table("shop_cate")->insert($cate)){
                $this->success("添加成功","Cate/show_cate");
            }else{
                $this->error("添加失败");
            }
        }
    }
    public function change_show_status(){
        $cate_status=request()->post("show_status");
        $cid=request()->post("cid");
        if($cate_status==0){
            $cate_status=1;
        }else{
            $cate_status=0;
        }
        if(Db::table("shop_cate")->where("cate_id",$cid)->update(["cate_is_show"=>$cate_status])){
            echo json_encode(["status"=>1,"content"=>"ok"]);
        }else{
            echo json_encode(["status"=>0,"content"=>"not ok"]);
        }
    }
    public function change_cate_name(){
        $cate_name=request()->post("cate_name");
        $cate_id=request()->post("cate_id");
        $cate_name=str_replace("-","",$cate_name);
        if(Db::table("shop_cate")->where("cate_id",$cate_id)->update(["cate_name"=>$cate_name])){
            echo json_encode(["status"=>1,"content"=>"ok"]);
        }else{
            echo json_encode(["status"=>0,"content"=>"not ok"]);
        }
    }
}