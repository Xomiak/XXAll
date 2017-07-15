<?php
include("application/views/head.php");
include("application/views/header.php");
$this->lang->load('main', $current_lang);
?>

    <!-- START MAIN-SECTION- -->

    <section class="sections">
        <div class="container">
            <div class="row">
                <?php include('application/views/left.tpl.php'); ?>

                <div class="col-md-8">
                    <div class="subsubmenu-content">

                        <?php //include("application/views/mod/breadcrumbs.mod.php") ?>
                        <h1>Поиск:</h1>

                        <form method="post" action="/search/">
                            <div class="input-group input-group-lg">
                                <input name="search" type="text" class="form-control"
                                       placeholder="<?= $this->lang->line('header_search') ?>" required
                                       value="<?= userdata('search') ?>">
                      <span class="input-group-btn">
                        <input class="btn btn-default" type="submit" value="Поиск">
                      </span>

                            </div>
                            <!-- /input-group -->
                        </form>
                        <div class="clearfix"></div>
                        <?php
                        if (isset($articles) && $articles != false) { // Выводим организации
                            ?>
                            <ul><?php
                            $count = count($articles);
                            for ($i = 0; $i < $count; $i++) {
                                $article = $articles[$i];
                                ?>
                                <li>
                                    <span><?= ($i + 1) ?>.</span>
                                    <?php if ($article['image'] != '') { ?>
                                        <img src="<?= CreateThumb(60, 60, $article['image'], 'organizations') ?>"
                                             alt="<?= $article['name'] ?>">
                                    <?php } else { ?>
                                        <?php $category = $this->model_categories->getCategoryById($article['category_id']); ?>
                                        <?php if($category['image'] != '') { ?>
                                        <img src="<?= CreateThumb2(60, 60, $category['image'], 'organizations') ?>"
                                             alt="no logo">
                                             <?php } ?>
                                    <?php } ?>
                                    <div class="wrap-subsubmenu-text">
                                        <a href="<?= getFullUrl($article) ?>"><?= $article['name'] ?></a>
                                        <p><?= $article['short_content'] ?></p>
                                    </div>
                                </li>
                                <div class="clearfix"></div>
                                <?php
                            }
                            ?></ul><?php
                        } else {
                            echo 'По Вашему запросу ничего не найдено...';
                        }
                        ?>

                        <div class="search pager"><?=$pager?></div>


                    </div>
                    </div>


                    <?php include('application/views/right.tpl.php'); ?>
                </div>
    </section>

    <!-- END MAIN-SECTION- -->

    <section class="main-section">
        <?php include('application/views/bottom.tpl.php'); ?>
    </section>

<?php include("application/views/footer.php"); ?>