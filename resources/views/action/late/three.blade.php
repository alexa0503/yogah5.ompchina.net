@extends('layouts.app')
@section('content')
<audio src="{{asset('assets/images/bgm.mp3')}}" id="bgm" preload="auto" autoplay loop style="display:none; height:0;"></audio>

<div class="wrapper">
	<div class="page Act1">
    	<div class="innerDiv">
        	<div class="act6Img1 bgImg"></div>
            <a href="javascript:void(0);" class="abs actBtn1" onClick="goAct2();"><img src="{{asset('assets/images/actBtn1.png')}}"></a>
        </div>
    </div>

    <div class="page Act2" style="display:none;">
    	<div class="innerDiv">
        	<div class="act6Img2 bgImg"></div>
            <div class="abs flower"></div>
            <a href="javascript:void(0);" class="abs actRule" onClick="showActRule();"><img src="{{asset('assets/images/space.gif')}}" width="158" height="26"></a>
            <a href="javascript:void(0);" class="abs actBtn2" onClick="goAct3();"><img src="{{asset('assets/images/actBtn2.png')}}"></a>
        </div>
    </div>

    <div class="page Act3" style="display:none;">
    	<div class="innerDiv">
        	<div class="act6Img3 bgImg"></div>
            <img src="{{asset('assets/images/page1Img4.png')}}" class="abs ac1">
            <img src="{{asset('assets/images/page1Img4.png')}}" width="70" class="abs ac2">
        	<div class="bgImg">
            	<div class="innerDiv">
                	<img src="{{asset('assets/images/act6A1.png')}}" class="actImg actImg1">
                	<img src="{{asset('assets/images/act6A2.png')}}" class="actImg actImg2" style="display:none;">
                    <img src="{{asset('assets/images/act6A3.png')}}" class="actImg actImg3" style="display:none;">
                    <img src="{{asset('assets/images/act6A4.png')}}" class="actImg actImg4" style="display:none;">
                </div>
            </div>
            <div class="time1">00:00</div>
            <div class="time2">02:05</div>
            <div class="timeBar">
            	<div class="timeGoBar"></div>
            </div>
            <a href="javascript:void(0);" class="abs actBtn3" onClick="startAct6();"><img src="{{asset('assets/images/actBtn3.png')}}"></a>
            <div class="restTime" style="display:none;">5</div>
        </div>
    </div>

    <div class="page Act4" style="display:none;">
    	<div class="innerDiv">
        	<div class="act6Img4 bgImg"></div>
            <img src="{{$wechat_user->head_img}}" class="abs wxImg">
            <div class="abs wxName">{{json_decode($wechat_user->nick_name)}}</div>
            <div class="btnLine">
				<a href="javascript:void(0);" onClick="showInfo();"><img src="{{asset('assets/images/actBtn4.png')}}"></a>
            	<a href="javascript:void(0);" onClick="showShareNote();"><img src="{{asset('assets/images/actBtn5.png')}}"></a>
            </div>
        </div>
    </div>
</div>

<a href="javascript:void(0);" class="abs backBtn" onClick="history.back(-1);"><img src="{{asset('assets/images/backBtn.png')}}"></a>
<a href="javascript:void(0);" class="bmgBtn" onClick="bgmCon();"><img src="{{asset('assets/images/musicBtn1.png')}}" class="bgm1 bmgOn">
	<img src="{{asset('assets/images/musicBtn2.png')}}" class="bgm2" style="display:none;"></a>

<div class="popBg" style="display:none;"></div>
<div class="ActRuleBlock ActRuleBlock6" style="display:none;">
	<div class="innerDiv">
    	<div class="ActRuleMain">
        	<div id="scrollbar2">
                <div class="scrollbar">
                    <div class="track">
                        <div class="thumb">
                            <div class="end"></div>
                        </div>
                    </div>
                </div>
                <div class="viewport">
                    <div class="overview">
                        <img src="{{asset('assets/images/a6S1.png')}}">
                    </div>
                </div>
            </div>
        </div>
        <a href="javascript:void(0);" class="abs ruleClose2" onClick="closeActRule();"><img src="{{asset('assets/images/space.gif')}}" width="41" height="41"></a>
    </div>
</div>
<div class="infoBlock" style="display:none;">
	<div class="innerDiv">
    	<div class="selSex">
        	<div class="selb sel1"></div>
            <div class="selb sel2"></div>
        </div>
    	<input type="text" class="infoTxt infoTxt1" maxlength="20">
        <input type="tel" class="infoTxt infoTxt2" maxlength="11">
        <input type="text" class="infoTxt infoTxt3" maxlength="20">
        <textarea class="infoArea" maxlength="40"></textarea>
        <a href="javascript:void(0);" class="abs infoBtn1" onClick="submitInfo('{{url("post")}}');"><img src="{{asset('assets/images/infoBtn1.png')}}"></a>
    </div>
</div>
<img src="{{asset('assets/images/popShare.png')}}" class="popShare" style="display:none;" onClick="closePopShare();">
<form action="{{url('unlock')}}" id="unlockForm" method="post">
	{!! csrf_field() !!}
	<input name="action" value="{{$action}}" type="hidden" />
</form>
@endsection
@section('scripts')
<script>
wxData.DESC = '我和胎宝宝一起解锁了主题6孕动插画，好孕之路更进一步。';
var actTime=125;//持续时间
var nowTime=0;//进行时间
var actInterval;
$('document').ready(function(){
	$('.selb').click(function(){
		$('.selb').removeClass('selOn');
		$(this).addClass('selOn');
		});
});
</script>
@endsection
