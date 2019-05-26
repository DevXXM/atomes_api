<?php

namespace App\Http\Middleware;

use App\Model\Token;
use App\Providers\RetServiceProvider;
use Closure;
use Illuminate\Support\Facades\DB;

class AuthUser
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $token = $request->header('Authorization');
        if (empty($token)){
            RetServiceProvider::ret_error(-1001,'token不能为空');
        }
        $user = Token::get_userinfo($token);
        if (empty($user->uid)){
            RetServiceProvider::ret_error(-1001,'错误,请检查token是否错误或是否过期');
        }
        $request->userinfo = $user;
        DB::table('token')->where('token','=',$token)->update(['expires'=>time()+86400]);
        return $next($request);
}
}
