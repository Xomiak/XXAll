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
        <div class="row">
            <div class="span12"><!--left-->
                <div class="columnheadlineabout2">
                    <h4><span><?= $article['subname']?></span></h4>
                </div>
                <article class="blogpost">
                    <div class="blogimage">
                        <img src="<?= cropImage($article['image'], 655, 344) ?>" alt="<?= $article['name'] ?>" alt="">
                        <!-- <?php if ($article['image'] != '') { ?>
                        <?php } ?> -->
                        <div class="blogdate">
                            <p><?= date('d',$article['date_unix']) ?><br><?= date('F',$article['date_unix']) ?><br> <?= date('Y',$article['date_unix']) ?></p>
                        </div>
                    </div>
                    <p class="blogtext">
                        <?= $article['content']?>
                    </p>
                </article>
            </div>
        </div>
    </div>


<?=getFooter()?>