<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Created by PhpStorm.
 * User: XomiaK
 * Date: 22.06.2017
 * Time: 12:35
 */


function getProductBlock($product){
    ob_start();
    $tags = array();
    $tagsUrls = ' ';
    if($product['tags'] != '')
        $tags = explode(',',$product['tags']);
    if(is_array($tags)){
        foreach ($tags as $tag){
            $tag = trim($tag);
            $tagsUrls .= translitRuToEn($tag).' ';
        }
    }
    $url = getFullUrl($product);
    ?>
    <div class="col-md-4 mix <?=$tagsUrls?>">
        <div class="single-vehicle-sorter">
            <div class="img-box">
                <a href="<?=$url?>"><img src="<?=$product['image']?>" alt="<?=$product['name']?>"></a>
            </div>
            <div class="title-box-wrapper clearfix">
                <div class="title-box pull-left">
                    <a href="<?=$url?>"><h3><?=$product['name']?></h3></a>
                </div>
                <div class="button-box pull-right">
                    <a href="<?=getFullUrl($product)?>" class="thm-btn"><i class="fa fa-angle-right"></i> Узнать подробнее</a>
                </div>
            </div>
            <div class="middle-box-wrapper clearfix">
                <div class="middle-box">
                    <ul>
                        <li><span>Телевизор :</span> <?=$product['tv']?></li>
                        <li><span>Аудиосистема:</span> <?=$product['audio']?></li>
                        <li><span>Кондиционер:</span> <?=$product['condition']?></li>
                        <li><span>Туалет:</span> <?=$product['bathroom']?></li>
                    </ul>
                </div>
                <div class="middle-box">
                    <ul>
                        <li><span>Кухня:</span> <?=$product['kitchen']?></li>
                        <li><span>Раздвижной салон:</span> <?=$product['sliding']?></li>
                        <li><span>Посадочные места:</span> <?=$product['seat']?></li>

                    </ul>
                </div>
            </div>
            <div class="bottom-box-wrapper clearfix">
                <p class="price-box hour pull-left">
                    Цена за час:
                    <span><b>$</b><?=$product['price_hour']?></span>
                </p>
                <p class="price-box pull-left">
                    Цена за день:
                    <span><b>$</b><?=$product['price_day']?></span>
                </p>
            </div>
        </div>
    </div>
    <?php
    $html = ob_get_contents();
    ob_clean();
    return $html;
}

function getProductMainBlock($product){
    ob_start();
    $tags = array();
    $tagsUrls = ' ';
    if($product['tags'] != '')
        $tags = explode(',',$product['tags']);
    if(is_array($tags)){
        foreach ($tags as $tag){
            $tag = trim($tag);
            $tagsUrls .= translitRuToEn($tag).' ';
        }
    }
    $url = getFullUrl($product);
    ?>
    <div class="col-md-6 col-sm-6 mix <?=$tagsUrls?>">
        <div class="single-vehicle-sorter">
            <div class="img-box">
                <a href="<?=$url?>"><img src="<?=$product['image']?>" alt="<?=$product['name']?>"></a>
            </div>
            <a href="<?=$url?>"><h3><?=$product['name']?></h3></a>

            <div class="middle-box-wrapper clearfix">
                <div class="middle-box">
                    <ul>
                        <li><span>Телевизор :</span> <?=$product['tv']?></li>
                        <li><span>Аудиосистема:</span> <?=$product['audio']?></li>
                        <li><span>Кондиционер:</span> <?=$product['condition']?></li>
                        <li><span>Туалет:</span> <?=$product['bathroom']?></li>
                    </ul>
                </div>
                <div class="middle-box">
                    <ul>
                        <li><span>Кухня:</span> <?=$product['kitchen']?></li>
                        <li><span>Раздвижной салон:</span> <?=$product['sliding']?></li>
                        <li><span>Посадочные места:</span> <?=$product['seat']?></li>

                    </ul>
                </div>
                <div class="middle-box">
                    <a href="<?=$url?>" class="thm-btn"><i class="fa fa-angle-right"></i> Узнать подробнее</a>
                </div>
            </div>
            <div class="bottom-box-wrapper clearfix">
                <p class="price-box hour pull-left">
                    Цена за час:
                    <span><b>$</b><?=$product['price_hour']?></span>
                </p>
                <p class="price-box pull-left">
                    Цена за день:
                    <span><b>$</b><?=$product['price_day']?></span>
                </p>
            </div>
        </div>
    </div>
    <?php
    $html = ob_get_contents();
    ob_clean();
    return $html;
}

function getImageBlock($image, $category = false, $i = false){
    ob_start();
    if($category != false)
        $category['name'] .= ' (Фото №)'.$i;

    ?>
    <div class="col-md-4 col-sm-6 mix muscle party">
        <div class="single-gallery-item">
            <div class="img-box">
                <img src="<?=CreateThumb(370,370,$image['image'],'370x370')?>" alt="<?=$category['name']?>">
                <div class="overlay">
                    <div class="box">
                        <div class="content">
                            <a href="<?=$image['image']?>" class="fancybox" data-fancybox-group="service-gallery"><i class="fa fa-camera"></i></a>
                        </div>
                    </div>
                </div>
            </div>
            <!--div class="text-box">
                <h3><?=$category['name']?></h3>
                <?=$image['text']?>
            </div-->
        </div>
    </div>

    <?php
    $html = ob_get_contents();
    ob_clean();
    return $html;
}

function getBottomGallery(){
    ob_start();
    ?>
    <section class="gallery-wrapper section-padding pb0">
        <div class="container-fulid">
            <div class="section-title text-center">
                <h2><span>check our gallery</span></h2>
            </div>

            <div class="owl-carousel owl-theme" data-carousel-nav="false">
                <div class="item">
                    <div class="single-gallery-item">
                        <div class="img-box">
                            <img src="img/gallery/1.jpg" alt="Awesome Image"/>
                            <div class="overlay">
                                <div class="box">
                                    <div class="content">
                                        <a href="img/gallery/big/1.jpg" class="fancybox" data-fancybox-group="service-gallery"><i class="fa fa-camera"></i></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="item">
                    <div class="single-gallery-item">
                        <div class="img-box">
                            <img src="img/gallery/2.jpg" alt="Awesome Image"/>
                            <div class="overlay">
                                <div class="box">
                                    <div class="content">
                                        <a href="img/gallery/big/2.jpg" class="fancybox" data-fancybox-group="service-gallery"><i class="fa fa-camera"></i></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="item">
                    <div class="single-gallery-item">
                        <div class="img-box">
                            <img src="img/gallery/3.jpg" alt="Awesome Image"/>
                            <div class="overlay">
                                <div class="box">
                                    <div class="content">
                                        <a href="img/gallery/big/3.jpg" class="fancybox" data-fancybox-group="service-gallery"><i class="fa fa-camera"></i></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="item">
                    <div class="single-gallery-item">
                        <div class="img-box">
                            <img src="img/gallery/4.jpg" alt="Awesome Image"/>
                            <div class="overlay">
                                <div class="box">
                                    <div class="content">
                                        <a href="img/gallery/big/4.jpg" class="fancybox" data-fancybox-group="service-gallery"><i class="fa fa-camera"></i></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
<?php
    $html = ob_get_contents();
    ob_clean();
    return $html;
}