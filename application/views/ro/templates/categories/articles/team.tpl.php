<?= getHead($meta) ?>
<?= getHeader() ?>

    <section id="team" class="team">
        <div class="container">
            <?=getBreadcrumbs()?>
            <h1 class="heading text-center"><?=$category['name']?></h1>
            <div class="container">
                <div class="row ">
                    <?= getBlock('team', false, array('type' => 'params', 'articles' => $articles, 'category' => $category)) ?>
                </div>
            </div>
        </div>
    </section>

<?= getFooter() ?>