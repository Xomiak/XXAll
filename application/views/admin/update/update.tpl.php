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

                <div data-widget-group="group1">

                    <div class="panel panel-default" data-widget='{"draggable": "false"}'>
                        <div class="panel-heading">
                            <h2>Поиск обновлений</h2>
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


                            <p>Версия движка: <?= $this->config->item('cms_version') ?>
                                (<?= $this->config->item('cms_build') ?>)</p>

                            <div class="form-group">
                                <button id="check_update" class="btn-primary btn">Проверить наличие новой версии</button>
                            </div>

                            <div id="check_update_results"></div>

                            <?php if ($_SERVER['SERVER_NAME'] == 'new.xx.org.ua') { ?>
                                <div class="form-group">
                                    <a href="/admin/update/create/">
                                        <button id="create_update" class="btn-primary btn">Собрать сборку</button>
                                    </a>
                                    <div id="create_update_results"></div>
                                </div>
                            <?php } ?>

                            <div class="form-group">
                                <div id="div_get_update" style="display: none">
                                    <button id="get_update" class="btn-primary btn">Обновить</button>
                                </div>
                            </div>



                            <script>
                                $(document).ready(function () {
                                    var current_build = '<?= $this->config->item('cms_build') ?>';
                                    var current_version = '<?= $this->config->item('cms_version') ?>';
                                    var latest_build = current_build;
                                    var latest_version = current_version;

//                                        $("#create_update").click(function () {
//                                            $.ajax({
//                                                /* адрес файла-обработчика запроса */
//                                                url: '/admin/ajax/update/create/',
//                                                /* метод отправки данных */
//                                                method: 'POST',
//                                                /* данные, которые мы передаем в файл-обработчик */
//                                                data: {},
//
//                                            }).done(function (data) {
//                                                $("#create_update_results").html(data);
//                                            });
//                                        });

                                    $("#check_update").click(function () {
                                        $.ajax({
                                            /* адрес файла-обработчика запроса */
                                            url: '/admin/ajax/update/get_latest_build/',
                                            /* метод отправки данных */
                                            method: 'POST',
                                            /* данные, которые мы передаем в файл-обработчик */
                                            data: {},

                                        }).done(function (data) {
                                            var obj = jQuery.parseJSON(data);
                                            latest_build = obj.cms_build;
                                            latest_version = obj.cms_version;
                                            if (current_build != latest_build) {
                                                $("#check_update_results").html("Есть более новая версия: " + obj.cms_version + ' (' + obj.cms_build + ')');
                                                $("#div_get_update").show();
                                            }
                                        });
                                    });

                                    
                                });
                            </script>
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