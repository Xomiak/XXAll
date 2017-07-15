<?= $head ?>
<?= $header ?>
    <div id="wrapper">
    <div id="layout-static">
<?= $left_sidebar ?>
    <div class="static-content-wrapper">
    <div class="static-content">
        <div class="page-content">
            <ol class="breadcrumb">

                <li><a href="/">Главная</a></li>
                <li class="active"><a href="<?= $_SERVER['REQUEST_URI'] ?>"><?= $title ?></a></li>

            </ol>
            <div class="page-heading">
                <h1><?= $title ?></h1>
                <div class="options">
                    <div class="btn-toolbar">
                        <a href="#" class="btn btn-default"><i class="fa fa-fw fa-wrench"></i></a>
                    </div>
                </div>
            </div>
            <div class="container-fluid">

                <div class="row">
                    <div class="col-md-12">

                        <div class="panel">
                            <div class="panel-body panel-no-padding">
                                <br/>
                                <button id="cache_clear_all" class="btn-primary btn">Очистить весь кэш</button><br /><br />
                                <button id="cache_clear_files" class="btn-primary btn">Очистить файловый кэш</button><br /><br />
                                <button id="cache_clear_db" class="btn-primary btn">Очистить кэш в базе</button><br /><br />
                                <div id="result"></div>
                            </div>
                        </div>
                    </div>
                </div>

            </div> <!-- .container-fluid -->
        </div> <!-- #page-content -->
    </div>

<script>
    $(document).ready(function () {
        $("#cache_clear_db").click(function () {
            cache_clear_db();
        });
        $("#cache_clear_files").click(function () {
            cache_clear_files();
        });
        $("#cache_clear_all").click(function () {
            cache_clear_all();
        });
    });
</script>
<?php
$adding_scripts = "";
?>
<?=$footer?>