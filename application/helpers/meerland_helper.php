<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

function getArticleBlock($item){
    ob_start();
    if ($item['image'] != '' && $item['price_file'] != '') {
        ?>
        <div class="col-md-3 col-sm-4">
            <a target="_blank" href="<?= $item['price_file'] ?>" class="item">
                <div class="wrap-img">
                        <img src="<?= $item['image'] ?>" alt="<?= $item['name'] ?>">
                </div>
                <h3><?= $item['name'] ?></h3>
            </a>
        </div>
        <?php
    }
    $html = ob_get_contents();
    ob_clean();
    return $html;
}

function getMobileArticleBlock($item){
    ob_start();
        ?>
        <a href="<?=getFullUrl($item)?>" class="item">
            <?php if ($item['image'] != '') { ?>
                <div class="wrap-img"><img src="<?=$item['image']?>" alt="<?=$item['name']?>"></div>
            <?php } ?>
            <div class="title"><h2><?=$item['name']?></h2></div>
        </a>
        <?php
    $html = ob_get_contents();
    ob_clean();
    return $html;
}

