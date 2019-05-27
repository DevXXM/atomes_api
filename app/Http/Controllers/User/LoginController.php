<?php

namespace App\Http\Controllers\User;
use App\Model\User;
use App\Providers\SMSServiceProvider;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Providers\RetServiceProvider;
class LoginController extends Controller
{
    //
    public function __construct()
    {
    }



    /**
     * 登录/注册都放到这一个方法里，如果没注册就注册之后再登录
     * 成功返回token，失败返回-1
     * add by 毛毛
     */
    public function login(Request $request){
        $username = $request->input('username');
        $password = $request->input('password');
        if (empty($username) || empty($password)){
            RetServiceProvider::ret_error(-1,'Account password cannot be empty');
        }
        $token = User::login($username,$password);
        if (!$token){
            RetServiceProvider::ret_error(-1,'Incorrect password');
        }
        RetServiceProvider::ret(0,'success',['token'=>$token]);
    }



}
