<?php

namespace App\Model;

use App\Providers\EmailServiceProvider;
use EasyWeChat\Factory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use EasyWeChat\Kernel\Messages\Text;

class User extends Model
{
    protected $table = "user";
    /**
     * 注册函数
     * 成功或者已被注册过直接返回uid，失败或者被封禁返回false
     *add by 毛毛
     */
    public static function reg($user){
       $uid = DB::table('user')->insertGetId($user);
        if (empty($uid)){
            return false;
        }
        $token = Token::make_token_key($uid);
        return $token;
    }

    /**
     * 登录函数
     * 登录成功返回token，失败返回false
     *add by 毛毛
     */
    public static function login($username,$password){

        $user = DB::table('user')
            ->where('username','=',$username)
            ->where('status','=','1')
            ->first();
        if (empty($user->uid)){
            return false;
        }
        if ($user->password != md5($password)){
            return false;
        }
        $res = DB::table('token')
            ->where('uid',$user->uid)
            ->where('expires','>=',time())
            ->first();
        $token = "";
        if (empty($res->uid)){
            //如果没有就生成token
            $token = Token::make_token_key($user->uid);
        }else{
            //未过期就返回之前的
            $token = $res->token;
        }
        return $token;
    }

    /**
     * 通过token获取用户信息
     * 成功返回用户信息，失败返回false
     *add by 毛毛
     */
    public static function get_userinfo($token){

        $uid = DB::table('token')->where('token',$token)->value('uid');
        if (empty($uid)){
            return false;
        }
        $res = DB::table('user')->where('uid',$uid)->first();
        if (empty($res->uid)){
            return false;
        }
        if ($res->status == -1){
            return false;
        }
        if ($res){
            return $res;
        }
        return false;
    }

    /**
     * 通过uid获取用户信息
     * 成功返回用户信息，失败返回false
     * add by 毛毛
     */
    public static function get_user_index($uid){
        if (empty($uid)){
            return false;
        }
        $res = DB::table('user')->where('uid',$uid)->where('status','=',1)->first();
        if (empty($res->uid)){
            return false;
        }
        if ($res->status == -1){
            return false;
        }
        if ($res){
            return $res;
        }
        return false;
    }


    /**
     * 修改用户资料
     * 成功返回用户信息，失败返回false
     * add by 毛毛
     */
    public static function update_userinfo($uid,$data){
        if (empty($uid)){
            return false;
        }
        $res = DB::table('user')->where('uid',$uid)->update($data);
        if (!$res){
            return false;
        }
        if ($res){
            return $res;
        }
        return false;
    }

}
