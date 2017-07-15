<?php
include("header.php");
?>
    <table width="100%" cellpadding="0" cellspacing="0">
        <tr>
            <td width="200px" valign="top"><?php include("menu.php"); ?></td>
            <td width="20px"></td>
            <td valign="top">
                <div class="title_border">
                    <div class="content_title"><h1><?= $title ?></h1></div>
                    <div class="back_and_exit">

                        <span class="back_to_site"><a href="/" target="_blank" title="Открыть сайт в новом окне">Вернуться
                                на сайт ></a></span>
                        <span class="exit"><a href="/admin/login/logoff/">Выйти</a></span>
                    </div>
                </div>

                <div class="content">
                    <div class="top_menu">
                        <div class="top_menu_link"><a href="/admin/">Главная</a></div>
                        <div class="top_menu_link"><a href="/admin/main/edit/">Редактировать</a></div>
                    </div>
                    <?php include("lang.php"); ?>
                    <form action="/admin/main/edit/" method="post">
                        <table>
                            <tr>
                                <td>title:</td>
                                <td>
                                    <?php
                                    //$main['title'] = unserialize($main['title']);
                                    /*
                                    $main['title'] = array(
                                        'rus' => 'ru',
                                        'english' => 'english'
                                    );
                                    */
                                    ?>
                                    <input class="multilang <?= $langs[0] ?>" required type="text"
                                           name="<?= $langs[0] . '_title' ?>" size="50"
                                    <?php
                                    if (isset($_POST['title'][$langs[0]]))
                                        echo 'value="' . $_POST['title'][$langs[0]] . '" />';
                                    else
                                        echo (isset($main['title']) && $main['title'] != '') ?
                                            'value="' . $main['title'] . '"/>' :
                                            '/> <span class="multilang ' . $langs[0] . '">[' . $langs[0] . '] Нет данных</span>';
                                    ?>
                                    <?php
                                    for ($i = 1; $i < count($langs); $i++) { ?>
                                        <input class="hidden multilang <?= $langs[$i] ?>" type="text"
                                               name="<?= $langs[$i] . '_title' ?>" size="50"
                                        <?php if (isset($_POST['title'][$langs[$i]]))
                                            echo 'value="' . $_POST['title'][$langs[$i]] . '" />';
                                        else
                                            echo (isset($main['title_' . $langs[$i]]) && $main['title_' . $langs[$i]] != '') ?
                                                'value="' . $main['title_' . $langs[$i]] . '"/>' :
                                                '/> <span class="hidden multilang ' . $langs[$i] . '">[' . $langs[$i] . '] Нет данных</span>';
                                        ?>
                                        <?php
                                    }
                                    ?>
                                </td>
                            </tr>
                            <tr>
                                <td>keywords:</td>
                                <td>
                                    <?php
                                    //$main['keywords'] = unserialize($main['keywords']);

                                    ?>
                                    <textarea class="multilang <?= $langs[0] ?> " name="<?= $langs[0] . '_keywords' ?>"><?php
                                        if (isset($_POST['keywords'][$langs[0]]) && !empty($_POST['keywords'][$langs[0]])) echo $_POST['keywords'][$langs[0]];
                                        else echo (isset($main['keywords']) && $main['keywords'] != '') ?
                                            $main['keywords'] . '</textarea>' :
                                            '</textarea><span class="multilang ' . $langs[0] . '">[' . $langs[0] . '] Нет данных</span>';
                                        ?>
                                        <?php
                                        for ($i = 1;
                                        $i < count($langs);
                                        $i++) { ?>
                                        <textarea class="hidden multilang <?= $langs[$i] ?> "
                                                  name="<?= $langs[$i] . '_keywords' ?>"><?php
                                            if (isset($_POST['keywords'][$langs[$i]]) && !empty($_POST['keywords'][$langs[$i]])) echo $_POST['keywords'][$langs[$i]];
                                            else echo (isset($main['keywords_' . $langs[$i]]) && $main['keywords_' . $langs[$i]] != '') ?
                                                $main['keywords_' . $langs[$i]] . '</textarea>' :
                                                '</textarea><span class="hidden multilang ' . $langs[$i] . '">[' . $langs[$i] . '] Нет данных</span>';
                                            ?>
                                            <?php
                                            } ?>
                                </td>
                            </tr>
                            <tr>
                                <td>description:</td>
                                <td>
                                    <?php
                                    //$main['description'] = unserialize($main['description']);

                                    ?>
                                    <textarea class="multilang <?= $langs[0] ?> "
                                              name="<?= $langs[0] . '_description' ?>"><?php
                                        if (isset($_POST['description'][$langs[0]]) && !empty($_POST['description'][$langs[0]])) echo $_POST['description'][$langs[0]];
                                        else echo (isset($main['description']) && $main['description'] != '') ?
                                            $main['description'] . '</textarea>' :
                                            '</textarea><span class="multilang ' . $langs[0] . '">[' . $langs[0] . '] Нет данных</span>';
                                        ?>
                                        <?php
                                        for ($i = 1;
                                        $i < count($langs);
                                        $i++) { ?>
                                        <textarea class="hidden multilang <?= $langs[$i] ?> "
                                                  name="<?= $langs[$i] . '_description' ?>"><?php
                                            if (isset($_POST['description'][$langs[$i]]) && !empty($_POST['description'][$langs[$i]])) echo $_POST['description'][$langs[$i]];
                                            else echo (isset($main['description_' . $langs[$i]]) && $main['description_' . $langs[$i]] != '') ?
                                                $main['description_' . $langs[$i]] . '</textarea>' :
                                                '</textarea><span class="hidden multilang ' . $langs[$i] . '">[' . $langs[$i] . '] Нет данных</span>';
                                            ?>
                                            <?php
                                            } ?>
                                </td>
                            </tr>
                            <tr>
                                <td>Заголовок H1:</td>
                                <td>
                                    <?php
                                    //$main['h1'] = unserialize($main['h1']);

                                    ?>
                                    <input class="multilang <?= $langs[0] ?>" required type="text"
                                           name="<?= $langs[0] . '_h1' ?>" size="50"
                                    <?php
                                    if (isset($_POST['h1'][$langs[0]]) && !empty($_POST['h1'][$langs[0]]))
                                        echo $_POST['h1'][$langs[0]];
                                    else
                                        echo (isset($main['h1']) && $main['h1'] != '') ?
                                            'value="' . $main['h1'] . '"/>' :
                                            '/> <span class="multilang ' . $langs[0] . '">[' . $langs[0] . '] Нет данных</span>';
                                    ?>
                                    <?php
                                    for ($i = 1; $i < count($langs); $i++) { ?>
                                        <input class="hidden multilang <?= $langs[$i] ?>" type="text"
                                               name="<?= $langs[$i] . '_h1' ?>" size="50"
                                        <?php
                                        if (isset($_POST['h1'][$langs[$i]]) && !empty($_POST['h1'][$langs[$i]]))
                                            echo $_POST['h1'][$langs[$i]];
                                        else
                                            echo (isset($main['h1_' . $langs[$i]]) && $main['h1_' . $langs[$i]] != '') ?
                                                'value="' . $main['h1_' . $langs[$i]] . '"/>' :
                                                '/> <span class="hidden multilang ' . $langs[$i] . '">[' . $langs[$i] . '] Нет данных</span>';
                                        ?>
                                        <?php
                                    } ?>
                                </td>
                            </tr>
                            <tr>
                                <td>Контент:</td>
                                <td>
                                    <?php
                                    //$main['seo'] = unserialize($main['seo']);

                                    ?>
                                    <textarea class=" multilang <?= $langs[0] ?> ckeditor" rows="30" type="text"
                                              name="<?= $langs[0] . '_content' ?>">
                                        <?php if (isset($_POST['content'][$langs[0]]) && !empty($_POST['content'][$langs[0]])) echo $_POST['content'][$langs[0]];
                                        else echo (isset($main['content']) && $main['content'] != '') ?
                                            $main['content'] . '</textarea>' :
                                            '</textarea><span class="multilang ' . $langs[0] . '">[' . $langs[0] . '] Нет данных</span>';
                                        ?>
                                        <?php
                                        for ($i = 1;
                                        $i < count($langs);
                                        $i++) { ?>
                                        <textarea class="hidden multilang <?= $langs[$i] ?> adv_editor" rows="30"
                                                  type="text" name="<?= $langs[$i] . '_content' ?>">
                                            <?php if (isset($_POST['content'][$langs[$i]]) && !empty($_POST['content'][$langs[$i]])) echo $_POST['content'][$langs[$i]];
                                            else echo (isset($main['content_' . $langs[$i]]) && $main['content_' . $langs[$i]] != '') ?
                                                $main['content_' . $langs[$i]] . '</textarea>' :
                                                '</textarea><span class="hidden multilang ' . $langs[$i] . '">[' . $langs[$i] . '] Нет данных</span>';
                                            ?>
                                            <?php
                                            } ?>
                                </td>
                            </tr>

                            <tr>
                                <td>SEO:</td>
                                <td>
                                    <?php
                                    //$main['seo'] = unserialize($main['seo']);

                                    ?>
                                    <textarea class=" multilang <?= $langs[0] ?> ckeditor" rows="30" type="text"
                                              name="<?= $langs[0] . '_seo' ?>">
                                        <?php if (isset($_POST['seo'][$langs[0]]) && !empty($_POST['seo'][$langs[0]])) echo $_POST['seo'][$langs[0]];
                                        else echo (isset($main['seo']) && $main['seo'] != '') ?
                                            $main['seo'] . '</textarea>' :
                                            '</textarea><span class="multilang ' . $langs[0] . '">[' . $langs[0] . '] Нет данных</span>';
                                        ?>
                                        <?php
                                        for ($i = 1;
                                        $i < count($langs);
                                        $i++) { ?>
                                        <textarea class="hidden multilang <?= $langs[$i] ?> adv_editor" rows="30"
                                                  type="text" name="<?= $langs[$i] . '_seo' ?>">
                                            <?php if (isset($_POST['seo'][$langs[$i]]) && !empty($_POST['seo'][$langs[$i]])) echo $_POST['seo'][$langs[$i]];
                                            else echo (isset($main['seo_' . $langs[$i]]) && $main['seo_' . $langs[$i]] != '') ?
                                                $main['seo_' . $langs[$i]] . '</textarea>' :
                                                '</textarea><span class="hidden multilang ' . $langs[$i] . '">[' . $langs[$i] . '] Нет данных</span>';
                                            ?>
                                            <?php
                                            } ?>
                                </td>
                            </tr>

                            <tr>
                                <td valign="top">Доп. скрипты в head:</td>
                                <td><textarea style="width: 80%; height: 300px"
                                        name="adding_scripts"><?php if (isset($_POST['adding_scripts'])) echo $_POST['adding_scripts']; else echo $main['adding_scripts']; ?></textarea>
                                </td>
                            </tr>

                            <tr>
                                <td colspan="2"><input type="submit" value="Изменить" name="save"/></td>
                            </tr>
                        </table>
                    </form>

                </div>

            </td>
        </tr>
    </table>
    <script type="text/javascript">
        $('.adv_editor').not('.hidden').ckeditor();
    </script>
<?php
include("footer.php");
?>