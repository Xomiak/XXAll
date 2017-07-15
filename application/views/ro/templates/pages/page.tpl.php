<?=getHead($meta)?>
<?=getHeader()?>

<?php if ($page['image'] != '') { ?>
    <!--========== HERO (BANNER) ==========-->
    <section id="welcome" class="parallax banner image-banner">
        <img src="<?= CreateThumb(1920, 360, $page['image'], 'pages') ?>" width="1920" alt="<?= $page['name'] ?>">
        <h2 class="page-title"><?= $page['name'] ?></h2>
    </section>
<?php } ?>

    <!--========== MAIN CONTENT ==========-->
    <section id="team" class="team">
        <div class="container">
        <?php showBreadCrumbs() ?>
        <h1 class="heading text-center"><?= $page['name'] ?></h1>
        <div class="grid">
            <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="blog-post">
                    <?=$page['content']?>
                </div>

            </div>
        </div>
        </div>

        <!-- End of Blog Single Page -->
    </section>
    <!--========== END OF MAIN CONTENT==========-->

<?=getFooter()?>