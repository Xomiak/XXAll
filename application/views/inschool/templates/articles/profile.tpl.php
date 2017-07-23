<?=getHead($meta)?>
<?=getHeader()?>
<?php
loadHelper(TEMPLATE);
?>
    <div class="pageheadline">
        <div class="container">
            <div class="row">
                <div class="span6">
                    <h1><?= $article['name']?></h1>
                    <?= getBreadcrumbs() ?>
                </div>
                <div class="span6">
                    <ul class="ch-grid1">
                        <li>
                            <div class="ch-item ch-img-1">
                            </div>
                        </li>
                        <li>
                            <div class="ch-item ch-img-2">
                            </div>
                        </li>
                        <li>
                            <div class="ch-item ch-img-3">
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="row article_person">
            <div class="span12">
                <div class="columnheadlineabout">
                    <h4><span><?= $article['title'] ?></span></h4>
                </div>
            </div>
            <div class="span8">
                <h5><?= $article['subname'] ?></h5>
                <p>
                    <?= $article['content'] ?>
                </p>
            </div>
            <!--/span8 end-->
            <div class="span4">
                <div class="staffimage">
                    <?php if ($article['image'] != '') { ?>
                        <a data-fancybox="gallery" href="<?=$article['image']?>" alt="<?= $article['name'] ?>"><img src="<?= cropImage($article['image'], 190, 190) ?>" alt="<?= $article['name'] ?>"></a>
                    <?php } ?>
                </div>
            </div>
            <!-- <?= $article['short_content'] ?> -->
        </div>
    </div>

<?=getFooter()?>