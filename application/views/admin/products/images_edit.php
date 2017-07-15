<?php
$myType = userdata('type');
$languages = $this->model_languages->getLanguages();
$defaultLanguage = $this->model_languages->getDefaultLanguage();
$languagesCount = $this->model_languages->languagesCount(1);
?>
<?php if(isset($head)) echo $head; ?>

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
<?php if(isset($header)) echo $header; ?>

<div id="wrapper">
    <div id="layout-static">
        <?php if(isset($left_sidebar)) echo $left_sidebar; ?>
        <div class="static-content-wrapper">
            <div class="static-content">
                <div class="page-content">
                    <ol class="breadcrumb">

                        <li><a href="/admin/">Главная</a></li>
                        <li><a href="/admin/articles/">Статьи</a></li>
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
                            <div class="panel-heading">
                                <h2>Поля статьи:</h2>
                                <div class="panel-ctrls"
                                     data-actions-container=""
                                     data-action-collapse='{"target": ".panel-body"}'
                                >
                                </div>
                            </div>
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

                                <?php
                                if(!isset($_GET['images'])) {
                                    ?>

                                    <form enctype="multipart/form-data" action="<?= $_SERVER['REQUEST_URI'] ?>"
                                          method="post" class="form-horizontal row-border" id="validate-form"
                                          data-parsley-validate>

                                        <input type="hidden" name="action" value="<?= $action ?>">
                                        <div class="container-fluid">

                                            <div class="tab-content">
                                                <div class="tab-pane active" id="tab1">
                                                    <div class="row">
                                                        <?php if ($languagesCount > 1) { // Если больше 1-го языка, выводим заголовок таба ?>
                                                            <div class="panel-heading">
                                                                <h2>Основные поля:</h2>
                                                            </div>
                                                        <?php } ?>
                                                        <div class="panel-editbox" data-widget-controls=""></div>
                                                        <div class="panel-body">
                                                            <?php
                                                            $date = date("Y-m-d");
                                                            $time = date("H:i");

                                                            $typeOfContent = 'article';
                                                            //vd($article);
                                                            $settings = $multiLang;
                                                            $language = $defaultLanguage;
                                                            $otherLanguage = false;

                                                            include(X_PATH . '/application/views/admin/common/partical.inc.php');

                                                            //  if ($languagesCount > 1) {
                                                            $settings = $noLang;
                                                            $otherLanguage = false;
                                                            include(X_PATH . '/application/views/admin/common/partical.inc.php');
                                                            //}

                                                            ?>
                                                            <div class="form-group fixed-buttons">
                                                                <input class="btn form-submit save" type="submit"
                                                                       name="<?= $action ?>"
                                                                       title="Сохранить" value=""/>&nbsp;
                                                                <input class="btn form-submit save_and_close"
                                                                       type="submit"
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
                                                    foreach ($languages as $language) {
                                                        if ($language['code'] != $defaultLanguage) {
                                                            $otherLanguage = true;
                                                            //else $otherLanguage = false;
                                                            ?>
                                                            <div class="tab-pane" id="tab-<?= $language['code'] ?>">

                                                                <div class="row">
                                                                    <div class="panel-heading">
                                                                        <h2>Мультиязычные поля (<?= $language['name'] ?>
                                                                            ):</h2>
                                                                    </div>
                                                                    <div class="panel-editbox"
                                                                         data-widget-controls=""></div>
                                                                    <div class="panel-body">
                                                                        <?php
                                                                        $date = date("Y-m-d");
                                                                        $time = date("H:i");
                                                                        $settings = $multiLang;
                                                                        $otherLanguage = true;
                                                                        include(X_PATH . '/application/views/admin/modules/partical.inc.php');
                                                                        ?>
                                                                        <div class="form-group fixed-buttons">
                                                                            <input class="form-submit save btn"
                                                                                   type="submit"
                                                                                   name="<?= $action ?>"
                                                                                   title="Сохранить" value=""/>&nbsp;
                                                                            <input class="form-submit save_and_close btn"
                                                                                   type="submit"
                                                                                   name="<?= $action ?>_and_close"
                                                                                   title="Сохранить и закрыть"
                                                                                   value=""/>
                                                                        </div>
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
                                    <?php
                                } else {
                                    if (isset($article)) include X_PATH."/application/views/admin/products/adding-images.inc.php";
                                }
                                ?>
                            </div>
                        </div>


                        <?php //if (isset($article)) include X_PATH."/application/views/admin/products/adding-images.inc.php"; ?>


                        <?php if ($action == 'add_article') { ?>
                            <script type="text/javascript"
                                    src="<?=GENERAL_DOMAIN?>/includes/assets/plugins/liTranslit/js/jquery.liTranslit.js"></script>
                            <script>
                                $(document).ready(function () {
                                    $('#inp_name').liTranslit({
                                        elAlias: $('#inp_url'),
                                        reg: '" "="-","«"="","»"=""',
                                    });
                                });
                            </script>
                        <?php } ?>

                        <?php
                        $adding_scripts = '
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

<!-- <script type="text/javascript" src="/includes/assets/plugins/iCheck/icheck.min.js"></script>  -->    							<!-- iCheck // already included on site-level -->
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

                        if(isset($imagesScripts)) {
                            $adding_scripts .= $imagesScripts;
                        }
                        if(isset($footer)) {
                            $footer = str_replace('[adding_scripts]', $adding_scripts, $footer);
                            echo $footer;
                        }
                        ?>

