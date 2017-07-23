/*
* Author : Design Guruji
* Template Name : Mogaly - Multipurpose Portfolio Template
* Build Date : January, 2017
* Version : 1.0
* Copyright © 2017 Design Guruji
*/

"use strict";
function bannerHeight() {
      var windowHeight = $(window).height();
      $(".welcome").css("height", windowHeight);
}
jQuery(document).ready(function() {
"use strict";
      /* Background Parallax Scrolling*/
      /*------------------------*/
      if ($(window).width() > 1280) {
            $(".parallax").parallax({
                  speed: 0.50
            });
      }
      $(window).on("load scroll", function() {
            var wScrollTop  = $(window).scrollTop();
            if(wScrollTop > 1) {
                  $("#pageHeader").addClass("affix");
            } else {
                  $("#pageHeader").removeClass("affix");
            }
      });

      /* Bootstrap Scroll Spy*/
      /*------------------------*/
      $("body").scrollspy({
            target: ".navbar-collapse",
            offset: 60
      });
      /* Collapse navigation on click on nav anchor in Mobile*/
      /*------------------------*/
      $(".nav a").on('click', function() {
            $("#myNavbar").removeClass("in").addClass("collapse");
      });
      /* Header Navigation Scrolling*/
      /*------------------------*/
      $(".navbar-nav li a, .navbar-brand, .button a").on("click", function (e) {
            var anchor = $(this);
            $("html, body").stop().animate({
                scrollTop: $(anchor.attr("href")).offset().top - 60
            }, 1000);
            e.preventDefault();
        });
        /* Typewritter Text */
       /*------------------------*/
      $(".type").typed({
            strings: ["FrondEnd Developer", "UI/UX Designer", "Visualizer", "Photographer"],
            loop: true,
            startDelay: 20,
            typeSpeed:0.5,
            backDelay:3e3,
            loopCount:!1
      });
      /* Progress Bars with AppearJS */
     /*------------------------*/
      $(".progress .progress-bar").appear(function () {
               $('.progress .progress-bar').progressbar();
      });
      /* Fun Facts (Counters)*/
      /*------------------------*/
      $(".text-counter").counterUp({
            delay: 10,
            time: 2000
      });
      /* Portfolio - Layout Isotope after each image loads*/
      /*------------------------*/
      $(".grid").imagesLoaded().progress( function() {
            $(".grid").isotope("layout");
      });
      /*  Portfolio - Full Width  */
      /*------------------------*/
      $(".grid").isotope({
            itemSelector: ".item"
      });
      /*  Portfolio - Filter Items on anchor click*/
      /*------------------------*/
      $(".filters li").on("click", "a", function(e) {
            e.preventDefault();
            var filterValue = $(this).attr("data-filter");
            $(".grid").isotope({
                  filter: filterValue
            });
      });
      /*  Portfolio - Toggle Active Class*/
      /*------------------------*/
      $(".filters").each(function(i, buttonGroup) {
            var $buttonGroup = $(buttonGroup);
            $buttonGroup.on("click", "a", function() {
                  $buttonGroup.find(".active").removeClass("active");
                  $(this).addClass("active");
            });
      });
      /*  Portfolio Gallery Popup*/
      /*------------------------*/
      $("a[data-rel^=lightcase]").lightcase({showSequenceInfo:false});
      /*  Banner  Owl Carousel*/
      /*------------------------*/
      $(".banner-carousel").owlCarousel({
            margin: 0,
            loop: true,
            nav: true,
            dots: true,
            autoplay:false,
            smartSpeed: 1000,
            navText: ['<i class="fa fa-angle-left"></i>', '<i class="fa fa-angle-right"></i>'],
            responsive: {
                  0: { items: 1 },
                  1000: { items: 1 }
            }
      });
      /*  Testimonials Owl Carousel*/
      /*------------------------*/
      $(".testimonials-carousel").owlCarousel({
            margin: 30,
            loop: true,
            nav: true,
            dots: true,
            autoplay:true,
            navText: ['<i class="fa fa-angle-left"></i>', '<i class="fa fa-angle-right"></i>'],
            responsive: {
                  0: { items: 1 },
                  768: { items: 2},
                  1000: { items: 3 }
            }
      });
      /*  Clients Owl Carousel*/
      /*------------------------*/
      $(".clients-carousel").owlCarousel({
            margin: 30,
            loop: true,
            nav: false,
            dots: false,
            autolay:true,
            navText: ['<i class="fa fa-angle-left"></i>', '<i class="fa fa-angle-right"></i>'],
            responsive: {
                  0: { items: 1 },
                  480: { items: 2 },
                  767: { items: 3 },
                  991: { items: 4 },
                  1200: { items: 5 },
                  1600: { items: 6 }
            }
      });
      /* Copyright Year */
      /*------------------------*/
      var currentYear = (new Date).getFullYear();
      $("#copyright-year").text((new Date).getFullYear());

      /*  Style Switcher */
      /*------------------------------------------------------------------>*/
      $("head").append('<link rel="stylesheet" type="text/css"  id="switch-style">');
            var $switchStyle = $(".switch-style");
            $(".switch-style-toggle").on("click", function(){
                  $switchStyle.toggleClass("active");
            });
            $(".color").on("click", function(e) {
                  var colorSkinsPath = $("#colorSkinsPath").val();
                  var id = $(this).attr("id");
                  $("#switch-style").attr("href", colorSkinsPath + id + ".css");
                  $(".switch-style").removeClass("active");
                  set_option('default_skin_color', id);
                  e.preventDefault();
            });

});

function set_option(name, value) {
    $.ajax({
          /* адрес файла-обработчика запроса */
        url: '/admin/ajax/option/set/',
          /* метод отправки данных */
        method: 'POST',
          /* данные, которые мы передаем в файл-обработчик */
        data: {
            "name": name,
            "value": value
        },

    }).done(function (data) {
        console.log(data);
//        $("#"+owner).html(data);
    });
}

jQuery(window).on("load resize", function() {
      /* Pre-Loader*/
      /*------------------------*/
      $("#preloader").fadeOut(450);
      /* Custome Fuctions */
      /*------------------------*/
      bannerHeight();
});

