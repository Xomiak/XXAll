<?=getHead($meta)?>
<?=getHeader()?>
<?php
loadHelper(TEMPLATE);
?>
<div class="pageheadline">
    <div class="container">
        <div class="row">
            <div class="span6">
                <h1><?= $category['name'] ?></h1>
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
                <h4><span><?= $category['name']?></span></h4>
                <p><?= $category['subname']?></p>



            </div>
        </div>
    </div>
</div>
<div class="container">

    <div class="row article_person">
        <div class="isotopecontainer  span12 startAnimation animated" data-animate="fadeInUp">
            <div id="options" class="clearfix">

                <div id="portfoliocontainer" class="photos">
                    <?php
                    if($articles){
                        foreach ($articles as $article){
                            echo  getGalleryArticles($article);

                        }
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>


<!--<div class="container">
    <div class="row">

        <div class="span12">
            <div class="columnheadlineabout2">
                <h4><span><?/*= $category['name'] */?></span></h4>
                <p><?/*= $category['subname']*/?></p>
            </div>
        </div>
        <?php
/*        if($articles){
            foreach ($articles as $article){
                echo  getGalleryArticles($article);
            }
        }
        */?>
    </div></div>-->
<?=getFooter()?>
