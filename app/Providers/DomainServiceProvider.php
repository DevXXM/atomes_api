<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class DomainServiceProvider extends ServiceProvider
{
    public static function check_domain($domain)
    {
        $url = "http://panda.www.net.cn/cgi-bin/check.cgi?area_domain=".$domain;

        if (empty($domain))
        {
            $return = array(
                'status' => '-1',
                'msg' => '域名不能为空'
            );
            return $return;
        }

        $res = CurlServiceProvider::curl_get($url);
        $res = XmlServiceProvider::xmlToArray($res);

        if (empty($res['original']))
        {
            $return = array(
                'status' => '-2',
                'msg' => '接口通讯失败！请稍后重试'
            );
            return $return;
        }
        $status = $res['original'];
        switch ($status)
        {
            case "211 : Domain name is not available":
                $return = array(
                    'status' => '1',
                    'msg' => '域名已经被注册！'
                );
                return $return;
                break;
            case "210 : Domain name is available":
                $return = array(
                    'status'=>'0',
                    'msg'=>"域名可以注册！"
                );
                return $return;
                break;
            case "212 : Domain name is invalid":
                $return = array(
                    'status'=>'2',
                    'msg'=>"域名参数传输错误！"
                );
                return $return;
                break;
            case "213 : Time out":
                $return = array(
                    'status'=>'3',
                    'msg'=>"查询超时"
                );
                return $return;
                break;
            default:
                $return = array(
                    'status'=>'4',
                    'msg'=>"未知错误，请稍后重试"
                );
                return $return;
                break;
        }
    }
}
