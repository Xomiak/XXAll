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
                <h1 class="akcia__title">Акция «<?= $article['name'] ?>»</h1>
                <p class="akcia__date"><?= $article['start_date'] ?> - <?= $article['end_date'] ?></p>

                <?php if ($article['image'] != '') { ?>
                    <i class="akcia__img"><img src="<?= $article['image'] ?>" alt="<?= $article['name'] ?>"></i>
                <?php } ?>

                <?= $article['content'] ?>
                <?php
                if ($article['end_date_unix'] > time()) {
                    //vd($user);
                    if ($user) {
                        ?>
                        <div style="display: none;text-align: center" id="payment-form">
                            <form action="/payment/" method="post">
                                <h3><?=getLine('Сумма пожертвования')?>:</h3>
                                <input type="hidden" name="product_id" value="<?=$article['id']?>" />
                                <input style="width: 75px" id="money" name="price" value="1,00 $" type="text" data-symbol="R$ " data-thousands="." data-decimal="," />

                                <p><button><?=getLine('Пожертвовать!')?></button></p>
                            </form>
                        </div>
<!--                        <p class="text-center"><a data-fancybox data-src="#payments" href="javascript:;" class="btn">Принять участие</a></p>-->
                        <p class="text-center"><a data-fancybox data-src="#payment-form" href="javascript:;"><?=getLine('Принять участие!')?></a></p>
<!--                        <a data-fancybox="iframe" data-src="/payment/" data-type="iframe" href="javascript:;">Iframed page</a>-->
                        <?php
                    } else {
                        echo '<script src="//ulogin.ru/js/ulogin.js"></script><p class="text-center"><a id="uLogin49428e9c" data-ulogin="display=window;fields=first_name,last_name,email;optional=phone,city,photo_big,country,photo,bdate,nickname,sex;verify=1;providers=google,facebook,linkedin,vkontakte,odnoklassniki,mailru;hidden=twitter,yandex,livejournal,openid,lastfm,liveid,soundcloud,steam,flickr,uid,youtube,webmoney,foursquare,tumblr,googleplus,vimeo,instagram,wargaming;redirect_uri='.getProtokol().'://'.$_SERVER['SERVER_NAME'].'/login/" class="btn">'.getLine('Принять участие').'</a></p>';
                    }
                } else {
                    echo '<p class="text-center"><a class="btn ended">'.getLine('Акция завершена').'</a></p>';
                } ?>
            </div>
        </div>
<!--        <a data-fancybox="iframe" data-src="/login/iframe_login/" data-type="iframe" href="javascript:;">Iframed page</a>-->

        <?= modules_getOtherNews($article) ?>


    </div>

<?php include("application/views/footer.php"); ?>

<script src="/js/jquery-3.2.1.min.js"></script>
<link href="/libs/fancybox/jquery.fancybox.min.css" rel="stylesheet" />
<script src="/libs/fancybox/jquery.fancybox.min.js"></script>
<script src="/libs/jquery.maskMoney.min.js"></script>
<script>
    var j = $.noConflict();
    j(document).ready(function() {
        j("#money").maskMoney({thousands:'', decimal:'.', allowZero:false, suffix: ' $'});
        // You can use as usual :
        j( '.fancybox' ).fancybox();
        // or just create links having "data-fancybox" attribute
    });

</script>

