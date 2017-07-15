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

                <div class="col-md-6">
                    <div class="page-section-center">

                        <?php include("application/views/mod/breadcrumbs.mod.php") ?>

                        <section class="set-type">

                            <h1><?=$h1?></h1>

                            <div class = "col-md-12 ">
                                Итого, к оплате:
                                <?php
                                if(isset($_GET['extend']) && $_GET['extend'] == 'year') echo $tarif['price_year'];
                                else echo $tarif['price'];
                                ?> грн<br />
                                <input type="button" value="Перейти к оплате" disabled /><br />
                                Автоматическая оплата временно не работает.<br />
                                Для изменения тарифа обращайтесь на почту: info@hobby.od.ua
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