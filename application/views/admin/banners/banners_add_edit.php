<?php
$myType = userdata('type');
$languages = $this->model_languages->getLanguages();
$defaultLanguage = $this->model_languages->getDefaultLanguage();
$languagesCount = $this->model_languages->languagesCount(1);
?>
<?php if(isset($head)) echo $head; ?>
<link type="text/css" href="/includes/assets/plugins/form-select2/select2.css"
      rel="stylesheet">                        <!-- Select2 -->
<link type="text/css" href="/includes/assets/plugins/form-multiselect/css/multi-select.css"
      rel="stylesheet">           <!-- Multiselect -->
<link type="text/css" href="/includes/assets/plugins/form-fseditor/fseditor.css"
      rel="stylesheet">                      <!-- FullScreen Editor -->
<link type="text/css" href="/includes/assets/plugins/form-tokenfield/bootstrap-tokenfield.css"
      rel="stylesheet">        <!-- Tokenfield -->
<link type="text/css" href="/includes/assets/plugins/switchery/switchery.css"
      rel="stylesheet">                            <!-- Switchery -->

<link type="text/css" href="/includes/assets/plugins/bootstrap-touchspin/dist/jquery.bootstrap-touchspin.min.css"
      rel="stylesheet"> <!-- Touchspin -->

<link type="text/css" href="/includes/assets/js/jqueryui.css"
      rel="stylesheet">                                            <!-- jQuery UI CSS -->

<link type="text/css" href="/includes/assets/plugins/iCheck/skins/minimal/_all.css"
      rel="stylesheet">                   <!-- Custom Checkboxes / iCheck -->
<link type="text/css" href="/includes/assets/plugins/iCheck/skins/flat/_all.css" rel="stylesheet">
<link type="text/css" href="/includes/assets/plugins/iCheck/skins/square/_all.css" rel="stylesheet">

<link type="text/css" href="/includes/assets/plugins/form-daterangepicker/daterangepicker-bs3.css"
      rel="stylesheet">    <!-- DateRangePicker -->
<link type="text/css" href="/includes/assets/plugins/iCheck/skins/minimal/blue.css"
      rel="stylesheet">                   <!-- Custom Checkboxes / iCheck -->
<link type="text/css" href="/includes/assets/plugins/clockface/css/clockface.css"
      rel="stylesheet">                    <!-- Clockface -->

<!--<link type="text/css" href="/includes/assets/plugins/card/lib/css/card.css" rel="stylesheet">-->                                    <!-- Card -->
<link type="text/css" href="assets/plugins/form-select2/select2.css"
      rel="stylesheet">                        <!-- Select2 -->
<?php if(isset($header)) echo $header; ?>

<div id="wrapper">
    <div id="layout-static">
        <?php if(isset($left_sidebar)) echo $left_sidebar; ?>
        <div class="static-content-wrapper">
            <div class="static-content">
                <div class="page-content">
                    <ol class="breadcrumb">

                        <li><a href="/admin/">Главная</a></li>
                        <li><a href="/admin/menus/">Меню</a></li>
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
<!--                            <div class="panel-heading">-->
<!--                                <h2>Настройки баннера/слайда:</h2>-->
<!--                                <div class="panel-ctrls"-->
<!--                                     data-actions-container=""-->
<!--                                     data-action-collapse='{"target": ".panel-body"}'-->
<!--                                >-->
<!--                                </div>-->
<!--                            </div>-->
                            <div class="panel-editbox" data-widget-controls=""></div>
                            <div class="panel-body">

                                <form enctype="multipart/form-data" action="<?= $_SERVER['REQUEST_URI'] ?>"
                                      method="post" class="form-horizontal row-border">
                                    <input type="hidden" name="action" value="<?=$action?>" />
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
                                                                <input id="inp_name" class="form-control" type="text" name="name"
                                                                       value="<?php if (isset($banner)) echo $banner['name']; ?>">
                                                            </div>
                                                        </div>

                                                        <div class="form-group">
                                                            <label class="col-sm-2 control-label">
                                                                URL:
                                                            </label>
                                                            <div class="col-sm-8">
                                                                <input id="inp_url" class="form-control" type="text" name="url"
                                                                       value="<?php if (isset($banner['url'])) echo $banner['url']; elseif(isset($url)) echo $url; ?>">
                                                            </div>
                                                        </div>

                                                        <div class="form-group">
                                                            <label class="col-sm-2 control-label">
                                                                Последовательность:
                                                            </label>
                                                            <div class="col-sm-8">
                                                                <input id="inp_num" class="form-control" type="text" name="num"
                                                                       value="<?php if (isset($banner['num'])) echo $banner['num']; elseif(isset($num)) echo $num; ?>">
                                                            </div>
                                                        </div>


                                                        <div class="form-group">
                                                            <label class="col-sm-2 control-label">
                                                                Файл:
                                                            </label>
                                                            <div class="col-sm-8">
                                                                <?php
                                                                if(isset($banner['image']) && $banner['image'] != '') {
                                                                    echo '<img src="' . $banner['image'] . '" style="max-width:600px" /><br /><input type="checkbox" name="image_del">Удалить<br />';
                                                                    echo '<input type="text" class="form-control" name="image" value="http://'.$_SERVER['SERVER_NAME'].$banner['image'].'" />';
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
                                                                if(isset($banner['image']) && $banner['image'] != '') echo 'другой ';
                                                                echo 'файл</span>
                                                                                    <span class="fileinput-exists">Изменить</span>
                                                                                    <input type="file" name="userfile">
                                                                                </span>
                                                                                
                                                                            </span>
                                                                        </div>
                                                                    </div>
                                                                ';
                                                                ?>

                                                            </div>
                                                        </div>

                                                        <div class="form-group">
                                                            <label class="col-sm-2 control-label">
                                                                Тип *:
                                                            </label>
                                                            <div class="col-sm-8">

                                                                <SELECT required class="form-control" name="position" id="sel_position">
                                                                    <option value="">- Позиция -</option>
                                                                    <?php
                                                                    foreach ($banner_positions as $position){
                                                                        echo '<option value="'.$position['name'].'"';
                                                                        if(isset($banner['position']) && $banner['position'] == $position['name'])echo ' selected';
                                                                        echo '>'.$position['value'].'</option>';
                                                                    }
                                                                    ?>
                                                                </SELECT>
                                                            </div>
                                                        </div>

                                                        <!--div class="form-group">
                                                            <label for="active" class="col-sm-2 control-label">
                                                                Цвет:
                                                            </label>
                                                            <div class="col-sm-1">
                                                                <?php
                                                                $color = "";
                                                                if(isset($banner['format']) && $banner['format'] != NULL) $color = $banner['format'];
                                                                $name = 'format';
                                                                echo '
                                                                <div class="input-group cpicker color" data-color="' . $color . '" data-color-format="hex">
                                                                    <input name="' . $name . '" type="text" readonly class="form-control form-color" value="' . $color . '">
                                                                    <span class="input-group-addon"><i style="background-color: ' . $color . '; margin-left: 8px;"></i></span>
                                                                </div>
                                                                <script>
                                                                $(document).ready(function () {
                                                                //Color Picker
                                                                        $(\'.cpicker\').colorpicker();
                                                                        
                                                                        $("#inp_' . $name . '").change(function(){
                                                                            $("#smpl_' . $name . '").css("background-color",$("#inp_' . $name . '").val());
                                                                        });
                                                                });
                                                                </script>';
                                                                ?>
                                                            </div>
                                                        </div-->

                                                        <div class="form-group">
                                                            <label for="active" class="col-sm-2 control-label">
                                                                Активный:
                                                            </label>
                                                            <div class="col-sm-1">
                                                                <input  class="bootstrap-switch switch-alt" data-on-color="success" data-off-color="default" data-on-text="ДА" data-off-text="НЕТ" type = "checkbox" id = "active" name = "active" <?php if(isset($banner['active']) && $banner['active'] == 0) echo ''; else echo ' checked'; ?> />


                                                        <!--                                                        КНОПКИ СОХРАНИТЬ И СОХРАНИТЬ И ЗАКРЫТЬ-->
                                                        <input type="hidden" name="action" value="<?=$action?>" />
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
                                        </div>
                                    </div>


                                </form>
                            </div>
                        </div>



                        <?php
                        $adding_scripts = '
<script type="text/javascript" src="/includes/assets/plugins/form-multiselect/js/jquery.multi-select.min.js"></script>  			<!-- Multiselect Plugin -->
<script type="text/javascript" src="/includes/assets/plugins/quicksearch/jquery.quicksearch.min.js"></script>           			<!-- Quicksearch to go with Multisearch Plugin -->
<script type="text/javascript" src="/includes/assets/plugins/form-typeahead/typeahead.bundle.min.js"></script>                 	<!-- Typeahead for Autocomplete -->
<script type="text/javascript" src="/includes/assets/plugins/form-select2/select2.min.js"></script>                     			<!-- Advanced Select Boxes -->
<script type="text/javascript" src="/includes/assets/plugins/form-autosize/jquery.autosize-min.js"></script>            			<!-- Autogrow Text Area -->
<script type="text/javascript" src="/includes/assets/plugins/form-colorpicker/js/bootstrap-colorpicker.min.js"></script> 			<!-- Color Picker -->

<script type="text/javascript" src="/includes/assets/plugins/bootstrap-touchspin/dist/jquery.bootstrap-touchspin.js"></script> <!-- Touchspin -->

<script type="text/javascript" src="/includes/assets/plugins/form-fseditor/jquery.fseditor-min.js"></script>            			<!-- Fullscreen Editor -->
<script type="text/javascript" src="/includes/assets/plugins/form-jasnyupload/fileinput.min.js"></script>               			<!-- File Input -->
<script type="text/javascript" src="/includes/assets/plugins/form-tokenfield/bootstrap-tokenfield.min.js"></script>     			<!-- Tokenfield -->
<script type="text/javascript" src="/includes/assets/plugins/switchery/switchery.js"></script>     								<!-- Switchery -->

<script type="text/javascript" src="/includes/assets/plugins/card/lib/js/card.js"></script> 										<!-- Card -->

<!-- <script type="text/javascript" src="/includes/assets/plugins/iCheck/icheck.min.js"></script>  -->    							<!-- iCheck // already included on site-level -->
<script type="text/javascript" src="/includes/assets/plugins/bootstrap-switch/bootstrap-switch.js"></script>     					<!-- BS Switch -->

<script type="text/javascript" src="/includes/assets/plugins/jquery-chained/jquery.chained.min.js"></script> 						<!-- Chained Select Boxes -->

<script type="text/javascript" src="/includes/assets/plugins/jquery-mousewheel/jquery.mousewheel.min.js"></script> <!-- MouseWheel Support -->

<script type="text/javascript" src="/includes/assets/demo/demo-formcomponents.js"></script>

<script type="text/javascript" src="/includes/assets/plugins/wijets/wijets.js"></script>     							<!-- Wijet -->
<script type="text/javascript" src="/includes/assets/plugins/clockface/js/clockface.js"></script>     								<!-- Clockface -->

<script type="text/javascript" src="/includes/assets/plugins/form-colorpicker/js/bootstrap-colorpicker.min.js"></script> 			<!-- Color Picker -->

<script type="text/javascript" src="/includes/assets/plugins/bootstrap-datepicker/bootstrap-datepicker.js"></script>      			<!-- Datepicker -->
<script type="text/javascript" src="/includes/assets/plugins/bootstrap-timepicker/bootstrap-timepicker.js"></script>      			<!-- Timepicker -->
<script type="text/javascript" src="/includes/assets/plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.js"></script> 	<!-- DateTime Picker -->
<script type="text/javascript" src="/includes/assets/plugins/form-daterangepicker/moment.min.js"></script>              			<!-- Moment.js for Date Range Picker -->
<script type="text/javascript" src="/includes/assets/plugins/form-daterangepicker/daterangepicker.js"></script>     				<!-- Date Range Picker -->
<script type="text/javascript" src="/includes/assets/plugins/jcrop/js/jquery.Jcrop.min.js"></script>  	<!-- Image cropping Plugin -->

<script type="text/javascript" src="/includes/assets/plugins/dropzone/dropzone.min.js"></script>   	<!-- Dropzone Plugin -->
<link type="text/css" href="/includes/assets/plugins/dropzone/css/dropzone.css" rel="stylesheet"> <!-- Dropzone Plugin -->

<script>
	//Fix since CKEditor can\'t seem to find it\'s own relative basepath
	CKEDITOR_BASEPATH  =  "/includes/assets/plugins/form-ckeditor/";
</script>
<script type="text/javascript" src="/includes/assets/plugins/form-ckeditor/ckeditor.js"></script>  	<!-- CKEditor -->

';
if(isset($footer)) {
    $footer = str_replace('[adding_scripts]', $adding_scripts, $footer);
    echo $footer;
}
                        ?>
