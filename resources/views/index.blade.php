@extends('layouts.app')
@section('content')

<audio src="{{asset('assets/images/bgm.mp3')}}" id="bgm" preload="auto" autoplay loop style="display:none; height:0;"></audio>

<div class="wrapper">
	<div class="page page1">
    	<div class="innerDiv">
        	<img src="{{asset('assets/images/page1Img4.png')}}" class="abs page1c1">
            <img src="{{asset('assets/images/page1Img4.png')}}" width="100" class="abs page1c2">
            <img src="{{asset('assets/images/page1Img4.png')}}" width="60" class="abs page1c3">
            <div class="page1Img2 bgImg"></div>
            <div class="page1Img3 bgImg"></div>
            <div class="scrollInit abs" id="scrollInit">
            	<div class="innerDiv">
                	<div class="topInit" onClick="goSelPage(['{{url("pregnancy/mid")}}','{{url("pregnancy/late")}}']);"><img src="{{$wechat_user->head_img}}" class="wxFace"></div>
                    <div class="bottomInit"></div>
                </div>
            </div>
            <div id="touchBlock"></div>
            <a href="javascript:void(0);" class="abs indexBtn1" onClick="showRule();"><img src="{{asset('assets/images/btn1.png')}}"></a>
        </div>
    </div>
</div>

<img src="{{asset('assets/images/logo.png')}}" class="logo">
<a href="javascript:void(0);" class="bmgBtn" onClick="bgmCon();"><img src="{{asset('assets/images/musicBtn1.png')}}" class="bgm1 bmgOn">
	<img src="{{asset('assets/images/musicBtn2.png')}}" class="bgm2" style="display:none;"></a>

<div class="popBg" style="display:none;"></div>
<div class="ruleBlock" style="display:none;">
	<div class="innerDiv">
    	<div class="ruleMain">
        	<div id="scrollbar">
                <div class="scrollbar">
                    <div class="track">
                        <div class="thumb">
                            <div class="end"></div>
                        </div>
                    </div>
                </div>
                <div class="viewport">
                    <div class="overview">
                        <img src="{{asset('assets/images/ruleImg.png')}}">
                    </div>
                </div>
            </div>
        </div>
        <a href="javascript:void(0);" class="abs ruleClose" onClick="closeRule();"><img src="{{asset('assets/images/space.gif')}}" width="41" height="41"></a>
    </div>
</div>
@endsection
@section('scripts')
<script>
$('document').ready(function(){
	$('#touchBlock').on('touchmove',function(e){
		e.preventDefault();
		});
	changeMc();
	});
</script>
@endsection
