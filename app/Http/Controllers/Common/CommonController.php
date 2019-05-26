<?php

namespace App\Http\Controllers\Common;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;


class CommonController extends Controller
{
    //
    public function __construct()
    {
//        $this->api_url = env('BAIDU_URL');
////        $this->ak = "U8wg6m5GfnudeGWHmsYx0PE8iPjGki3a";
////        $this->ak = "eOlQbkxk7oM2UVzvop8EFgMG1yu3wshY";
//        $this->ak = env('BAIDU_AK');
//        $data = [
//            //'uri' => $_SERVER['REQUEST_URI'],
//            'param' => $_SERVER['QUERY_STRING'],
//            //'redirect_url' => $_SERVER['REDIRECT_URL']
//        ];
//        DB::table('access_log')->insert($data);
    }

    /**
     * 返回函数
     * @status : 0成功，其他都为失败
     * @msg : 文本信息
     * @data : 数组返回值，如果有的话
     * @author wangzicheng
     **/
    public function ret($status = "0",$msg = "",$data = array()){
        $return = array(
            'status' => $status,
            'msg' => $msg,
            'data' => $data
        );
        //$error = $this->get_error($status);
//        if (empty($msg)){
//            $return['msg'] = $error;
//        }
        $json = json_encode($return);
        die($json);
    }




}
