<?php
include("header.php");
?>
<table width="100%" cellpadding="0" cellspacing="0">
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
                    <div class="top_menu_link"><a href="/admin/currency/">Валюты</a></div>
                    <div class="top_menu_link"><a href="/admin/currency/add/">Добавить валюту</a></div>
                </div>
                <?php include("lang.php"); ?>
                <form enctype="multipart/form-data" action="<?=$_SERVER['REQUEST_URI']?>" method="post">
                    <input type="hidden" name="num" value="<?=$num?>" />
                    <table>
                        <tr>
                            <td>Название *:</td>
                            <td>
                                <input required type="text" name="name" value="<?php if(isset($_POST['name'])) echo $_POST['name']; elseif(isset($currency['name'])) echo $currency['name']; ?>" />
                            </td>
                        </tr>
                        <tr>
                            <td>Код *:</td>
                            <td>
                                <input required type="text" name="code" value="<?php if(isset($_POST['code'])) echo $_POST['code']; elseif(isset($currency['code'])) echo $currency['code']; ?>" />
                            </td>
                        </tr>
                        <tr>
                            <td>Отображение *:</td>
                            <td>
                                <input required type="text" name="view" value="<?php if(isset($_POST['view'])) echo $_POST['view']; elseif(isset($currency['view'])) echo $currency['view']; ?>" />
                            </td>
                        </tr>
                        <tr>
                            <td>Коэффициент *:</td>
                            <td>
                                <input required type="text" name="rate" value="<?php if(isset($_POST['rate'])) echo $_POST['rate']; elseif(isset($currency['rate'])) echo $currency['rate']; else echo '1'; ?>" />
                            </td>
                        </tr>
                        
			<tr>
                            <td colspan="2"><input type="checkbox" name="main" <?php if(isset($currency['main']) && $currency['main'] == 1) echo 'checked'; ?> /> Основная валюта</td>
                        </tr>
                        <tr>
                            <td colspan="2"><input type="checkbox" name="active" <?php if(isset($currency['active']) && $currency['active'] == 1) echo 'checked'; ?> /> Активный</td>
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