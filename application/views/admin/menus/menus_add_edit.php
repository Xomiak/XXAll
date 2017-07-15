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
        <?php include(X_PATH."/application/views/admin/common/left_sidebar.php"); ?>
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

                                <form enctype="multipart/form-data" action="<?= $_SERVER['REQUEST_URI'] ?>"
                                      method="post" class="form-horizontal row-border">
                                    <input type="hidden" name="action" value="<?=$action?>" />
                                    <div class="container-fluid">
                                        <div class="tab-content">
                                            <div class="tab-pane active" id="tab1">
                                                <div class="row">

                                                    <div class="panel-editbox" data-widget-controls=""></div>
                                                    <div class="panel-body">
                                                        <?php
                                                        $date = date("Y-m-d");
                                                        $time = date("H:i");

                                                        if($languagesCount > 1){
                                                            foreach ($languages as $language){
                                                                if(isset($menu['name'])) {
                                                                    $menu['name_' . $defaultLanguage['code']] = $menu['name'];
                                                                    //vd($menu);
                                                                }
                                                                ?>
                                                                <div class="form-group">
                                                                    <label class="col-sm-2 control-label">
                                                                        Название (<?=$language['name']?>):
                                                                    </label>
                                                                    <div class="col-sm-8">
                                                                        <input id="inp_name_<?=$language['code']?>" class="form-control" type="text" name="name_<?=$language['code']?>"
                                                                               value="<?php if (isset($menu['name_'.$language['code']])) echo $menu['name_'.$language['code']]; elseif(isset($from['name_'.$language['code']])) echo $from['name_'.$language['code']]; elseif(isset($from['name'])) echo $from['name'];?>">
                                                                    </div>
                                                                </div>
                                                                <?php
                                                            }
                                                        } else {
                                                        ?>
                                                        <div class="form-group">
                                                            <label class="col-sm-2 control-label">
                                                                Название:
                                                            </label>
                                                            <div class="col-sm-8">
                                                                <input id="inp_name" class="form-control" type="text" name="name"
                                                                       value="<?php if (isset($menu['name'])) echo $menu['name']; elseif(isset($from['name'])) echo $from['name']; ?>">
                                                            </div>
                                                        </div>
                                                        <?php } ?>
                                                        
                                                        <div class="form-group">
                                                            <label class="col-sm-2 control-label">
                                                                Позиция *:
                                                            </label>
                                                            <div class="col-sm-8">
                                                                <select id="sel_position" name="position" class="form-control" required>
                                                                    <option></option>
                                                                    <?php
                                                                    if($mp){
                                                                        foreach ($mp as $item){
                                                                            ?>
                                                                            <option
                                                                                value="<?=$item['position']?>"<?php if ((isset($menu['position'])) && $menu['position'] == $item['position'])
                                                                                echo ' selected'; ?>><?=$item['name']?>
                                                                            </option>
                                                                            <?php
                                                                        }
                                                                    }
                                                                    ?>

                                                                </select>
                                                            </div>
                                                        </div>

                                                        <script>
                                                            // POSITION
                                                            $(document).ready(function () {
                                                                $("#sel_position").change(function () {
                                                                    var sel_position = $("#sel_position").val();
                                                                    getPositionMenus(sel_position);
                                                                    console.log('position: '+sel_position);
                                                                    
                                                                });
                                                            });
                                                        </script>
                                                        
                                                        <div class="form-group">
                                                            <label class="col-sm-2 control-label">
                                                                Родитель:
                                                            </label>
                                                            <div class="col-sm-8">
                                                                <SELECT id="sel_parent_id" name = "parent_id" class="form-control">
                                                                    <option value = "0">нет</option>
                                                                    <?php
//                                                                    $optionsTree = new AdminElementsTree('menu');
//                                                                    if ($menu['parent_id'])
//                                                                        $optionsTree->setSelectedOptions($menu['parent_id']);
//                                                                    echo $optionsTree->createOptionsTreeForSelect($menus, 0);
                                                                    ?>
                                                                </SELECT>
                                                            </div>
                                                        </div>

                                                        <div class="form-group">
                                                            <label class="col-sm-2 control-label">
                                                                Тип:
                                                            </label>
                                                            <div class="col-sm-8">
                                                                <select name="type" id="sel_type" class="form-control">
                                                                    <option
                                                                        value="url"<?php if (((isset($menu['type'])) && $menu['type'] == 'url') || (isset($type) && $type == 'url'))
                                                                        echo ' selected'; ?>>URL
                                                                    </option>
                                                                    <option
                                                                        value="category"<?php if (((isset($menu['type'])) && $menu['type'] == 'category') || (isset($type) && $type == 'category'))
                                                                        echo ' selected'; ?>>Раздел
                                                                    </option>
                                                                    <option
                                                                        value="page"<?php if (((isset($menu['type'])) && $menu['type'] == 'page') || (isset($type) && $type == 'page'))
                                                                        echo ' selected'; ?>>Страница
                                                                    </option>
                                                                </select>
                                                            </div>
                                                        </div>

                                                        <script>
                                                            // TYPE
                                                            $(document).ready(function () {
                                                                $("#sel_type").change(function () {
                                                                    var sel_type = $("#sel_type").val();
                                                                    console.log('type: '+sel_type);
                                                                    if(sel_type == 'url'){
                                                                        $("#inp_url").show();
                                                                        $("#inp_url_disabled").hide();
                                                                        $("#div-page").hide(300);
                                                                        $("#div-category").hide(300);
                                                                        $("#div-page").val('');
                                                                        $("#div-category").val('');
                                                                    } else{
                                                                        $("#inp_url").hide();
                                                                        $("#inp_url_disabled").show();
                                                                        if(sel_type == 'category') {
                                                                            $("#div-category").show(300);
                                                                            $("#div-page").hide(300);
                                                                        }
                                                                        else if(sel_type == 'page') {
                                                                            $("#div-page").show(300);
                                                                            $("#div-category").hide(300);
                                                                        }
                                                                    }
                                                                });
                                                            });
                                                        </script>

                                                        <div id="div-category" class="form-group"<?php if(!isset($menu) || $menu['type'] != 'category') echo ' style="display:none;"';?>>
                                                            <label class="col-sm-2 control-label">
                                                                Выберите раздел:
                                                            </label>
                                                            <div class="col-sm-8">
                                                                <select name="category_id" id="sel_category" class="form-control">
                                                                    <option value="0"></option>
                                                                    <?php
                                                                    if(isset($menu['category_id'])) $cat_ids = $menu['category_id'];
                                                                    elseif(isset($category_id)) $cat_ids = $category_id;
                                                                    $optionsTree = new AdminElementsTree('category');
                                                                    $optionsTree->setSelectedOptions($cat_ids);
                                                                    echo $optionsTree->createOptionsTreeForSelect($categories, 0);
//                                                                    if($categories){
//                                                                        foreach ($categories as $category){
//                                                                            echo '<option value="'.$category['id'].'"';
//                                                                            if($menu['category_id'] == $category['id']) echo ' selected';
//                                                                            echo '>'.$category['name'].'</option>';
//                                                                        }
//                                                                    }
                                                                    ?>
                                                                </select>
                                                            </div>
                                                        </div>

                                                        <script>
                                                            // CATEGORY
                                                            $(document).ready(function () {
                                                                // Получаем и зменяем url и название меню из раздела
                                                                $("#sel_category").change(function () {
                                                                    console.log("category change");
                                                                    var category_id = $("#sel_category").val();
                                                                    var category_url = false;

                                                                    var urlGetUrl = "/admin/ajax/get_full_url/category/"+category_id+"/";
                                                                    $.get(urlGetUrl, {
                                                                    }, function (data) {
                                                                        $("#inp_url").val(data);
                                                                        $("#inp_url_disabled").val(data);
                                                                    });

                                                                    var urlGetName = "/admin/ajax/get_name_of/category/"+category_id+"/";
                                                                    $.get(urlGetName, {
                                                                    }, function (data) {
                                                                        <?php
                                                                        if($languagesCount > 1) echo '$("#inp_name_'.$defaultLanguage['code'].'").val(data);';
                                                                        else echo '$("#inp_name").val(data);';
                                                                        ?>
                                                                    });
                                                                });
                                                            });
                                                        </script>

                                                        <div id="div-page" class="form-group"<?php if(!isset($menu) || $menu['type'] != 'page') echo ' style="display:none;"';?>>
                                                            <label class="col-sm-2 control-label">
                                                                Выберите страницу:
                                                            </label>
                                                            <div class="col-sm-8">
                                                                <select name="page_id" id="sel_page" class="form-control">
                                                                    <option value="0"></option>
                                                                    <?php
                                                                    if($pages){
                                                                        foreach ($pages as $page){
                                                                            echo '<option value="'.$page['id'].'"';
                                                                            if(isset($menu) && $menu['page_id'] == $page['id']) echo ' selected';
                                                                            elseif(isset($page_id) && $page_id == $page['id']);
                                                                            echo '>'.$page['name'].'</option>';
                                                                        }
                                                                    }
                                                                    ?>
                                                                </select>
                                                            </div>
                                                        </div>

                                                        <script>
                                                            // PAGE
                                                            $(document).ready(function () {
                                                                $("#sel_page").change(function () {
                                                                    // Получаем и зменяем url и название меню из страницы
                                                                    console.log("page change");
                                                                    var page_id = $("#sel_page").val();
                                                                    var page_url = false;

                                                                    var urlGetUrl = "/admin/ajax/get_full_url/page/"+page_id+"/";
                                                                    $.get(urlGetUrl, {
                                                                    }, function (data) {
                                                                        $("#inp_url").val(data);
                                                                        $("#inp_url_disabled").val(data);
                                                                    });

                                                                    var urlGetName = "/admin/ajax/get_name_of/page/"+page_id+"/";
                                                                    $.get(urlGetName, {
                                                                    }, function (data) {
                                                                        <?php
                                                                        if($languagesCount > 1) echo '$("#inp_name_'.$defaultLanguage['code'].'").val(data);';
                                                                        else echo '$("#inp_name").val(data);';
                                                                        ?>
                                                                    });

                                                                });
                                                            });
                                                        </script>

                                                        <div class="form-group">
                                                            <label class="col-sm-2 control-label">
                                                                URL:
                                                            </label>
                                                            <div class="col-sm-8">
                                                                <input id="inp_url" class="form-control" type="text" name="url"
                                                                       value="<?php if (isset($menu['url'])) echo $menu['url']; elseif(isset($url)) echo $url; ?>">
                                                                <input disabled style="display: none; width: 100%" id="inp_url_disabled" class="form-control" type="text" name="url_disabled"
                                                                       value="<?php if (isset($menu['url'])) echo $menu['url']; elseif(isset($url)) echo $url; ?>">
                                                            </div>
                                                        </div>

                                                        <div class="form-group">
                                                            <label class="col-sm-2 control-label">
                                                                Последовательность:
                                                            </label>
                                                            <div class="col-sm-8">
                                                                <input id="inp_num" class="form-control" type="text" name="num"
                                                                       value="<?php if (isset($menu['num'])) echo $menu['num']; elseif(isset($num)) echo $num; ?>">
                                                            </div>
                                                        </div>

                                                        

                                                        <div class="form-group">
                                                            <label class="col-sm-2 control-label">
                                                                Параметры:
                                                            </label>
                                                            <div class="col-sm-8">
                                                                <input id="inp_params" class="form-control" type="text" name="params"
                                                                       value="<?php if (isset($menu['params'])) echo $menu['params']; ?>">
                                                            </div>
                                                        </div>

                                                        <div class="form-group">
                                                            <label class="col-sm-2 control-label">
                                                                Отображение:
                                                            </label>
                                                            <div class="col-sm-8">
                                                                <select name="show_type" class="form-control">
                                                                    <option
                                                                        value = "name"<?php if ((isset($menu['show_type'])) && $menu['show_type'] == 'name')
                                                                        echo ' selected'; ?>>Только имя
                                                                    </option>
                                                                    <option
                                                                        value = "icon"<?php if ((isset($menu['show_type'])) && $menu['show_type'] == 'icon')
                                                                        echo ' selected'; ?>>Только иконка
                                                                    </option>
                                                                    <option
                                                                        value = "both"<?php if ((isset($menu['show_type'])) && $menu['show_type'] == 'both')
                                                                        echo ' selected'; ?>>Имя и иконка
                                                                    </option>
                                                                </select>
                                                            </div>
                                                        </div>

                                                        <div class="form-group">
                                                            <label class="col-sm-2 control-label">
                                                                Иконка:
                                                            </label>
                                                            <div class="col-sm-8">
                                                                <?php
                                                                if(isset($menu['icon']) && $menu['icon'] != '') {
                                                                    echo '<img src="' . $menu['icon'] . '" style="max-width:600px" /><br /><input type="checkbox" name="icon_del">Удалить<br />';
                                                                    echo '<input type="text" class="form-control" name="icon" value="http://'.$_SERVER['SERVER_NAME'].$menu['icon'].'" />';
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
                                                                                        if(isset($menu['icon']) && $menu['icon'] != '') echo 'другой ';
                                                                                        echo 'файл</span>
                                                                                    <span class="fileinput-exists">Изменить</span>
                                                                                    <input type="file" name="icon">
                                                                                </span>
                                                                                
                                                                            </span>
                                                                        </div>
                                                                    </div>
                                                                ';
                                                                ?>

                                                            </div>
                                                        </div>

                                                        <div class="form-group">
                                                            <label for="no_click" class="col-sm-2 control-label">
                                                                Не кликабельный:
                                                            </label>
                                                            <div class="col-sm-1">
                                                                <input  class="bootstrap-switch switch-alt" data-on-color="success" data-off-color="default" data-on-text="ДА" data-off-text="НЕТ" type = "checkbox" id = "no_click" name = "no_click" <?php if(isset($menu['no_click']) && $menu['no_click'] == 1) echo ' checked'; ?> />
                                                            </div>
                                                        </div>

                                                        <div class="form-group">
                                                            <label for="active" class="col-sm-2 control-label">
                                                                Активный:
                                                            </label>
                                                            <div class="col-sm-1">
                                                                <input  class="bootstrap-switch switch-alt" data-on-color="success" data-off-color="default" data-on-text="ДА" data-off-text="НЕТ" type = "checkbox" id = "active" name = "active" <?php if(isset($menu['active']) && $menu['active'] == 0) echo ''; else echo ' checked'; ?> />
                                                            </div>
                                                        </div>

<!--                                                        КНОПКИ СОХРАНИТЬ И СОХРАНИТЬ И ЗАКРЫТЬ-->
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
                                                foreach ($languages as $language) {
                                                    if ($language != $defaultLanguage)
                                                        $otherLanguage = true;
                                                    else $otherLanguage = false;
                                                    ?>
                                                    <div class="tab-pane" id="tab-<?= $language['code'] ?>">

                                                        <div class="row">
                                                            <div class="panel-heading">
                                                                <h2>Мультиязычные поля (<?= $language['name'] ?>):</h2>
                                                            </div>
                                                            <div class="panel-editbox" data-widget-controls=""></div>
                                                            <div class="panel-body">
                                                                <?php
                                                                $date = date("Y-m-d");
                                                                $time = date("H:i");
                                                                //$settings = $multiLang;
                                                                //include('application/views/admin/menus/partical.inc.php');
                                                                ?>
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

                                                        </div> <!-- .container-fluid -->
                                                    </div>
                                                    <?php
                                                }
                                            }
                                            ?>
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