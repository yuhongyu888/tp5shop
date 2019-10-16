<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/10/13
 * Time: 15:38
 */
namespace app\admin\controller;
class Product extends Common{
    public function product_show(){
        return view();
    }
    public function product_add(){
        return view();
    }
    public function product_update(){
        echo "我是商品的修改";
    }
    public function product_delete(){
        echo "我是商品的删除";
    }
}