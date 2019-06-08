<?php

namespace App\Http\Controllers\User;
use App\Model\User;
use App\Providers\SMSServiceProvider;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Providers\RetServiceProvider;
use Illuminate\Support\Facades\DB;

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

    /**
     * 注册方法
     * 成功返回token，失败返回-1
     * add by 毛毛
     */
    public function reg(Request $request){
        $username = $request->input('username');
        $password = $request->input('password');
        $name = $request->input('name');
        $description = $request->input('description');
        $linkedin = $request->input('linkedin');
        if (empty($username) || empty($password)){
            RetServiceProvider::ret_error(-1,'Account password cannot be empty');
        }
        $res = DB::table('user')->where('username',$username)->first();
        if (!empty($res->uid)) {
            if ($res->status == 1) {
                RetServiceProvider::ret_error(-1,'Username has been registered');
            }
        }
        $user = [
            'username' => $username,
            'password' => md5($password)
        ];
        if (!empty($name)){
            $user['name'] = $name;
        }
        if (!empty($description)){
            $user['description'] = $description;
        }
        if (!empty($linkedin)){
            $user['linkedin'] = $linkedin;
        }
        $token = User::reg($user);
        if (!$token){
            RetServiceProvider::ret_error(-1,'Incorrect password');
        }
        RetServiceProvider::ret(0,'success',['token'=>$token]);
    }

}
