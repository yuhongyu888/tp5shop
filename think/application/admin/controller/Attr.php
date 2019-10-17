<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/10/17
 * Time: 16:04
 */

namespace app\admin\controller;


use app\admin\model\Type;
use app\admin\service\TypeService;

class Attr extends Common
{
    public function show(){
        $attr=\app\admin\model\Attr::all();
        return view("",["attr"=>$attr]);
    }
    public function add(){
        if(request()->isGet()){
            $typeModel=new Type();
            $type=$typeModel::all();
            return view("",["type"=>$type]);
        }
        if(request()->isPost()){
            $attr_name=request()->post('attr_name');
            $type_id=request()->post('type_id');
            $group_name=request()->post('group_name');
            $attr_type=request()->post('attr_type');
            $attr_input_type=request()->post('attr_input_type');
            $attr_input_value=request()->post('attr_input_value');

            $data=['attr_name'=>$attr_name,'type_id'=>$type_id,'group_name'=>$group_name,'attr_type'=>$attr_type,'attr_input_type'=>$attr_input_type,'attr_input_value'=>$attr_input_value];
            if((new \app\admin\model\Attr())->save($data)){
                $this->success('添加商品属性成功','Attr/show');
            }else{
                $this->error('添加商品属性失败');
            }
        }
    }
    public function getGroupName(){
        $type_id=request()->post("type_id");
        $typeService=new TypeService();
        $group_name=$typeService->groupName($type_id);
        echo json_encode(["status"=>1,"msg"=>"ok","content"=>$group_name]);
    }
}