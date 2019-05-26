<?php

namespace App\Providers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Session;

class SMSServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        //
    }
    public static function send_sms($mobile,$content){
        //$url = env('SMS_URL')."?apikey=".env('SMS_KEY')."&mobile=$mobile&content=$content";
		$url = env('SMS_URL');
		$data = ['content'=>$content,'mobile'=>$mobile,'apikey'=>env('SMS_KEY')];
        $res = CurlServiceProvider::curl_post($url,$data);
        return $res;
    }
    public static function get_code(){
        $code = rand(100000,999999);
        return $code;
    }

    //获取apikey
    public static function get_apikey(){
        return env('SMS_APIKEY');
    }

    //发送验证码短信
    public static function send_verify($mobile,$code=""){
        if (empty($code)){
            $code = self::get_code();
        }
        $apikey = self::get_apikey();
        $url = "https://api.dingdongcloud.com/v1/sms/sendyzm?apikey={$apikey}&mobile={$mobile}&content=【米粒阅读】尊敬的用户，您的验证码是：{$code}，请在15分钟内输入。请勿告诉其他人。";
        $res = CurlServiceProvider::curl_get_https($url);
        return json_decode($res,true);
    }


}
