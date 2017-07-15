<?php
include("application/views/admin/common/head.php");
include("application/views/admin/common/header.php");
?>
    <div id="wrapper">
    <div id="layout-static">
<?php include("application/views/admin/common/left_sidebar.php"); ?>
    <div class="static-content-wrapper">
    <div class="static-content">
        <div class="page-content">
            <ol class="breadcrumb">

                <li><a href="/admin/">Главная</a></li>
                <li><a href="/admin/update/">Обновление</a></li>
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

                <div data-widget-group="group1">

                    <div class="panel panel-default" data-widget='{"draggable": "false"}'>
                        <div class="panel-heading">
                            <h2>Создание новой сборки</h2>
                            <div class="panel-ctrls"
                                 data-actions-container=""
                                 data-action-collapse='{"target": ".panel-body"}'
                                 data-action-expand=''
                                 data-action-colorpicker=''
                            >
                            </div>
                        </div>
                        <div class="panel-editbox" data-widget-controls=""></div>
                        <div class="panel-body">


                            <p>Текущая версия движка: <?= $this->config->item('cms_version') ?> (<?= $this->config->item('cms_build') ?>)</p>

                            <p>Новая сборка готова: <?=$build_link?></p>

                        </div>
                    </div>
                </div>


            </div> <!-- .container-fluid -->
        </div> <!-- #page-content -->
    </div>
    <div id="result"></div>

<?php
$adding_scripts = "";
include("application/views/admin/common/footer.php");
?>