<?=getHead($meta)?>
<?=getHeader()?>

    <section id="blog" class="blog">
        <div class="container">
            <h1 class="heading text-center"><?=$category['name']?></h1>
            <div class="row">
                <?php
                //var_dump($news);
                //$model = getModel('articles');
                //$news = $model->getArticlesByCategory(1);
                if($articles){
                    foreach ($articles as $item){
                        $url = getFullUrl($item);
                        ?>
                        <div class="col-md-6 col-sm-6 col-xs-12 article-height" style="<?php if($item['image'] != '') echo 'background: url(\''.$item['image'].'\'") 0px 0px no-repeat cover';?>">
                            <div class="blog-post">
                                <div class="post-date"><?=$item['date']?></div>
                                <h3><a href="<?=$url?>"><?=$item['name']?></a></h3>
                                <p><?=string_limit_words(strip_tags($item['content']),50)?></p>
                            </div>
                        </div>
                        <?php
                    }
                }
                ?>

            </div>
        </div>
    </section>

<?=getFooter()?>