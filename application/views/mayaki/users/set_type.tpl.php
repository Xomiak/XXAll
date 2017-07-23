<?php
include("application/views/head.php");
include("application/views/header.php");
$this->lang->load('main', $current_lang);
?>

    <!-- START MAIN-SECTION- -->
    <section class="sections">
        <div class="container">
            <div class="row">
                <?php include('application/views/users/my_organizations.inc.php'); ?>
                <div class="col-md-2 hidden-sm hidden-xs">
                    <div class="top-ten-section">
                        <h2>Мои организации</h2>
                        <ul>
                            <?php
                            if($myArticles){
                                foreach ($myArticles as $item){
                                    ?><li><a href="<?=getFullUrl($item)?>?preview"><?=$item['name']?></a></li><?php
                                }
                            }
                            ?>
                        </ul>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="page-section-center">

                        <?php include("application/views/mod/breadcrumbs.mod.php") ?>

                        <section class="set-type">

                            <h1><?=$h1?></h1>

                            <div class = "col-md-12 ">
                                Текущий тариф организации: <?=$article['type']?><br />
                                <?php if($article['type'] != 'free' && $article['type'] != ''){ ?>
                                    Дата окончания тарифа: <?=$article['type_end_date']?> [<a href="/user/buy-type/<?=$article['id']?>/<?=$article['type']?>/">продлить</a>]<br /><br />
                                <?php } ?>
                                <!--form method="post">
                                Выбрать другой тариф:
                                <select name="tarif" id="tarif-select">
                                    <?php foreach ($tarifs as $tarif){ ?>
                                        <option><?=$tarif['name']?></option>
                                    <?php } ?>
                                </select>
                                    <input type="submit" name="set-tarif" value="Изменить тариф" />
                                </form-->
                                <h2>Выбор тарифа:</h2>
                                <table class="tarifs-table" style="width: 100%">
                                    <tr>
                                        <th>Название</th>
                                        <th>Описание</th>
                                        <th>Цена (за месяц)</th>
                                        <th>Цена (за год)</th>
                                        <th></th>
                                    </tr>
                                    <?php foreach ($tarifs as $tarif) { ?>
                                        <tr>
                                            <th><?=$tarif['name']?></th>
                                            <td><?=$tarif['description']?></td>
                                            <td><?=$tarif['price']?></td>
                                            <td><?=$tarif['price_year']?></td>
                                            <td>
                                                <?php if($tarif['name'] != 'free'){ ?>
                                                <a href="/user/buy-type/<?=$article['id']?>/?extend=month&tarif=<?=$tarif['name']?>">на месяц</a> | <a href="/user/buy-type/<?=$article['id']?>/?extend=year&tarif=<?=$tarif['name']?>">на год</a>
                                                <?php } ?>
                                            </td>
                                        </tr>
                                    <?php } ?>
                                </table>
                            </div>

                        </section>
                    </div>
                </div>

                <?php include('application/views/users/menu.inc.php'); ?>
            </div>
        </div>
    </section>

    <!-- END MAIN-SECTION- -->
    <section class="main-section">
        <?php include('application/views/bottom.tpl.php'); ?>
    </section>

<?php include("application/views/footer.php"); ?>