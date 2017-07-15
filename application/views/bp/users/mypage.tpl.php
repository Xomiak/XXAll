<?php
include("application/views/head.php");
include("application/views/header.php");
?>

    <div class="container">
        <div class="row">
            <div class="col-md-6 accoutn">
                <h2 class="accoutn__title"><?=getLine('Мой кабиент')?></h2>
                <p class="accoutn__date"><?=getLine('Дата регистрации')?>: <?=$user['reg_date']?></p>

                <p class="accoutn__user"><?=getLine('ФИО')?>: <?=$user['lastname']?> <?=$user['name']?></p>
                <p class="accoutn__email">E-mail: <?=$user['email']?></p>
                <br />
                <p class="logout"><a href="/login/logout/"><?=getLine('Выйти из аккаунта')?></a></p>
            </div>

            <div class="col-md-6 tnx">
                <img src="/img/site/tnximg.png" alt="">
                <p class="tnx__text"><?=getLine('Спасибо за помощь!=)')?></p>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <h3 class="active-in"><?=getLine('Участие в акциях')?>: <?=count($orders)?> <?=getLine('акции')?> - $<?=$priceAll?> (<?=getLine('успешных транзакций: $').$pricePayed?>)</h3>
            </div>

            <div class="col-md-12">
                <div class="owl-carousel">


                    <?php
                    if($orders){
                        $model = getModel('products');
                        foreach ($orders as $order){
                           // vdd($order);

                            $article = $model->getProductById($order['product_id']);
                            //vdd($article);
                            $goPay = '';
                            $article = translateArticle($article);
                            $status = getLine('Не оплачен');
                            if($order['status'] == 'new' && $article['end_date_unix'] > time()) {
                                $goPay = getLine('Перейти к оплате');
                            }



                            if($goPay != ''){
                                $goPay = '<br /><a href="/payment/?order_id='.$order['id'].'&product_id='.$article['id'].'">'.$goPay.'</a>';
                            }
                            ?>
                            <div>
                                <ul class='car-list'>
                                    <li><?=getLine('Акция')?>: <?=$article['name']?></li>
                                    <li><?=getLine('Взнос')?>: $<?=$order['price']?></li>
                                    <li><?=getLine('Дата взноса')?>:    <?=$order['date']?> <?=$order['time']?></li>
                                    <li><?=getLine('Статус платежа')?>:    <?=getLine($order['status'])?><?=$goPay?></li>
                                </ul>

                                <p class='car-img'><img src="<?=$article['image']?>" alt=""></p>
                                <p class='car-btn'><a href="<?=getFullUrl($article)?>" class="btn"><?=getLine('Посмотреть отчет')?></a></p>

                            </div>
                            <?php
                        }
                    }
                    ?>


                </div>
            </div>
        </div>

    </div>

<?php include("application/views/footer.php"); ?>
<!--[if lt IE 9]>
<script src="/libs/html5shiv/es5-shim.min.js"></script>
<script src="/libs/html5shiv/html5shiv.min.js"></script>
<script src="/libs/html5shiv/html5shiv-printshiv.min.js"></script>
<script src="/libs/respond/respond.min.js"></script>
<![endif]-->

<!-- Load Scripts Start -->
<script>var scr = {"scripts":[
        {"src" : "/js/libs.js", "async" : false},
        {"src" : "/js/common.js", "async" : false}
    ]};!function(t,n,r){"use strict";var c=function(t){if("[object Array]"!==Object.prototype.toString.call(t))return!1;for(var r=0;r<t.length;r++){var c=n.createElement("script"),e=t[r];c.src=e.src,c.async=e.async,n.body.appendChild(c)}return!0};t.addEventListener?t.addEventListener("load",function(){c(r.scripts);},!1):t.attachEvent?t.attachEvent("onload",function(){c(r.scripts)}):t.onload=function(){c(r.scripts)}}(window,document,scr);
</script>
<!-- Load Scripts End -->
