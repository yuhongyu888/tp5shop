<?php

namespace app\admin\controller;


class Type extends Common
{
    public function show(){
        $typeMode=new \app\admin\model\Type();
        $type=$typeMode::all();
        return view("",["type"=>$type]);
    }
    public function add(){
        if(request()->isGet()){
            return view();
        }
        if(request()->isPost()){
            $type_name=request()->post("type_name");
            $group_name=request()->post("group_name");
            $data["type_name"]=$type_name;
            $data["group_name"]=$group_name;
            $typeModel=new \app\admin\model\Type();
            if($typeModel->save($data)){
                $this->success("添加成功","Type/show");
            }else{
                $this->error("添加失败");
            }
        }
    }
}