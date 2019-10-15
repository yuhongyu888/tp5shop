<?php

namespace app\admin\controller;


class Brand extends Common
{
    public function show(){
        $brandModel=new \app\admin\model\Brand();
        $brands=$brandModel::all();
        return view("",["brands"=>$brands]);
    }
    public function add(){
        if(request()->isGet()){
            return view();
        }
        if(request()->isPost()){
            $brand_name=request()->post("brand_name");
            $brand_order=request()->post("brand_order");
            $brand_status=request()->post("brand_status");
            $file = request()->file('brand_logo');
            // 移动到框架应用根目录/uploads/ 目录下
            $info = $file->move("../public/uploads");
            if($info){
                // 成功上传后 获取上传信息
                // 输出 20160820/42a79759f284b767dfcb2a0197904287.jpg
                $brand_logo=$info->getSaveName();
            }else{
                // 上传失败获取错误信息
                echo $file->getError();
            }
            $brand_logo=request()->domain().'/uploads/'.str_replace('\\','/',$brand_logo);
            $brandModel=new \app\admin\model\Brand();
            $brandModel->brand_name=$brand_name;
            $brandModel->brand_order=$brand_order;
            $brandModel->brand_status=$brand_status;
            $brandModel->brand_logo=$brand_logo;
            if($brandModel->save()){
                $this->success("添加成功","Brand/show");
            }else{
                $this->error("添加失败");
            }
        }
    }
}