<?php
loadHelper(TEMPLATE);
if(!isset($meta))
    $meta = false;

//vdd($meta);
?>

<?=getHead($meta)?>
<?=getHeader()?>


    <!-- block-wrapper-section
        ================================================== -->
    <section class="block-wrapper">
        <div class="container">
            <div class="row">


                <div class="col-md-2 col-sm-0">

                    <!-- sidebar -->
                    <?php
                    include(X_PATH . '/application/views/' . TEMPLATE . '/common/left_sidebar.inc.php');
                    ?>

                </div>

                <div class="col-md-7 col-sm-8">

                    <!-- block content -->
                    <div class="block-content">
                        <?=getBreadcrumbsBlock()?>

                        <!-- single-post box -->
                        <div class="single-post-box">

                            <div class="title-post">
                                <h1><?=$article['name']?></h1>
                                <ul class="post-tags">
                                    <li><i class="fa fa-clock-o"></i><?= getWordDate($article['date']) ?></li>
                                    <li><a href="#"><i class="fa fa-comments-o"></i><span>0</span></a></li>
                                    <li><i class="fa fa-eye"></i><?=$article['count']?></li>
                                </ul>
                            </div>

                            <!--div class="share-post-box">
                                <ul class="share-box">
                                    <li><i class="fa fa-share-alt"></i><span>Share Post</span></li>
                                    <li><a class="facebook" href="#"><i class="fa fa-facebook"></i><span>Share on Facebook</span></a></li>
                                    <li><a class="twitter" href="#"><i class="fa fa-twitter"></i><span>Share on Twitter</span></a></li>
                                    <li><a class="google" href="#"><i class="fa fa-google-plus"></i><span></span></a></li>
                                    <li><a class="linkedin" href="#"><i class="fa fa-linkedin"></i><span></span></a></li>
                                </ul>
                            </div-->

                            <?php if($article['image'] != ''){ ?>
                            <div class="post-gallery">
                                <img src="<?=$article['image']?>" alt="<?=$article['name']?>">
                                <!--span class="image-caption">Cras eget sem nec dui volutpat ultrices.</span-->
                            </div>
                            <?php } ?>

                            <div class="post-content">

                                <?=$article['content']?>
                            </div>

                            <div class="article-inpost">
                                <div class="row">
                                    <?php
                                    $modelImages = getModel('images');
                                    $images = $modelImages->getByArticleId($article['id'], 1, '');
                                    $imgCount = 1;
                                    if($images){
                                        foreach ($images as $image){
                                            $name = strip_tags($image['text']);
                                            if($name == '') $name = $article['name'].' (фото №'.$imgCount.')';
                                            $imgCount++;
                                            ?>
                                            <div class="col-md-6">
                                                <div class="image-content">
                                                    <div class="image-place">
                                                        <img src="<?=CreateThumb(330,380,$image['image'],'330x380')?>" alt="<?=$name?>">
                                                        <div class="hover-image">
                                                            <a class="zoom" href="<?=$image['image']?>"><i class="fa fa-arrows-alt"></i></a>
                                                        </div>
                                                    </div>
                                                    <span class="image-caption"><?=$name?></span>
                                                </div>
                                            </div>
                                            <?php
                                        }
                                    }
                                    ?>

                                </div>
                            </div>


                                    <?php
                                    $tags = getTags($article['tags']);
                                    if($tags){
                                        ?>
                            <div class="post-tags-box">
                                <ul class="tags-box">
                                    <li><i class="fa fa-tags"></i><span>Тэги:</span></li>
                                        <?php
                                        foreach ($tags as $tag){
                                            $tag = getTag($tag);
                                            echo '<li><a href="/tags/'.$tag['url'].'/">'.$tag['name'].'</a></li>';
                                        }
                                        ?>
                                </ul>
                            </div>
                                        <?php
                                    }
                                    ?>


                            <div class="share-post-box">
                                <ul class="share-box">
                                    <li><i class="fa fa-share-alt"></i><span>Поделиться</span></li>
                                </ul>

                                <script type="text/javascript">(function(w,doc) {
                                        if (!w.__utlWdgt ) {
                                            w.__utlWdgt = true;
                                            var d = doc, s = d.createElement('script'), g = 'getElementsByTagName';
                                            s.type = 'text/javascript'; s.charset='UTF-8'; s.async = true;
                                            s.src = ('https:' == w.location.protocol ? 'https' : 'http')  + '://w.uptolike.com/widgets/v1/uptolike.js';
                                            var h=d[g]('body')[0];
                                            h.appendChild(s);
                                        }})(window,document);
                                </script>
                                <div data-background-alpha="0.0" data-buttons-color="#ffffff" data-counter-background-color="#ffffff" data-share-counter-size="12" data-top-button="false" data-share-counter-type="common" data-share-style="12" data-mode="share" data-like-text-enable="false" data-hover-effect="scale" data-mobile-view="true" data-icon-color="#ffffff" data-orientation="horizontal" data-text-color="#000000" data-share-shape="round-rectangle" data-sn-ids="fb.vk.tw.ok.gp.mr.lj.ln.em." data-share-size="30" data-background-color="#ffffff" data-preview-mobile="false" data-mobile-sn-ids="fb.vk.tw.wh.ok.vb." data-pid="1673064" data-counter-background-alpha="1.0" data-following-enable="true" data-exclude-show-more="false" data-selection-enable="true" data-follow-fb="Favorit.udachi" class="uptolike-buttons" ></div>

                            </div>

                            <div class="prev-next-posts">
                                <?php
                                $prev = $this->db->where('num <', $article['num'])->limit(1)->get('articles')->result_array();
                                $next = $this->db->where('num >', $article['num'])->limit(1)->get('articles')->result_array();
                                if(isset($prev[0])) {
                                    $prev = $prev[0];
                                    $url = getFullUrl($prev);
                                    ?>
                                    <div class="prev-post">
                                        <div class="post-content">
                                            <h2><a href="<?=$url?>" title="<?=$prev['name']?>"><?=$prev['name']?></a></h2>
                                            <ul class="post-tags">
                                                <li><i class="fa fa-clock-o"></i><?= getWordDate($prev['date']) ?></li>
                                                <li><a href="<?=$url?>"><i class="fa fa-comments-o"></i><span><?=$prev['count']?></span></a></li>
                                            </ul>
                                        </div>
                                    </div>
                                    <?php
                                }
                                if(isset($next[0])) {
                                    $next = $next[0];
                                    $url = getFullUrl($next);
                                    ?>
                                    <div class="prev-post">
                                        <div class="post-content">
                                            <h2><a href="<?=$url?>" title="<?=$next['name']?>"><?=$next['name']?></a></h2>
                                            <ul class="post-tags">
                                                <li><i class="fa fa-clock-o"></i><?= getWordDate($next['date']) ?></li>
                                                <!--li><a href="<?=$url?>"><i class="fa fa-comments-o"></i><span><?=$next['count']?></span></a></li-->
                                            </ul>
                                        </div>
                                    </div>
                                    <?php
                                }
                                ?>
                            </div>

                            <?php
                            if($GLOBALS['comments_on'] == 1) {

                                loadHelper('comments');

                                echo getArticleComments($article['id']);
                                echo getNewCommentBlock($article['id']);
                            }
                            ?>


                            <!-- carousel box -->
                            <div class="carousel-box owl-wrapper">
                                <div class="title-section">
                                    <h1><span>Похожие новости</span></h1>
                                </div>
                                <div class="owl-carousel" data-num="3">
                                    <?php
                                    $related = array();
                                    if($tags){
                                        foreach ($tags as $tag){
                                            $res = $this->art->getArticlesByTag($tag, 20, 0, 1);
                                            if($res){
                                                foreach ($res as $item){
                                                    if(!in_array($item, $related))
                                                        array_push($related,$item);
                                                }
                                            }
                                            if(count($related) > 20)
                                                break;
                                        }
                                    }

                                    if($related){
                                        //var_dump($related);die();
                                        foreach ($related as $item){
                                            //vdd($item);
                                            $url = getFullUrl($item);
                                            ?>
                                            <div class="item news-post image-post3">
                                                <?php if($item['image'] != '') { ?>
                                                    <img src="<?=CreateThumb(220, 200, $item['image'], '220x200')?>" alt="<?=$item['name']?>">
                                                <?php } ?>
                                                <div class="hover-box">
                                                    <h2><a href="<?=$url?>"><?=$item['name']?></a></h2>
                                                    <ul class="post-tags">
                                                        <li><i class="fa fa-clock-o"></i><?= getWordDate($next['date']) ?></li>
                                                    </ul>
                                                </div>
                                            </div>
                                            <?php
                                        }
                                    }
                                    ?>
                                </div>
                            </div>
                            <!-- End carousel box -->

                        </div>
                        <!-- End single-post box -->

                    </div>
                    <!-- End block content -->

                </div>

                <div class="col-md-3 col-sm-4">
                    <!-- sidebar -->
                    <?php
                    include(X_PATH . '/application/views/' . TEMPLATE . '/common/right_sidebar.inc.php');
                    ?>
                    <!-- End sidebar -->
                </div>

            </div>

        </div>
    </section>
    <!-- End block-wrapper-section -->
<?=getFooter()?>