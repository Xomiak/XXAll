<script src="/js/simplemodal.js"></script>
<link type="text/css"  rel="stylesheet" href="/css/setka_form.css" />
<script>
/*

HW Slider - простой слайдер на jQuery. 

Настройки скрипта:

hwSlideSpeed - Скорость анимации перехода слайда.
hwTimeOut - время до автоматического перелистывания слайдов.
hwNeedLinks - включает или отключает показ ссылок "следующий - предыдущий". Значения true или false

Подробнее на http://heavenweb.ru/

*/
(function ($) {
var hwSlideSpeed = 700;
var hwTimeOut = 3000;
var hwNeedLinks = true;

$(document).ready(function(e) {
	$('.month').css(
		{"position" : "absolute",
		 "top":'0', "left": '0'}).hide().eq(0).show();
	var slideNum = 0;
	var slideTime;
	slideCount = $("#slider_month .month").size();
	var animSlide = function(arrow){
		clearTimeout(slideTime);
		$('.month').eq(slideNum).fadeOut(hwSlideSpeed);
		if(arrow == "next"){
			if(slideNum == (slideCount-1)){slideNum=0;}
			else{slideNum++}
			}
		else if(arrow == "prew")
		{
			if(slideNum == 0){slideNum=slideCount-1;}
			else{slideNum-=1}
		}
		else{
			slideNum = arrow;
			}
		$('.month').eq(slideNum).fadeIn(hwSlideSpeed, rotator);
		$(".control-slide.active").removeClass("active");
		$('.control-slide').eq(slideNum).addClass('active');
		}
if(hwNeedLinks){
//var $linkArrow = $('<a id="left_button_month" href="#">&lt;</a><a id="kalendar_next" href="#">&gt;</a>')
	//.prependTo('#slider_month');		
	$('.kalendar_next').click(function(){
		animSlide("next");
		return false;
		})
	$('#kalendar_prew').click(function(){
		animSlide("prew");
		return false;
		})
}
	var $adderSpan = '';
	$('.month').each(function(index) {
			$adderSpan += '<span class = "control-slide">' + index + '</span>';
		});
	//$('<div class ="sli-links">' + $adderSpan +'</div>').appendTo('#slider-wrap');
	$(".control-slide:first").addClass("active");
	$('.control-slide').click(function(){
	var goToNum = parseFloat($(this).text());
	animSlide(goToNum);
	});
	var pause = true;
	var rotator = function(){
			//if(!pause){slideTime = setTimeout(function(){animSlide('next')}, hwTimeOut);}
			}
	$('#slider_month').hover(	
		function(){clearTimeout(slideTime); pause = true;},
		function(){pause = false; rotator();
		});
	rotator();
});
})(jQuery);

</script>

<div id="kalendar">
            <script>
            var next_asd = 0;
            function nextLR_asd()
            {                                    
                if(next_asd == 0)
                {
                    $("#next_asd").html('<');
                    next_asd = 1;
                }
                else
                {
                    $("#next_asd").html('>');
                    next_asd = 0;
                }
            }
            </script>
    <div><span id="kalendar_zayn">Календарь занятости </span><a style="cursor: pointer;"><span onclick="nextLR_asd()" id="next_asd" class="kalendar_next">></span></a><span id="kalendar_year">2013</span></div>
    <div class="clr"></div>

    <div id="slider_month">				
        <div class="month">
            <div class="one_month">
                <center><span class="month_name">Июль</span></center>
                <div class="month_l_full"></div><div><label><input type="checkbox" /><span class="lab_sp"></span></label></div>
            </div>
            <div class="one_month">
                <center><span class="month_name">Август</span></center>
                <div><label><input type="checkbox" /><span class="lab_sp"></span></label></div><div><label><input type="checkbox" /><span class="lab_sp"></span></label></div>
            </div>
            <div class="one_month">
                <center><span class="month_name">Сетябрь</span></center>
                <div class="month_l_full"></div><div class="month_r_full"></div>
            </div>
            <div class="one_month">
                <center><span class="month_name">Октябрь</span></center>
                <div><form><label><input type="checkbox" /><span class="lab_sp"></span></label></form></div><div class="month_l_full"></div>
            </div>
            <div class="one_month">
                <center><span class="month_name">Ноябрь</span></center>
                <div class="month_l_full"></div><div><form><label><input type="checkbox" /><span class="lab_sp"></span></label></form></div>
            </div>
            <div class="one_month">
                <center><span class="month_name">Декабрь</span></center>
                <div class="month_l_full"></div><div><form><label><input type="checkbox" /><span class="lab_sp"></span></label></form></div>
            </div>
        </div>
        <div class="month">
            <div class="one_month">
                <center><span class="month_name">Январь</span></center>
                <div class="month_l_full"></div><div class="month_r_full"></div>
            </div>
            <div class="one_month">
                <center><span class="month_name">Февраль</span></center>
                <div><form><label><input type="checkbox" /><span class="lab_sp"></span></label></form></div><div class="month_l_full"></div>
            </div>
            <div class="one_month">
                <center><span class="month_name">Март</span></center>
                <div class="month_l_full"></div><div class="month_r_full"></div>
            </div>
            <div class="one_month">
                <center><span class="month_name">Апрель</span></center>
                <div><form><label><input type="checkbox" /><span class="lab_sp"></span></label></form></div><div><form><label><input type="checkbox" /><span class="lab_sp"></span></label></form></div>
            </div>
            <div class="one_month">
                <center><span class="month_name">Май</span></center>
                <div><form><label><input type="checkbox" /><span class="lab_sp"></span></label></form></div><div><form><label><input type="checkbox" /><span class="lab_sp"></span></label></form></div>
            </div>
            <div class="one_month">
                <center><span class="month_name">Июнь</span></center>
                <div class="month_l_full"></div><div><form><label><input type="checkbox" /><span class="lab_sp"></span></label></form></div>
            </div>
        </div>
    </div>
        <a id="okno_vxod" href="#"><input id="kalendar_subm" name="#" type="submit" value="Отправить запрос"/></a>
    <div id="content_vxod" class="basic_content">
        <div id="setka_form">
            <span>Ваше имя (обязательно) </span><input class="inp1" type="text"/><br />
            <span>Ваш E-mail (обязательно)</span> <input class="inp1" type="text"/><br />
           <span> Номер телефона</span> <input class="inp1" type="text"/><br />
            <span>Комментарий </span><input class="inp2" type="text"/><br />
            <input class="setka_subm" value="Отправить" type="submit"/>
        </div>
    </div>
</div>
