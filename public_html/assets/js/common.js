//找到url中匹配的字符串
function findInUrl(str) {
    url = location.href;
    return url.indexOf(str) == -1 ? false : true;
}
//获取url参数
function queryString(key) {
    return (document.location.search.match(new RegExp("(?:^\\?|&)" + key + "=(.*?)(?=&|$)")) || ['', null])[1];
}

//产生指定范围的随机数
function randomNumb(minNumb, maxNumb) {
    var rn = Math.round(Math.random() * (maxNumb - minNumb) + minNumb);
    return rn;
}


var selType = 0;

function goSelPage(params) {
    if (topCanClick) {
        topCanClick = false;
        mc.destroy();
        //提交选择
        if (selType == 1) {
			_smq.push(['custom','Cal1','02_Middle']);
            window.location.href = params[0];
        } else if (selType == 2) {
			_smq.push(['custom','Cal1','03_Late']);
            window.location.href = params[1];
        } else {
            window.location.reload();
        }
    }
}

//移动
var reqAnimationFrame = (function() {
    return window[Hammer.prefixed(window, 'requestAnimationFrame')] || function(callback) {
        window.setTimeout(callback, 1000 / 60);
    };
})();

var el;
var ei;

var START_X = 0; //Math.round((window.innerWidth - el.offsetWidth) / 2);
var START_Y = 0; //Math.round((window.innerHeight - el.offsetHeight) / 2);

var endx = 0;
var endy = 0;
var posX = 0;
var posY = 0;

var ticking = false;
var transform;
var timer;
var topCanClick = false;

var mc;

var iX = 0;
var iY = 0;

function changeMc() {
    el = document.querySelector("#touchBlock");
    ei = document.querySelector('#scrollInit');
    mc = new Hammer.Manager(el);

    mc.add(new Hammer.Pan({
        threshold: 0,
        pointers: 0
    }));
    mc.on("panstart panmove panend", onPan);

    resetElement();

    $('#touchBlock').on('touchend', function() {
        setTimeout(function() {
            $('.topInit').html('确认');
            topCanClick = true;
        }, 100);
    });
}

function resetElement() {
    el.className = 'animate';
    transform = {
        translate: {
            x: START_X,
            y: START_Y
        },
        scale: 1,
        angle: 0,
        rx: 0,
        ry: 0,
        rz: 0
    };
    requestElementUpdate();
}

var isFirst = true;

function updateElementTransform() {
    if (transform.translate.x < 0) {
        transform.translate.x = 0;
    }
    if (transform.translate.x > 360) {
        transform.translate.x = 360;
    }

    var value = [

        'translate3d(' + transform.translate.x + 'px, ' + 0 + 'px, 0)',

        'scale(' + transform.scale + ', ' + transform.scale + ')',

        'rotate3d(' + transform.rx + ',' + transform.ry + ',' + transform.rz + ',' + transform.angle + 'deg)'

    ];

    iX = transform.translate.x;
    topCanClick = false;

    if (transform.translate.x >= 220) {
        $('.topInit').css({
            "background-position": "-80px,0",
            'color': '#f64200'
        });
        if (!isFirst) {
            $('.topInit').html('孕晚期');
            selType = 2;
        }
    } else {
        $('.topInit').css({
            "background-position": "0,0",
            'color': '#ff880e'
        });
        if (!isFirst) {
            $('.topInit').html('孕中期');
            selType = 1;
        }
    }

    isFirst = false;
    value = value.join(" ");
    ei.style.webkitTransform = value;
    ei.style.mozTransform = value;
    ei.style.transform = value;
    ticking = false;
}


function requestElementUpdate() {
    if (!ticking) {
        reqAnimationFrame(updateElementTransform);
        ticking = true;
    }
}

function onPan(ev) {
    el.className = '';
    switch (ev.type) {
        case 'panmove':
            posX = ev.deltaX + endx;
            posY = ev.deltaY + endy;
            break;
        case 'panend':
            endx = posX;
            endy = posY;
            break;
    }
    transform.translate = {
        x: posX,
        y: posY
    };
    requestElementUpdate();
}

function showRule() {
    $('.popBg').show();
    $('.ruleBlock').show();
    $('#scrollbar').tinyscrollbar();
}

function closeRule() {
    $('.popBg').fadeOut(500);
    $('.ruleBlock').fadeOut(500);
}

var canGoAct = '14';

function getBtn2() {
    $('.btn2 .abTop2').addClass('abTop2Act');
    $('.btn2 .manB').addClass('abTop2Act');
    $('.btn2 .manBout').css({
        '-webkit-transform': 'translate(-10px,-15px) scale(0.8)',
        'top': '0'
    });
    $('.btn2 .manMain').removeClass('manBMain manBAct').addClass('manAMain manAAct');
    canGoAct = canGoAct + '2';
}

function getBtn3() {
    $('.btn3 .abTop3').addClass('abTop3Act');
    $('.btn3 .manC').addClass('abTop3Act');
    $('.btn3 .manCout').css({
        '-webkit-transform': 'translate(-15px,-30px) scale(0.7)',
        'top': '0'
    });
    $('.btn3 .manMain').removeClass('manBMain manBAct').addClass('manAMain manAAct');
    canGoAct = canGoAct + '3';
}

function getBtn5() {
    $('.btn5 .abTop2').addClass('abTop2Act');
    $('.btn5 .manB').addClass('abTop2Act');
    $('.btn5 .manBout').css({
        '-webkit-transform': 'translate(-10px,-15px) scale(0.8)',
        'top': '0'
    });
    $('.btn5 .manMain').removeClass('manBMain manBAct').addClass('manAMain manAAct');
    canGoAct = canGoAct + '5';
}

function getBtn6() {
    $('.btn6 .abTop3').addClass('abTop3Act');
    $('.btn6 .manC').addClass('abTop3Act');
    $('.btn6 .manCout').css({
        '-webkit-transform': 'translate(-15px,-30px) scale(0.7)',
        'top': '0'
    });
    $('.btn6 .manMain').removeClass('manBMain manBAct').addClass('manAMain manAAct');
    canGoAct = canGoAct + '6';
    $('.eFlag').show();
}

function goAct(e) {
    if (canGoAct.indexOf(e) < 0) {
        return false;
    } else {
        window.location.href = actionUrl+'/'+ ((e-1)%3+1);
        //window.location.href = 'act' + e + '.html';
    }
}

function goAct2() {
    $('.Act1').fadeOut(500);
    $('.Act2').fadeIn(500);
	_smq.push(['custom','Cal3','11_Exercise']);
}

function showActRule() {
    $('.popBg').show();
    $('.ActRuleBlock').show();
    $('#scrollbar2').tinyscrollbar();
	_smq.push(['custom','Cal3','12_Detail']);
}

function closeActRule() {
    $('.popBg').fadeOut(500);
    $('.ActRuleBlock').fadeOut(500);
}

function goAct3(url) {
    $('.Act2').fadeOut(500);
    $('.Act3').fadeIn(500);
    var data = $('#unlockForm').serializeArray();
    $.ajax(url,{
        type: 'post',
        data: data,
        success: function(json){

        },
        error: function(){

        }
    })
	_smq.push(['custom','Cal3','13_Start']);
}

function goAct4() {
    $('.Act3').fadeOut(500);
    $('.Act4').fadeIn(500);
    wxShare(true);
}


function startAct1() {
    $('.actBtn3').hide();
    actInterval;
    actInterval = setInterval(function() {
        act1act();
    }, 1000);
}

function act1act() {
    nowTime++;
    if (nowTime >= actTime) {
        clearInterval(actInterval);
        wxData.DESC = '我和胎宝宝一起解锁了主题2孕动插画，好孕之路更进一步。';
        goAct4();
        return false;
    }
    if (nowTime < 60 && (nowTime % 3 == 1)) {
        $('.actImg').hide();
        $('.actImg2').show();
    }
    if (nowTime < 60 && (nowTime % 3 == 2)) {
        $('.actImg').hide();
        $('.actImg3').show();
    }
    if (nowTime < 60 && (nowTime % 3 == 0)) {
        $('.actImg').hide();
        $('.actImg1').show();
    }
    if (nowTime == 60) {
        $('.actImg').hide();
        $('.restTime').show();
    }
    if (nowTime == 61) {
        $('.restTime').html(4);
    }
    if (nowTime == 62) {
        $('.restTime').html(3);
    }
    if (nowTime == 63) {
        $('.restTime').html(2);
    }
    if (nowTime == 64) {
        $('.restTime').html(1);
    }
    if (nowTime == 65) {
        $('.restTime').hide();
        $('.actImg').hide();
        $('.actImg3').show();
    }
    if (nowTime > 65 && (nowTime % 3 == 0)) {
        $('.actImg').hide();
        $('.actImg2').show();
    }
    if (nowTime > 65 && (nowTime % 3 == 2)) {
        $('.actImg').hide();
        $('.actImg3').show();
    }
    if (nowTime > 65 && (nowTime % 3 == 1)) {
        $('.actImg').hide();
        $('.actImg1').show();
    }
    var mm = parseInt(nowTime / 60);
    var ss = nowTime % 60;
    if (mm < 10) {
        mm = '0' + mm.toString();
    }
    if (ss < 10) {
        ss = '0' + ss.toString();
    }
    $('.time1').html(mm + ':' + ss);
    $('.timeGoBar').width(nowTime / actTime * 100 + '%');
}

function startAct2() {
    $('.actBtn3').hide();
    actInterval;
    actInterval = setInterval(function() {
        act2act();
    }, 1000);
}

function act2act() {
    nowTime++;
    if (nowTime >= actTime) {
        clearInterval(actInterval);
        wxData.DESC = '我和胎宝宝一起解锁了主题3孕动插画，好孕之路更进一步。';
        goAct4();
        return false;
    }
    if (nowTime == 6) {
        $('.actImg').hide();
        $('.actImg2').show();
    }
	if(nowTime==59||nowTime==119||nowTime==175){
		$('.act2Img3Bg').addClass('act2Img3BgAct').show();
		}
	if(nowTime==65||nowTime==125){
		$('.act2Img3Bg').hide().removeClass('act2Img3BgAct');
		}
    var mm = parseInt(nowTime / 60);
    var ss = nowTime % 60;
    if (mm < 10) {
        mm = '0' + mm.toString();
    }
    if (ss < 10) {
        ss = '0' + ss.toString();
    }
    $('.time1').html(mm + ':' + ss);
    $('.timeGoBar').width(nowTime / actTime * 100 + '%');
}

function startAct3() {
    $('.actBtn3').hide();
    actInterval;
    actInterval = setInterval(function() {
        act3act();
    }, 1000);
}

function act3act() {
    nowTime++;
    if (nowTime >= actTime) {
        clearInterval(actInterval);
        wxData.DESC = '我和胎宝宝一起解锁了主题4孕动插画，好孕之路更进一步。';
        goAct4();
        return false;
    }
    if (nowTime == 6) {
        $('.actImg').hide();
        $('.actImg2').show();
    }
    if (nowTime == 11) {
        $('.actImg').hide();
        $('.actImg3').show();
    }
    if (nowTime == 90) {
        $('.actImg').hide();
        $('.restTime').show();
    }
    if (nowTime == 91) {
        $('.restTime').html(4);
    }
    if (nowTime == 92) {
        $('.restTime').html(3);
    }
    if (nowTime == 93) {
        $('.restTime').html(2);
    }
    if (nowTime == 94) {
        $('.restTime').html(1);
    }
    if (nowTime == 95) {
        $('.restTime').hide();
        $('.actImg').hide();
        $('.actImg1').show();
    }
    if (nowTime == 101) {
        $('.actImg').hide();
        $('.actImg2').show();
    }
    if (nowTime == 106) {
        $('.actImg').hide();
        $('.actImg3').show();
    }
    var mm = parseInt(nowTime / 60);
    var ss = nowTime % 60;
    if (mm < 10) {
        mm = '0' + mm.toString();
    }
    if (ss < 10) {
        ss = '0' + ss.toString();
    }
    $('.time1').html(mm + ':' + ss);
    $('.timeGoBar').width(nowTime / actTime * 100 + '%');
}

function startAct4() {
    $('.actBtn3').hide();
    actInterval;
    actInterval = setInterval(function() {
        act4act();
    }, 1000);
}

function act4act() {
    nowTime++;
    if (nowTime >= actTime) {
        clearInterval(actInterval);
        wxData.DESC = '我和胎宝宝一起解锁了主题5孕动插画，好孕之路更进一步。';
        goAct4();
        return false;
    }
    if (nowTime == 6) {
        $('.actImg').hide();
        $('.actImg2').show();
    }
    if (nowTime == 16) {
        $('.actImg').hide();
        $('.actImg3').show();
    }
    if (nowTime == 80) {
        $('.actImg').hide();
        $('.restTime').show();
    }
    if (nowTime == 81) {
        $('.restTime').html(4);
    }
    if (nowTime == 82) {
        $('.restTime').html(3);
    }
    if (nowTime == 83) {
        $('.restTime').html(2);
    }
    if (nowTime == 84) {
        $('.restTime').html(1);
    }
    if (nowTime == 85) {
        $('.restTime').hide();
        $('.actImg').hide();
        $('.actImg4').show();
    }
    if (nowTime == 91) {
        $('.actImg').hide();
        $('.actImg5').show();
    }
    if (nowTime == 101) {
        $('.actImg').hide();
        $('.actImg6').show();
    }
    var mm = parseInt(nowTime / 60);
    var ss = nowTime % 60;
    if (mm < 10) {
        mm = '0' + mm.toString();
    }
    if (ss < 10) {
        ss = '0' + ss.toString();
    }
    $('.time1').html(mm + ':' + ss);
    $('.timeGoBar').width(nowTime / actTime * 100 + '%');
}

function startAct5() {
    $('.actBtn3').hide();
    actInterval;
    actInterval = setInterval(function() {
        act5act();
    }, 1000);
}

function act5act() {
    nowTime++;
    if (nowTime >= actTime) {
        clearInterval(actInterval);
        wxData.DESC = '我和胎宝宝一起解锁了主题6孕动插画，好孕之路更进一步。';
        goAct4();
        return false;
    }
    if (nowTime % 8 == 1) {
        $('.actImg').hide();
        $('.actImg1').show();
    }
    if (nowTime % 8 == 4) {
        $('.actImg').hide();
        $('.actImg2').show();
    }
    var mm = parseInt(nowTime / 60);
    var ss = nowTime % 60;
    if (mm < 10) {
        mm = '0' + mm.toString();
    }
    if (ss < 10) {
        ss = '0' + ss.toString();
    }
    $('.time1').html(mm + ':' + ss);
    $('.timeGoBar').width(nowTime / actTime * 100 + '%');
}

function startAct6() {
    $('.actBtn3').hide();
    actInterval;
    actInterval = setInterval(function() {
        act6act();
    }, 1000);
}

function act6act() {
    nowTime++;
    if (nowTime >= actTime) {
        clearInterval(actInterval);
        goAct4();
        return false;
    }
    if (nowTime < 60 && nowTime % 10 == 1) {
        $('.actImg').hide();
        $('.actImg1').show();
    }
    if (nowTime < 60 && nowTime % 10 == 6) {
        $('.actImg').hide();
        $('.actImg2').show();
    }
    if (nowTime == 60) {
        $('.actImg').hide();
        $('.restTime').show();
    }
    if (nowTime == 61) {
        $('.restTime').html(4);
    }
    if (nowTime == 62) {
        $('.restTime').html(3);
    }
    if (nowTime == 63) {
        $('.restTime').html(2);
    }
    if (nowTime == 64) {
        $('.restTime').html(1);
    }
    if (nowTime == 65) {
        $('.restTime').hide();
        $('.actImg').hide();
        $('.actImg3').show();
    }
    if (nowTime > 65 && nowTime % 10 == 6) {
        $('.actImg').hide();
        $('.actImg3').show();
    }
    if (nowTime > 65 && nowTime % 10 == 1) {
        $('.actImg').hide();
        $('.actImg4').show();
    }
    var mm = parseInt(nowTime / 60);
    var ss = nowTime % 60;
    if (mm < 10) {
        mm = '0' + mm.toString();
    }
    if (ss < 10) {
        ss = '0' + ss.toString();
    }
    $('.time1').html(mm + ':' + ss);
    $('.timeGoBar').width(nowTime / actTime * 100 + '%');
}

var canSubmit = true;

function submitInfo(url) {
	_smq.push(['custom','Cal4','15_Submit']);
    var iName = $.trim($('.infoTxt1').val());
    var iSex = '女';
    var iTel = $.trim($('.infoTxt2').val());
    var iCity = $.trim($('.infoTxt3').val());
    var iAddress = $.trim($('.infoArea').val());
    var pattern = /^1[3456789]\d{9}$/;

    if (iName == '') {
        alert('请输入姓名');
        return false;
    }
    /*if (iSex == '') {
        alert('请选择性别');
        return false;
    }*/
    if (iTel == '' || !pattern.test(iTel)) {
        alert('请输入正确的手机号码');
        return false;
    }
    if (iCity == '') {
        alert('请输入所在地区');
        return false;
    }
    if (iAddress == '') {
        alert('请输入详细地址');
        return false;
    }

    //ajax提交
    if (canSubmit) {
        canSubmit = false;
        var data = {
            name: iName,
            mobile: iTel,
            gender: iSex,
            district: iCity,
            address: iAddress
        };
        $.ajax(url, {
            data: data,
            type: 'post',
            dataType: 'json',
            success: function(json) {
                if (json.ret == 0) {
                    //提交成功
                    alert('信息提交成功');
                    $('.popBg,.infoBlock').hide();
                    //跳下一关
                    //window.location.href = json.url;
                } else {
                    canSubmit = true;
                    alert(json.msg);
                }
            },
            error: function() {
                //提交失败
                canSubmit = true;
                alert('提交失败~请稍候重试')
            }
        })
    }
}

function showInfo() {
    $('.popBg').fadeIn(500);
    $('.infoBlock').fadeIn(500);
}

function closeInfo(){
	$('.popBg').fadeOut(500);
    $('.infoBlock').fadeOut(500);
	}

function showShareNote() {
    $('.popBg').fadeIn(500);
    $('.popShare').fadeIn(500);
	_smq.push(['custom','Cal4','14_Share']);
}

function closePopShare() {
    $('.popBg').fadeOut(500);
    $('.popShare').fadeOut(500);
}

var isPlay = true;

function bgmCon() {
    if (isPlay) {
        isPlay = false;
        var bgm = document.getElementById('bgm');
        bgm.pause();
        $('.bgm1').hide();
        $('.bgm2').show();
    } else {
        isPlay = true;
        var bgm = document.getElementById('bgm');
        bgm.play();
        $('.bgm2').hide();
        $('.bgm1').show();
    }
}
