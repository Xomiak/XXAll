<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');


function modules_getNewBlock($article){
    ob_start();
    $article = translateArticle($article);
    $url = getFullUrl($article);
    if($article['image'] == '')
        $article['image'] = getOgImage($article,'articles');
    ?>
    <div class="col-md-6">
        <p class='all-news__date'><?=$article['date']?></p>
        <?php if($article['image'] != '') { ?>
            <i class="all-news__img"><a href="<?=$url?>"><img src="<?=$article['image']?>" alt="<?=$article['name']?>"></a></i>
        <?php } ?>
        <h2 class="all-news__title"><a href="<?=$url?>"><?=$article['name']?></a></h2>
        <p class="all-news__desc"><?=strip_tags($article['short_content'])?></p>
    </div>
    <?php
    $output = ob_get_contents();
    ob_end_clean();
    return $output;
}

function modules_getProductBlock($article){
    ob_start();
    $article = translateArticle($article);
    $url = getFullUrl($article);
    if($article['image'] == '')
        $article['image'] = getOgImage($article,'products');
    ?>
    <div class="col-md-6">
        <p class='all-news__date'><?=$article['date']?></p>
        <?php if($article['image'] != '') { ?>
            <i class="all-news__img"><a href="<?=$url?>"><img src="<?=$article['image']?>" alt="<?=$article['name']?>"></a></i>
        <?php } ?>
        <h2 class="all-news__title"><a href="<?=$url?>"><?=$article['name']?></a></h2>
        <p class="all-news__desc"><?=strip_tags($article['short_content'])?></p>
    </div>
    <?php
    $output = ob_get_contents();
    ob_end_clean();
    return $output;
}

function modules_getOtherNews($article = false){
    ob_start();
    $model = getModel('articles');
    if(isset($article['category_id']))
        $articles = $model->getArticlesByCategory($article['category_id'],4,0,1,'DESC','num',$article['id']);
    else $articles = $model->getArticlesByParentCategory(1,4,0,1);

    if($articles){
        ?>
        <div class="row">
            <div class="col-md-12">
                <h3 class="another-news__title"><?=getLine('Другие новости')?></h3>
            </div>
        </div>

        <div class="row">
        <?php
        foreach ($articles as $item){
            echo modules_getOtherNew($item);
        }
        echo '</div>';
    }
    $output = ob_get_contents();
    ob_end_clean();
    return $output;
}

function modules_getOtherNew($article){
    $url = getFullUrl($article);
    $article = translateArticle($article);
    ob_start();
    ?>
    <div class="col-md-3 col-sm-6">
        <?php if($article['image'] != '') { ?>
            <p class="another-news__img"><a href="<?=$url?>"><img src="<?=$article['image']?>" alt="<?=$article['name']?>"></a></p>
        <?php } ?>

        <p class="another-news__desc"><a href="<?=$url?>">
                <?=$article['name']?>
            </a></p>
    </div>
    <?php
    $output = ob_get_contents();
    ob_end_clean();
    return $output;
}

function modules_getLastProduct(){
    $product = userdata('product');
    if(!$product){
        $model = getModel('products');
        $product = $model->getProductsByCategory(5,1,0,1,'asc','end_date_unix',1);
        if(isset($product[0])) return $product[0];

        return false;
    }
}

function modules_getLastProductUrl(){
    $itemUrl = userdata('lastProductLink');
    if(!$itemUrl){
        $model = getModel('products');
        $product = $model->getProductsByCategory(5,1,0,1,'asc','end_date_unix',1);
        if(isset($product[0])) $itemUrl = getFullUrl($product[0]);
        if($itemUrl != '#')
            set_userdata('lastProductLink', $itemUrl);
    }
    return $itemUrl;

}