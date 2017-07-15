<?php
$title_min = 10;
$title_max = 70;
$description_min = 50;
$description_max = 160;
$myType = userdata('type');
$languages = $this->model_languages->getLanguages();
$defaultLanguage = $this->model_languages->getDefaultLanguage();
$languagesCount = $this->model_languages->languagesCount(1);
?>
<?=$head?>
    <link type="text/css" href="<?=GENERAL_DOMAIN?>/includes/assets/plugins/form-select2/select2.css"
          rel="stylesheet">                        <!-- Select2 -->
    <link type="text/css" href="<?=GENERAL_DOMAIN?>/includes/assets/plugins/form-multiselect/css/multi-select.css"
          rel="stylesheet">           <!-- Multiselect -->
    <link type="text/css" href="<?=GENERAL_DOMAIN?>/includes/assets/plugins/form-fseditor/fseditor.css"
          rel="stylesheet">                      <!-- FullScreen Editor -->
    <link type="text/css" href="<?=GENERAL_DOMAIN?>/includes/assets/plugins/form-tokenfield/bootstrap-tokenfield.css"
          rel="stylesheet">        <!-- Tokenfield -->
    <link type="text/css" href="<?=GENERAL_DOMAIN?>/includes/assets/plugins/switchery/switchery.css"
          rel="stylesheet">                            <!-- Switchery -->

    <link type="text/css" href="<?=GENERAL_DOMAIN?>/includes/assets/plugins/bootstrap-touchspin/dist/jquery.bootstrap-touchspin.min.css"
          rel="stylesheet"> <!-- Touchspin -->

    <link type="text/css" href="<?=GENERAL_DOMAIN?>/includes/assets/js/jqueryui.css"
          rel="stylesheet">                                            <!-- jQuery UI CSS -->

    <link type="text/css" href="<?=GENERAL_DOMAIN?>/includes/assets/plugins/iCheck/skins/minimal/_all.css"
          rel="stylesheet">                   <!-- Custom Checkboxes / iCheck -->
    <link type="text/css" href="<?=GENERAL_DOMAIN?>/includes/assets/plugins/iCheck/skins/flat/_all.css" rel="stylesheet">
    <link type="text/css" href="<?=GENERAL_DOMAIN?>/includes/assets/plugins/iCheck/skins/square/_all.css" rel="stylesheet">

    <link type="text/css" href="<?=GENERAL_DOMAIN?>/includes/assets/plugins/form-daterangepicker/daterangepicker-bs3.css"
          rel="stylesheet">    <!-- DateRangePicker -->
    <link type="text/css" href="<?=GENERAL_DOMAIN?>/includes/assets/plugins/iCheck/skins/minimal/blue.css"
          rel="stylesheet">                   <!-- Custom Checkboxes / iCheck -->
    <link type="text/css" href="<?=GENERAL_DOMAIN?>/includes/assets/plugins/clockface/css/clockface.css"
          rel="stylesheet">                    <!-- Clockface -->

    <!--<link type="text/css" href="/includes/assets/plugins/card/lib/css/card.css" rel="stylesheet">-->                                    <!-- Card -->
    <link type="text/css" href="<?=GENERAL_DOMAIN?>/includes/assets/plugins/form-select2/select2.css"
          rel="stylesheet">                        <!-- Select2 -->
<?=$header?>

    <div id="wrapper">
    <div id="layout-static">
<?=$left_sidebar?>
    <div class="static-content-wrapper">
    <div class="static-content">
    <div class="page-content">
    <ol class="breadcrumb">

        <li><a href="/admin/">Главная</a></li>
        <li><a href="/admin/options/">Опции</a></li>
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
<?php include(X_PATH.'/application/views/admin/'.$type.'/menu.inc.php'); ?>

    <div data-widget-group="group1">

    <div class="panel panel-1" data-widget='{"draggable": "false"}'>
    <!--    <div class="panel-heading">-->
    <!--        <h2>Основные поля:</h2>-->
    <!--        <div class="panel-ctrls"-->
    <!--             data-actions-container=""-->
    <!--             data-action-collapse='{"target": ".panel-body"}'-->
    <!--        >-->
    <!--        </div>-->
    <!--    </div>-->
    <div class="panel-editbox" data-widget-controls=""></div>
    <div class="panel-body">

        <form enctype="multipart/form-data" action="<?= $_SERVER['REQUEST_URI'] ?>"
              method="post" class="form-horizontal row-border">
            <div class="container-fluid">

                <div class="tab-content">
                    <div class="tab-pane active" id="tab1">
                        <div class="row">

                            <div class="panel-editbox" data-widget-controls=""></div>
                            <div class="panel-body">
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">
                                        Название:
                                    </label>
                                    <div class="col-sm-8">
                                        <input id="inp_rus" class="form-control" type="text" name="rus"
                                               value="<?php if (isset($option['rus'])) echo $option['rus']; ?>">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-sm-2 control-label">
                                        Обозначение *:
                                    </label>
                                    <div class="col-sm-8">
                                        <input original="false" id="inp_name" class="form-control" type="text" name="name"
                                               value="<?php if (isset($option['name'])) echo $option['name']; ?>">
                                        <?php if(isset($err['name'])) echo '<div class="error">'.$err['name'].'</div>';?>
                                    </div>
                                    <div id="name_msg" class="" style="display: none"></div>
                                </div>

                                <div class="form-group">
                                    <label class="col-sm-2 control-label">
                                        Тип *:
                                    </label>
                                    <div class="col-sm-8">

                                        <SELECT required class="form-control" name="type" id="sel_type">
                                            <option value="">- Тип -</option>
                                            <?php
                                            if(isset($option['type']) && $option['type'] == 'textarea') $option['type'] = 'Строка';
                                            if(isset($option['type']) && $option['type'] == 'tinymce') $option['type'] = 'Текстовый редактор';
                                            if(isset($option['type']) && $option['type'] == 'input') $option['type'] = 'Текст';
                                            if(isset($option['type']) && $option['type'] == 'bool') $option['type'] = 'Логический';
                                            if (isset($fieldtypes) && is_array($fieldtypes)) {
                                                foreach ($fieldtypes as $fieldtype) {
                                                    echo '<option value="'.$fieldtype['name'].'"';
                                                    if(isset($option['type']) && $option['type'] == $fieldtype['name'])echo ' selected';
                                                    echo '>'.$fieldtype['rus'].'</option>';
                                                }
                                            }
                                            ?>
                                        </SELECT>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-sm-2 control-label">
                                        Модуль:
                                    </label>
                                    <div class="col-sm-8">
                                        <SELECT class="form-control" name="module">
                                            <option value="">- Модуль -</option>
                                            <?php
                                            if ($modules) {
                                                $count = count($modules);
                                                for ($i = 0; $i < $count; $i++) {
                                                    $m = $modules[$i];
                                                    echo '<option value="' . $m['name'] . '"';
                                                    if (isset($option['module']) && $option['module'] == $m['name']) echo ' selected';
                                                    elseif((!isset($option['module'])) && userdata('options_module_name') == $m['name']) echo ' selected';
                                                    echo '>' . $m['title'] . '</option>';
                                                }
                                            }
                                            ?>
                                        </SELECT>
                                    </div>
                                </div>

                                <div id="option_value">
                                    <?php
                                    if ($action == 'edit') {                                          // РЕДАКТИРОВАНИЕ
                                        ?>
                                        <div class="form-group">
                                            <label class="col-sm-2 control-label">
                                                Значение:
                                            </label>
                                            <div class="col-sm-8">
                                                <?php
                                                $fieldtype = $this->ft->getByName($option['type']);
                                                $inputType = 'text';
                                                $inputClass = '';
                                                $formElem = 'input';

                                                // Преобразуем старые типы в новые:
                                                if ($fieldtype['view'] == 'number' || $fieldtype['view'] == 'double-number') $inputType = 'number';
                                                elseif ($fieldtype['view'] == 'email') $inputType = 'email';
                                                elseif ($fieldtype['view'] == 'file') $inputType = 'file';
                                                elseif ($fieldtype['view'] == 'checkbox') $inputType = 'checkbox';
                                                elseif ($fieldtype['view'] == 'textarea') $formElem = 'textarea';
                                                elseif ($fieldtype['view'] == 'select') { $formElem = 'input'; $inputClass = 'tokenfield'; }
                                                elseif ($fieldtype['view'] == 'multiple-select') {
                                                    $formElem = 'select';
                                                    $inputType = 'multiple-select';
                                                } elseif ($fieldtype['view'] == 'editor') {
                                                    $formElem = 'textarea';
                                                    $inputType = 'editor';
                                                }

                                                //vd($fieldtype);
                                                if ($formElem == 'input') {
                                                    if($fieldtype['name'] == 'Логический'){
                                                        echo '<input ';
                                                        if($option['value'] == 1) echo ' checked="checked"';
                                                        echo 'class="option_chk bootstrap-switch" type="checkbox" data-size="small" data-on-text="ДА" data-off-text="НЕТ" data-on-color="success" data-off-color="default" name="value">';
                                                    } else {
                                                        if($inputType == 'file' && isset($option['value']) && $option['value'] != '')
                                                            echo '<img src="'.$option['value'].'" /><br />
                                                            <input type="hidden" name="old_value" value="'.$option['value'].'" />
                                                            <input type="checkbox" name="del_file" /> Удалить файл&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                            Путь к текущему файлу: <a href="'.$option['value'].'">'.$option['value'].'</a>';

                                                        ?>
                                                        <input id="inp_value" class="form-control <?= $inputClass ?>"
                                                               type="<?= $inputType ?>"
                                                               name="value"
                                                               value="<?php if (isset($option['value'])) echo $option['value']; ?>">
                                                        <?php
                                                    }
                                                } elseif ($formElem == 'textarea') {
                                                    echo '<textarea name="value" class="form-control';
                                                    if ($inputType == 'editor') echo ' ckeditor';
                                                    echo '">';
                                                    echo $option['value'];
                                                    echo '</textarea>';
                                                } elseif ($formElem == 'textarea') {
                                                    echo '<textarea name="value" class="form-control';
                                                    if ($inputType == 'editor') echo ' ckeditor';
                                                    echo '">';
                                                    echo $option['value'];
                                                    echo '</textarea>';
                                                }
                                                ?>

                                            </div>
                                            <div style="min-width: 100px"><?php if($action=='edit' && isset($option['adding']) && $option['adding'] != '') echo '<img src="/img/admin/info.png" title="'.strip_tags($option['adding']).'" />'; ?></div>
                                        </div>
                                        <?php
                                    }
                                    ?>
                                </div>

                                <div class="form-group">
                                    <label class="col-sm-2 control-label">
                                        Пометка:
                                    </label>
                                    <div class="col-sm-8">
                                        <textarea class="form-control" name="adding"><?php if(isset($option['adding'])) echo strip_tags($option['adding']); ?></textarea>
                                    </div>
                                </div>

                                <input type="hidden" name="action" value="<?= $action ?>"/>

                                <div class="form-group fixed-buttons">
                                    <input<?php if($action == 'add') echo ' disabled';?> class="form-submit save<?php if($action == 'add') echo ' disabled';?>" type="submit"
                                           name="<?= $action ?>"
                                           title="Сохранить" value=""/>&nbsp;
                                    <input<?php if($action == 'add') echo ' disabled';?> class="form-submit save_and_close<?php if($action == 'add') echo ' disabled';?>" type="submit"
                                           name="<?= $action ?>_and_close"
                                           title="Сохранить и закрыть"
                                           value=""/>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>

    </div>
    <script src="//ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
    <script>
        $(document).ready(function () {
            $('.tokenfield').tokenfield();
        });
    </script>

    <script>
        var formGetted = false;
        var nameOriginal = false;
        $(document).ready(function () {

//            $('.tokenfield').tokenfield();

            $("#sel_type").change(function () {

                var option_type = $('#sel_type').val();
                console.log('type changed to: ' + $('#sel_type').val());
                get_form_for_edit(option_type, option_type);

                if($("#inp_name").attr("original") == "true") {
                    $(".form-submit").removeAttr('disabled');
                    $(".form-submit").removeClass('disabled');
                }
                formGetted = true;
            });

//            $("#inp_name").keydown(function () {
//                try_option_name()
//            });
//            $("#inp_rus").keydown(function () {
//                try_option_name();
//            });
            $("#inp_name").keyup(function () {
                try_option_name()
            });
//            $("#inp_rus").keyup(function () {
//                try_option_name();
//            });
            $("#inp_name").change(function () {
                try_option_name()
            });
            $("#inp_rus").change(function () {
                try_option_name();
            });



        });

        function try_option_name() {
            var option_name = $('#inp_name').val();
            option_name = option_name.trim();
            if(option_name != '') {
                console.log('Проверяем на уникальность названия: ' + option_name);
                <?php
                if($action != 'edit') echo 'is_option_exists(option_name);';
                ?>
            } else $('#name_msg').hide(500);
        }

        function is_option_exists(name) {
            console.log('Достаём значение опции: ' + name);
            $.ajax({
                async: false,
                /* адрес файла-обработчика запроса */
                url: '/admin/ajax/option/get_option/',
                /* метод отправки данных */
                method: 'POST',
                /* данные, которые мы передаем в файл-обработчик */
                data: {
                    "name": name,
                    <?php if(isset($option['id'])) echo '"id": '.$option['id'].'';?>
                },

            }).done(function (data) {
                console.log("DATA: "+data);
                if(((!data) || data == 'false') && data != ''){
                    $('#name_msg').removeClass('error');
                    $('#name_msg').html('<img src="<?=GENERAL_DOMAIN?>/img/admin/ok.png" />');
                    $('#name_msg').show(500);
                    $('.error').hide();
                    if(formGetted == true) {
                        $(".form-submit").removeAttr('disabled');
                        $(".form-submit").removeClass('disabled');
                    }
                    $("#inp_name").attr('original','true');
                    //console.log('set true');
                    nameOriginal = true;
                } else {
                    $('#name_msg').addClass('error');
                    $('#name_msg').html('<img src="<?=GENERAL_DOMAIN?>/img/admin/warning-red.png" title="Такое обозначение уже есть!" />');
                    $('#name_msg').show(500);
                    $(".form-submit").attr('disabled','disabled');
                    $(".form-submit").addClass('disabled');
                    //console.log(data);
                    nameOriginal = false;
                    $("#inp_name").attr('original','false');
                    //console.log('set false');
                }
            });

        }
    </script>

<?php if ($action == 'add') { ?>
    <script type="text/javascript" src="<?=GENERAL_DOMAIN?>/includes/assets/plugins/liTranslit/js/jquery.liTranslit.js"></script>
    <script>
        $(document).ready(function () {
            $('#inp_rus').liTranslit({
                elAlias: $('#inp_name'),
                reg: '" "="-"',
            });
        });
    </script>
<?php } ?>

<?php
$adding_scripts = '
<!-- Translit Url --> 


<script type="text/javascript" src="'.GENERAL_DOMAIN.'/includes/assets/plugins/form-multiselect/js/jquery.multi-select.min.js"></script>  			<!-- Multiselect Plugin -->
<script type="text/javascript" src="'.GENERAL_DOMAIN.'/includes/assets/plugins/quicksearch/jquery.quicksearch.min.js"></script>           			<!-- Quicksearch to go with Multisearch Plugin -->
<script type="text/javascript" src="'.GENERAL_DOMAIN.'/includes/assets/plugins/form-typeahead/typeahead.bundle.min.js"></script>                 	<!-- Typeahead for Autocomplete -->
<script type="text/javascript" src="'.GENERAL_DOMAIN.'/includes/assets/plugins/form-select2/select2.min.js"></script>                     			<!-- Advanced Select Boxes -->
<script type="text/javascript" src="'.GENERAL_DOMAIN.'/includes/assets/plugins/form-autosize/jquery.autosize-min.js"></script>            			<!-- Autogrow Text Area -->
<script type="text/javascript" src="'.GENERAL_DOMAIN.'/includes/assets/plugins/form-colorpicker/js/bootstrap-colorpicker.min.js"></script> 			<!-- Color Picker -->

<script type="text/javascript" src="'.GENERAL_DOMAIN.'/includes/assets/plugins/bootstrap-touchspin/dist/jquery.bootstrap-touchspin.js"></script> <!-- Touchspin -->

<script type="text/javascript" src="'.GENERAL_DOMAIN.'/includes/assets/plugins/form-fseditor/jquery.fseditor-min.js"></script>            			<!-- Fullscreen Editor -->
<script type="text/javascript" src="'.GENERAL_DOMAIN.'/includes/assets/plugins/form-jasnyupload/fileinput.min.js"></script>               			<!-- File Input -->
<script type="text/javascript" src="'.GENERAL_DOMAIN.'/includes/assets/plugins/form-tokenfield/bootstrap-tokenfield.min.js"></script>     			<!-- Tokenfield -->
<script type="text/javascript" src="'.GENERAL_DOMAIN.'/includes/assets/plugins/switchery/switchery.js"></script>     								<!-- Switchery -->

<script type="text/javascript" src="'.GENERAL_DOMAIN.'/includes/assets/plugins/card/lib/js/card.js"></script> 										<!-- Card -->

<!-- <script type="text/javascript" src="'.GENERAL_DOMAIN.'/includes/assets/plugins/iCheck/icheck.min.js"></script>  -->    							<!-- iCheck // already included on site-level -->
<script type="text/javascript" src="'.GENERAL_DOMAIN.'/includes/assets/plugins/bootstrap-switch/bootstrap-switch.js"></script>     					<!-- BS Switch -->

<script type="text/javascript" src="'.GENERAL_DOMAIN.'/includes/assets/plugins/jquery-chained/jquery.chained.min.js"></script> 						<!-- Chained Select Boxes -->

<script type="text/javascript" src="'.GENERAL_DOMAIN.'/includes/assets/plugins/jquery-mousewheel/jquery.mousewheel.min.js"></script> <!-- MouseWheel Support -->

<script type="text/javascript" src="'.GENERAL_DOMAIN.'/includes/assets/demo/demo-formcomponents.js"></script>

<script type="text/javascript" src="'.GENERAL_DOMAIN.'/includes/assets/plugins/wijets/wijets.js"></script>     							<!-- Wijet -->
<script type="text/javascript" src="'.GENERAL_DOMAIN.'/includes/assets/plugins/clockface/js/clockface.js"></script>     								<!-- Clockface -->

<script type="text/javascript" src="'.GENERAL_DOMAIN.'/includes/assets/plugins/form-colorpicker/js/bootstrap-colorpicker.min.js"></script> 			<!-- Color Picker -->

<script type="text/javascript" src="'.GENERAL_DOMAIN.'/includes/assets/plugins/bootstrap-datepicker/bootstrap-datepicker.js"></script>      			<!-- Datepicker -->
<script type="text/javascript" src="'.GENERAL_DOMAIN.'/includes/assets/plugins/bootstrap-timepicker/bootstrap-timepicker.js"></script>      			<!-- Timepicker -->
<script type="text/javascript" src="'.GENERAL_DOMAIN.'/includes/assets/plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.js"></script> 	<!-- DateTime Picker -->
<script type="text/javascript" src="'.GENERAL_DOMAIN.'/includes/assets/plugins/form-daterangepicker/moment.min.js"></script>              			<!-- Moment.js for Date Range Picker -->
<script type="text/javascript" src="'.GENERAL_DOMAIN.'/includes/assets/plugins/form-daterangepicker/daterangepicker.js"></script>     				<!-- Date Range Picker -->
<script type="text/javascript" src="'.GENERAL_DOMAIN.'/includes/assets/plugins/jcrop/js/jquery.Jcrop.min.js"></script>  	<!-- Image cropping Plugin -->

<script type="text/javascript" src="'.GENERAL_DOMAIN.'/includes/assets/plugins/dropzone/dropzone.min.js"></script>   	<!-- Dropzone Plugin -->
<link type="text/css" href="'.GENERAL_DOMAIN.'/includes/assets/plugins/dropzone/css/dropzone.css" rel="stylesheet"> <!-- Dropzone Plugin -->

<script>
	//Fix since CKEditor can\'t seem to find it\'s own relative basepath
	CKEDITOR_BASEPATH  =  "'.GENERAL_DOMAIN.'/includes/assets/plugins/form-ckeditor/";
</script>
<script type="text/javascript" src="'.GENERAL_DOMAIN.'/includes/assets/plugins/form-ckeditor/ckeditor.js"></script>  	<!-- CKEditor -->
';

if(isset($footer)) {
    $footer = str_replace('[adding_scripts]', $adding_scripts, $footer);
    echo $footer;
}
?>
