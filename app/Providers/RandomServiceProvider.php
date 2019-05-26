<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class RandomServiceProvider extends ServiceProvider
{
    /*随机数字*/
    public static function random_num($config)
    {

        $num = $config['num'];//生成数量
        $min = $config['min'];
        $max = $config['max'];
        $base = empty($config['base']) ? 10 : $config['base'];//进制
        $url = "https://www.random.org/integers/?num=".$num."&min=".$min."&max=".$max."&col=1&base=".$base."&format=plain&rnd=new";
        $res = CurlServiceProvider::curl_get_https($url);
        $arr = array_filter(explode(',', str_replace("\n",",",$res)));
        return $arr;
    }
    /*随机字符串*/
    public static function random_str($config)
    {
        $num = $config['num'];//生成数量
        $len = (int)$config['len'];//长度
        $digits = empty($config['digits']) ? "on" : $config['digits'];//是否有数字
        $upper = empty($config['upper']) ? "on" : $config['upper'];//开启大写
        $lower = empty($config['lower']) ? "on" : $config['lower'];//开启小写
        $unique = empty($config['unique']) ? "on" : $config['unique'];//唯一
//        $url = "https://www.random.org/strings/?num=$num&len=$len&digits=$digits&upperalpha=$upper&loweralpha=$lower&unique=$unique&format=plain&rnd=new";
        $url = "https://www.random.org/strings/?num=$num&len=$len&digits=$digits&unique=$unique&format=plain&rnd=new";
        $res = CurlServiceProvider::curl_get_https($url);
        $arr = array_filter(explode(',', str_replace("\n",",",$res)));
        return $arr;
    }

}
