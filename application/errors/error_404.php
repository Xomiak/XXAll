<?php
if(!isset($meta))
    $meta = false;
$CI = & get_instance();
$CI->load->model('Model_pages','pages');
$page = $CI->pages->getPageByUrl('err404');
$page = translatePage($page);
$keywords = $description = $title = $page['title'];
$robots = "noindex, follow";
?>
<?=getHead($meta)?>
<?=getHeader()?>
    <!--===== PAGE TITLE =====-->
    <div class="page-title page-main-section" style="<?php if($page['image'] != '') echo 'background-image: url('.$page['image'].')'?>">
        <div class="container padding-bottom-top-120 text-uppercase text-center">
            <div class="main-title">
                <h1><?=$page['name']?></h1>
                <!--                <h5>10 Years Of Experience!</h5>-->
                <div class="line_4"></div>
                <div class="line_5"></div>
                <div class="line_6"></div>

            </div>
        </div>
    </div>

    <!--===== #/PAGE TITLE =====-->
    <!-- LISTING -->
    <section id="faqs" class="padding">
        <div class="container">
            <div class="row bottom40">
                <div class="col-xs-12">

                </div>
            </div>
            <div class="row bottom30">
                <?= getLangText($page['content']) ?>
            </div>

        </div>
    </section>

<?=getFooter()?>