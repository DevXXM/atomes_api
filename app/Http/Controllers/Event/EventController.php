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
        $uid = $request->userinfo->uid;
        $res = DB::table("join_list")->where(['uid'=>$uid,'event_id'=>$id,'status'=>1])->first();
        $info = [
            'id' => $data->id,
            'name' => $data->name,
            'address' => $data->address,
            'contact' => $data->contact,
            'description' => $data->description,
            'photo' => json_decode($data->photo,true),
            'views' => $data->views,
            'peoples' => 1,
            'join' => false
        ];
        if (!empty($res)){
            $info['join'] = true;
        }
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

    /**
     * home
     * */
    public function my_event(Request $request){
        $where = [
            'event.status'=>'1',
            'join_list.status' => '1'
        ];
        $list = DB::table("event")
            ->join('join_list','event.id','join_list.event_id')
            ->selectRaw("atomes_event.id,atomes_event.name,atomes_event.cover,atomes_event.description")
            ->where($where)
            ->orderByDesc('join_list.id')
            ->paginate(10);
        RetServiceProvider::ret('0','成功',$list);
    }
    /**
     * home
     * */
    public function my_project(Request $request){
        $where = [
            'status'=>'1',
            'uid' => $request->userinfo->uid
        ];
        $list = DB::table("event")
            ->selectRaw("id,name,cover,description")
            ->where($where)
            ->orderByDesc('id')
            ->paginate(10);
        RetServiceProvider::ret('0','成功',$list);
    }


    /**
     * 加入
     * */
    public function join_event(Request $request){
        $event_id = $request->input('event_id');
        $status = $request->input('status',"1");
        $uid = $request->userinfo->uid;
        if (empty($event_id)){
            RetServiceProvider::ret_error(-1,'event id can not be empty');
        }
        if ($status == '-1'){
            $res = DB::table("join_list")->where(['uid'=>$uid,'event_id'=>$event_id,'status'=>1])->first();
            if (empty($res)){
                RetServiceProvider::ret_error(0,"success");
            }
            $update = [
                'status' => -1
            ];
            DB::table("join_list")->where(['uid'=>$uid,'event_id'=>$event_id,'status'=>1])->update($update);
            RetServiceProvider::ret(0,"success");
        }


        $res = DB::table("event")->where(['id'=>$event_id,'status'=>1])->first();
        if (empty($res)){
            RetServiceProvider::ret_error(-1,'event not exist');
        }

        $res = DB::table("join_list")->where(['uid'=>$uid,'event_id'=>$event_id,'status'=>1])->first();
        if (!empty($res)){
            RetServiceProvider::ret_error(-1,'you have already join.');
        }
        $res = DB::table("join_list")->insert(['event_id'=>$event_id,'uid'=>$uid]);
        if ($res){
            RetServiceProvider::ret('0',"success");
        }
        RetServiceProvider::ret_error(-1,'failed');
    }
}
