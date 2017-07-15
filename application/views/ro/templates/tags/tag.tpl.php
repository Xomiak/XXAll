<?php
include("application/views/head.php");
include("application/views/header.php");
//$this->lang->load('main', $current_lang);
?>

    <!-- START MAIN-SECTION- -->

    <section class="main-columns">
        <div class="container">
            <div class="row">
                <div class="col-md-12">

                    <?=showBreadCrumbs()?>

                </div>
                <div class="col-md-12">
                    <div class="header-cols">
                        <h1><?=$h1?></h1>
                        <a href="/" class="accent-btn"><i class="fa fa-chevron-left" aria-hidden="true"></i>На
                            главную</a>
                    </div>
                </div>

                <?php
                if($articles){
                    foreach ($articles as $article){
                        echo modules_getArticleBlock($article);
                    }
                }
                ?>



                <!-- СПИСОК ТЕГОВ -->
                <div class="list-of-tags">
                    <h2>СПИСОК ТЕГОВ</h2>
                    <div class="text-of-tags">
                        <?= getRandomTags(getOption('tags_count_in_block')) ?>
                    </div>
                </div>
            </div>
        </div>
    </section>

<?php include("application/views/footer.php"); ?>