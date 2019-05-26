<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class IpServiceProvider extends ServiceProvider
{
    /*获取真实IP*/
    public static function get_real_ip()
    {
        $ip=false;
        if(!empty($_SERVER["HTTP_CLIENT_IP"]))
        {
            $ip = $_SERVER["HTTP_CLIENT_IP"];
        }
        if (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))
        {
            $ips = explode (", ", $_SERVER['HTTP_X_FORWARDED_FOR']);
            if ($ip)
            {
                array_unshift($ips, $ip);
                $ip = FALSE;
            }
            for ($i = 0; $i < count($ips); $i++)
            {
                if (!preg_match ("^(10|172\.16|192\.168)\.", $ips[$i]))
                {
                    $ip = $ips[$i];
                    break;
                }
            }
        }
        return ($ip ? $ip : $_SERVER['REMOTE_ADDR']);
    }
    /*根据IP去百度SDK获取地址和经纬度*/
    public static function get_ip_addr($ip)
    {
        $api_url = env('BAIDU_URL');
        $ak = env('BAIDU_AK');
        if (empty($api_url) || empty($ak))
        {
            return false;
        }
        $url = $api_url."/location/ip?ak=".$ak."&coor=bd09ll&ip=".$ip;
        $data = CurlServiceProvider::curl_post($url);
        return $data;
    }


    public static function get_host(){
        return $_SERVER['HTTP_HOST'];
    }

}
