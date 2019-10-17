<?php

namespace app\admin\model;

use think\Model;

class Type extends Model
{
    protected $pk="type_id";
    public function attr()
    {
        return $this->hasMany('Attr',"attr_id","type_id");
    }
}
