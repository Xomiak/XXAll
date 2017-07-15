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
                    <div class="page-section-center">

                            <h1><?= $h1 ?></h1>
                            <p>Вы будете перенаправлены через <span id="time"></span>...</p>
                        <p>Если этого не произошло, нажмите на следующую ссылку: <a rel="nofollow" href="<?=$url?>"><?=$url?></a></p>
                        <b></b>
                        <script type="text/javascript">
                            var i = 5;//время в сек.
                            function time(){
                                document.getElementById("time").innerHTML = i;//визуальный счетчик
                                i--;//уменьшение счетчика
                                if (i < 0) location.href = "<?=$url?>";//редирект
                            }
                            time();
                            setInterval(time, 1000);
                        </script>

                    </div>
                </div>

                <?php include('application/views/right.tpl.php'); ?>
            </div>
        </div>
    </section>

    <!-- END MAIN-SECTION- -->


<?php include("application/views/footer.php"); ?>