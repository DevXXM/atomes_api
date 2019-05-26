<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class RetServiceProvider extends ServiceProvider
{
    /**
     * 返回函数
     * @status : 0成功，其他都为失败
     * @msg : 文本信息
     * @data : 数组返回值，如果有的话
     * @author wangzicheng
     **/
    public static function ret($status = "0",$msg = "",$data = array())
    {
        header('Content-type: application/json');
        $return = array(
            'code' => $status,
            'message' => $msg
        );
        if(!empty($data)){
            $return['data'] = $data;
        }
        $json = json_encode($return);
        die($json);
    }
    /**
     * 返回失败
     * @status : 0成功，其他都为失败
     * @msg : 文本信息
     * @data : 数组返回值，如果有的话
     * @author wangzicheng
     **/
    public static function ret_error($status = "-1",$msg = "")
    {
        header('Content-type: application/json');
        $return = array(
            'code' => $status,
            'message' => $msg
        );
        $json = json_encode($return);
        die($json);
    }
}
