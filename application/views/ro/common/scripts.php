<?php
$template = getTemplateName();
$assetsPath = '/application/views/'.$template.'/assets';
?>
<!--========== JQUERY FILES ==========-->
<script src="/js/lib/jquery-2.2.4.js"></script>
<!-- Bootstrap JS  -->
<script src="/bootstrap/js/bootstrap.js"></script>
<!-- Plugins JS  -->
<script src="/js/typed.js"></script>
<script src="/js/appear.js"></script>
<script src="/js/owl.carousel.js"></script>
<script src="/js/easing.js"></script>
<script src="/js/parallax.js"></script>
<script src="/js/waypoints.js"></script>
<script src="/js/counterup.js"></script>
<script src="/js/isotope.js"></script>
<script src="/js/imagesloaded.js"></script>
<script src="/js/lightcase.js"></script>
<!-- Fancybox -->
<script src="/js/fancybox/jquery.fancybox.min.js"></script>
<!-- Custom JS  -->
<script src="/js/functions.js"></script>
<!--[if lt IE 9]>
<script src="/js/modernizr.min.js"></script>
<![endif]-->
<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCq_azNrbz2eHhbjMisZwUUaIz9hPihulc"></script>
<script type="text/javascript" src="/js/google-map.js"></script>
<script>
    var showed = false;
    $(document).ready(function () {
        $('.xhideme').slideUp(500);

        $('.xnocookies').click(
            function () {
                if (!showed) {
                    $(this).siblings('.xhideme').stop(false, true).slideDown(500);
                    showed = true;
                    $('#description-show').html('Спрятать');
                }
                else {
                    $('.xhideme').slideUp(500);
                    showed = false;
                    $('#description-show').html('Читать дальше');
                }
            }
        );
    });
</script>