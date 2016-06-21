@extends('layouts.app')
@section('content')

<audio src="{{asset('assets/images/bgm.mp3')}}" id="bgm" preload="auto" autoplay loop style="display:none; height:0;"></audio>

<div class="wrapper">
	<div class="page page2">
    	<div class="innerDiv">
        	<div class="abs btn1" onClick="goAct(1);_smq.push(['custom','Cal2','08_BestStart']);">
            	<div class="innerDiv">
                	<img src="{{asset('assets/images/aBtn11.png')}}" class="abs abTop1 abTop1Act">
                    <div class="manAout">
                    	<div class="manA abTop1Act">
                    		<div class="manAMain manAAct">1</div>
                    	</div>
                    </div>
                	<img src="{{asset('assets/images/aBtn12.png')}}" class="abs abBottom">
                </div>
            </div>

            <div class="abs btn2" onClick="goAct(2);_smq.push(['custom','Cal2','09_Great']);">
            	<div class="innerDiv">
                	<img src="{{asset('assets/images/aBtn21.png')}}" class="abs abTop2">
                    <div class="manBout">
                    	<div class="manB">
                    		<div class="manMain manBMain manBAct">2</div>
                    	</div>
                    </div>
                	<img src="{{asset('assets/images/aBtn22.png')}}" class="abs abBottom">
                </div>
            </div>

            <div class="abs btn3" onClick="goAct(3);_smq.push(['custom','Cal2','10_Equipment']);">
            	<div class="innerDiv">
                	<img src="{{asset('assets/images/aBtn31.png')}}" class="abs abTop3">
                    <div class="manCout">
                    	<div class="manC">
                    		<div class="manMain manBMain manBAct">3</div>
                    	</div>
                    </div>
                	<img src="{{asset('assets/images/aBtn32.png')}}" class="abs abBottom">
                </div>
            </div>

            <div class="eFlag abs" style="display:none;"></div>
        </div>
    </div>
</div>

<img src="{{asset('assets/images/logo.png')}}" class="logo">
<a href="javascript:void(0);" class="bmgBtn" onClick="bgmCon();"><img src="{{asset('assets/images/musicBtn1.png')}}" class="bgm1 bmgOn">
	<img src="{{asset('assets/images/musicBtn2.png')}}" class="bgm2" style="display:none;"></a>

@endsection
@section('scripts')
<script>
wxData.DESC = '{{env("WECHAT_PREGNANCY_SHARE_DESC")}}';
$('document').ready(function(){
	@if ($wechat_user->info->action >= 1)
	getBtn2();
	@endif
	@if ($wechat_user->info->action >= 2)
	getBtn3();
	@endif
});
</script>
@endsection
