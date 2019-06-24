<?php

namespace App\Http\Controllers\Event;
use App\Model\Event;
use App\Model\User;
use App\Providers\EmailServiceProvider;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Providers\RetServiceProvider;
use Illuminate\Support\Facades\DB;
use PharIo\Manifest\Email;

class EventController extends Controller
{
    //
    public function __construct()
    {
    }
    /**
     * home
     * */
    public function info(Request $request){
        $id = $request->input('id');
        $data = Event::get_info($id);
        $info = [
            'id' => $data->id,
            'name' => $data->name,
            'address' => $data->address,
            'contact' => $data->contact,
            'description' => $data->description,
            'photo' => $data->photo,
            'views' => $data->views,
            'peoples' => 1
        ];
        RetServiceProvider::ret('0','成功',$info);
    }

    /**
     * home
     * */
    public function lists(Request $request){
        $where = [
            'status'=>'1',
        ];
        $list = DB::table("event")
            ->selectRaw("id,name,cover,description")
            ->where($where)
            ->orderByDesc('id')
            ->paginate(10);
        RetServiceProvider::ret('0','成功',$list);
    }


}
