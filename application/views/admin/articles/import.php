<?php
include("application/views/admin/header.php");
?>
    <table width="100%" height="100%" cellpadding="0" cellspacing="0">
        <tr>
            <td width="200px" valign="top"><?php include("application/views/admin/menu.php"); ?></td>
            <td width="20px"></td>
            <td valign="top">
                <div class="title_border">
                    <div class="content_title"><h1><?=$title?></h1></div>
                    <div class="back_and_exit">
                        русский <a href="/en<?=$_SERVER['REQUEST_URI']?>">english</a>
                        <span class="back_to_site"><a href="/" target="_blank" title="Открыть сайт в новом окне">Вернуться на сайт ></a></span>
                        <span class="exit"><a href="/admin/login/logoff/">Выйти</a></span>
                    </div>
                </div>

                <div class="content">
                    <?php
                    include("application/views/admin/articles/articles_menu.inc.php");
                    ?>

                    <?=$msg?>

                    <form enctype="multipart/form-data" action="<?=$_SERVER['REQUEST_URI']?>" method="post">
                        <table>
                            <tr>
                                <td>XLS/XLSX файл:</td>
                                <td><input required type="file" name="userfile" /></td>
                            </tr>
                            <!--tr>
                                <td><input type="checkbox" name="price_only" checked />Только цены</td>
                                        </tr-->

                            <tr>
                                <td colspan="2"><input type="submit" value="Добавить" /></td>
                            </tr>
                        </table>
                    </form>
                    <!--div class="helps">
                        <p>* Для добавления товаров через csv файл, необходимо скачать и заполить следующий файл: <a href="/images/import.csv">import.csv</a></p>
                        <strong>Описание правильности заполнения ячеек</strong>
                        <table border="1" cellpadding="1" cellspacing="1">
                            <tbody>
                            <tr>
                                <td>ID товара</td>
                                <td>Необходимо ТОЛЬКО при редактировании уже имеющихся позиций. При добавлении новой - оставить пустым!</td>
                            </tr>
                            <tr>
                                <td>ID раздела *</td>
                                <td>ID раздела, в который добавляется позиция. ID Ваших разделов можно посмотреть в <a href="/admin/categories/" target="_blank">Разделах</a>.<br />
                                    Если необходимо указать несколько разделов, то ID разделяются знаком *</td>
                            </tr>
                            <tr>
                                <td>Бренд</td>
                                <td>Название бренда.<br />
                                    Если такого бренда ещё нет, он будет создан.</td>
                            </tr>
                            <tr>
                                <td>Название*</td>
                                <td>ОБЯЗАТЕЛЬНОЕ ПОЛЕ</td>
                            </tr>
                            <tr>
                                <td>Размеры</td>
                                <td>Если Вам необходимо указать несколько размеров, разделяйте их символом |<br />
                                    Если такого размера нет в списке возможных размеров, возможны ошибки в работе! Сперва, убидитесь, что размер указан в настройках: <a href="/admin/options/edit/113/" target="_blank">Настройки размеров</a></td>
                            </tr>
                            <tr>
                                <td>Фото</td>
                                <td>Относительный путь к фото на сервере</td>
                            </tr>
                            <tr>
                                <td>Youtube</td>
                                <td>Идентификатор необходимого видео.<br />
                                    Например, для видео: http://www.youtube.com/watch?v=<strong>tE-1KDlbbh4</strong><br />
                                    Код видео: <strong>tE-1KDlbbh4</strong></td>
                            </tr>
                            </tbody>
                        </table>
                    </div-->
                </div>
            </td>
        </tr>
    </table>
<?php
include("application/views/admin/footer.php");
?>