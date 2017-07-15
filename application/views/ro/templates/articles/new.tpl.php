<?=getHead($meta)?>
<?=getHeader()?>

    <!--========== MAIN CONTENT ==========-->
    <main id="mainContent">
        <section id="blog" class="blog">
            <div class="container">
                <?=getBreadcrumbs()?>
                <h1 class="heading text-center"><?=$article['name']?></h1>
                <div class="row article-content">
                    <?php if($article['image'] != '') { ?>
                        <img src="<?=$article['image']?>" alt="<?=$article['name']?>" class="article-img" />
                    <?php } ?>
                    <?=$article['content']?>

                </div>
            </div>
        </section>
        <?php
        if($images) {
            echo '<div class="grid"><div class="row">';
            $i = 1;
            foreach ($images as $item){
                ?>
                <div class="col-md-3 col-sm-4 col-xs-6 item ">
                    <?php if($item['image'] != '') { ?>
                        <img src="<?=CreateThumb(300,300,$item['image'],'300x300')?>" alt="<?=$article['name']?> (Фото №<?=$i?>)" />
                    <?php } ?>
                    <a data-fancybox="gallery" href="<?=$item['image']?>">
                        <div class="project-content">
                            <div class="inner">
                                <h3 class="text-center"><?=$article['name']?> (Фото №<?=$i?>)</h3>
                            </div>
                        </div>
                    </a>
                </div>
                <?php
                $i++;
            }
            echo '</div></div>';
        }
        ?>
    </main>

<?=getFooter()?>