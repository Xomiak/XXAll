<?=getHead()?>
<?=getHeader()?>

<section class="property-details padding">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h1 class="text-uppercase"><?=$article['name']?></h1>
            </div>
        </div>
        <div class="row">
            <div class="col-md-8">
                <div class="row">
                    <div class="col-md-12">
                        <div id="property-d-1" class="owl-carousel">
                            <?php if($article['image'] != '') {?>
                                <div class="item"><img src="<?=CreateThumb(750,440,$article['image'],'750x440')?>" alt="<?=$article['name']?>" /></div>
                            <?php } ?>
                            <?php
                            if($images){
                                $imgCount = 1;
                                foreach ($images as $image){
                                    $imgCount++;
                                    echo '<div class="item"><img src="'.CreateThumb(750,440,$image['image'],'750x440').'" alt="'.$image['image'].' (Фото №'.$imgCount.')" /></div>';
                                }
                            }
                            ?>
                        </div>
                        <div id="property-d-1-2" class="owl-carousel">
                            <?php if($article['image'] != '') {?>
                                <div class="item"><img src="<?=CreateThumb(148,116,$article['image'],'148x116')?>" alt="<?=$article['name']?> thumb" /></div>
                            <?php } ?>
                            <?php
                            if($images){
                                $imgCount = 1;
                                foreach ($images as $image){
                                    $imgCount++;
                                    echo '<div class="item"><img src="'.CreateThumb(148,116,$image['image'],'148x116').'" alt="'.$image['image'].' (Фото №'.$imgCount.') thumb" /></div>';
                                }
                            }
                            ?>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="property-tab">
                            <!-- Nav tabs -->
                            <ul class="nav nav-tabs" role="tablist">
                                <li role="presentation" class="active"><a href="#description" aria-controls="description" role="tab" data-toggle="tab">Описание</a></li>
                                <li role="presentation"><a href="#plan" aria-controls="plan" role="tab" data-toggle="tab">Планировка</a></li>
                            </ul>
                            <!-- Tab panes -->
                            <div class="tab-content">
                                <div role="tabpanel" class="tab-pane active" id="description">
                                    <h3 class="text-uppercase  bottom20 top10">Описание <span class="color_red">квартиры</span></h3>
                                    <?=$article['content']?>
                                </div>

                                <div role="tabpanel" class="tab-pane bg_light" id="plan">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <h3 class="text-uppercase bottom20 top10">Планировка <span class="color_red">квартиры</span></h3>
                                        </div>
                                        <div class="col-md-4 col-sm-4 col-xs-12 top10">
                                            <div class="image">
                                                <img src="images/property-d-1-f-1.jpg" alt="image" />
                                                <div class="overlay border_radius">
                                                    <a class="fancybox centered" href="images/property-d-1-f-1.jpg" data-fancybox-group="gallery"><i class="icon-focus"></i></a>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4 col-sm-4 col-xs-12">

                <div class="row">
                    <div class="col-md-12">
                        <?php
                        loadHelper(TEMPLATE);
                        echo getLatestBlock();
                        ?>
                    </div>
                </div>
                <div class="row">
                    <?php
                    echo getActionsBlock();
                    ?>
                </div>
            </div>
        </div>
    </div>
    </div>
</section>
<?=getFooter()?>
