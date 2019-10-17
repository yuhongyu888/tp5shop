<?php

namespace app\admin\model;

use think\Model;

class Attr extends Model
{
    protected  $pk="attr_id";
    public function type()
    {
        return $this->belongsTo('Type',"type_id","attr_id");
    }
}
