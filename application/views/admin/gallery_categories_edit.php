<?php
$languages = $this->model_languages->getLanguages();
include("header.php");
?>
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
                    <div class="top_menu_link"><a href="/admin/gallery/">Галерея</a></div>
                    <div class="top_menu_link"><a href="/admin/gallery/add/">Добавить фотку</a></div>
                    <div class="top_menu_link"><a href="/admin/gallery/zip_import/">Импорт zip архива</a></div>
                    <div class="top_menu_link"><a href="/admin/gallery/categories/">Разделы галереи</a></div>
                    <div class="top_menu_link"><a href="/admin/gallery/categories/add/">Добавить раздел галереи</a></div>                    
                    <div class="top_menu_link"><a href="/admin/options/set_module/gallery/">Настройки галереи</a></div>
                </div>
                <?php include("lang.php"); ?>
                <strong><font color="Red"><?=$err?></font></strong>
                <form enctype="multipart/form-data" action="/admin/gallery/categories/edit/<?=$category['id']?>/" method="post">
                    <table>
                        <tr>
                            <td>Название *:</td>
                            <td>
                                <?php

                                //$cat['name'] = unserialize($cat['name']); ?>
                                <input class="multilang <?= $langs[0] ?>" required type="text"
                                       name="<?= $langs[0] . '_name' ?>" size="50"
                                <?php

                                if (isset($_POST['name'][$langs[0]]))
                                    echo 'value="' . $_POST['name'][$langs[0]] . '" />';
                                else
                                    echo (isset($cat['name'][$langs[0]]) && $cat['name'][$langs[0]] != '') ?
                                        'value="' . $cat['name'] . '"/>' :
                                        '/> <span class="multilang ' . $langs[0] . '">[' . $langs[0] . '] Нет данных</span>';
                                ?>
                                <?php
                                for ($i = 1; $i < count($langs); $i++) {
                                    $lang = $langs[$i];
                                    ?>
                                    <input class="hidden multilang <?= $langs[$i] ?>" type="text"
                                           name="<?= $langs[$i] . '_name' ?>" size="50"
                                    <?php if (isset($_POST['name'][$langs[$i]]))
                                        echo 'value="' . $_POST['name'][$langs[$i]] . '" />';
                                    else
                                        echo (isset($cat['name_'.$langs[$i]]) && $cat['name_'.$langs[$i]] != '') ?
                                            'value="' . $cat['name_'.$langs[$i]] . '"/>' :
                                            '/> <span class="multilang ' . $langs[$i] . '">[' . $langs[$i] . '] Нет данных</span>';
                                    ?>
                                    <?php
                                }
                                ?>
                            </td>
                        </tr>
                        <tr>
                            <td>url:</td>
                            <td><input type="text" name="url" size="50" value="<?php if(isset($_POST['url'])) echo $_POST['url']; else echo $category['url']; ?>" /></td>
                            <td><span class="helper"><img src="/img/question.png" alt="Подсказка" title="Подсказка" width="16px" height="16px" /> Название категории в транслите. Используется в адресе</span></td>
                        </tr>
                        <tr>
                            <td>Имя папки:</td>
                            <td><input type="text" name="folder" size="50" value="<?php if(isset($_POST['folder'])) echo $_POST['folder']; else echo $category['folder'];?>" /></td>
                            <td><span class="helper"><img src="/img/question.png" alt="Подсказка" title="Подсказка" width="16px" height="16px" /> Имя папки на сервере, в котором будут храниться фотографии</span></td>
                        </tr>
                        <tr>
                            <td>Позиция:</td>
                            <td><input type="text" name="num" value="<?php if(isset($_POST['num'])) echo $_POST['num']; else echo $category['num']?>" size="3" /></td>
                        </tr>
                        <tr>
                            <td>Родительский раздел:</td>
                            <td>
                                <SELECT name="parent_id">
                                    <option value="0">нет</option>
                                    <?php
                                    if($categories)
                                    {
                                        $count = count($categories);
                                        for($i = 0; $i < $count; $i++)
                                        {
                                            $c = $categories[$i];
                                            echo '<option value="'.$c['id'].'"';
                                            if($c['id'] == $category['parent_id']) echo ' selected';
                                            echo '>'.$c['name'].'</option>';
                                        }
                                    }
                                    ?>
                                </SELECT>
                            </td>
                        </tr>
                        <tr>
                            <td>Фото раздела:</td>
                            <td>
                                <?php
                                if($category['image'] != '')
                                {
                                    echo '<img src="'.$category['image'].'" /><br /><input type="checkbox" name="image_del">Удалить<br />';
                                }
                                ?>
                                <input type="file" name="userfile" />
                                <input type="hidden" name="image" value="<?=$category['image']?>" />
                            </td>
                        </tr>
                        <tr>
                            <td>title:</td>
                            <td>
                                <?php //$cat['title'] = unserialize($cat['title']); ?>
                                <input class="multilang <?= $langs[0] ?>" type="text"
                                       name="<?= $langs[0] . '_title' ?>" size="50"
                                <?php
                                if (isset($_POST['title'][$langs[0]]) && !empty($_POST['title'][$langs[0]]))
                                    echo $_POST['title'][$langs[0]];
                                else
                                    echo (isset($cat['title']) && $cat['title'] != '') ?
                                        'value="' . $cat['title'] . '"/>' :
                                        '/> <span class="multilang ' . $langs[0] . '">[' . $langs[0] . '] Нет данных</span>';
                                ?>
                                <?php
                                for ($i = 1; $i < count($langs); $i++) {
                                    ?>
                                    <input class="hidden  multilang <?= $langs[$i] ?>" type="text"
                                           name="<?= $langs[$i] . '_title' ?>" size="50"
                                    <?php
                                    if (isset($_POST['title'][$langs[$i]]) && !empty($_POST['title'][$langs[$i]]))
                                        echo $_POST['title'][$langs[$i]];
                                    else
                                        echo (isset($cat['title_'.$langs[$i]]) && $cat['title_'.$langs[$i]] != '') ?
                                            'value="' . $cat['title_'.$langs[$i]] . '"/>' :
                                            '/> <span class="hidden multilang ' . $langs[$i] . '">[' . $langs[$i] . '] Нет данных</span>';
                                    ?>
                                    <?php
                                } ?>

                            </td>
                        </tr>
                        <tr>
                            <td>keywords:</td>
                            <td>
                                <?php //$cat['keywords'] = unserialize($cat['keywords']); ?>
                                <textarea class="multilang <?= $langs[0] ?> " name="<?= $langs[0] . '_keywords' ?>"><?php
                                    if (isset($_POST['keywords'][$langs[0]]) && !empty($_POST['keywords'][$langs[0]]))
                                        echo $_POST['keywords'][$langs[0]];
                                    else echo (isset($cat['keywords']) && $cat['keywords'] != '') ?
                                        $cat['keywords'] . '</textarea>' :
                                        '</textarea><span class="multilang ' . $langs[0] . '">[' . $langs[0] . '] Нет данных</span>';
                                    ?>
                                    <?php
                                    for ($i = 1;
                                    $i < count($langs);
                                    $i++) {
                                    ?>
                                    <textarea class="hidden multilang <?= $langs[$i] ?> "
                                              name="<?= $langs[$i] . '_keywords' ?>"><?php
                                        if (isset($_POST['keywords'][$langs[$i]]) && !empty($_POST['keywords'][$langs[$i]]))
                                            echo $_POST['keywords'][$langs[$i]];
                                        else echo (isset($cat['keywords_'.$langs[$i]]) && $cat['keywords_'.$langs[$i]] != '') ?
                                            $cat['keywords_'.$langs[$i]] . '</textarea>' :
                                            '</textarea><span class="hidden multilang ' . $langs[$i] . '">[' . $langs[$i] . '] Нет данных</span>';
                                        ?>
                                        <?php
                                        } ?>

                            </td>
                        </tr>
                        <tr>
                            <td>description:</td>
                            <td>
                                <?php //$cat['description'] = unserialize($cat['description']); ?>
                                <textarea class="multilang <?= $langs[0] ?> "
                                          name="<?= $langs[0] . '_description' ?>"><?php
                                    if (isset($_POST['description'][$langs[0]]) && !empty($_POST['description'][$langs[0]]))
                                        echo $_POST['description'][$langs[0]];
                                    else echo (isset($cat['description']) && $cat['description'] != '') ?
                                        $cat['description'] . '</textarea>' :
                                        '</textarea><span class="multilang ' . $langs[0] . '">[' . $langs[0] . '] Нет данных</span>';
                                    ?>
                                    <?php
                                    for ($i = 1;
                                    $i < count($langs);
                                    $i++) {
                                    ?>
                                    <textarea class="hidden multilang <?= $langs[$i] ?> "
                                              name="<?= $langs[$i] . '_description' ?>"><?php
                                        if (isset($_POST['description'][$langs[$i]]) && !empty($_POST['description'][$langs[$i]]))
                                            echo $_POST['description'][$langs[$i]];
                                        else echo (isset($cat['description_'.$langs[$i]]) && $cat['description_'.$langs[$i]] != '') ?
                                            $cat['description_'.$langs[$i]] . '</textarea>' :
                                            '</textarea><span class="hidden multilang ' . $langs[$i] . '">[' . $langs[$i] . '] Нет данных</span>';
                                        ?>
                                        <?php
                                        } ?>

                            </td>
                        </tr>
                        <tr>
                            <td>SEO текст:</td>
                            <td>
                                <?php //$cat['seo'] = unserialize($cat['seo']); ?>
                                <textarea class="multilang <?= $langs[0] ?> adv_editor" rows="30" type="text"
                                          name="<?= $langs[0] . '_seo' ?>">
				<?php if (isset($_POST['seo'][$langs[0]]) && !empty($_POST['seo'][$langs[0]]))
                    echo $_POST['seo'][$langs[0]];
                else echo (isset($cat['seo']) && $cat['seo'] != '') ?
                    $cat['seo'] . '</textarea>' :
                    '</textarea><span class="multilang ' . $langs[0] . '">[' . $langs[0] . '] Нет данных</span>';
                ?>
                                    <?php
                                    for ($i = 1;
                                    $i < count($langs);
                                    $i++) {
                                    ?>
                                    <textarea class="hidden multilang <?= $langs[$i] ?> adv_editor" rows="30"
                                              type="text" name="<?= $langs[$i] . '_seo' ?>">
					<?php if (isset($_POST['seo'][$langs[$i]]) && !empty($_POST['seo'][$langs[$i]]))
                        echo $_POST['seo'][$langs[$i]];
                    else echo (isset($cat['seo_'.$langs[$i]]) && $cat['seo_'.$langs[$i]] != '') ?
                        $cat['seo_'.$langs[$i]] . '</textarea>' :
                        '</textarea><span class="hidden multilang ' . $langs[$i] . '">[' . $langs[$i] . '] Нет данных</span>';
                    ?>
                    <?php
                    } ?>

                            </td>
                        </tr>
                        <script type="text/javascript">
                            $('.adv_editor').not('.hidden').ckeditor();
                        </script>
                        <tr>
                            <td colspan="2"><input type="checkbox" name="active"<?php if($category['active'] == '1') echo ' checked'?> /> Активный</td>
                        </tr>
                        <tr>
                            <td colspan="2"><input type="submit" value="Сохранить" /></td>
                        </tr>
                    </table>
                </form>
            </div>
        </td>
    </tr>
</table>
<?php
include("footer.php");
?>