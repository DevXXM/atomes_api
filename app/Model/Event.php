<?php

namespace App\Model;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Event extends Model
{
    protected $table = "event";


    /**
     * 通过event详情
     * 登录成功返回userinfo，失败返回false
     *add by 毛毛
     */
    public static function get_info($id)
    {
        if (empty($id)){
            return false;
        }
        $data = DB::table("event")->where('id',$id)->where('status','=',1)->first();
        if (empty($data->id)){
            return false;
        }
        return $data;
    }

}
