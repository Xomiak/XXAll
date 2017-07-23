<?php
include("application/views/head.php");
include("application/views/header.php");
//$this->lang->load('main', $current_lang);
$user = false;
if (userdata('login') != false)
    $user = getUserData();

$isHttps = !empty($_SERVER['HTTPS']) && 'off' !== strtolower($_SERVER['HTTPS']);

?>
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h1 class="akcia__title"><?= getLine('Подтверждение оплаты') ?></h1>
            <?php if (isset($article['name'])) echo '<h2><span class="payment-h2-span" style="font-weight: normal">'. getLine('Пожертвование на').':</span> <strong>' . $article['name'] . '</strong></h2>'; ?>
            <h3><?= getLine('Сумма пожертвования:') ?> <?= $order['price'] ?> $</h3>
            <h3><?= getLine('Способ оплаты:') ?> <?= getLine('Интеркасса') ?></h3>

            <?php
           // $json = '{"resultCode":125,"resultMsg":"\u0423 \u043a\u0430\u0441\u0441\u044b [58e4f68b3d1eaf226c8b456a] \u043d\u0435\u0442 \u0430\u043a\u0442\u0438\u0432\u043d\u044b\u0445 \u043f\u043b\u0430\u0442\u0435\u0436\u043d\u044b\u0445 \u043d\u0430\u043f\u0440\u0430\u0432\u043b\u0435\u043d\u0438\u0439"}';
            //var_dump(json_decode($json));
            ?>


            <form name="payment" method="post" action="https://sci.interkassa.com/" method="post"
                  accept-charset="UTF-8">
                <input type="hidden" name="ik_co_id" value="<?=getOption('ik_co_id')?>" />
                <input type="hidden" name="ik_pm_no" value="<?= $order['id'] ?>" />
                <input type="hidden" name="ik_am" value="<?= ($order['price'] * 27) ?>" />
                <input type="hidden" name="ik_cur" value="UAH" />
                <input type="hidden" name="ik_desc" value="<?=$order['description']?>" />

                <input type="hidden" name="ik_suc_u" value="<?=getProtocol()?>://<?=$_SERVER['SERVER_NAME']?>/payment/?action=payed&type=interkassa&status=success" />
                <input type="hidden" name="ik_suc_m" value="post" />
                <input type="hidden" name="ik_fal_u" value="<?=getProtocol()?>://<?=$_SERVER['SERVER_NAME']?>/payment/?action=payed&type=interkassa&status=fail" />
                <input type="hidden" name="ik_fal_m" value="post" />
                <input type="hidden" name="ik_pnd_u" value="<?=getProtocol()?>://<?=$_SERVER['SERVER_NAME']?>/payment/?action=payed&type=interkassa&status=pending" />
                <input type="hidden" name="ik_pnd_m" value="post" />
                <input type="hidden" name="ik_enc" value="utf-8" />
                <input type="submit" value="Pay" value="<?=getLine('Перейти к оплате')?>">
            </form>

            <div id="payment_form">

            </div>
            <div id="result">

            </div>
        </div>
    </div>
</div>
<?php include("application/views/footer.php"); ?>
<script>
    function ik_pay() {
        $("#result").html('Отправляем платёж...');
        $.ajax({
            /* адрес файла-обработчика запроса */
            url: 'https://sci.interkassa.com/',
            /* метод отправки данных */
            method: 'POST',
            /* данные, которые мы передаем в файл-обработчик */
            data: {
                "ik_co_id": "<?=getOption('ik_co_id')?>",
                "ik_pm_no": "<?= $order['id'] ?>",
                "ik_desc": "<?= $order['description'] ?>",
                "ik_am": "<?= $order['price'] ?>",
                "ik_cur": "USD",
                "ik_act": "payways",
                "ik_suc_u": "<?=getProtocol()?>://<?=$_SERVER['SERVER_NAME']?>/payment/?action=payed&type=interkassa",
                "ik_fal_u": "<?=getProtocol()?>://<?=$_SERVER['SERVER_NAME']?>/payment/?action=payed&type=interkassa",
                "ik_pnd_u": "<?=getProtocol()?>://<?=$_SERVER['SERVER_NAME']?>/payment/?action=payed&type=interkassa",
                "ik_int": "post",
                "ik_pnd_m": "post",
                "ik_enc": "json"

            }

        }).done(function (data) {
            $("#result").html(data);
//            alert(data);
//            var obj = jQuery.parseJSON(data);
//            alert(obj.resultMsg);
//            console.log(data);
            //alert(data);

            //console.log('Menu positions save: '+data);
        });
    }


    $(document).ready(function () {
        $("#payment_opt").change(function () {
            //    alert((this).val());
        });
    });
</script>
</body>
</html>
