<?php
include("application/views/admin/header.php");
?>
    <table width="100%" cellpadding="0" cellspacing="0">
        <tr>
            <td width="200px" valign="top"><?php include("application/views/admin/menu.php"); ?></td>
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
                        <div class="top_menu_link"><a href="/admin/mailer/">Рассылка</a></div>
                        <div class="top_menu_link"><a href="/admin/mailer/add/">Создать рассылку</a></div>
                    </div>
                    <?php include("application/views/admin/lang.php"); ?>
                    <strong><font color="Red"><?=$err?></font></strong>
             <form enctype="multipart/form-data" action="/admin/mailer/edit/<?=$mailer['id']?>/" method="post">
                <table>
                    <tr>
                        <td>Название *:</td>
                        <td>
                            <input required type="text" name="name" size="50" value="<?php if(isset($_POST['name'])) echo $_POST['name']; else echo $mailer['name'];?>" />
                        </td>

                    </tr>
                    
                    <tr>
                        <td>Значение *:</td>
                        <td>
                            <textarea class="adv_editor multilang" required name="content" cols="50" rows="5"><?php if(isset($_POST['content'])) echo $_POST['content']; else echo $mailer['content'];?></textarea>
                        </td>
                    </tr>

                    <tr>
                        <td>Дополнительные адреса (через запятую):</td>
                        <td>
                            <textarea  name="emails" cols="50" rows="5"><?php if(isset($_POST['emails'])) echo $_POST['emails'];else echo $mailer['emails'];?></textarea>
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
                            <?php
                            if($mailer['file'] != '' && $mailer['file'] != NULL){
                                echo '<a href="'.$mailer['file'].'" target="_blank">'.$mailer['file'].'</a><br />';
                                echo '<input type="checkbox" name="file_del"/> Удалить файл<br /><input type="hidden" name="file_old" value="'.$mailer['file'].'"  />';
                            }
                            ?>
                            <input type="file" name="userfile" />
                        </td>
                    </tr>
                    <tr><td colspan="2"><input type="checkbox" name="for_users"<? if($mailer['for_users']==1) echo ' checked'?> /> Отправить всем пользователям</td></tr>
                    <tr><td colspan="2"><input type="checkbox" name="for_organizations"<? if($mailer['for_organizations']==1) echo ' checked'?> /> Отправить всем организациям</td></tr>
                    <tr>
                        <td>Статус:</td>
                        <td>
                            Рассылка была запущена: <?=$mailer['started']?><br/>
                            Рассылка успешно завершена: <?=$mailer['ended']?><br/>
                        </td>
                    </tr>
                    
                    <tr>
                        <td colspan="2"><input type="submit" name="save" value="Изменить" /> <input type="submit" name="save_and_send" value="Сохранить и приступить" /></td>
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