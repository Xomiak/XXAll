<?php if(isset($head)) echo $head; ?>
    <!-- подключение галлереи-библиотеки для изображений -->
    <script src="/libs/jquery/jquery-1.7.2.min.js"></script>
    <link rel="stylesheet" href="/libs/magnific-popup/magnific-popup.css">

<?php if(isset($header)) echo $header; ?>
qwe
    <table width="100%" height="100%" cellpadding="0" cellspacing="0">
        <tr>
            <td width="200px" valign="top"><?php include("menu.php"); ?></td>
            <td width="20px"></td>
            <td valign="top">
                <div class="title_border">
                    <div class="content_title"><h1><?=$title?></h1></div>
                    <div class="back_and_exit">

                        <span class="back_to_site"><a href="/" target="_blank" title="Открыть сайт в новом окне">Вернуться на сайт ></a></span>
                        <span class="exit"><a href="/admin/login/logoff/">Выйти</a></span>
                    </div>
                </div>

                <div class="content">
                    <div class="top_menu">
                        <div class="top_menu_link">
                            <form method="post" action="/admin/gallery/set_category/" style="float: left;">
                                Выбор альбома:
                                <SELECT name="category_id" onchange="submit();">
                                    <option value="all">Все</option>
                                    <?php
                                    $count = count($categories);
                                    for($i = 0; $i < $count; $i++)
                                    {
                                        $cat = $categories[$i];
                                        echo '<option value="'.$cat['id'].'"';
                                        if($this->session->userdata('gallery_category_id') == $cat['id']) echo ' selected';
                                        echo '>'.$cat['name'].'</option>';
//                                    $subcats = $this->gallery->getSubCategories($cat['id']);
//                                    if($subcats)
//                                    {
//                                        $subcount = count($subcats);
//                                        for($j = 0; $j < $subcount; $j++)
//                                        {
//                                            $sub = $subcats[$j];
//                                            echo '<option value="'.$sub['id'].'"';
//                                            if($this->session->userdata('gallery_category_id') == $sub['id']) echo ' selected';
//                                            echo '>&nbsp;└&nbsp;'.$sub['name'].'</option>';
//                                        }
//                                    }
                                    }
                                    ?>
                                </SELECT>
                            </form>
                        </div>
                        <div class="top_menu_link"><a href="/admin/gallery/">Галерея</a></div>
                        <div class="top_menu_link"><a href="/admin/gallery/add/">Добавить фотку</a></div>
                        <div class="top_menu_link"><a href="/admin/gallery/zip_import/">Импорт zip архива</a></div>
                        <div class="top_menu_link"><a href="/admin/gallery/categories/">Разделы галереи</a></div>
                        <div class="top_menu_link"><a href="/admin/gallery/categories/add/">Добавить раздел галереи</a></div>
                        <div class="top_menu_link"><a href="/admin/options/set_module/gallery/">Настройки галереи</a></div>
                    </div>

                    <div class="pagination"><?=$pager?></div>
                    <?php
                    if(userdata('gallery_category_id') !== false)
                    {
                        ?>
                        <!-- Создаем поле в которое мы будим переносить наши файлы -->
                        <div id="dropbox">
                            <!-- Напишем пояснительную записку в которой укажем что файлы необходимо кидать именно сюда -->
                            <span class="message">Перенесите сюда изображения для загрузки</span>
                        </div>
                        <?php
                    }
                    ?>
                    <script type="text/javascript">
                        $(document).ready( function() {
                            $("#maincheck").click( function() {
                                if($('#maincheck').attr('checked')){
                                    $('.mc').attr('checked', true);
                                } else {
                                    $('.mc').attr('checked', false);
                                }
                            });
                        });
                    </script>
                    <form method="post" action="<?=$_SERVER['REQUEST_URI']?>">
                        <input type="submit" name="delete" value="Удалить выбранные" onclick="return confirm('Вы точно хотите УДАЛИТЬ выбранные?')" />
                        <table width="100%" cellpadding="1" cellspacing="1">
                            <tr bgcolor="#EEEEEE">
                                <th><input type="checkbox" name="maincheck" id="maincheck" title="Выбрать все" /></th>
                                <th width="200px">Фото</th>
                                <th>Название</th>
                                <th>Позиция</th>
                                <th>Вверх/Вниз</th>
                                <th>Действия</th>
                            </tr>
                            <?php
                            $count = count($images);
                            for($i = 0; $i < $count; $i++)
                            {
                                $img = $images[$i];
                                $category = $this->gallery->getCategoryById($img['category_id']);
                                $folder = $category['url'];
                                //if($category['folder'] != '') $folder = 'categories/'.$category['folder'].'/';
                                $thumb = '';

                                ?>
                                <tr class="list">
                                    <td><input class="mc" type="checkbox" name="list[]" value="<?=$img['id']?>" /></td>
                                    <td>
                                        <div class="popup-gallery">
                                            <a href="<?=$img['image']?>"><img class="preview" src="<?=$img['image']?>" height="120" width="auto" /></a>
                                        </div>
                                    </td>
                                    <td><a href="<?=$img['image']?>" target="_blank" title="Открыть фото"><?=$img['image']?></a></td>
                                    <td><?=$img['num']?></td>
                                    <td><a href="/admin/gallery/up/<?=$img['id']?>/"><img src="/img/uparrow.png" border="0" alt="Вверх" title="Вверх" /></a>
                                        <a href="/admin/gallery/down/<?=$img['id']?>/"><img src="/img/downarrow.png" border="0" alt="Вниз" title="Вниз" /></a></td>

                                    <td>
                                        <a href="/admin/gallery/active/<?=$img['id']?>/"><?php
                                            if($img['active'] == 1)
                                                echo '<img src="/img/visible.png" width="16px" height="16px" border="0" title="Деактивировать" />';
                                            else
                                                echo '<img src="/img/not-visible.png" width="16px" height="16px" border="0" title="Активировать" />';
                                            ?></a>
                                        <a href="/admin/gallery/edit/<?=$img['id']?>/"><img src="/img/edit.png" width="16px" height="16px" border="0" title="Редактировать" /></a>
                                        <a onclick="return confirm('Удалить?')" href="/admin/gallery/del/<?=$img['id']?>/"><img src="/img/del.png" border="0" alt="Удалить" title="Удалить" /></a></td>
                                </tr>
                                <?php
                            }
                            ?>
                        </table>
                    </form>
                    <div class="pagination"><?=$pager?></div>
                </div>
            </td>
        </tr>
    </table>
    <script>
        $(function(){

            var dropbox = $('#dropbox'),
                message = $('.message', dropbox);

            dropbox.filedrop({
                paramname:'pic',

                maxfiles: 50,
                maxfilesize: 2,
                url: '/admin/ajax/upload_files/gallery/',

                uploadFinished:function(i,file,response){
                    $.data(file).addClass('done');
                },

                error: function(err, file) {
                    switch(err) {
                        case 'BrowserNotSupported':
                            showMessage('Ваш Браузер не поддерживает HTML5!');
                            break;
                        case 'TooManyFiles':
                            alert('Разрешено загружать за 1 раз не более 5 изображений');
                            break;
                        case 'FileTooLarge':
                            alert(file.name+' Слишком большой.Разрешена загрузка файлов не более 2мб.');
                            break;
                        default:
                            break;
                    }
                },

                beforeEach: function(file){
                    if(!file.type.match(/^image\//)){
                        alert('Разрешена загрузка только изображений!!!!');
                        return false;
                    }
                },

                uploadStarted:function(i, file, len){
                    createImage(file);
                },

                progressUpdated: function(i, file, progress) {
                    $.data(file).find('.progress').width(progress);
                }

            });

            var template = '<div class="preview">'+
                '<span class="imageHolder">'+
                '<img />'+
                '<span class="uploaded"></span>'+
                '</span>'+
                '<div class="progressHolder">'+
                '<div class="progress"></div>'+
                '</div>'+
                '</div>';


            function createImage(file){

                var preview = $(template),
                    image = $('img', preview);

                var reader = new FileReader();

                image.width = 100;
                image.height = 100;

                reader.onload = function(e){

                    image.attr('src',e.target.result);
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



<?php
$adding_scripts = "
<script src=\"/libs/magnific-popup/jquery.magnific-popup.min.js\"></script>
<script src=\"/js/main.js\"></script>
";
if(isset($footer)) {
    $footer = str_replace('[adding_scripts]', $adding_scripts, $footer);
    echo $footer;
}
?>