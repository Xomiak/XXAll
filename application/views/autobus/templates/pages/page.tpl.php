<?php
loadHelper(TEMPLATE);
if(!isset($meta))
    $meta = false;
?>
<?=getHead($meta)?>
<?= getHeader() ?>

<section class="inner-banner"<?php if($page['image'] != '') echo ' style="background: #000 url('.$page['image'].') center center no-repeat; background-size: cover;"';?>>
    <div class="container text-center">
        <h1><span><?= $page['name'] ?></span></h1>
    </div>
</section>

<section class="contact-page section-padding">
    <div class="container">
        <?=$page['content']?>
    </div>
</section>

<?= getFooter() ?>
