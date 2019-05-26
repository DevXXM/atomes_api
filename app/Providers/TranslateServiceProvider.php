<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class TranslateServiceProvider extends ServiceProvider
{
    /**
     * fanyi
     * */
    public static function translate($keyword,$num)
    {
        $url = "http://dict.youdao.com/suggest?q=$keyword&le=eng&num=$num&doctype=json";
        $res = CurlServiceProvider::curl_get($url);
        return $res;
    }
}
