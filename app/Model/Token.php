<?php

namespace App\Model;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Token extends Model
{
    protected $table = "token";
    /**
     * 生成Tokenkey
     * 登录成功返回token，失败返回false
     *add by 毛毛
     */
    public static function make_token_key($uid)
    {
        if (empty($uid)){
            return false;
        }
        $time = time();
        $md5 = md5(md5($time.rand(100000,999999)));

        $token = DB::table('token')->where('uid',$uid)->where('expires','>=',time())->first();

        if ($token){
            return $token->token;
        }
        $time = time();
        $bool = DB::table('token')->insert(['token'=>$md5,'uid'=>$uid,'datetime'=>$time,'expires'=>$time+86400]);
        if ($bool){
            return $md5;
        }
        return false;
    }

    /**
     * 通过token获取用户信息
     * 登录成功返回userinfo，失败返回false
     *add by 毛毛
     * 今天端午节？
     * 在家写代码
     */
    public static function get_userinfo($token)
    {
        if (empty($token)){
            return false;
        }

        $token = DB::table('token')->where('token',$token)->where('expires','>=',time())->first();
        if (empty($token->uid)){
            return false;
        }
        $user = DB::table('user')->where('uid',$token->uid)->where('status','=',1)->first();
        return $user;
    }

}
