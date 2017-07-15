<?= getHead($meta) ?>
<?= getHeader() ?>


<?php if ($page['image'] != '') { ?>
    <!--========== HERO (BANNER) ==========-->
    <section id="welcome" class="parallax banner image-banner">
        <img src="<?= CreateThumb(1920, 360, $page['image'], 'pages') ?>" width="1920" alt="<?= $page['name'] ?>">
        <h2 class="page-title"><?= $page['name'] ?></h2>
    </section>
<?php } ?>


    <!--========== END OF HERO (BANNER) ==========-->

    <!--========== MAIN CONTENT ==========-->
    <section id="team" class="team">
        <div class="container">
            <?= getBreadcrumbs() ?>
            <h1 class="heading text-center"><?= $page['name'] ?></h1>
            <div class="grid">
                <div class="row">
                    <?php
                    $uslugi = $this->model_categories->getCategories(1, 'products');
                    //var_dump($uslugi);
                    if ($uslugi) {
                        foreach ($uslugi as $item) {
                            ?>
                            <div class="col-md-3 col-sm-4 col-xs-6 item ">
                                <?php if ($item['image'] != '') { ?>
                                    <img src="<?= CreateThumb(600, 600, $item['image'], '600x600') ?>"
                                         alt="<?= $item['name'] ?>"/>
                                <?php } else { ?>
                                    <img src="http://placehold.it/600x600" alt="<?= $item['name'] ?>"/>
                                <?php } ?>
                                <a href="<?= getFullUrl($item) ?>">
                                    <div class="project-content">
                                        <div class="inner">
                                            <h3 class="text-center"><?= $item['name'] ?></h3>
                                        </div>
                                    </div>
                                </a>
                            </div>
                            <?php
                        }
                    }
                    ?>

                </div>

            </div>
        </div>
        <!-- End of Blog Single Page -->
    </section>
    <!--========== END OF MAIN CONTENT==========-->

<?= getFooter() ?>