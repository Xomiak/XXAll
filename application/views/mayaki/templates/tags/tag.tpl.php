<?php
loadHelper(TEMPLATE);
if(!isset($meta))
    $meta = false;
?>

<?=getHead($meta)?>
<?=getHeader()?>

    <style>
        .no-link-pg{
            margin-bottom: 10px;
        }
    </style>
    <!-- block-wrapper-section
                ================================================== -->

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
                        <!-- article box -->
                        <div class="article-box">
                            <div class="title-section">
                                <h1><span><?=$category['name']?></span></h1>
                            </div>

                            <?php
                            if($articles){
                                $count = count($articles);
                                for($i = 0; $i < $count; $i++) {
                                    $article = $articles[$i];
                                    echo getCategoryNew($article);
                                    if(($i + 1) == ($count / 2))
                                        echo getBanners('center');
                                }
                            }
                            ?>
                        </div>



                        <style>
                            .no-link-pg{
                                background: #f5d76e none repeat scroll 0 0;
                                border: 1px solid #f5d76e;
                                color: #222222;
                                border-radius: 3px;

                                display: inline-block;
                                font-family: "Lato",sans-serif;
                                font-size: 12px;
                                padding: 6px 11px;
                                text-decoration: none;
                                transition: all 0.2s ease-in-out 0s;
                            }
                        </style>

                        <!-- Pagination box -->
                        <div class="pagination-box">
                            <ul class="pagination-list">
                                <?=$pager['html']?>
                            </ul>
                            <p>Страница <?=$pager['page_number']?> из <?=$pager['pages_count']?></p>
                        </div>
                        <!-- End Pagination box -->
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