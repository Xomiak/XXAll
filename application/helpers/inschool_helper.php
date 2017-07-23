<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Created by PhpStorm.
 * User: XomiaK
 * Date: 18.07.2017
 * Time: 15:34
 */

/**
 * @param $article статья
 * @return string html
 */
function getStudentsItem($article)
{
    ob_start();
    $url = getFullUrl($article);
    ?>
        <li data-id="id-1" class="everybody therapist">
            <div class="row">
                <div class="staff span8">
                    <div class="row">
                        <div class="span2">
                            <?php if ($article['image'] != '') { ?>
                                <a href="<?= $url ?>">
                                    <img src="<?= cropImage($article['image'], 190, 190) ?>" alt="<?= $article['name'] ?>">
                                </a>
                            <?php } ?>
                        </div>
                        <div class="span6">
                            <a href="<?= $url ?>">
                                <h5><?= $article['name'] ?><?php if ($article['subname'] != '') echo '<span>' . $article['subname'] . '</span>'; ?></h5>
                            </a>
                            <?= $article['short_content'] ?>
                        </div>
                    </div>
                </div>
            </div>
        </li>
    <?php
    $html = ob_get_contents();
    ob_clean();
    return $html;
}

function getRightSidebar()
{
    ob_start();
    ?>
        <div class="headlinesidebar">
            <h4><span>Услуги</span></h4>
        </div>
        <ul class="sidebarabout1">
            <?php
            $mArticles = getModel('articles');
            $articles = $mArticles->getArticlesByCategory(3, -1, -1, 1);
            if($articles){
                foreach ($articles as $article)
                    echo '<li><a href="'.getFullUrl($article).'">'.$article['name'].'</a></li>';
            }
            ?>
        </ul>
        <?=getOption('right_sidebar')?>

    <?php
    $html = ob_get_contents();
    ob_clean();
    return $html;
}

function getCourceItem($article)
{
    ob_start();
    $url = getFullUrl($article);
    ?>
        <div class="span12  tabinside">
            <a href="<?= $url ?>">
            <h4><?= $article['name'] ?></h4>
            </a>
            <div class="row">
                <div class="span3">
                    <ul class="ch-grid4">
                        <li>
                            <div class="ch-item4">
                                <?php if ($article['image'] != '') { ?>
                                <a href="<?= $url ?>">
                                <img src="<?= cropImage($article['image'], 220, 220) ?>" alt="<?= $article['name'] ?>">
                                </a>
                                <?php } ?>
                                <div class="pricewrapspecial">
                                    <div class="pricebgspecial"><p> $5</p></div>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
                <div class="span9">
                    <a href="<?= $url ?>">
                    <h5><?=$article['subname']?></h5>
                    </a>
                    <p>
                        <?=$article['short_content']?>
                    </p>
                    <div class="buypresent2text1">
                        <div class="sendgiftnow1">
                            <a href="<?= $url ?>">Подробнее</a>
                        </div>
                    </div>
                </div>
            </div>
        </div><

    <?php
    $html = ob_get_contents();
    ob_clean();
    return $html;
}

function getPedagog($article)
{
    ob_start();
    $url = getFullUrl($article);
    ?>
        <div class="row"><!--one column-->
            <div class="staff paddingbottom1 span12">
                <div class="row">
                    <div class="span2">
                        <a href="<?= $url ?>">
                        <img src="<?= cropImage($article['image'], 220, 220) ?>" alt="<?= $article['name'] ?>" alt="">
                        </a>
                        <section class="icons">
                            <h4><span><?= $article['subname'] ?></span></h4>
                        </section>
                    </div>
                    <div class="span10">
                        <a href="<?= $url ?>">
                        <h5><?= $article['name'] ?></h5>
                        </a>
                        <p>
                            <?= $article['short_content'] ?>
                        </p>
                    </div><!--/span10 end-->
                </div><!--/row end-->
            </div><!--/staff end-->
        </div>
    <?php
    $html = ob_get_contents();
    ob_clean();
    return $html;
}

function getGalleryArticles($article)
{
    ob_start();
    $url = getFullUrl($article);
    ?>
        <?php if ($article['image'] != '') { ?>
        <figure class="photo2 element filterone view view-first">
            <img src="<?= cropImage($article['image'], 341, 227) ?>" alt="picture"/>
            <figcaption class="mask">
                <div class="maskinner">
                    <a class='link' href="<?= $url ?>"></a>
                    <h3><?= $article['name'] ?></h3>
                    <h3><?= getPhotoCounter($article)." "."Фото"?></h3>
                </div>
            </figcaption>
        </figure>
<?php }
    ?>

    <?php
    $html = ob_get_contents();
    ob_clean();
    return $html;
}

function getPhotosForGalleryArticle($image)
{
    ob_start();
    ?>
                <?php if ($image['image'] != '') { ?>
                    <figure class="photo2 element filterone view view-first">
                        <img src="<?= cropImage($image['image'], 341, 227) ?>" alt=""/>
                        <figcaption class="mask">
                            <div class="maskinner">
                                <a class='imagepopup glass' href="<?= $image['image']?>"></a>
                            </div>
                        </figcaption>
                    </figure>
               <?php }
               ?>
    <?php
    $html = ob_get_contents();
    ob_clean();
    return $html;
}

function getPhotoCounter($article)
{
        $model = getModel('images');
        $images = $model->getByArticleId($article['id']);
        $count = 0;
                    if($images){
                        foreach ($images as $image){
                            $count = $count+1;
                        }
                    }
    return $count;

}

function getFirstCources($article)
{
    ob_start();
    $url = getFullUrl($article);
    ?>
    <div class="span4 spacolumn">
        <div class="spaheadline">
            <h3><?=$article['name']?></h3>
        </div>
        <div class="circleimage1a">
            <div class="circlebg circlemg">
                <a href="<?= $url ?>"><img src="<?= cropImage($article['image'], 350, 350) ?>" alt=""/></a>
            </div>
        </div>
        <div class="decoration">
        </div>
        <p>
            <?=$article['short_content']?>
        </p>
        <section class="button1">
            <a href="<?= $url ?>">Подробнее</a>
        </section>
    </div>

    <?php
    $html = ob_get_contents();
    ob_clean();
    return $html;
}

function getFirstNews($article)
{
    ob_start();
    $url = getFullUrl($article);
    ?>
    <div class="row">
        <div class=" span6 recentnewsrow">
            <a href="" class="ch-gridwrapper">
                <ul class="ch-grid">
                    <li>
                        <div class="ch-item ch-img-1 circlemg-1">
                            <a href="<?= $url ?>"><img src="<?= cropImage($article['image'], 350, 350) ?>" alt=""/></a>
                            <div class="ch-info" >
                                <a href="<?= $url ?>">
                                    <p><?= date('d',$article['date_unix']) ?><br><span><?= date('F',$article['date_unix']) ?><br><?= date('Y',$article['date_unix']) ?></span></p>
                                </a>
                            </div>
                        </div>
                    </li>
                </ul>
            </a>
            <a href="<?= $url ?>">
            <h4><?=$article['name']?></h4>
            </a>
            <p><?=$article['short_content']?>
            </p>
        </div>
    </div><!--/span6 end-->
    <?php
    $html = ob_get_contents();
    ob_clean();
    return $html;
}

