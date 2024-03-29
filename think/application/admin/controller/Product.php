<?php
namespace app\admin\controller;
use app\admin\model\Attr;
use app\admin\model\Brand;
use app\admin\model\BrandCate;
use app\admin\model\Cate;
use app\admin\model\ProductAttr;
use app\admin\model\Type;
use think\Db;
use think\Exception;

class Product extends Common{
    public function product_show(){
        $product=\app\admin\model\Product::all();
        foreach($product as $key=>$val){
            $product_id=$val->product_id;
            $arr=productAttr::where(["product_id"=>$product_id,"attr_type"=>1])->select()->toArray();
            if(!empty($arr)) {
                $product[$key]["attr_status"] = 1;
            }
        }
        return view("",["product"=>$product]);
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
            $attr=[$data["attr_id"],$data["attr_name"],$data["attr"],$data["attr_type"],$data["attr_price"]];
            unset($data["type_id"]);
            unset($data["attr_id"]);
            unset($data["attr_name"]);
            unset($data["attr"]);
            unset($data["attr_type"]);
            unset($data["attr_price"]);
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
            Db::startTrans();
            try{
                //添加商品表
                $productModel=new \app\admin\model\Product();
                $productModel->save($data);
                $product_id=$productModel->product_id;
                //添加商品属性表
                $d=[];
                foreach($attr[0] as $key=>$val){
                    $d[]=[
                        "product_id"=>$product_id,
                        "attr_id"=>$attr[0][$key],
                        "attr_name"=>$attr[1][$key],
                        "attr_value"=>$attr[2][$key],
                        "attr_type"=>$attr[3][$key],
                        "attr_price"=>$attr[4][$key]
                    ];
                }
                $productAttrModel=new ProductAttr();
                $productAttrModel->saveall($d);
                //添加品牌分类表
                $brandCateModel=new BrandCate();
                $brandCateModel->save($bc);
                Db::commit();
                $this->success("添加商品成功","product_show");
            }catch(Exception $e){
                Db::rollback();
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
}