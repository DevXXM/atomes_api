<?php

namespace App\Http\Controllers\Index;
use App\Model\Banner;
use App\Model\Books;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Providers\RetServiceProvider;
class IndexController extends Controller
{
    //
    public function __construct()
    {
    }
    /**
     * home
     * */
    public function index(Request $request){
        var_dump("hello");
    }

}
