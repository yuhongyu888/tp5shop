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
}