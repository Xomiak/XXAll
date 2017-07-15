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

    <!--<link type="text/css" href="<?=GENERAL_DOMAIN?>/includes/assets/plugins/card/lib/css/card.css" rel="stylesheet">-->                                    <!-- Card -->
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
        <li><a href="/admin/pages/">Страницы</a></li>
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

        <?php if ($languagesCount > 1) { // Если больше 1-го языка, выводим табы ?>
            <div class="page-tabs">
                <ul class="nav nav-tabs">
                    <li class="active"><a data-toggle="tab" href="#tab1">Основные поля</a></li>
                    <?php
                    foreach ($languages as $language) {
                        if ($language != $defaultLanguage)
                            echo '<li><a data-toggle="tab" href="#tab-' . $language['code'] . '">' . $language['name'] . '</a></li>';
                    }
                    ?>
                </ul>
            </div>
        <?php } ?>

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
                                        URL:
                                    </label>
                                    <div class="col-sm-8">
                                        <input id="inp_url" class="form-control" type="text" name="url"
                                               value="<?php if (isset($page['url'])) echo $page['url']; ?>">
                                    </div>
                                </div>

                                <?php
                                $date = date("Y-m-d");
                                $time = date("H:i");
                                //                                            if ($languagesCount > 1)
                                //                                                $settings = $noLang;
                                //                                            $otherLanguage = false;
                                $language = $defaultLanguage;
                                $langAdding = '_' . $defaultLanguage['code'];

                                include(X_PATH.'/application/views/admin/pages/multilanguage.inc.php');
                                ?>


                                <div class="form-group">
                                    <label class="col-sm-2 control-label">
                                        Позиция:
                                    </label>
                                    <div class="col-sm-8">
                                        <input id="inp_num" class="form-control" type="number" name="num"
                                               style="width: 140px"
                                               value="<?php if (isset($page['num'])) echo $page['num']; else echo $num; ?>">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-sm-2 control-label">
                                        Шаблон страницы:
                                    </label>
                                    <div class="col-sm-8">
                                        <?php
                                        $this->load->helper('file');
                                        $files = get_filenames(X_PATH.'/application/views/'.SITE.'/templates/pages/');
                                        var_dump($files);  
                                        ?>
                                        <SELECT id="sel_templates" name="template" required class="form-control">
                                            <option value="">- нет -</option>
                                            <?php
                                            //if(isset($page)){

                                            $count = count($files);
                                            sort($files);
                                            for ($i = 0; $i < $count; $i++) {
                                                echo '<option value="' . $files[$i] . '"';
                                                if (isset($page['template']) && $page['template'] == $files[$i])
                                                    echo ' selected';
                                                echo '>' . $files[$i] . '</option>';
                                            }
                                            //}
                                            ?>
                                        </SELECT>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-sm-2 control-label">
                                        Фото:
                                    </label>
                                    <div class="col-sm-8">
                                        <?php
                                        if (isset($page['image']) && $page['image'] != '') {
                                            echo '<img src="' . $page['image'] . '" style="max-width:600px;max-height:300px" /><br /><input type="checkbox" name="image_del">Удалить<br />';
                                            echo '<input type="text" class="form-control" name="image" value="//' . $_SERVER['SERVER_NAME'] . $page['image'] . '" />';
                                        }
                                        echo '
                                                                <div class="fileinput fileinput-new" data-provides="fileinput">
                                                                        <div class="input-group">
                                                                            <div class="form-control uneditable-input" data-trigger="fileinput">
                                                                                <i class="fa fa-file fileinput-exists"></i>&nbsp;<span class="fileinput-filename"></span>
                                                                            </div>
                                                                            <span class="input-group-btn">
                                                                                <a id="inp_del_image" href="#" class="btn btn-default fileinput-exists" data-dismiss="fileinput">Убрать</a>
                                                                                <span class="btn btn-default btn-file">
                                                                                    <span class="fileinput-new">Выбрать ';
                                        if (isset($page['image']) && $page['image'] != '') echo 'другой ';
                                        echo 'файл</span>
                                                                                    <span class="fileinput-exists">Изменить</span>
                                                                                    <input id="inp_image" type="file" name="image">
                                                                                </span>
                                                                                
                                                                            </span>
                                                                        </div>
                                                                    </div>
                                                                ';
                                        ?>
                                        <img id="image_preview" src="#" alt="" class="preview-image-upload" style="display: none" />
                                        <script>
                                            function readURL(input) {

                                                if (input.files && input.files[0]) {
                                                    var reader = new FileReader();

                                                    reader.onload = function (e) {
                                                        $('#image_preview').attr('src', e.target.result);
                                                    };

                                                    reader.readAsDataURL(input.files[0]);
                                                    $('#image_preview').show(700);
                                                }
                                            }

                                            $("#inp_del_image").click(function(){
                                                $('#image_preview').hide(700);
                                            });

                                            $("#inp_image").change(function(){
                                                readURL(this);
                                            });
                                        </script>
                                    </div>
                                </div>


                                <div class="form-group">
                                    <label class="col-sm-2 control-label">
                                        Активный:
                                    </label>
                                    <div class="col-sm-8">
                                        <input type="checkbox" id="inp_active" name="active"
                                            <?php
                                            if ((isset($page['active']) && $page['active'] == 1) || !isset($page)) echo ' checked ';
                                            ?>
                                               class="bootstrap-switch switch-alt" data-on-color="success"
                                               data-off-color="default" data-on-text="ДА" data-off-text="НЕТ"/>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-sm-2 control-label">
                                        Кнопки соц.сетей:
                                    </label>
                                    <div class="col-sm-8">
                                        <input type="checkbox" id="inp_social_buttons" name="social_buttons"
                                            <?php
                                            if ((isset($page['social_buttons']) && $page['social_buttons'] == 1) || !isset($page)) echo ' checked ';
                                            ?>
                                               class="bootstrap-switch switch-alt" data-on-color="success"
                                               data-off-color="default" data-on-text="ДА" data-off-text="НЕТ"/>
                                    </div>
                                </div>

                                <input type="hidden" name="action" value="<?= $action ?>"/>

                                <div class="form-group fixed-buttons">
                                    <input class="form-submit save" type="submit"
                                           name="<?= $action ?>"
                                           title="Сохранить" value=""/>&nbsp;
                                    <input class="form-submit save_and_close" type="submit"
                                           name="<?= $action ?>_and_close"
                                           title="Сохранить и закрыть"
                                           value=""/>
                                </div>
                            </div>
                        </div>

                    </div>
                    <?php
                    if ($languagesCount > 1) {      // Если больше 1-го языка, выводим мультиязычные поля в табах
                        $otherLanguage = false;
                        $ii = 0;
                        foreach ($languages as $language) {
                            if ($language != $defaultLanguage) {
                                $code = $language['code'];
                                $langAdding = "_" . $code;
                                ?>
                                <div class="tab-pane" id="tab-<?= $language['code'] ?>">

                                    <div class="row">

                                        <div class="panel-editbox" data-widget-controls=""></div>
                                        <div class="panel-body">
                                            <?php
                                            include(X_PATH.'/application/views/admin/pages/multilanguage.inc.php');
                                            ?>
                                        </div>
                                    </div> <!-- .container-fluid -->
                                </div>
                                <?php
                            }
                        }
                    }
                    ?>
                </div>
            </div>
        </form>

    </div>

<?php if ($action == 'add') { ?>
    <script type="text/javascript" src="<?=GENERAL_DOMAIN?>/includes/assets/plugins/liTranslit/js/jquery.liTranslit.js"></script>
    <script>
        $(document).ready(function () {
            $('#inp_name_<?=$defaultLanguage['code']?>').liTranslit({
                elAlias: $('#inp_url'),
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
<script type="text/javascript" src="'.GENERAL_DOMAIN.'/includes/assets/plugins/form-ckeditor/ckfinder/ckfinder.js"></script>  <!-- CKFinder Media Browser -->
<script type="text/javascript" src="'.GENERAL_DOMAIN.'/includes/assets/plugins/form-parsley/parsley.js"></script>  					<!-- Validate Plugin / Parsley -->
';
if(isset($footer)) {
    $footer = str_replace('[adding_scripts]', $adding_scripts, $footer);
    echo $footer;
}
?>