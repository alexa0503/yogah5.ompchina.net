<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use App\Helper;
use Carbon\Carbon;

class WechatController extends Controller
{
    public function auth(Request $request)
    {
        $callback_url = $request->getUriForPath('/wechat/callback');
        //http://call.socialjia.com/Wxapp/weixin_common/oauth2.0/link.php?entid=88&scope=snsapi_userinfo&response_type=code&url=urlencode(url)
        $url = 'http://call.socialjia.com/Wxapp/weixin_common/oauth2.0/link.php?entid=88&scope=snsapi_userinfo&response_type=code&url='.urlencode($callback_url);
        return redirect($url);
    }
    public function callback(Request $request)
    {
        $code = $request->get('wxcode');
        $timestamp = time();
        $api_key = env('WECHAT_API_KEY');
        $sig = md5($api_key.env('WECHAT_API_SECRET').$timestamp);
        $params = [
            'apiKey'=> $api_key,
            'timestamp'=> $timestamp,
            'sig'=> $sig,
            'a' => 'userInfo',
            'm' => 'getUserInfoByCode',
            'code' => $code,
        ];
        $url = "http://api.socialjia.com/index.php?".http_build_query($params);
        $response = json_decode(Helper\HttpClient::get($url));
        if (isset($response->error) && $response->error != 0) {
            return view('errors/503',['error_msg' => '获取用户信息失败~']);
        }
        /*
        $wechat_token = $token->access_token;
        $openid = $token->openid;

        $url = "https://api.weixin.qq.com/sns/userinfo?access_token={$wechat_token}&openid={$openid}";
        $data = Helper\HttpClient::get($url);
        $user_data = json_decode($data);
        */
        $user_data = $response->data;
        $openid = $user_data->openid;
        $wechat_user = \App\WechatUser::where('open_id',$openid);
        if($wechat_user->count() > 0){
            $wechat = $wechat_user->first();
        }
        else{
            $wechat = new \App\WechatUser();
            $wechat->open_id = $openid;
            $wechat->create_time = Carbon::now();
            $wechat->create_ip = $request->getClientIp();
        }
        $wechat->gender = $user_data->sex;
        $wechat->head_img = $user_data->headimgurl;
        $wechat->nick_name = json_encode($user_data->nickname);
        $wechat->country = $user_data->country;
        $wechat->province = $user_data->province;
        $wechat->city = $user_data->city;
        //$wechat->options = $options;
        $wechat->save();
        $request->session()->set('wechat.openid', $openid);

        if( null != $request->session()->get('wechat.redirect_uri'))
            return redirect($request->session()->get('wechat.redirect_uri'));
        else
            return redirect('/');
    }
}
