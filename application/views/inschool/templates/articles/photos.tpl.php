<?=getHead($meta)?>
<?=getHeader()?>
<?php
loadHelper(TEMPLATE);
?>
<div class="pageheadline">
    <div class="container">
        <div class="row">
            <div class="span6">
                <h1><?= $article['name'] ?></h1>
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
        <div class="span12">
            <div class="columnheadlineabout2">
                <h4><span><?= $article['name']?></span></h4>
                <p><?= getPhotoCounter($article)." "."Фото"?></p>
            </div>
        </div>
    </div>
</div>
<div class="container">

    <div class="row article_person">
    <div class="isotopecontainer  span12 startAnimation animated" data-animate="fadeInUp">
        <div id="options" class="clearfix">           

            <div id="portfoliocontainer" class="photos">
                <?php $model = getModel('images');
        $images = $model->getByArticleId($article['id']);

                    if($images){
                        foreach ($images as $image){
                            echo getPhotosForGalleryArticle($image);
                        }
                    }
                    ?>
            </div>
        </div>
    </div>
    </div>
</div>

<?=getFooter()?>
