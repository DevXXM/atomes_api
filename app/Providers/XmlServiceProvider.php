<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class XmlServiceProvider extends ServiceProvider
{
    /**
     * xml转数组
     * */
    public static function xmlToArray($xml)
    {
        //禁止引用外部xml实体
        libxml_disable_entity_loader(true);
        $values = json_decode(json_encode(simplexml_load_string($xml, 'SimpleXMLElement', LIBXML_NOCDATA)), true);
        return $values;
    }

}
