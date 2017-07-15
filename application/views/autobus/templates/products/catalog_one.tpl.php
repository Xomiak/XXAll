<?php
loadHelper(TEMPLATE);
if(!isset($meta))
    $meta = false;
?>
<?=getHead($meta)?>
<?=getHeader()?>

<section class="inner-banner" style="<?php if(isset($article['background_image']) && $article['background_image'] != '' && $article['background_image'] != null) echo 'background: #000 url('.$article['background_image'].') center center no-repeat; background-size: cover;';?>">
    <div class="container text-center">
        <h1><span><?=$article['name']?></span></h1>
    </div>
</section>
<section class="breadcrumbs container">
    <?=getBreadcrumbs()?>
</section>


<div class="single-car-content section-padding pb0  single-blog-post-page">
    <div class="container">
        <div class="row">
            <div class="col-md-7">
                <?php
                $config = array(
                    'product_id' => $article['id'],
                    'active'        => 1,
                    'type'    => 'slider'
                );

                $images = getItemsBy($config,'images');
                $i = 1;
                if($images){
                    echo '<div class="single-car-carousel-content-box owl-carousel owl-theme">';
                    foreach ($images as $image){
                        ?>
                        <div class="item">
                            <img src="<?=$image['image']?>" alt="<?=$article['name']?> (Слайд №<?=$i?>)"/>
                        </div>
                        <?php
                        $i++;
                    }
                    echo '</div>';

                    echo '<div class="single-car-carousel-thumbnail-box owl-carousel owl-theme">';
                    foreach ($images as $image){
                        ?>
                        <div class="item">
                            <img src="<?=CreateThumb(217, 139,$image['image'],'slides')?>" alt="<?=$article['name']?> (Превью слайда №<?=$i?>)"/>
                        </div>
                        <?php
                        $i++;
                    }
                    echo '</div>';
                }
                ?>


            </div>
            <div class="col-md-5">
                <div class="single-vehicle-sorter">
                    <?php if($article['image'] != ''){ ?>
                    <div class="img-box">
                        <img src="<?=$article['image']?>" alt="<?=$article['name']?>">
                    </div>
                    <?php } ?>
                    <h3><?=$article['name']?></h3>
                    <div class="middle-box-wrapper clearfix">
                        <div class="middle-box">
                            <ul>
                                <li><span>Телевизор :</span> <?=$article['tv']?></li>
                                <li><span>Аудиосистема:</span> <?=$article['audio']?></li>
                                <li><span>Кондиционер:</span> <?=$article['condition']?></li>
                                <li><span>Туалет:</span> <?=$article['bathroom']?></li>
                            </ul>
                        </div>
                        <div class="middle-box">
                            <ul>
                                <li><span>Кухня:</span> <?=$article['kitchen']?></li>
                                <li><span>Раздвижной салон:</span> <?=$article['sliding']?></li>
                                <li><span>Посадочные места:</span> <?=$article['seat']?></li>
                            </ul>
                        </div>
                    </div>
                    <div class="bottom-box-wrapper clearfix">
                        <p class="price-box hour pull-left">
                            Цена за час:
                            <span><b>$</b><?=$article['price_hour']?></span>
                        </p>
                        <p class="price-box pull-left">
                            Цена за день:
                            <span><b>$</b><?=$article['price_day']?></span>
                        </p>
                        <a  data-toggle="modal" data-target=".booking-form" href="#" class="thm-btn"><i class="fa fa-angle-right"></i> Заказать</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="single-car-tab-wrapper">
            <div class="car-content">
                <?=$article['content']?>
            </div>
        </div>
    </div>
</div>


<?=getBlock('modal')?>


<?=getFooter()?>
