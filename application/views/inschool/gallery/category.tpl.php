<?php
include("application/views/head.php");
include("application/views/header.php");
?>
    <div class="about">
        <div class="container">
            <div class="row">
                <div class="col-md-12">

                    <?php include("application/views/mod/breadcrumbs.mod.php") ?>

                    <h1 class="gallery"><?= $category['name'] ?></h1>

                    <div class="popup-gallery">
<!--                        <div class="container">-->
<!--                            <div class="row">-->

                    <?php

                    if ($images) {
                        //var_dump($images);die();
                        $count = count($images);
                        $cols = 0;
                        for ($i = 0; $i < $count; $i++) {
                            $img = $images[$i];
                            //var_dump($img);
                            ?>
                            <div class="col-md-3 col-sm-6 col-xs-12 demo">
                                <a href="<?= $img['image'] ?>"
                                   class="pirobox_gall" title="<?= $img['name'] ?>">
                                    <img alt="<?= $img['name'] ?>" title="<?= $img['name'] ?>"
                                         src="<?= CreateThumb(270, 250, $img['image'], 'gallery') ?>" width="250" height="auto"/>
                                </a>
                            </div>

                            <?php
                        }
                    }
                    ?>
<!--                            </div>-->
<!--                        </div>-->
                    </div><!-- popup gallery-->
                    <div class="clear"></div>

                    <div class="empty">

                        <div class="gallery-pagination">
                            <?= $pager ?>
                        </div>

                    </div>
                </div>

                <div class="bottom-wrap">

                    <div class="gallery-pagination">
                        <?= $pager ?>
                    </div>

                </div>


            </div>
        </div>
    </div>
    </div>
<?php include("application/views/footer.php"); ?>