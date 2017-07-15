<?php
loadHelper(TEMPLATE);
if(!isset($meta))
    $meta = false;
?>
<?=getHead($meta)?>
<?=getHeader()?>



    <section class="inner-banner"<?php if($category['image'] != '') echo ' style="background: #000 url('.$category['image'].') center center no-repeat; background-size: cover;"';?>>
        <div class="container text-center">
            <h1><span><?=mb_strtoupper($category['name'])?></span></h1>
        </div>
    </section>

    <section class="breadcrumbs container">
        <?=getBreadcrumbs()?>
    </section>

    <section class="vehicle-sorter-area section-padding col-3-page">
        <div class="container">

            <div class="vehicle-sorter-wrapper mix-it-gallery">

                <div class="row">
                    <?php
                    /** выводим элементы */
                    $mImages = getModel('images');
                    $images = $mImages->getByCategoryId($category['id'],1);
                    //var_dump($images[0]['image']);
                    if($images){
                        $i = 1;
                        foreach ($images as $image){
                            //var_dump($image['image']);
                            //   /upload/categories/2017-06-27/image-0-02-05-d57eab15dd43ed981e4f3acf4d22c2d77f746348bbf063bfe1c11f8dc05e9df6-V.jpg
                            //   /upload/categories/2017-07-10/Indoor-reklama.png
                            //cropImage($image['image'], 800, 800);
                            echo getImageBlock($image, $category, $i);
                            $i++;
                        }
                    } else echo 'В этом разделе пока пусто...';
                    ?>
                </div>

                <!--ul class="post-pagination text-center">
                    <li><span>01</span></li>
                    <li><a href="#">02</a></li>
                    <li><a href="#">03</a></li>
                    <li><a href="#">04</a></li>
                    <li><a href="#">05</a></li>
                    <li><a href="#">06</a></li>
                    <li><a href="#">07</a></li>
                    <li><a href="#">08</a></li>
                    <li><a href="#">09</a></li>
                    <li><a href="#"><i class="fa fa-angle-double-right"></i></a></li>
                </ul-->
            </div>
        </div>
    </section>

<?=getFooter()?>