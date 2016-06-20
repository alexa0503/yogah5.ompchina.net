<?php
/**
 * Created by PhpStorm.
 * User: Alexa
 * Date: 16/4/27
 * Time: 下午2:43.
 */

namespace App\Helper;
class Jssdk
{
    private $jsapi_ticket;
    private $app_id;
    public function __construct($jsapi_ticket, $app_id)
    {
        $this->jsapi_ticket;
        $this->app_id = $app_id;
    }

    public function getSignPackage($url = null)
    {
        //$jsapiTicket = $this->getJsApiTicket();
        $jsapiTicket = $this->jsapi_ticket;

        // 注意 URL 一定要动态获取，不能 hardcode.
        if ($url == null) {
            $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? 'https://' : 'http://';
            $url = "$protocol$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
        }

        $timestamp = time();
        $nonceStr = $this->createNonceStr();

        // 这里参数的顺序要按照 key 值 ASCII 码升序排序
        $string = "jsapi_ticket=$jsapiTicket&noncestr=$nonceStr&timestamp=$timestamp&url=$url";

        $signature = sha1($string);

        $signPackage = array(
            'appId' => $this->app_id,
            'nonceStr' => $nonceStr,
            'timestamp' => $timestamp,
            'url' => $url,
            'signature' => $signature,
            'rawString' => $string,
        );

        return $signPackage;
    }

    private function createNonceStr($length = 16)
    {
        $chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
        $str = '';
        for ($i = 0; $i < $length; ++$i) {
            $str .= substr($chars, mt_rand(0, strlen($chars) - 1), 1);
        }

        return $str;
    }

    /*
    private function getJsApiTicket()
    {
        // jsapi_ticket 应该全局存储与更新，以下代码以写入到文件中做示例
        $data = !file_exists($this->path.'jsapi_ticket.json') ? null : json_decode(file_get_contents($this->path.'jsapi_ticket.json'));
        if ($data == nul || !is_object($data) || $data->expire_time < time()) {
            $accessToken = $this->getAccessToken();
            // 如果是企业号用以下 URL 获取 ticket
            // $url = "https://qyapi.weixin.qq.com/cgi-bin/get_jsapi_ticket?access_token=$accessToken";
            $url = "https://api.weixin.qq.com/cgi-bin/ticket/getticket?type=jsapi&access_token=$accessToken";
            $res = json_decode($this->httpGet($url));
            $ticket = $res->ticket;
            if ($ticket) {
                $data->expire_time = time() + 7000;
                $data->jsapi_ticket = $ticket;
                $fp = fopen($this->path.'jsapi_ticket.json', 'w');
                fwrite($fp, json_encode($data));
                fclose($fp);
            }
        } else {
            $ticket = $data->jsapi_ticket;
        }

        return $ticket;
    }

    public function getAccessToken()
    {
        // access_token 应该全局存储与更新，以下代码以写入到文件中做示例
        $data = !file_exists($this->path.'access_token.json') ? null : json_decode(file_get_contents($this->path.'access_token.json'));
        //$data = json_decode(file_get_contents("access_token.json"));
        if ($data == null || !is_object($data) || $data->expire_time < time()) {
            // 如果是企业号用以下URL获取access_token
            // $url = "https://qyapi.weixin.qq.com/cgi-bin/gettoken?corpid=$this->appId&corpsecret=$this->appSecret";
            $url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=$this->appId&secret=$this->appSecret";
            $res = json_decode($this->httpGet($url));
            //var_dump($res);
            $access_token = $res->access_token;
            if ($access_token) {
                $data->expire_time = time() + 7000;
                $data->access_token = $access_token;
                $fp = fopen($this->path.'access_token.json', 'w');
                fwrite($fp, json_encode($data));
                fclose($fp);
            }
        } else {
            $access_token = $data->access_token;
        }

        return $access_token;
    }

    private function httpGet($url)
    {
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_TIMEOUT, 500);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($curl, CURLOPT_URL, $url);

        $res = curl_exec($curl);
        curl_close($curl);

        return $res;
    }
    */
}
