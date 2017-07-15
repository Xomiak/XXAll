<?php
loadHelper(TEMPLATE);
if(!isset($meta))
    $meta = false;
?>
<?=getHead($meta)?>
<?=getHeader()?>



    <section class="inner-banner"<?php if($category['image'] != '') echo ' style="background: #000 url('.$category['image'].') center center no-repeat; background-size: cover;"';?>>
        <div class="container text-center">
            <h1><span><?=mb_strtoupper($category['name'])?></span></h1>
        </div>
    </section>

    <section class="breadcrumbs container">
        <?=getBreadcrumbs()?>
    </section>

    <section class="vehicle-sorter-area section-padding col-3-page">
        <div class="container">

            <div class="vehicle-sorter-wrapper mix-it-gallery">
                <ul class="gallery-filter list-inline">
                    <li class="filter" data-filter="all"><span>Все</span></li>
                    <?php
                    $tags = getItemsBy(array('active'=> 1), 'tags');
                    foreach ($tags as $tag){
                        echo '<li class="filter" data-filter=".'.$tag['url'].'"><span>'.$tag['name'].'</span></li>';
                    }
                    ?>
                </ul>

                <div class="row">
            <?php
            /** выводим элементы */
            if($articles){
                foreach ($articles as $product){
                    echo getProductBlock($product);
                }
            } else echo 'В этом разделе пока пусто...';
            ?>
                </div>

                <!--ul class="post-pagination text-center">
                    <li><span>01</span></li>
                    <li><a href="#">02</a></li>
                    <li><a href="#">03</a></li>
                    <li><a href="#">04</a></li>
                    <li><a href="#">05</a></li>
                    <li><a href="#">06</a></li>
                    <li><a href="#">07</a></li>
                    <li><a href="#">08</a></li>
                    <li><a href="#">09</a></li>
                    <li><a href="#"><i class="fa fa-angle-double-right"></i></a></li>
                </ul-->
            </div>
        </div>
    </section>

<?=getFooter()?>