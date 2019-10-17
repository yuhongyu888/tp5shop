<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/10/13
 * Time: 15:38
 */
namespace app\admin\controller;
use app\admin\model\Attr;
use app\admin\model\Type;

class Product extends Common{
    public function product_show(){
        return view();
    }
    public function product_add(){
        $type=Type::all();
        return view("",["type"=>$type]);
    }
    public function product_update(){
        echo "我是商品的修改";
    }
    public function product_delete(){
        echo "我是商品的删除";
    }
    public function getGroupName(){
        $type_id=request()->post("type_id");
        $attr=Attr::where("type_id",$type_id)->all();
        foreach($attr as $key=>$val){
            if($val["attr_input_type"]==1){
                $v=explode("，",$val["attr_input_value"]);
                $val["value"]=$v;
            }
        }
        return ["status"=>1,"msg"=>"ok","content"=>$attr];
    }
}