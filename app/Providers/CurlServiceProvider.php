<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class CurlServiceProvider extends ServiceProvider
{
    /*curlPost函数*/
    public static function curl_post($url,$post_data = array())
    {
        if (empty($url))
        {
            return false;
        }
        $post_data = json_encode($post_data);
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_HEADER, 0);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_POST, 1);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $post_data);
        $data = curl_exec($curl);
        curl_close($curl);
        $json = json_decode($data,true);
        if (empty($json))
        {
            return $data;
        }
        return $json;
    }
    /*curlget函数*/
    public static function curl_get($url, array $params = array(),$timeout=5)
    {
        $ch = curl_init();
        curl_setopt ($ch, CURLOPT_URL, $url);
        curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt ($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
        $file_contents = curl_exec($ch);
        curl_close($ch);
        return $file_contents;
    }
    /*curlget函数*/
    public static function curl_get_https($url, array $params = array(),$timeout=5)
    {
        $ch = curl_init();
        curl_setopt ($ch, CURLOPT_URL, $url);
        curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt ($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0); // 信任任何证书
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0); // 检查证书中是否设置域名（为0也可以，就是连域名存在与否都不验证了）
        $file_contents = curl_exec($ch);
        curl_close($ch);
        return $file_contents;
    }
}
