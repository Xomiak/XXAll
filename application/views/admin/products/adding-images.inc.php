<div data-widget-group="group2">

    <div class="panel panel-2" data-widget='{"draggable": "false"}'>
        <div class="panel-heading">
            <h2>Доп. фото:</h2>
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


                        <form method="post" action="/admin/ajax/upload_files/products/" class="dropzone">


                            <input type="hidden" name="product_id" value="<?= $article['id'] ?>"/>
                            <input type="hidden" name="show_in_bottom" value="1"/>
                            <input type="hidden" name="active" value="1"/>


                        </form>
                        <div id="adding-images">
                            <ul id="sortable">
                        <!--            </div>-->

                        <?php
                        $this->load->model('Model_images', 'images');
                        $images = $this->images->getByProductId($article['id']);
                        $count = count($images);
                        for ($i = 0; $i < $count; $i++) {
                            $image = $images[$i];
                            $imgPath = $image['image'];
//                            var_dump(X_PATH.$imgPath);
//                            var_dump(file_exists(X_PATH.$imgPath));
                            $noImgFile = false;
                            $inputImgPath = $imgPath;
                            if(! file_exists($_SERVER['DOCUMENT_ROOT'].$imgPath)) {
                                if(file_exists(X_PATH.$imgPath)) {
                                    $imgPath = GENERAL_DOMAIN . $imgPath;
                                    $inputImgPath = $imgPath;
                                }
                                else
                                    $noImgFile = true;
                            }
                            ?>

                            <li id="image-<?= $image['id'] ?>" class="article-image ui-state-default">
                                <div style="float: left">
                                    <div class="article-img" style="">
                                        <?php if(! $noImgFile) { ?>
                                            <img src="<?=$imgPath?>"
                                                 style="max-width: 250px; max-height: 160px;  line-height: 250px !important"/>
                                        <?php } else echo 'Файл картинки не найден на сервере!'; ?>
                                    </div>

                                    <div style="display: none">
                                        <input class="image_show_in_buttom" type="checkbox" image_id="<?= $image['id'] ?>"
                                               name="show_in_bottom"<?php if ($image['show_in_bottom'] == 1) echo ' checked'; ?> />Показать внизу<br/>
                                    </div>
                                    Тип:<br/>
                                    <select class="form-control" id="image-<?=$image['id']?>-type" image_id="<?= $image['id'] ?>" name="type">
                                        <option value="slider"<?php if($image['type'] == 'slider') echo ' selected';?>>Слайдер</option>
                                        <option value="plan"<?php if($image['type'] == 'plan') echo ' selected';?>>Планировка (строящиеся)</option>
                                        <option value="room"<?php if($image['type'] == 'room') echo ' selected';?>>Квартира (сданные)</option>
                                    </select><br/>
                                    <input id="image-<?=$image['id']?>-active" class="bootstrap-switch switch-alt image_active"  data-on-color="success" data-off-color="default" data-on-text="ДА" data-off-text="НЕТ" type="checkbox" image_id="<?= $image['id'] ?>"
                                           name="active"<?php if ($image['active'] == 1) echo ' checked'; ?> /> Активный<br/>

                                </div>
                                <div style="float:left; padding-left: 20px">
                                    <textarea id="image-<?=$image['id']?>-text" style="width: 100%; height: 150px" class="form-control ckeditor" name="text" image_id="<?=$image['id']?>"><?=$image['text']?></textarea>
                                    <?php
                                    echo '
                                    <script>
                            $(document).ready(function () {
                                if ( typeof CKEDITOR !== \'undefined\' ) {
                                    CKEDITOR.addCss( \'img {max-width:; height: auto;}\' );
                                    var editor = CKEDITOR.replace( \'image-' . $image['id']. '-text\', {
                                        extraPlugins: \'uploadimage,image2,codemirror\',
                                        removePlugins: \'image\',
                                        height: \'150px\',
                                        width: \'100%\'
                                    } );
                                    CKFinder.setupCKEditor( editor );
                                } else {
                                    document.getElementById( \'editor1\' ).innerHTML = \'<div class="tip-a tip-a-alert">This sample requires working Internet connection to load CKEditor from CDN.</div>\'
                                }
                            });
                        </script>
                                    ';
                                    ?>
                                </div>


                                <div style="clear: both;width: 100%"></div>
                                Путь к файлу:<br />
                                <input class="active-input" type="text"
                                       value="<?=$inputImgPath?>" style="width: 100%" /><br>

                                <button type="button" class="btn btn-primary image-save" image_id="<?=$image['id']?>" data-toggle="button" style="width: 80%; float: left">Сохранить изменения</button>

                                <button type="button" data-loading-text="Loading..." image_id="<?= $image['id'] ?>" class="loading-example-btn btn btn-danger image_delete" style="width: 20%; float: right">Удалить</button>
                            </li>
                            <?php
                        }
                        ?>



                            </ul>
                        </div>
                        <script type="text/javascript">
                            $(document).ready(function () {

                                //reloadAllImages(<?=$article['id']?>);
                            });

                            function reloadAllImages(id) {
                                return true;
                                $.ajax({
                                    /* адрес файла-обработчика запроса */
                                    url: '/admin/ajax/get_images/?product_id=' + id,
                                    /* метод отправки данных */
                                    method: 'POST',
                                    /* данные, которые мы передаем в файл-обработчик */
                                    data: {
                                        "product_id": id
                                    },

                                }).done(function (data) {
                                    $("#sortable").html(data);
                                    $('.ckeditor').ckeditor();
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
                                    alert(vid);
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
                                        /* данные, которые мы передаем в файл-обработчик */
                                        data: {
                                            "image_id": vid,
                                            "param": "delete"
                                        },

                                    }).done(function (data) {
                                        if(data == 'deleted') {
                                            $("#image-" + vid).remove();
                                            showNotify('Удалено успешно!','Картинка ID: ' + vid + ' успешно удалена!');
                                        } else showNotify('Ошибка удаления картинки!','Возможно, картинка была удалена ранее', 'error');

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