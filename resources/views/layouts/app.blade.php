<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="format-detection" content="telephone=no"/>
    <meta name="apple-mobile-web-app-capable" content="yes"/>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{env("PAGE_TITLE")}}</title>
    <link rel="stylesheet" href="{{asset('assets/css/common.css')}}">
    <script>
        var actionUrl = '{{url("action")}}';
        //var wxShareUrl = '{{url("wx/share")}}';
        var wxData = {};
        wxData.title = '{{env("WECHAT_SHARE_TITLE")}}';
        wxData.desc = '{{env("WECHAT_SHARE_DESC")}}';
        wxData.link = '{{url("/")}}';
        wxData.imgUrl = '{{asset(env("WECHAT_SHARE_IMG"))}}';
        //wxData.jsApiList = '';
        wxData.debug = true;
    </script>

    <script src="{{asset('assets/js/jquery-1.9.1.min.js')}}"></script>
    <script src="{{asset('assets/js/hammer.js')}}"></script>
    <script src="{{asset('assets/js/jquery.tinyscrollbar.min.js')}}"></script>
    <script src="{{asset('assets/js/common.js')}}"></script>
    <!--移动端版本兼容 -->
    <script type="text/javascript">
        var phoneWidth = parseInt(window.screen.width);
        var phoneScale = phoneWidth / 640;
        var ua = navigator.userAgent;
        if (/Android (\d+\.\d+)/.test(ua)) {
            var version = parseFloat(RegExp.$1);
            if (version > 2.3) {
                document.write('<meta name="viewport" content="width=640, minimum-scale = ' + phoneScale + ', maximum-scale = ' + phoneScale + ', target-densitydpi=device-dpi , user-scalable=no">');
            } else {
                document.write('<meta name="viewport" content="width=640, target-densitydpi=device-dpi , user-scalable=no">');
            }
        } else {
            document.write('<meta name="viewport" content="width=640, minimum-scale=0.1, maximum-scale=1.0 , user-scalable=no" />');
        }
    </script>
    <!--移动端版本兼容 end -->

</head>
<body>
@yield('content')
@yield('scripts')
    <script src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js"></script>
    <script src="http://wx.ompchina.net/resources/Scripts/weixinjssdk.js"></script>
    <script type="text/javascript">
    function wxShare(unlock)
    {
        DATAForWeixin.debug = wxData.debug; // 可设置为 true 以调试
        DATAForWeixin.appId = 'wx1f984cba30eb34b7',//账号的appid//
        DATAForWeixin.openid = '',
        DATAForWeixin.sharecampaign = '善存钙尔奇孕妇瑜伽',//campaign名称

        /* 请修改以下文字和图片，定制分享文案 */
        DATAForWeixin.setTimeLine({
            title: wxData.desc,
            imgUrl: wxData.imgUrl,
            link: wxData.link,
            success:function(){
                if(unlock){
                    $('#unlockForm').submit();
                    //location.href='{{url("unlock")}}';
                }
            }
        });
        DATAForWeixin.setAppMessage({
            title: wxData.title,
            imgUrl: wxData.imgUrl,
            desc: wxData.desc,
            link: wxData.link,
            success:function(){
                if(unlock){
                    $('#unlockForm').submit();
                    //location.href='{{url("unlock")}}';
                }
            }
        });
        DATAForWeixin.setQQ({
            title: wxData.title,
            imgUrl: wxData.imgUrl,
            desc: wxData.desc,
            link: wxData.link
          });
    }
    $(document).ready(function() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    });
    wxShare();

    </script>
    
<script>!(function(a,b,c,d,e,f){var g="",h=a.sessionStorage,i="__admaster_ta_param__",j="tmDataLayer"!==d?"&dl="+d:"";
if(a[f]={},a[d]=a[d]||[],a[d].push({startTime:+new Date,event:"tm.js"}),h){var k=a.location.search,
l=new RegExp("[?&]"+i+"=(.*?)(&|#|$)").exec(k)||[];l[1]&&h.setItem(i,l[1]),l=h.getItem(i),
l&&(g="&p="+l+"&t="+ +new Date)}var m=b.createElement(c),n=b.getElementsByTagName(c)[0];m.src="//tag.cdnmaster.com/tmjs/tm.js?id="+e+j+g,
m.async=!0,n.parentNode.insertBefore(m,n)})(window,document,"script","tmDataLayer","TM-122714","admaster_tm");</script>

</body>
</html>
