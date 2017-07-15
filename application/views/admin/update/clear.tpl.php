<?=$head?>

    <link type="text/css" href="/includes/assets/plugins/iCheck/skins/minimal/blue.css"
          rel="stylesheet">                   <!-- Custom Checkboxes / iCheck -->

<?=$header?>
    <!-- Custom Checkboxes / iCheck -->


    <div id="wrapper">
    <div id="layout-static">
<?=$left_sidebar?>
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
                            <h2>Выберите, какие данные Вы хотите очистить:</h2>
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
                            <?php
                            if(isset($result) && $result != ''){
                                echo '<div class="text-success">'.$result.'</div>';
                            }
                            ?>
                            <form method="post" id="form_clear">
                                <div class="form-group">
                                    <div class="col-sm-8">
                                        <label class="checkbox" for="inp_articles">
                                        <input id="inp_articles" type="checkbox" name="articles"
                                               class="bootstrap-switch switch-alt" data-on-color="success"
                                               data-off-color="default" data-on-text="ДА" data-off-text="НЕТ"/>
                                        Статьи
                                            </label>


                                        <label class="checkbox" for="inp_products">
                                            <input id="inp_products" type="checkbox" name="products"
                                                   class="bootstrap-switch switch-alt" data-on-color="success"
                                                   data-off-color="default" data-on-text="ДА" data-off-text="НЕТ"/>
                                            Товары
                                        </label>

                                        <label class="checkbox" for="inp_categories">
                                            <input id="inp_categories" type="checkbox" name="categories"
                                                   class="bootstrap-switch switch-alt" data-on-color="success"
                                                   data-off-color="default" data-on-text="ДА" data-off-text="НЕТ"/>
                                            Разделы
                                        </label>

                                        <label class="checkbox" for="inp_pages">
                                            <input id="inp_pages" type="checkbox" name="pages"
                                                   class="bootstrap-switch switch-alt" data-on-color="success"
                                                   data-off-color="default" data-on-text="ДА" data-off-text="НЕТ"/>
                                            Страницы
                                        </label>

                                        <label class="checkbox" for="inp_menus">
                                            <input id="inp_menus" type="checkbox" name="menus"
                                                   class="bootstrap-switch switch-alt" data-on-color="success"
                                                   data-off-color="default" data-on-text="ДА" data-off-text="НЕТ"/>
                                            Меню
                                        </label>

                                        <label class="checkbox" for="inp_images">
                                            <input id="inp_images" type="checkbox" name="images"
                                                   class="bootstrap-switch switch-alt" data-on-color="success"
                                                   data-off-color="default" data-on-text="ДА" data-off-text="НЕТ"/>
                                            Картинки
                                        </label>

                                        <label class="checkbox" for="inp_tags">
                                            <input id="inp_tags" type="checkbox" name="tags"
                                                   class="bootstrap-switch switch-alt" data-on-color="success"
                                                   data-off-color="default" data-on-text="ДА" data-off-text="НЕТ"/>
                                            Тэги
                                        </label>

                                        <input type="hidden" name="clear" value="clear">
                                        <button id="btn_clear" name="btn_clear" type="button" data-loading-text="Loading..." class="loading-example-btn btn btn-danger"><i class="fa fa-trash-o" aria-hidden="true"></i> Приступить к очистке данных</button>

                                        <br /><br />
                                        <div class="text-info">
                                            * Внимание!!! После очистки восстановить информацию будет невозможно!<br />
                                            Перед очисткой рекомендуется сделать <a href="/admin/update/create_backup/">бэкап</a> (резервную копию).
                                        </div>

                                    </div>
                                </div>
                            </form>

                        </div>
                    </div>
                </div>

                <script>
                    $(document).ready(function () {
                        $("#btn_clear").click(function () {
                            if (confirm("Вы точно хотите безвозвратно удалить выбранные данные?")) {
                                $("#form_clear").submit();
                            }
                        });
                    });
                </script>

            </div> <!-- .container-fluid -->
        </div> <!-- #page-content -->
    </div>
    <div id="result"></div>


<?php
$adding_scripts = '
';
if(isset($footer)) {
    $footer = str_replace('[adding_scripts]', $adding_scripts, $footer);
    echo $footer;
}
?>