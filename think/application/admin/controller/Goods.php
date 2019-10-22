<?php

namespace app\admin\controller;

use app\admin\model\Product;
use app\admin\model\ProductAttr;
use think\Controller;

class Goods extends Common
{
    public function show()
    {
        $product_id=request()->param("product_id");
        $product=Product::get($product_id);
        $goods=$product->goods;
        $attr_arr=[];
        foreach($goods as $key=>$val) {
            $product_attr_id = explode("-", $val["product_attr_id"]);
            foreach ($product_attr_id as $k => $v) {
                $attr_arr[$key][]=ProductAttr::where("product_attr_id",$v)->field("attr_value")->find()["attr_value"];
            }
        }
        foreach($attr_arr as $key=>$val){
            $attr_str=implode(" + ",$val);
            $goods[$key]["attr_value"]=$attr_str;
        }
        return view("",["product_id"=>$product_id,"goods"=>$goods]);
    }
    public function add()
    {
        if(request()->isGet()){
            $product_id=request()->param("product_id");
            $attr=ProductAttr::where(["product_id"=>$product_id,"attr_type"=>1])->select();
            $result=[];
            foreach($attr as $key=>$val){
                $result[$val["attr_name"]][]=$val;
            }
            return view("",["result"=>$result,"product_id"=>$product_id]);
        }
        if(request()->isPost()){
            $data=request()->post("product_attr_id");
            $product_id=request()->post("product_id");
            $good=[];
            foreach($data as $key=>$val){
                $goods_num=array_pop($val);
                $good[$key]["product_id"]=$product_id;
                $good[$key]["product_attr_id"]=implode("-",$val);
                $good[$key]["goods_sn"]="TP".substr(uniqid(),-6);
                $good[$key]["goods_num"]=$goods_num;
            }
            $goodsModel=new \app\admin\model\Goods();
            if($goodsModel->saveAll($good)){
                $this->success("添加成功",url("Goods/show",["product_id"=>$product_id]));
            }else{
                $this->error("添加失败");
            }
        }
    }

    public function update()
    {
        //
    }
    public function delete()
    {
        //
    }
}
