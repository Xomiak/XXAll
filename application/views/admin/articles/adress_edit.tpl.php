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
                    <?php
                    include("application/views/admin/articles/articles_menu.inc.php");
                    ?>
                    <?php include("application/views/admin/lang.php"); ?>

                    <form enctype="multipart/form-data" action="<?=$_SERVER['REQUEST_URI']?>" method="post">
                        <table style="width: 100%">
                            <tr>
                                <td>Адрес *:</td>
                                <td><input required type="text" name="adress" size="50" value="<?php if(isset($_POST['adress'])) echo $_POST['adress']; else echo $adress['adress'];?>" /></td>
                            </tr>
                            <tr>
                                <td>Город *:</td>
                                <td><input required type="text" name="city" size="50" value="<?php if(isset($_POST['city'])) echo $_POST['city']; else echo $adress['city'];?>" /></td>
                            </tr>

                            <tr style="background-color: gainsboro">
                                <td colspan="2">
                                    Поиск по адресу: <input type="text" name="searchByAdress" value="" size="76" />
                                    <?=$map['html']?>
                                </td>
                            </tr>

                            <tr>
                                <td>Организация:</td>
                                <td>
                                    <?php
                                    $org = $this->articles->getArticleById($adress['article_id']);
                                    if($org){
                                    ?>
                                        <a href="/admin/articles/edit/<?=$adress['article_id']?>/" target="_blank"><?=$org['name']?></a>
                                   <?php } ?>
                                </td>
                            </tr>

                            <tr>
                                <td>Широта:</td>
                                <td><input id="coordsLat" required type="text" name="lat" size="50" value="<?php if(isset($_POST['lat'])) echo $_POST['lat']; else echo $adress['lat'];?>" /></td>
                            </tr>

                            <tr>
                                <td>Долгота:</td>
                                <td><input id="coordsLng" required type="text" name="lng" size="50" value="<?php if(isset($_POST['lng'])) echo $_POST['lng']; else echo $adress['lng'];?>" /></td>
                            </tr>


                            <tr>
                                <td valign="top">Фото:</td>
                                <td>
                                    <?php
                                    if($adress['icon'] != '')
                                    {
                                        echo '<img src="'.$adress['icon'].'" /><br /><input type="checkbox" name="icon_del">Удалить<br />';
                                    }
                                    ?>
                                    <input type="file" name="userfile" />
                                    <input type="hidden" name="icon" value="<?=$adress['icon']?>" />
                                </td>
                            </tr>
                            <tr>
                                <td>Описание:</td>
                                <td>
                                    <textarea name="description"><?=$adress['description']?></textarea>
                                </td>
                            </tr>

                            <script type="text/javascript">
                                $('.adv_editor').not('.hidden').ckeditor();
                            </script>

                            <tr>
                                <td colspan="2"><input type="checkbox" name="active"<? if($adress['active']==1) echo ' checked'?> /> Активный</td>
                            </tr>
                            <tr>
                                <td><input type="submit" name="save" value="Сохранить" /></td>
                                <td><input type="submit" name="save_and_stay" value="Сохранить и остаться" /></td>
                            </tr>
                        </table>
                    </form>
                </div>
            </td>
        </tr>
    </table>
<?php
include("application/views/admin/footer.php");
?>