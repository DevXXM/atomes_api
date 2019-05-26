<?php

namespace App\Http\Controllers\Card;
use App\Http\Controllers\Common\CommonController;
use App\Model\Books;
use App\Model\Card;
use App\Model\User;
use App\Model\Vip;
use App\Providers\RandomServiceProvider;
use Illuminate\Http\Request;
use App\Providers\RetServiceProvider;
class CardController extends CommonController
{
    //
    public function __construct()
    {
        parent::__construct();
    }
    /**
     * 生成
     * 登录成功返回0 success，失败返回-1
     * add by 毛毛
     */
    public function make_card(Request $request){
        $number = $request->get('number');//生成数量
        $level = $request->get('level');
        if (empty($number)){
            $number = 10;
        }
        $res = Card::make_card($number,$level);
        if ($res){
            RetServiceProvider::ret(0,'成功');
        }
        RetServiceProvider::ret_error(-1,'失败');
    }


    /**
     * 激活卡
     * 登录成功返回0 success，失败返回-1
     * add by 毛毛
     */
    public function activation_card(Request $request){
        $card_number = $request->get('card_number');//生成数量
        if (empty($card_number)){
            RetServiceProvider::ret_error(-1,'卡号不能为空');
        }
        $is_used = Card::is_used($card_number);
        if (!$is_used){
            RetServiceProvider::ret_error(-1,'此卡不存在或已被使用');
        }
        //没被使用的话就开始使用了
        $res = Card::use_card($card_number,$request->userinfo->uid);
        if ($res){
            RetServiceProvider::ret(0,'成功');
        }
        RetServiceProvider::ret_error(-1,'失败');
    }


    /**
     * 我的会员卡
     * 登录成功返回0 success，失败返回-1
     * add by 毛毛
     */
    public function my_card(Request $request){
        $user = $request->userinfo;
        $vip_list = Vip::my_card($user->uid);
        RetServiceProvider::ret(0,'成功',['list'=>$vip_list]);
    }



}
