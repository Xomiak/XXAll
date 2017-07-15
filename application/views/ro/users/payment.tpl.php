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
        <div class="col-md-12">
            <h1 class="akcia__title"><?= getLine('Способ оплаты пожертвования') ?></h1>
            <?php if (isset($article['name'])) echo '<h2>' . $article['name'] . '</h2>'; ?>
            <h3><?= getLine('Сумма пожертвования:') ?> <?= post('price') ?></h3>
            <form action="/payment/" method="post">
                <input type="hidden" name="product_id" value="<?=$article['id']?>" />
                <input type="hidden" name="order_id" value="<?=$order['id']?>" />
                <input class="payment_opt" type="radio" name="payment" value="liqpay"/> <?= getLine('Оплата картой (LiqPay)') ?><br/>
                <input class="payment_opt" type="radio" name="payment" value="interkassa"/> <?= getLine('Интеркасса') ?><br/>
                <input type="submit" name="pay" value="<?=getLine('Далее')?>" />
            </form>
            <div id="payment_form">

            </div>
        </div>
    </div>
</div>
<?php include("application/views/footer.php"); ?>
<script>
    $(document).ready(function () {
        $("#payment_opt").change(function () {
        //    alert((this).val());
        });
    });
</script>
</body>
</html>
