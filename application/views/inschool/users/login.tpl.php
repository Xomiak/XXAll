<?php
include("application/views/head.php");
include("application/views/header.php");
//$this->lang->load('main', $current_lang);
$user = false;
if (userdata('login') != false)
    $user = getUserData();
?>

<div class="container">
    <div class="row">
        <?php showBreadCrumbs(); ?>
    </div>

    <div class="row">
        <div class="col-md-12">
            <h1 class="akcia__title"><?=getLine('Авторизируйтесь')?></h1>
            <?php
                    echo '<script src="//ulogin.ru/js/ulogin.js"></script><p class="text-center"><a id="uLogin49428e9c" data-ulogin="display=window;fields=first_name,last_name,email;optional=phone,city,photo_big,country,photo,bdate,nickname,sex;verify=1;providers=google,facebook,linkedin,vkontakte,odnoklassniki,mailru;hidden=twitter,yandex,livejournal,openid,lastfm,liveid,soundcloud,steam,flickr,uid,youtube,webmoney,foursquare,tumblr,googleplus,vimeo,instagram,wargaming;redirect_uri=//'.$_SERVER['SERVER_NAME'].'/login/" class="btn">'.getLine('Войти').'</a></p>';
              ?>
        </div>
    </div>
    <!--        <a data-fancybox="iframe" data-src="/login/iframe_login/" data-type="iframe" href="javascript:;">Iframed page</a>-->




</div>

<?php include("application/views/footer.php"); ?>
<script src="/js/jquery-3.2.1.min.js"></script>

<link href="/libs/fancybox/jquery.fancybox.min.css" rel="stylesheet" />
<script src="/libs/fancybox/jquery.fancybox.min.js"></script>
<script>
    var j = $.noConflict();
    j(document).ready(function() {

        // You can use as usual :
        j( '.fancybox' ).fancybox();


        // or just create links having "data-fancybox" attribute

    });</script>

