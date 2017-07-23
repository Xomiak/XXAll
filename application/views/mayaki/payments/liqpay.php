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
            <h1 class="akcia__title"><?= getLine('Подтверждение оплаты') ?></h1>
            <?php if (isset($article['name'])) echo '<h2><span class="payment-h2-span" style="font-weight: normal">'. getLine('Пожертвование на').':</span> <strong>' . $article['name'] . '</strong></h2>'; ?>
            <h3><?= getLine('Сумма пожертвования:') ?> <?= $order['price'] ?> $</h3>
            <h3><?= getLine('Способ оплаты:') ?> <?= getLine('Оплата картой (LiqPay)') ?></h3>
            <?=$liqpay?>
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
