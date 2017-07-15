<?php loadHelper(TEMPLATE)?>

<?=getHead()?>
<?=getHeader()?>

    <section class="rev_slider_wrapper ">
        <div id="slider1" class="rev_slider"  data-version="5.0">
            <ul>
                <li data-transition="slidingoverlayleft">
                    <img src="<?=getOption('main_slider_bg')?>"  alt="" width="1920" height="705" data-bgposition="top center" data-bgfit="cover" data-bgrepeat="no-repeat" data-bgparallax="1" >
                    <div class="tp-caption sfl tp-resizeme caption-label"
                         data-x="left" data-hoffset="0"
                         data-y="top" data-voffset="280"
                         data-whitespace="nowrap"
                         data-transform_idle="o:1;"
                         data-transform_in="o:0"
                         data-transform_out="o:0"
                         data-start="500">
                        luxury car rental
                    </div>
                    <div class="tp-caption sfr tp-resizeme caption-h1"
                         data-x="left" data-hoffset="0"
                         data-y="top" data-voffset="325"
                         data-whitespace="nowrap"
                         data-transform_idle="o:1;"
                         data-transform_in="o:0"
                         data-transform_out="o:0"
                         data-start="1000">
                        Ferrari 458 Speciale
                    </div>
                    <div class="tp-caption sfr tp-resizeme caption-p"
                         data-x="left" data-hoffset="0"
                         data-y="top" data-voffset="380"
                         data-whitespace="nowrap"
                         data-transform_idle="o:1;"
                         data-transform_in="o:0;t:1000"
                         data-transform_out="o:0"
                         data-start="1500">
                        starting from $299 per day
                    </div>
                    <div class="tp-caption sfr tp-resizeme "
                         data-x="left" data-hoffset="0"
                         data-y="top" data-voffset="440"
                         data-whitespace="nowrap"
                         data-transform_idle="o:1;"
                         data-transform_in="o:0;t:1000"
                         data-transform_out="o:0"
                         data-start="2000">
                        <a href="/our-cars/" class="thm-btn hvr-sweep-to-top"><i class="fa fa-angle-right"></i> Показать машины</a>
                    </div>
                </li>
            </ul>
        </div>
    </section>



    <section class="call-to-action">
        <div class="container">
            <div class="row">
                <div class="col-md-5">
                    <h2><?=getOption('main_redblock_h2')?></h2>
                </div>
                <div class="col-md-7">
                    <?=getOption('main_redblock_icons')?>
                </div>
            </div>
        </div>
    </section>



    <section class="vehicle-sorter-area section-padding">
        <div class="container">
            <div class="section-title text-center">
                <h2>
                    <span>Наши машины</span>
                </h2>
            </div>
            <div class="vehicle-sorter-wrapper mix-it-gallery">
                <ul class="gallery-filter list-inline">
                    <li class="filter" data-filter="all"><span>Все</span></li>
                    <?php
                    $tags = getItemsBy(array("active" => 1), "tags");
                    foreach ($tags as $tag){
                        echo '<li class="filter" data-filter=".'.$tag['url'].'"><span>'.$tag['name'].'</span></li>';
                    }
                    ?>
                </ul>
                <div class="row">
                    <?php
                    /** выводим элементы */

                    if($products){
                        $articles  = $products;
                        foreach ($articles as $product){
                            echo getProductMainBlock($product);
                        }
                    } else echo 'В этом разделе пока пусто...';
                    ?>
                </div>
            </div>
        </div>
    </section>

    <section class="client-carousel">
        <div class="container">
            <div class="section-title text-center">
                <h2>
                    <span>Наши партнёры</span>
                </h2>
            </div>
            <div class="owl-carousel owl-theme">
                <?php
                $items = getItemsBy(array('position' => 'partners'), 'banners');
                if($items){
                    foreach ($items as $item){
                        ?>
                        <div class="item">
                            <img src="<?=$item['image']?>" alt="<?=$item['name']?>"/>
                        </div>
                        <?php

                    }
                }
                ?>
            </div>
        </div>
    </section>



<?=getFooter()?>