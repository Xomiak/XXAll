<?php
include("application/views/admin/header.php");
?>
    <table width="100%" cellpadding="0" cellspacing="0">
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
                    <div class="top_menu">
                        <div class="top_menu_link"><a href="/admin/mailer/">Рассылка</a></div>
                        <div class="top_menu_link"><a href="/admin/mailer/add/">Создать рассылку</a></div>
                    </div>
                    <?php include("application/views/admin/lang.php"); ?>
                    <strong><font color="Red"><?= $err ?></font></strong>
             <form enctype="multipart/form-data" action="/admin/mailer/add/" method="post">
                <table>
                    <tr>
                        <td>Название *:</td>
                        <td>
                            <input  type="text" name="name" size="50" value="<?php if(isset($_POST['name'])) echo $_POST['name'];?>" />
                            <?php
                            if(isset($err['name']))
                            {
                                ?>
                                <div class="error"><?=$err['name']?></div>
                                <?php
                            }
                            ?>
                        </td>
                    </tr>
                    
                    <tr>
                        <td>Контент *:</td>
                        <td>
                            <textarea class="adv_editor multilang"  name="content" cols="50" rows="5"><?php if(isset($_POST['content'])) echo $_POST['content'];?></textarea>
                            <?php
                            if(isset($err['value']))
                            {
                                ?>
                                <div class="error"><?=$err['value']?></div>
                                <?php
                            }
                            ?>
                        </td>
                    </tr>

                    <tr>
                        <td>Дополнительные адреса (через запятую):</td>
                        <td>
                            <textarea  name="emails" cols="50" rows="5"><?php if(isset($_POST['emails'])) echo $_POST['emails'];?></textarea>
                            <?php
                            if(isset($err['value']))
                            {
                                ?>
                                <div class="error"><?=$err['value']?></div>
                                <?php
                            }
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <td>Прикрепить файл:</td>
                        <td>
                            <input type="file" name="userfile" />
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2"><input type="checkbox" name="for_users" checked /> Отправить всем пользователям</td>
                    </tr>
                    <tr>
                        <td colspan="2"><input type="checkbox" name="for_organizations" checked /> Отправить всем организациям</td>
                    </tr>
                    <tr>
                        <td colspan="2"><input type="submit" value="Добавить" /></td>
                    </tr>
                </table>
            </form>
                    <script type="text/javascript">
                        $('.adv_editor').not('.hidden').ckeditor();
                    </script>
                </div>
            </td>
        </tr>
    </table>
<?php
include("application/views/admin/footer.php");
?>