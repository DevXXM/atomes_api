<?php

namespace App\Providers;

use Illuminate\Support\Facades\Redis;
use Illuminate\Support\ServiceProvider;

class RedisServiceProvider extends ServiceProvider
{
    /**
     * xml转数组
     * */
    public static function create()
    {
        return Redis::connection();
    }

    /**
     * 获取push_book的key
     * */
    public static function get_push_key()
    {
        return "push_task";
    }

}
