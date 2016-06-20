<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
//use Carbon;
use Carbon\Carbon;
use Intervention\Image\ImageManagerStatic as Image;
class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('web');
        $this->middleware('wechat.auth');
    }

    public function index()
    {
        $openid = \Request::session()->get('wechat.openid');
        $wechat_user = \App\WechatUser::where('open_id', $openid)->first();
        return view('index',['wechat_user'=>$wechat_user]);
    }

    public function pregnancy($term)
    {
        $openid = \Request::session()->get('wechat.openid');
        $wechat_user = \App\WechatUser::where('open_id', $openid)->first();
        if( $wechat_user->info == null){
            $info = new \App\Info();
            $info->id = $wechat_user->id;
            $info->pregnancy = $term;
            $info->name = null;
            $info->gender = null;
            $info->mobile = null;
            $info->district = null;
            $info->address = null;
            $info->action = 0;
            $info->created_time = date('Y-m-d H:i:s');
            $info->created_ip = \Request::getClientIp();
            $info->save();
            $wechat_user->info = $info;
        }
        else{
            if( $wechat_user->info->pregnancy != $term ){
                return redirect('pregnancy/'.$wechat_user->info->pregnancy);
            }
        }
        return view('pregnancy/'.$term, ['wechat_user'=>$wechat_user]);
    }

    public function action($id)
    {
        $openid = \Request::session()->get('wechat.openid');
        $wechat_user = \App\WechatUser::where('open_id', $openid)->first();
        if( $wechat_user->info == null){
            return redirect('/');
        }
        if( $wechat_user->info->action + 1 < $id){
            return redirect('pregnancy/'.$wechat_user->info->pregnancy);
        }
        $term = $wechat_user->info->pregnancy;
        $array = ['one','two','three'];
        return view('action/'.$term.'/'.$array[$id-1], ['wechat_user'=>$wechat_user, 'action'=>$id]);
    }
    public function unlock()
    {
        $openid = \Request::session()->get('wechat.openid');
        $wechat_user = \App\WechatUser::where('open_id', $openid)->first();
        if( $wechat_user->info == null){
            return redirect('/');
        }
        $action = \Request::input('action');
        $info = $wechat_user->info;

        //下一关未解锁情况,跳到下一关
        if( $info->action < 2 && $action == $info->action + 1){
            $info->action += 1;
            $info->save();
        }//下一关未解锁情况,跳到下一关
        elseif($info->pregnancy == 'mid' && $info->action == 2 && $action == 3){
            $info->action = 0;
            $info->pregnancy = 'late';
            $info->save();
        }
        $next_action = $action >=3 ? 1 : $action + 1;
        return redirect(url('action',['id'=>$next_action]));
    }
    public function post()
    {
        $result = ['ret'=>0,'msg'=>''];
        $openid = \Request::session()->get('wechat.openid');
        $wechat_user = \App\WechatUser::where('open_id', $openid)->first();
        if( $wechat_user->info == null){
            return redirect('/');
        }
        $info = $wechat_user->info;
        if( null != $info->name){
            $result = ['ret'=>1001,'msg'=>'您已经提交过信息了'];
        }
        else{
            $info->name = \Request::input('name');
            $info->gender = \Request::input('gender');
            $info->mobile = \Request::input('mobile');
            $info->district = \Request::input('district');
            $info->address = \Request::input('address');
            $info->save();
        }
        return json_encode($result);
    }
}
