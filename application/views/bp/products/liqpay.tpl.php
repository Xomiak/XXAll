<?php include("application/views/head.php"); ?>
<?php include("application/views/header.php"); ?>
<?php $this->lang->load('mypage', $current_lang); ?>
<?php $this->lang->load('shop', $current_lang); ?>
<div class="content">
    <div class="catalog">
        <div class="clr"></div>            
        <div class="page_tpl_wrap">
            <h1><?=$this->lang->line('shop_payed_liqpay_title')?></h1>
            <?php
            //vd($currency);
            $liqpay_merchant = $this->model_options->getOption('liqpay_merchant');
            $liqpay_merchant_pass = $this->model_options->getOption('liqpay_merchant_pass');

            $xml = '<request>      
              <version>1.2</version>
              <merchant_id>' . $liqpay_merchant . '</merchant_id>
              <result_url>http://' . $_SERVER['SERVER_NAME'] . '/payed/liqpay/' . $order['id'] . '/</result_url>
              <server_url>http://' . $_SERVER['SERVER_NAME'] . '/payed/liqpay/' . $order['id'] . '/</server_url>
              <order_id>' . $order['id'] . '</order_id>
              <amount>' . get_price($order['summa']) . '</amount>
              <currency>' . $currency['code'] . '</currency>
              <description>shop payments</description>
              <default_phone></default_phone>
              <pay_way>card</pay_way>
              <goods_id>1234</goods_id>
              </request>';
            $sign = base64_encode(sha1($liqpay_merchant_pass . $xml . $liqpay_merchant_pass, 1));
            $xml_encoded = base64_encode($xml);
            ?>
            <form action="https://www.liqpay.com/?do=clickNbuy" method="POST">
                <input type="hidden" name="operation_xml" value="<?= $xml_encoded ?>" />
                <input type="hidden" name="signature" value="<?= $sign ?>" />
                <input type="submit" value="<?=$this->lang->line('shop_payed_butt_submit')?>" />
            </form>
         </div>
        <div class="clr"></div>
    </div>
</div>
<?php include("application/views/footer.php"); ?>