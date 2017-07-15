<?php include("application/views/head.php"); ?>
<?php include("application/views/header.php"); ?>
<?php $this->lang->load('shop', $current_lang); ?>
<?php $privat24_merchant = $this->model_options->getOption('privat24_merchant');?>
<div class="content">
    <div class="catalog">
        <div class="clr"></div>            
        <div class="page_tpl_wrap">
            <h1><?=$this->lang->line('shop_payed_p24_title')?></h1>
            <form action="https://api.privatbank.ua/p24api/ishop" method="POST">
                <input type="hidden" name="amt" value="<?= get_price($order['summa']) ?>"/>
                <input type="hidden" name="ccy" value="<?= $currency ?>" />
                <input type="hidden" name="merchant" value="<?= $privat24_merchant ?>" />
                <input type="hidden" name="order" value="<?= $order['id'] ?>" />
                <input type="hidden" name="details" value="<?=$this->lang->line('shop_payed_p24_details')?>" />
                <input type="hidden" name="ext_details" value="" />
                <input type="hidden" name="pay_way" value="privat24" />
                <input type="hidden" name="return_url" value="http://<?= $_SERVER['SERVER_NAME'] ?>/payed/privat24/<?= $order['id'] ?>/" />
                <input type="hidden" name="server_url" value="http://<?= $_SERVER['SERVER_NAME'] ?>/payed/privat24/<?= $order['id'] ?>/" />
                <input type="submit" value="<?=$this->lang->line('shop_payed_butt_submit')?>" />
            </form>
        </div>
        <div class="clr"></div>
    </div>
</div>
<?php include("application/views/footer.php"); ?>