<?php
include("application/views/admin/header.php");
?>
    <table class="article" width="100%" height="100%" cellpadding="0" cellspacing="0">
        <tr>
            <td width="200px" valign="top"><?php include("application/views/admin/menu.php"); ?></td>
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
                    <?php
                    include("application/views/admin/articles/articles_menu.inc.php");
                    ?>
                    <div class="top_menu">
                        
                        <div class="top_menu_link">
                            <form action="<?= $_SERVER['REQUEST_URI'] ?>" method="post">
                                Поиск:<input type="text" name="search"
                                             value="<?php if (isset($_POST['search'])) echo $_POST['search']; ?>"
                                             style="width:500px"/>
                                <input type="submit" value="Искать"/>
                            </form>
                        </div>
                    </div>

                    <div class="pagination"><?= $pager ?></div>
                    <script type="text/javascript">
                        $(document).ready(function () {
                            $("#maincheck").click(function () {
                                if ($('#maincheck').attr('checked')) {
                                    $('.mc').attr('checked', true);
                                } else {
                                    $('.mc').attr('checked', false);
                                }
                            });
                        });
                    </script>
                    <form method="post" action="<?= $_SERVER['REQUEST_URI'] ?>">
                        <input type="submit" name="delete" value="Удалить выбранные"
                               onclick="return confirm('Вы точно хотите УДАЛИТЬ выбранные?')"/>
                        <div id="res"></div>
                        <table width="100%" cellpadding="1" cellspacing="1">
                            <tr bgcolor="#EEEEEE">
                                <th><input type="checkbox" name="maincheck" id="maincheck" title="Выбрать все"/></th>
                                <th>Город</th>
                                <th>[ID] Адрес</th>
                                <th>Организация</th>

                                <th>Действия</th>
                            </tr>
                            <?php
                            if (isset($articles) && ($articles)) {

                                $count = count($articles);
                                for ($i = 0; $i < $count; $i++) {
                                    $article = $articles[$i];
                                    ?>
                                    <tr id="tr-<?= $article['id'] ?>" class="list">
                                        <td><input class="mc" type="checkbox" name="list[]"
                                                   value="<?= $article['id'] ?>"/></td>

                                        <td>
                                            <?=$article['city']?>
                                        </td>
                                        <td>
                                            <?php
                                            $name = trim(str_replace($article['city'].',','',$article['adress']));
                                            //var_dump($article['name']);
                                            ?>

                                            <a class="tooltip" title="Перейти к редактированию"
                                               href="/admin/articles/adress_edit/<?= $article['id'] ?>/">
                                                <?= $name ?>
                                            </a>

                                            <?php
                                            ?>
                                        </td>
                                        <td>
                                            <?php
                                            $art = $this->articles->getArticleById($article['article_id']);
                                            if ($art) {
                                                echo '<a href="/admin/articles/edit/' . $art['id'] . '/" title="Перейти к редактированию организации">' . $art['name'] . '</a>';
                                            }
                                            ?>
                                        </td>

                                        <td>
                                            <img class="row-active" row_id="<?= $article['id'] ?>" type="adresses"
                                                 status="<?= $article['active'] ?>"
                                                 id="row-active-<?= $article['id'] ?>"
                                                 src="/img/<?php if ($article['active'] == 0) echo 'not-' ?>visible.png"
                                                 width="16px" height="16px" border="0" title="Активация/Деактивация"/>
                                            <a href="/admin/articles/adress_edit/<?= $article['id'] ?>/"><img
                                                    src="/img/edit.png" width="16px" height="16px" border="0"
                                                    title="Редактировать"/></a>
                                            <img class="row-del" id="del-<?= $article['id'] ?>" type="adresses"
                                                 row_id="<?= $article['id'] ?>" src="/img/del.png" border="0"
                                                 alt="Удалить" title="Удалить"/>
                                    </tr>
                                    <?php
                                }
                            } else echo '<tr><td colspan="4">Ничего нет</td></tr>';
                            ?>
                        </table>
                    </form>
                    <br/>
                    <div class="pagination"><?= $pager ?></div>
                </div>
            </td>
        </tr>
    </table>

<?php
include("application/views/admin/footer.php");
?>