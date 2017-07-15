<?php
$myType = userdata('type');
$languages = $this->model_languages->getLanguages();
$defaultLanguage = $this->model_languages->getDefaultLanguage();
$languagesCount = $this->model_languages->languagesCount(1);
include("application/views/admin/common/head.php");
?>

<?php
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
        <li><a href="/admin/languages/">Языки</a></li>
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
<?php include('application/views/admin/languages/menu.inc.php'); ?>
    <div data-widget-group="group1">

    <div class="panel panel-1" data-widget='{"draggable": "false"}'>
    <div class="panel-heading">
        <?php
        $title = "Добавление нового языка";
        if($action == 'edit') $title = 'Редактирование языка: '.$language['name'];
        ?>
        <h2><?= $title ?></h2>
        <div class="panel-ctrls"
             data-actions-container=""
             data-action-collapse='{"target": ".panel-body"}'
        >
        </div>
    </div>
    <div class="panel-editbox" data-widget-controls=""></div>
    <div class="panel-body">

        <form enctype="multipart/form-data" action="<?= $_SERVER['REQUEST_URI'] ?>" method="post"
              class="form-horizontal row-border">
            <div class="container-fluid">

                <div class="tab-content">
                    <div class="tab-pane active" id="tab1">
                        <div class="row">

                            <div class="panel-editbox" data-widget-controls=""></div>
                            <div class="panel-body">

                                <div class="form-group">
                                    <label class="col-sm-2 control-label">
                                        Название *:
                                    </label>
                                    <div class="col-sm-8">
                                        <input required id="inp_name" class="form-control" type="text" name="name"
                                               value="<?php if (isset($language['name'])) echo $language['name']; elseif (isset($_POST['name'])) echo $_POST['name']; ?>">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-sm-2 control-label">
                                        Код языка *:
                                    </label>
                                    <div class="col-sm-8">
                                        <input <?php if (isset($language)) echo "disabled"; ?> required id="inp_code" class="form-control" type="text" name="code"
                                               value="<?php if (isset($language['code'])) echo $language['code']; elseif (isset($_POST['code'])) echo $_POST['code']; ?>">
                                        <?php if (isset($err['code'])) echo '<div class="error">' . $err['code'] . '</div>'; ?>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-sm-2 control-label">
                                        Позиция *:
                                    </label>
                                    <div class="col-sm-8">
                                        <input required id="inp_num" class="form-control" type="text" name="num"
                                               value="<?php if (isset($language['num'])) echo $language['num']; elseif (isset($_POST['num'])) echo $_POST['num']; ?>">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-sm-2 control-label">
                                        Иконка:
                                    </label>
                                    <div class="col-sm-8">
                                        <?php
                                        $name = 'icon';
                                        if (isset($language['icon']) && $language['icon'] != '') {
                                            echo '<img src="' . $language[$name] . '" alt="' . $name . '" class="img-responsive" id="crop-' . $name . '" style="max-width: 50%">';
                                            echo '<input id="inp_' . $name . '" type="text" class="form-control" name="' . $name . '" value="http://' . $_SERVER['SERVER_NAME'] . $language[$name] . '" />';
                                        }
                                        echo '                    
                                    <div class="fileinput fileinput-new" data-provides="fileinput">
                                            <div class="input-group">
                                                <div class="form-control uneditable-input" data-trigger="fileinput">
                                                    <i class="fa fa-file fileinput-exists"></i>&nbsp;<span class="fileinput-filename"></span>
                                                </div>
                                                <span class="input-group-btn">
                                                    <a href="#" class="btn btn-default fileinput-exists" data-dismiss="fileinput">Убрать</a>
                                                    <span class="btn btn-default btn-file">
                                                        <span class="fileinput-new">Выбрать ';
                                        if (isset($language[$name]) && $language[$name] != '') echo 'другой ';
                                        echo 'файл</span>
                                                        <span class="fileinput-exists">Изменить</span>										
                                                        <input type="file" name="' . $name . '">
                                                    </span>
                                                    
                                                </span>
                                            </div>
                                        </div>
                                        <img class="preview-image-upload" id="preview_' . $name . '" style="display: none" src="#" alt="" />
                                    ';
                                        ?>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-sm-2 control-label">
                                            Активный:
                                        </label>
                                        <div class="col-sm-8">
                                            <input type="checkbox" name="active"
                                                <?php if(isset($language) && $language['active'] == 1) echo ' checked="checked"';?>
                                                <?php if(isset($language) && $language['default'] == 1) echo ' disabled ';?>
                                               class="bootstrap-switch switch-alt" data-on-color="success" data-off-color="default" data-on-text="ДА" data-off-text="НЕТ" />
                                            <?php if(isset($language) && $language['default'] == 1) echo ' Основной язык невозможно деактивировать!';?>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-sm-2 control-label">
                                            Основной:
                                        </label>
                                        <div class="col-sm-8">
                                            <input type="checkbox" name="default"
                                                <?php if(isset($language) && $language['default'] == 1) echo ' checked="checked"';?>
                                                <?php if(isset($language) && $language['default'] == 1) echo ' disabled';?>
                                                   class="bootstrap-switch switch-alt" data-on-color="success" data-off-color="default" data-on-text="ДА" data-off-text="НЕТ" />
                                        </div>
                                    </div>


                                    <div class="form-group fixed-buttons">
                                        <input class="form-submit save" type="submit"
                                               name="<?= $action ?>"
                                               title="Сохранить" value=""/>&nbsp;
                                        <input class="form-submit save_and_close"
                                               type="submit"
                                               name="<?= $action ?>_and_close"
                                               title="Сохранить и закрыть"
                                               value=""/>
                                    </div>
                                </div>
                                


                                <script>
                                    function readURL_<?=$name?>(input) {
                                        if (input.files && input.files[0]) {

                                            var reader = new FileReader();
                                            reader.onload = function (e) {
                                                $('#preview_<?=$name?>').attr('src', e.target.result);
                                            };
                                            reader.readAsDataURL(input.files[0]);
                                            $('#preview_<?=$name?>').show(1000);
                                        }
                                    }
                                    $(document).ready(function () {
                                        $('input[name="<?=$name?>"]').change(function () {
                                            readURL_<?=$name?>(this);
                                        });
                                    });
                                </script>
                                
                            </div>
                        </div>
                    </div>
                </div>


<!--                    <tr>-->
<!--                        <td colspan="2"><input id="default" type="checkbox"-->
<!--                                               name="default" --><?php //if (isset($language['default']) && $language['default'] == 1) echo ' checked'; ?><!-- />-->
<!--                            Основной-->
<!--                        </td>-->
<!--                    </tr>-->
<!--                    <tr>-->
<!--                        <script>-->
<!--                            /* ЕСЛИ ВЫБРАН DEFAULT, ТОГДА НЕЛЬЗЯ СДЕЛАТЬ НЕ АКТИВНЫМ-->
<!---->
<!--                             !!! НЕ РАБОТАЕТ!-->
<!--                             */-->
<!--                            $(document).ready(function () {-->
<!--                                $("#default").change(function () {-->
<!--                                    if ($("#default").attr("checked") != 'checked') {-->
<!--                                        //alert("1");-->
<!--                                        $("#active").attr('enabled', 'enabled');-->
<!--                                    }-->
<!--                                    else {-->
<!--                                        //alert("2");-->
<!--                                        //$( "#active" ).attr('disabled', 'disabled');-->
<!--                                    }-->
<!--                                });-->
<!--                            });-->
<!--                        </script>-->
<!--                        <td colspan="2"><input id="active" type="checkbox"-->
<!--                                               name="active" --><?php //if (isset($language['active']) && $language['active'] == 0) echo ' '; else echo ' checked'; ?><!-- />-->
<!--                            Активный-->
<!--                        </td>-->
<!--                    </tr>-->
<!--                    <tr>-->
<!--                        <td colspan="2"><input type="submit" value="--><?//= $action ?><!--"/></td>-->
<!--                    </tr>-->
<!--                </table>-->
            </div>
    </div>


<?php
$adding_scripts = '';

include("application/views/admin/common/footer.php");
?>