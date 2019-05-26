<?php

namespace App\Http\Controllers\User;
use App\Model\Level;
use App\Model\User;
use App\Model\Verify;
use App\Model\Vip;
use App\Providers\EmailServiceProvider;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Providers\RetServiceProvider;
use PharIo\Manifest\Email;

class UserController extends Controller
{
    //
    public function __construct()
    {
    }
    /**
     * home
     * */
    public function get_userinfo(Request $request){
        $uid = $request->userinfo->uid;
        $user = User::get_user_index($uid);
        $user_info = [
            'uid' => $user->uid,
            'username' => $user->username,
            'headimgurl' => $user->headimgurl,
        ];
        RetServiceProvider::ret('0','成功',$user_info);
    }




}
