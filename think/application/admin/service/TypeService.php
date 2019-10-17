<?php

namespace app\admin\service;


use app\admin\model\Type;

class TypeService
{
    public function groupName($type_id){
        $typeModel=new Type();
        $group_name=$typeModel::get($type_id);
        $group_name=$group_name->group_name;
        $group_name=explode("，",$group_name);
        return $group_name;
    }
}
