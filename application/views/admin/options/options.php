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

                        <li><a href="/">Главная</a></li>
                        <li class="active"><a href="<?= $_SERVER['REQUEST_URI'] ?>"><?= $title ?></a></li>

                    </ol>
                    <div class="page-heading">
                        <h1><?= $title ?></h1>
<!--                        <div class="options">-->
<!--                            <div class="btn-toolbar">-->
<!--                                <a href="#" class="btn btn-default"><i class="fa fa-fw fa-wrench"></i></a>-->
<!--                            </div>-->
<!--                        </div>-->
                    </div>
                    <?php include(X_PATH.'/application/views/admin/' . $type . '/menu.inc.php'); ?>
                    <div class="container-fluid">

                        <div class="row">
                            <div class="col-md-12">

                                <div class="panel">
                                    <div class="panel-body panel-no-padding">
                                        
                                <table class="table table-striped table-bordered">
                                    <thead>
                                    <tr bgcolor="#EEEEEE">
                                        <th valign="top">Модуль</th>
                                        <th valign="top">Описание</th>
                                        <th valign="top">Название</th>
                                        <th valign="top">Значение</th>
                                        <th valign="top">Действия</th>
                                    </tr>
                                    <tr>
                                        <th colspan="5">
                                            <form id="form_options_module" action="/admin/options/set_module/"
                                                  method="post">
                                                <select id="sel_option_module" class="form-control" name="module">
                                                    <option value="all">- Все -</option>
                                                    <?php
                                                    $modules = getModules(1);
                                                    foreach ($modules as $module) {
                                                        echo '<option value="' . $module['name'] . '"';
                                                        if (userdata("options_module_name") == $module['name']) echo ' selected';
                                                        echo '>' . $module['title'] . '</option>';
                                                    }
                                                    ?>
                                                </select>
                                            </form>
                                        </th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    //vd($options);
                                    $count = count($options);
                                    for ($i = 0; $i < $count; $i++) {
                                        $option = $options[$i];
                                        //if (in_array($option['module'], $activeModules)) {
                                            ?>
                                            <tr id="tr-<?= $option['id'] ?>" class="list">
                                                <td><?= $this->model_options->getModuleTitle($option['module']) ?></td>
                                                <td>
                                                    <a href="/admin/options/edit/<?= $option['id'] ?>/"
                                                       title="Перейти к редактированию"><?= $option['rus'] ?></a>
                                                </td>
                                                <td><?= $option['name'] ?></td>
                                                <td>
                                                    <?php
                                                    $inpType = false;
                                                    if ($option['type'] == 'bool' || $option['type'] == 'Логический') $inpType = 'checkbox';
                                                    elseif ($option['type'] == 'input'
                                                        || $option['type'] == 'Строка'
                                                    ) $inpType = 'input';
                                                    elseif ($option['type'] == 'E-mail') $inpType = 'email';
                                                    elseif ($option['type'] == 'Дробное число' || $option['type'] == 'Целое число') $inpType = 'number';
                                                    elseif ($option['type'] == 'Текст') $inpType = 'textarea';

                                                    if ($inpType == 'checkbox') {
                                                        echo '<input class="bootstrap-switch option_chk" id="inp_' . $option['name'] . '" type="checkbox" name="' . $option['name'] . '" option_rus="' . $option['rus'] . '" ';
                                                        if ($option['value'] == 1) echo ' checked="checked"';
                                                        //else echo ' checked="false"';
                                                        echo ' data-off-color="default"  data-on-text="ДА" data-off-text="НЕТ" data-size="small"  data-on-color="success" option_id="' . $option['id'] . '" option_rus="' . $option['rus'] . '" option_type="' . $option['type'] . '" option_name="' . $option['name'] . '" value="' . $option['value'] . '" />';
                                                    } elseif ($inpType == 'input' || $inpType == 'email' || $inpType == 'number') {
                                                        echo '<input id="inp_' . $option['name'] . '" type="' . $inpType . '" name="' . $option['name'] . '" value="' . $option['value'] . '" option_rus="' . $option['rus'] . '" class="option form-control" option_id="' . $option['id'] . '" option_type="' . $option['type'] . '" option_name="' . $option['name'] . '" />';
                                                    } elseif ($inpType == 'textarea') {
                                                        echo '<textarea id="inp_' . $option['name'] . '" name="' . $option['name'] . '" class="option form-control" option_id="' . $option['id'] . '" option_rus="' . $option['rus'] . '" option_type="' . $option['type'] . '" option_name="' . $option['name'] . '">' . $option['value'] . '</textarea>';
                                                    } else {
                                                        echo $option['value'];
                                                    }
                                                    ?>
                                                </td>
                                                <td>
                                                    <a href="/admin/options/edit/<?= $option['id'] ?>/"><img
                                                            src="<?=GENERAL_DOMAIN?>/img/edit.png"
                                                            width="16px"
                                                            height="16px"
                                                            border="0"
                                                            title="Редактировать"/></a>
                                                    <?php
                                                    if ($option['required'] != 1) {
                                                        ?>
                                                        <img class="row-del" id="del-<?= $option['id'] ?>"
                                                             type="options"
                                                             row_id="<?= $option['id'] ?>" src="<?=GENERAL_DOMAIN?>/img/del.png" border="0"
                                                             alt="Удалить" title="Удалить"/>
                                                        <?php
                                                    }
                                                    ?>
                                                </td>
                                            </tr>
                                            <?php
                                        //}
                                    }
                                    ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

            </div> <!-- .container-fluid -->
        </div> <!-- #page-content -->
    </div>
    <div id="result"></div>

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
<link type="text/css" href="'.GENERAL_DOMAIN.'>/includes/assets/plugins/dropzone/css/dropzone.css" rel="stylesheet"> <!-- Dropzone Plugin -->

<script>
	//Fix since CKEditor can\'t seem to find it\'s own relative basepath
	CKEDITOR_BASEPATH  =  "'.GENERAL_DOMAIN.'/includes/assets/plugins/form-ckeditor/";
</script>
<script type="text/javascript" src="'.GENERAL_DOMAIN.'/includes/assets/plugins/form-ckeditor/ckeditor.js"></script>  	<!-- CKEditor -->
';
?>
<?=$footer?>
