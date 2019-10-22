<?php

namespace app\admin\model;

use think\Model;

class Product extends Model
{
    protected $pk="product_id";
    public function attr()
    {
        return $this->belongsToMany('Attr',"product_attr","attr_id","product_id");
    }
    public function goods()
    {
        return $this->hasMany('Goods',"product_id","product_id");
    }
}
