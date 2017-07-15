<div data-widget-group="group2">
    <script type="text/javascript"
            src="/includes/assets/js/jqueryui-1.9.2.min.js"></script>
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


                        <form action="/admin/ajax/upload_files/categories/" class="dropzone">


                            <input type="hidden" name="category_id" value="<?= $category['id'] ?>"/>
                            <input type="hidden" name="show_in_bottom" value="1"/>
                            <input type="hidden" name="active" value="1"/>


                        </form>
                        <!--            </div>-->

                        <div id="adding-images">
                            <ul id="sortable">
                                <?php
                                $mImages = getModel('images');
                                $images = $mImages->getByCategoryId($category['id']);
                                if($images){
                                    foreach ($images as $image){
                                        showAddingCategoryFoto($image);
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
//                                $('.image_show_in_buttom').click(function () {
//                                    vid = $(this).attr('image_id');
//                                    if ($(this).attr("checked") == 'checked') {
//                                        vimage_show_in_buttom = 1;
//                                    } else {
//                                        vimage_show_in_buttom = 0;
//                                    }
//                                    $.ajax({
//                                        /* адрес файла-обработчика запроса */
//                                        url: '/admin/ajax/action_image/?image_id=' + vid + '&param=show_in_bottom&value=' + vimage_show_in_buttom,
//                                        /* метод отправки данных */
//                                        method: 'POST',
//                                        async: false,
//                                        /* данные, которые мы передаем в файл-обработчик */
//                                        data: {
//                                            "image_id": vid,
//                                            "param": "show_in_bottom",
//                                            "value": vimage_show_in_buttom
//                                        },
//
//                                    }).done(function (data) {
//                                        alert(data);
//                                    });
//                                });

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