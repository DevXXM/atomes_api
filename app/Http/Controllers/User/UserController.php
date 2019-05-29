<?php

namespace App\Http\Controllers\User;
use App\Model\User;
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
            'reg_time' => $user->reg_time,
            'description' => $user->description,
            'linkedin' => $user->linkedin,
            'name' => $user->name
        ];
        RetServiceProvider::ret('0','成功',$user_info);
    }


    /**
     * 修改资料
     * */
    public function update_userinfo(Request $request){
        $data = $request->request->all();
        $uid = $request->userinfo->uid;
        $user_info = [
            'headimgurl' => $data['headimgurl'],
            'description' => $data['description'],
            'linkedin' => $data['linkedin'],
            'name' => $data['name']
        ];
        $user = User::update_userinfo($uid,$user_info);
        if ($user){
            RetServiceProvider::ret('0','success');
        }else{
            RetServiceProvider::ret_error('-1',"failed");
        }
    }

}
