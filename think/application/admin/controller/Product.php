<?php
namespace app\admin\controller;
use app\admin\model\Attr;
use app\admin\model\Brand;
use app\admin\model\BrandCate;
use app\admin\model\Cate;
use app\admin\model\ProductAttr;
use app\admin\model\Type;

class Product extends Common{
    public function product_show(){
        return view();
    }
    public function product_add(){
        if(request()->isGet()){
            $type=Type::all();
            $cate=Cate::all();
            $cate=Cate::cateOrder($cate);
            $brand=Brand::all();
            return view("",["type"=>$type,"cate"=>$cate,"brand"=>$brand]);
        }
        if(request()->isPost()){
            $data=request()->post();
            $attr=[$data["attr_id"],$data["attr_name"],$data["attr"],$data["attr_type"]];
            unset($data["type_id"]);
            unset($data["attr_id"]);
            unset($data["attr_name"]);
            unset($data["attr"]);
            unset($data["attr_input_type"]);
            $file = request()->file('product_img');
            // 移动到框架应用根目录/uploads/ 目录下
            $info = $file->move("../public/uploads");
            if($info){
                // 成功上传后 获取上传信息
                // 输出 20160820/42a79759f284b767dfcb2a0197904287.jpg
                $product_img=$info->getSaveName();
            }else{
                // 上传失败获取错误信息
                echo $file->getError();
            }
            $product_img=request()->domain().'/uploads/'.str_replace('\\','/',$product_img);
            $data["product_img"]=$product_img;
            $bc=[
                "brand_id"=>$data["brand_id"],
                "cate_id"=>$data["cate_id"]
            ];
            //添加商品表
            $productModel=new \app\admin\model\Product();
            $productModel->save($data);
            $product_id=$productModel->product_id;
            //添加商品属性表
            $productAttrModel=new ProductAttr();
            foreach($attr as $key=>$val){
                $data=[
                    "product_id"=>$product_id,
                    "attr_id"=>$attr[0][$key],
                    "attr_name"=>$attr[1][$key],
                    "attr_value"=>$attr[2][$key],
                    "attr_type"=>$attr[3][$key]
                ];
                $productAttrModel->save($data);
            }
            //添加品牌分类表
            $brandCateModel=new BrandCate();
            if($brandCateModel->save($bc)){
                $this->success("添加成功","Product/product_show");
            }else{
                $this->error("添加失败");
            }
        }
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
    public function add_attr(){
        $attr=request()->post("attr");
        $data=explode("/",$attr);
        $data=[
            "product_id"=>$data[0],
            "attr_id"=>$data[1],
            "attr_name"=>$data[2],
            "attr_value"=>$data[3],
            "attr_input_type"=>$data[4]
        ];
        $productAttrModel=new ProductAttr();
        $productAttrModel->save($data);
    }
}