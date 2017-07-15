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
<?= $head ?>

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
<?= $header ?>

    <div id="wrapper">
    <div id="layout-static">
<?= $left_sidebar ?>
    <div class="static-content-wrapper">
    <div class="static-content">
    <div class="page-content">
        <ol class="breadcrumb">

            <li><a href="/admin/">Главная</a></li>
            <li><a href="/admin/users/">Пользователи</a></li>
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

                    <?php if(isset($err)) echo '<div class="error">'.$err.'</div>'; ?>

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
                                                    Логин *:
                                                </label>
                                                <div class="col-sm-8">
                                                    <input id="inp_login" class="form-control" type="text" name="login"
                                                           required
                                                           value="<?php if (isset($myuser['login'])) echo $myuser['login']; elseif(isset($err)) echo post('login'); ?>">
                                                </div>
                                            </div>

                                            <?php if(isset($myuser)){ ?>
                                            <div class="form-group">
                                                <label class="col-sm-2 control-label">Заменить пароль:</label>
                                                <div class="col-sm-8">
                                                    <div class="input-group">
                                                        <span class="input-group-addon icheck">
                                                            <input type="checkbox" name="set_password">
                                                        </span>
                                                        <input type="text" name="new_password" class="form-control">
                                                    </div>
                                                </div>
                                            </div>
                                            <?php } else { ?>
                                                <div class="form-group">
                                                    <label class="col-sm-2 control-label">
                                                        Пароль *:
                                                    </label>
                                                    <div class="col-sm-8">
                                                        <input id="inp_pass1" class="form-control" type="password" name="pass1" value="">
                                                    </div>
                                                    <div id="pass1err" style="display: none"><img src="/img/admin/warning-red.png" title="Пароль должен быть не менее 8 символов!"/></div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-sm-2 control-label">
                                                        Пароль ещё раз *:
                                                    </label>
                                                    <div class="col-sm-8">
                                                        <input id="inp_pass2" class="form-control" type="password" name="pass2" value="">
                                                    </div>
                                                    <div id="pass2err" style="display: none"><img src="/img/admin/warning.gif" title="Введённые пароли не совпадают!"/></div>
                                                </div>

                                                <script>
                                                    $(document).ready(function () {
                                                        var pass = '';
                                                        // проверка длины пароля
                                                        $('#inp_pass1').keyup(function () {
                                                            pass = $("#inp_pass1").val();
                                                            if(pass.length < 8){
                                                                console.log('Пароль меньше 8 символов!');
                                                                $("#pass1err").show(500);
                                                                $('input[type="submit"]').attr('disabled','disabled');
                                                            } else {
                                                                $("#pass1err").hide(500);
                                                                $(".fixed-buttons input").removeAttr('disabled');
                                                            }
                                                        });
                                                        // проверка второго пароля
                                                        $('#inp_pass2').keyup(function () {
                                                            pass = $("#inp_pass1").val();
                                                            var pass2 = $("#inp_pass2").val();
                                                            if(pass != pass2){
                                                                console.log('Пароли не совпадают!');
                                                                $("#pass2err").show(500);
                                                                $('input[type="submit"]').attr('disabled','disabled');
                                                            } else {
                                                                $("#pass2err").hide(500);
                                                                $(".fixed-buttons input").removeAttr('disabled');
                                                            }
                                                        });
                                                    });
                                                </script>
                                            <?php } ?>

                                            <div class="form-group">
                                                <label class="col-sm-2 control-label">
                                                    Тип *:
                                                </label>
                                                <div class="col-sm-8">
                                                    <SELECT id="sel_type" name="type" class="form-control" required>
                                                        <?php
                                                        if (isset($usertypes)) {
                                                            foreach ($usertypes as $type) {
                                                                echo '<option value="' . $type['value'] . '"';
                                                                if (isset($myuser['type']) && $myuser['type'] == $type['value']) echo ' selected';
                                                                elseif (!isset($myuser['type']) && $type['value'] == 'user') echo ' selected';
                                                                elseif(isset($err) && $type == post('type')) echo ' selected';
                                                                echo '>' . $type['name'] . '</option>';
                                                            }
                                                        }
                                                        ?>
                                                    </SELECT>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="col-sm-2 control-label">
                                                    Имя:
                                                </label>
                                                <div class="col-sm-8">
                                                    <input id="inp_name" class="form-control" type="text" name="name"
                                                           value="<?php if (isset($myuser['name'])) echo $myuser['name']; elseif(isset($err)) echo post('name');  ?>">
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="col-sm-2 control-label">
                                                    Фамилия:
                                                </label>
                                                <div class="col-sm-8">
                                                    <input id="inp_lastname" class="form-control" type="text"
                                                           name="lastname"
                                                           value="<?php if (isset($myuser['lastname'])) echo $myuser['lastname']; elseif(isset($err)) echo post('lastname');  ?>">
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="col-sm-2 control-label">
                                                    e-mail *:
                                                </label>
                                                <div class="col-sm-8">
                                                    <input id="inp_email" class="form-control" type="email" name="email"
                                                           required
                                                           value="<?php if (isset($myuser['email'])) echo $myuser['email']; elseif(isset($err)) echo post('email');  ?>">
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="col-sm-2 control-label">Пол:</label>
                                                <div class="col-sm-8">

                                                    <label class="radio icheck">
                                                        <input type="radio" name="sex" id="optionsRadios1"
                                                               value="w" <?php if (isset($myuser['sex']) && $myuser['sex'] == 'w') echo ' checked'; elseif(isset($err) && post('sex') == 'w') echo ' checked';  ?>>
                                                        женский
                                                    </label>

                                                    <label class="radio icheck">
                                                        <input type="radio" name="sex" id="optionsRadios2"
                                                               value="m" <?php if (isset($myuser['sex']) && $myuser['sex'] == 'm') echo ' checked'; elseif(isset($err) && post('sex') == 'm') echo ' checked';  ?>>
                                                        мужской
                                                    </label>

                                                </div>
                                            </div>


                                            <div class="form-group">
                                                <label class="col-sm-2 control-label">
                                                    Город:
                                                </label>
                                                <div class="col-sm-8">
                                                    <input id="inp_city" class="form-control" type="text" name="city"
                                                           value="<?php if (isset($myuser['city'])) echo $myuser['city']; elseif(isset($err)) echo post('city');  ?>">
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="col-sm-2 control-label">
                                                    Телефон:
                                                </label>
                                                <div class="col-sm-8">
                                                    <input id="inp_tel" class="form-control" type="tel" name="tel"
                                                           value="<?php if (isset($myuser['tel'])) echo $myuser['tel']; elseif(isset($err)) echo post('tel');  ?>">
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="col-sm-2 control-label">
                                                    Сайт:
                                                </label>
                                                <div class="col-sm-8">
                                                    <input id="inp_site" class="form-control" type="text" name="site"
                                                           value="<?php if (isset($myuser['site'])) echo $myuser['site']; elseif(isset($err)) echo post('site');  ?>" placeholder="http://">
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="col-sm-2 control-label">
                                                    Аватар:
                                                </label>
                                                <div class="col-sm-8">
                                                    <?php
                                                    if (isset($myuser['avatar'])) {
                                                        echo '<img src="' . $myuser['avatar'] . '" class="img-responsive" id="crop-avatar" style="max-width: 50%">';
                                                        echo '<input id="inp_avatar" type="text" class="form-control" name="avatar" value="' . $myuser['avatar'] . '" />';
                                                    }
                                                    //                                        echo '
                                                    //                                            <div class="fileinput fileinput-new" data-provides="fileinput">
                                                    //                                                    <div class="input-group">
                                                    //                                                        <div class="form-control uneditable-input" data-trigger="fileinput">
                                                    //                                                            <i class="fa fa-file fileinput-exists"></i>&nbsp;<span class="fileinput-filename"></span>
                                                    //                                                        </div>
                                                    //                                                        <span class="input-group-btn">
                                                    //                                                            <a href="#" class="btn btn-default fileinput-exists" data-dismiss="fileinput">Убрать</a>
                                                    //                                                            <span class="btn btn-default btn-file">
                                                    //                                                                <span class="fileinput-new">Выбрать ';
                                                    //                                                                if (isset($myuser['avatar']) && $myuser['avatar'] != '') echo 'другой ';
                                                    //                                                                echo 'файл</span>
                                                    //                                                                <span class="fileinput-exists">Изменить</span>
                                                    //                                                                <input type="file" name="avatar">
                                                    //                                                            </span>
                                                    //
                                                    //                                                        </span>
                                                    //                                                    </div>
                                                    //                                                </div>
                                                    //                                                <img class="preview-image-upload" id="preview_avatar" style="display: none" src="#" alt="" />
                                                    //                                            ';
                                                    ?>
                                                    <script>
                                                        function readURL_avatar(input) {
                                                            if (input.files && input.files[0]) {

                                                                var reader = new FileReader();
                                                                reader.onload = function (e) {
                                                                    $('#preview_avatar').attr('src', e.target.result);
                                                                };
                                                                reader.readAsDataURL(input.files[0]);
                                                                $('#preview_avatar').show(1000);
                                                            }
                                                        }
                                                        $(document).ready(function () {
                                                            $('input[name="avatar"]').change(function () {
                                                                readURL_avatar(this);
                                                            });
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
                                                        if ((isset($myuser['active']) && $myuser['active'] == 1) || !isset($myuser)) echo ' checked ';
                                                        ?>
                                                           class="bootstrap-switch switch-alt" data-on-color="success"
                                                           data-off-color="default" data-on-text="ДА"
                                                           data-off-text="НЕТ"/>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="col-sm-2 control-label">
                                                    Подписка на рассылку:
                                                </label>
                                                <div class="col-sm-8">
                                                    <input type="checkbox" id="inp_mailer" name="mailer"
                                                        <?php
                                                        if ((isset($myuser['mailer']) && $myuser['mailer'] == 1) || !isset($myuser)) echo ' checked ';
                                                        ?>
                                                           class="bootstrap-switch switch-alt" data-on-color="success"
                                                           data-off-color="default" data-on-text="ДА"
                                                           data-off-text="НЕТ"/>
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
                    </form>

                </div>
            </div>
        </div>
    </div>


<?php
$adding_scripts = '
<!-- Translit Url --> 


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

