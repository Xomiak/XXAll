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
                    <form enctype="multipart/form-data" action="<?=$_SERVER['REQUEST_URI']?>" method="post">
                        <input type="hidden" name="action" value="create">
                        <input type="submit" value="Создать бэкап">
                    </form>

                    <?=$msg?>

                    <strong>Сохранённые бэкапы:</strong>
                    <ul>
                    <?php
                    if($files){
                        foreach ($files as $file){
                            ?>
                            <li><a href="/admin/articles/backup/"><?=$file?></a></li>
                            <?php
                        }
                    }
                    ?>
                    </ul>



                </div>
            </td>
        </tr>
    </table>
<?php
include("application/views/admin/footer.php");
?>