<?php if (isset($head)) echo $head; ?>
<?php if (isset($header)) echo $header; ?>
<div id="wrapper">
    <div id="layout-static">
        <?php if (isset($left_sidebar)) echo $left_sidebar; ?>
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
                                <a title="Настройки полей" href="/admin/articles/settings/" class="btn btn-default"><i
                                            class="fa fa-fw fa-wrench"></i></a>
                            </div>
                        </div>
                    </div>
                    <?php // include(X_PATH . '/application/views/admin/' . $type . '/menu.inc.php'); ?>
                    <nav class="navbar sidebar-inverse" role="navigation" id="headernav"
                         style="background-color: #F5F5F5">
                        <div class="collapse navbar-collapse" id="horizontal-navbar">
                            <?php
                            $mCats = getModel('categories');
                            $categories = $mCats->getCategories(1, 'gallery');
                            $category = false;
                            ?>
                            <ul class="nav navbar-nav smart-menu">
                                <li>
                                    <SELECT name="category_id">
                                        <?php
                                        if ($categories) {
                                            $i = 0;
                                            foreach ($categories as $cat) {
                                                echo '<option value="' . $cat['id'] . '"';
                                                if (userdata('gallery_category') == $cat['id'] || $i == 0) {
                                                    echo ' selected';
                                                    $category = $cat;
                                                }
                                                echo '>' . $cat['name'] . '</option>';
                                                $i++;
                                            }
                                        } else echo '<option value="0"></option>';
                                        ?>
                                    </SELECT>
                                </li>
                                <!--li class="active"><a href="/admin/<?= $type ?>/"><i class="fa fa-language"></i> <span>Статьи</span></a></li>
                                <li><a href="/admin/<?= $type ?>/add/"><i class="fa fa-plus"></i> <span>Добавить статью</span></a></li>
                                <li><a href="/admin/<?= $type ?>/settings/"><i class="fa fa-cog"></i> <span>Настройки полей</span></a></li-->
                            </ul>
                        </div>
                    </nav>
                    <div class="container-fluid">

                        <div class="row">
                            <div class="col-md-12">

                                <form method="post" action="<?= $_SERVER['REQUEST_URI'] ?>">
                                    <input type="submit" name="delete" value="Удалить выбранные"
                                           onclick="return confirm('Вы точно хотите УДАЛИТЬ выбранные?')"/>
                                    <table width="100%" cellpadding="1" cellspacing="1">
                                        <tr bgcolor="#EEEEEE">
                                            <th><input type="checkbox" name="maincheck" id="maincheck"
                                                       title="Выбрать все"/></th>
                                            <th width="200px">Фото</th>
                                            <th>Название</th>
                                            <th>Позиция</th>
                                            <th>Вверх/Вниз</th>
                                            <th>Действия</th>
                                        </tr>
                                        <?php
                                        $count = count($images);
                                        for ($i = 0; $i < $count; $i++) {
                                            $img = $images[$i];
                                            $category = $this->gallery->getCategoryById($img['category_id']);
                                            $folder = $category['url'];
                                            //if($category['folder'] != '') $folder = 'categories/'.$category['folder'].'/';
                                            $thumb = '';

                                            ?>
                                            <tr class="list">
                                                <td><input class="mc" type="checkbox" name="list[]"
                                                           value="<?= $img['id'] ?>"/></td>
                                                <td>
                                                    <div class="popup-gallery">
                                                        <a href="<?= $img['image'] ?>"><img class="preview"
                                                                                            src="<?= $img['image'] ?>"
                                                                                            height="120" width="auto"/></a>
                                                    </div>
                                                </td>
                                                <td><a href="<?= $img['image'] ?>" target="_blank"
                                                       title="Открыть фото"><?= $img['image'] ?></a></td>
                                                <td><?= $img['num'] ?></td>
                                                <td><a href="/admin/gallery/up/<?= $img['id'] ?>/"><img
                                                                src="/img/uparrow.png" border="0" alt="Вверх"
                                                                title="Вверх"/></a>
                                                    <a href="/admin/gallery/down/<?= $img['id'] ?>/"><img
                                                                src="/img/downarrow.png" border="0" alt="Вниз"
                                                                title="Вниз"/></a></td>

                                                <td>
                                                    <a href="/admin/gallery/active/<?= $img['id'] ?>/"><?php
                                                        if ($img['active'] == 1)
                                                            echo '<img src="/img/visible.png" width="16px" height="16px" border="0" title="Деактивировать" />';
                                                        else
                                                            echo '<img src="/img/not-visible.png" width="16px" height="16px" border="0" title="Активировать" />';
                                                        ?></a>
                                                    <a href="/admin/gallery/edit/<?= $img['id'] ?>/"><img
                                                                src="/img/edit.png" width="16px" height="16px"
                                                                border="0" title="Редактировать"/></a>
                                                    <a onclick="return confirm('Удалить?')"
                                                       href="/admin/gallery/del/<?= $img['id'] ?>/"><img
                                                                src="/img/del.png" border="0" alt="Удалить"
                                                                title="Удалить"/></a></td>
                                            </tr>
                                            <?php
                                        }
                                        ?>
                                    </table>
                                </form>
                                <div class="text-center">
                                    <div class="pagination">
                                        <?= $pager ?>
                                    </div>
                                </div>
                                <?php if ($category) { ?>
                                <div data-widget-group="group2">
                                    <script type="text/javascript"
                                            src="/includes/assets/js/jqueryui-1.9.2.min.js"></script>
                                    <div class="panel panel-2" data-widget='{"draggable": "false"}'>
                                        <div class="panel-heading">
                                            <h2>Фото раздела:</h2>
                                            <div class="panel-ctrls"
                                                 data-actions-container=""
                                                 data-action-collapse='{"target": ".panel-body"}'
                                            >
                                            </div>
                                        </div>
                                        <div class="panel-editbox" data-widget-controls=""></div>
                                        <div class="panel-body">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="panel">
                                                        <!--            <div class="panel-body">-->


                                                        <form action="/admin/ajax/upload_files/categories/"
                                                              class="dropzone">


                                                            <input type="hidden" name="category_id"
                                                                   value="<?= $category['id'] ?>"/>
                                                            <input type="hidden" name="show_in_bottom" value="1"/>
                                                            <input type="hidden" name="active" value="1"/>


                                                        </form>
                                                        <!--            </div>-->

                                                        <div id="adding-images">
                                                            <ul id="sortable">
                                                                <?php
                                                                if ($images) {
                                                                    foreach ($images as $image) {
                                                                        showAddingFoto($image);
                                                                    }
                                                                }
                                                                ?>


                                                            </ul>
                                                        </div>
                                                        <script type="text/javascript">
                                                            $(document).ready(function () {
                                                                reloadAllImages(<?=$category['id']?>);
                                                            });

                                                            function reloadAllImages(id) {
                                                                $.ajax({
                                                                    /* адрес файла-обработчика запроса */
                                                                    url: '/admin/ajax/get_images/?category_id=' + id,
                                                                    /* метод отправки данных */
                                                                    method: 'POST',
                                                                    async: false,
                                                                    /* данные, которые мы передаем в файл-обработчик */
                                                                    data: {
                                                                        "category_id": id
                                                                    },

                                                                }).done(function (data) {
                                                                    $("#sortable").html(data);
                                                                });
                                                            }
                                                        </script>

                                                        <script>
                                                            $(document).ready(function () {

                                                                var vid = false;
                                                                var vimage_show_in_buttom = 1;
                                                                var vactive = 1;
                                                                $('.image_show_in_buttom').click(function () {
                                                                    vid = $(this).attr('image_id');
                                                                    if ($(this).attr("checked") == 'checked') {
                                                                        vimage_show_in_buttom = 1;
                                                                    } else {
                                                                        vimage_show_in_buttom = 0;
                                                                    }
                                                                    $.ajax({
                                                                        /* адрес файла-обработчика запроса */
                                                                        url: '/admin/ajax/action_image/?image_id=' + vid + '&param=show_in_bottom&value=' + vimage_show_in_buttom,
                                                                        /* метод отправки данных */
                                                                        method: 'POST',
                                                                        async: false,
                                                                        /* данные, которые мы передаем в файл-обработчик */
                                                                        data: {
                                                                            "image_id": vid,
                                                                            "param": "show_in_bottom",
                                                                            "value": vimage_show_in_buttom
                                                                        },

                                                                    }).done(function (data) {
                                                                        alert(data);
                                                                    });
                                                                });

                                                                $('.image_active').click(function () {
                                                                    vid = $(this).attr('image_id');
                                                                    if ($(this).attr("checked") == 'checked') {
                                                                        vactive = 1;
                                                                    } else {
                                                                        vactive = 0;
                                                                    }
                                                                    $.ajax({
                                                                        /* адрес файла-обработчика запроса */
                                                                        url: '/admin/ajax/action_image/?image_id=' + vid + '&param=active&value=' + vactive,
                                                                        /* метод отправки данных */
                                                                        method: 'POST',
                                                                        async: false,
                                                                        /* данные, которые мы передаем в файл-обработчик */
                                                                        data: {
                                                                            "image_id": vid,
                                                                            "param": "active",
                                                                            "value": vactive
                                                                        },

                                                                    }).done(function (data) {
                                                                        alert(data);
                                                                    });
                                                                });

                                                                // удаление картинки
                                                                $('.image_delete').click(function () {
                                                                    vid = $(this).attr('image_id');

                                                                    $.ajax({
                                                                        /* адрес файла-обработчика запроса */
                                                                        url: '/admin/ajax/action_image/?image_id=' + vid + '&param=delete',
                                                                        /* метод отправки данных */
                                                                        method: 'POST',
                                                                        async: false,
                                                                        /* данные, которые мы передаем в файл-обработчик */
                                                                        data: {
                                                                            "image_id": vid,
                                                                            "param": "delete"
                                                                        },

                                                                    }).done(function (data) {
                                                                        $("#image-" + vid).remove();
                                                                    });
                                                                });

                                                                $(".active-input").focus(function () {
                                                                    if (this.value == this.defaultValue) {
                                                                        this.select();
                                                                    }
                                                                });
                                                            });
                                                        </script>

                                                    </div>
                                                </div>
                                            </div>
                                        </div> <!-- #page-content -->


                                    </div>
                                </div>
                            </div>
                            <?php } ?>
                            <div id="result"></div>
                        </div>
                    </div>
                </div>

            </div> <!-- .container-fluid -->
        </div> <!-- #page-content -->
    </div>
</div>


    <?php
    $adding_scripts = '
<script type="text/javascript" src="' . GENERAL_DOMAIN . '/includes/assets/plugins/form-multiselect/js/jquery.multi-select.min.js"></script>  			<!-- Multiselect Plugin -->
<script type="text/javascript" src="' . GENERAL_DOMAIN . '/includes/assets/plugins/quicksearch/jquery.quicksearch.min.js"></script>           			<!-- Quicksearch to go with Multisearch Plugin -->
<script type="text/javascript" src="' . GENERAL_DOMAIN . '/includes/assets/plugins/form-typeahead/typeahead.bundle.min.js"></script>                 	<!-- Typeahead for Autocomplete -->
<script type="text/javascript" src="' . GENERAL_DOMAIN . '/includes/assets/plugins/form-select2/select2.min.js"></script>                     			<!-- Advanced Select Boxes -->
<script type="text/javascript" src="' . GENERAL_DOMAIN . '/includes/assets/plugins/form-autosize/jquery.autosize-min.js"></script>            			<!-- Autogrow Text Area -->
<script type="text/javascript" src="' . GENERAL_DOMAIN . '/includes/assets/plugins/form-colorpicker/js/bootstrap-colorpicker.min.js"></script> 			<!-- Color Picker -->

<script type="text/javascript" src="' . GENERAL_DOMAIN . '/includes/assets/plugins/bootstrap-touchspin/dist/jquery.bootstrap-touchspin.js"></script> <!-- Touchspin -->

<!--script type="text/javascript" src="' . GENERAL_DOMAIN . '/includes/assets/plugins/form-fseditor/jquery.fseditor-min.js"></script-->            			<!-- Fullscreen Editor -->
<script type="text/javascript" src="' . GENERAL_DOMAIN . '/includes/assets/plugins/form-jasnyupload/fileinput.min.js"></script>               			<!-- File Input -->
<script type="text/javascript" src="' . GENERAL_DOMAIN . '/includes/assets/plugins/form-tokenfield/bootstrap-tokenfield.min.js"></script>     			<!-- Tokenfield -->
<script type="text/javascript" src="' . GENERAL_DOMAIN . '/includes/assets/plugins/switchery/switchery.js"></script>     								<!-- Switchery -->

<script type="text/javascript" src="' . GENERAL_DOMAIN . '/includes/assets/plugins/card/lib/js/card.js"></script> 										<!-- Card -->

<!-- <script type="text/javascript" src="/includes/assets/plugins/iCheck/icheck.min.js"></script>  -->    							<!-- iCheck // already included on site-level -->
<script type="text/javascript" src="' . GENERAL_DOMAIN . '/includes/assets/plugins/bootstrap-switch/bootstrap-switch.js"></script>     					<!-- BS Switch -->

<script type="text/javascript" src="' . GENERAL_DOMAIN . '/includes/assets/plugins/jquery-chained/jquery.chained.min.js"></script> 						<!-- Chained Select Boxes -->

<script type="text/javascript" src="' . GENERAL_DOMAIN . '/includes/assets/plugins/jquery-mousewheel/jquery.mousewheel.min.js"></script> <!-- MouseWheel Support -->

<script type="text/javascript" src="' . GENERAL_DOMAIN . '/includes/assets/demo/demo-formcomponents.js"></script>

<script type="text/javascript" src="' . GENERAL_DOMAIN . '/includes/assets/plugins/wijets/wijets.js"></script>     							<!-- Wijet -->
<script type="text/javascript" src="' . GENERAL_DOMAIN . '/includes/assets/plugins/clockface/js/clockface.js"></script>     								<!-- Clockface -->

<script type="text/javascript" src="' . GENERAL_DOMAIN . '/includes/assets/plugins/form-colorpicker/js/bootstrap-colorpicker.min.js"></script> 			<!-- Color Picker -->

<script type="text/javascript" src="' . GENERAL_DOMAIN . '/includes/assets/plugins/bootstrap-datepicker/bootstrap-datepicker.js"></script>      			<!-- Datepicker -->
<script type="text/javascript" src="' . GENERAL_DOMAIN . '/includes/assets/plugins/bootstrap-timepicker/bootstrap-timepicker.js"></script>      			<!-- Timepicker -->
<script type="text/javascript" src="' . GENERAL_DOMAIN . '/includes/assets/plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.js"></script> 	<!-- DateTime Picker -->
<script type="text/javascript" src="' . GENERAL_DOMAIN . '/includes/assets/plugins/form-daterangepicker/moment.min.js"></script>              			<!-- Moment.js for Date Range Picker -->
<script type="text/javascript" src="' . GENERAL_DOMAIN . '/includes/assets/plugins/form-daterangepicker/daterangepicker.js"></script>     				<!-- Date Range Picker -->
<script type="text/javascript" src="' . GENERAL_DOMAIN . '/includes/assets/plugins/jcrop/js/jquery.Jcrop.min.js"></script>  	<!-- Image cropping Plugin -->

<script type="text/javascript" src="' . GENERAL_DOMAIN . '/includes/assets/plugins/dropzone/dropzone.min.js"></script>   	<!-- Dropzone Plugin -->
<link type="text/css" href="' . GENERAL_DOMAIN . '/includes/assets/plugins/dropzone/css/dropzone.css" rel="stylesheet"> <!-- Dropzone Plugin -->

<script>
	//Fix since CKEditor can\'t seem to find it\'s own relative basepath
	CKEDITOR_BASEPATH  =  "' . GENERAL_DOMAIN . '/includes/assets/plugins/form-ckeditor/";
	CKEDITOR.config.customConfig = "' . GENERAL_DOMAIN . '/includes/assets/plugins/form-ckeditor/my_config.js";
</script>
<script type="text/javascript" src="' . GENERAL_DOMAIN . '/includes/assets/plugins/form-ckeditor/ckeditor.js"></script>  	<!-- CKEditor -->


<script type="text/javascript" src="' . GENERAL_DOMAIN . '/includes/assets/plugins/form-ckeditor/ckfinder/ckfinder.js"></script>  <!-- CKFinder Media Browser -->
<script type="text/javascript" src="' . GENERAL_DOMAIN . '/includes/assets/plugins/form-parsley/parsley.js"></script>  					<!-- Validate Plugin / Parsley -->
';
    if (isset($footer)) {
        $footer = str_replace('[adding_scripts]', $adding_scripts, $footer);
        echo $footer;
    }
    ?>



    <?php
    $adding_scripts = '
    <script>
     $("input[type=\'checkbox\']").click(function () {

            if ($(\'input:checkbox:checked\')) {
                $("#hidden_mass").fadeIn("fast");
            } else $("#hidden_mass").fadeOut("fast");

            var selectedItems = new Array();
            $("input[type=\'checkbox\']:checked").each(function () {
                selectedItems.push($(this).val());
            });
            if (selectedItems.length > 0) {
                //$("#hidden_mass").fadeIn("fast");
                //alert(123);
            } else {
                //$("#hidden_mass").fadeOut("fast");
                alert(22222);
            }


            $("input[type=\'checkbox\']").each(function () {
                if ($(this).prop(\'checked\')) {
                    //$("#hidden_mass").fadeIn("fast");
                } else {
                    //$("#hidden_mass").fadeOut("fast");
                }
            });

            if ($(\'input:checkbox:checked\')) {
                $("#hidden_mass").fadeIn("fast");
            } else $("#hidden_mass").fadeOut("fast");
        });
            
		$(function(){

			var dropbox = $(\'#dropbox\'),
				message = $(\'.message\', dropbox);

			dropbox.filedrop({
				paramname:\'pic\',

				maxfiles: 50,
				maxfilesize: 2,
				url: \'/admin/ajax/upload_files/gallery/\',

				uploadFinished:function(i,file,response){
					$.data(file).addClass(\'done\');
				},

				error: function(err, file) {
					switch(err) {
						case \'BrowserNotSupported\':
							showMessage(\'Ваш Браузер не поддерживает HTML5!\');
							break;
						case \'TooManyFiles\':
							alert(\'Разрешено загружать за 1 раз не более 5 изображений\');
							break;
						case \'FileTooLarge\':
							alert(file.name+\' Слишком большой.Разрешена загрузка файлов не более 2мб.\');
							break;
						default:
							break;
					}
				},

				beforeEach: function(file){
					if(!file.type.match(/^image\//)){
						alert(\'Разрешена загрузка только изображений!!!!\');
						return false;
					}
				},

				uploadStarted:function(i, file, len){
					createImage(file);
				},

				progressUpdated: function(i, file, progress) {
					$.data(file).find(\'.progress\').width(progress);
				}

			});

			var template = \'<div class="preview">\'+
				\'<span class="imageHolder">\'+
				\'<img />\'+
				\'<span class="uploaded"></span>\'+
				\'</span>\'+
				\'<div class="progressHolder">\'+
				\'<div class="progress"></div>\'+
				\'</div>\'+
				\'</div>\';


			function createImage(file){

				var preview = $(template),
					image = $(\'img\', preview);

				var reader = new FileReader();

				image.width = 100;
				image.height = 100;

				reader.onload = function(e){

					image.attr(\'src\',e.target.result);
				};

				reader.readAsDataURL(file);

				message.hide();
				preview.appendTo(dropbox);

				$.data(file,preview);
			}

			function showMessage(msg){
				message.html(msg);
			}

		});
	</script>
';

    if (isset($footer)) {
        $footer = str_replace('[adding_scripts]', $adding_scripts, $footer);
      //  echo $footer;
    }
    ?>
