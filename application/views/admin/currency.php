<?php
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
                    <div class="top_menu_link"><a href="/admin/currency/">Валюты</a></div>
                    <div class="top_menu_link"><a href="/admin/currency/add/">Добавить валюту</a></div>
                </div>

                <table width="100%" cellpadding="1" cellspacing="1">
                    <tr bgcolor="#EEEEEE">
    
                        <th>Название</th>
                        <th>Код</th>
                        <th>Отображение</th>
                        <th>Коэффициент</th>
                        <th>Основная</th>
                        <th>Позиция</th>
                        <th>Вверх/Вниз</th>
                        <th>Действия</th>
    
                    </tr>
                    <?php
                    $count = count($pages);
                    for($i = 0; $i < $count; $i++)
                    {
                        $page = $pages[$i];
                        ?>
                        <tr class="list">
                            <td><a href="/admin/currency/edit/<?=$page['id']?>/" title="Перейти к редактированию"><?=$page['name']?></a></td>
                            <td><?=$page['code']?></td>
                            <td><?=$page['view']?></td>
                            <td><?=$page['rate']?></td>
                            <td>
                                <?php
                                if($page['main'] == 1) echo 'Да'; else echo 'Нет';
                                ?>
                            </td>
                            <td><?=$page['num']?></td>
                            <td><a href="/admin/currency/up/<?=$page['id']?>/"><img src="/img/uparrow.png" border="0" alt="Вверх" title="Вверх" /></a><a href="/admin/currency/down/<?=$page['id']?>/"><img src="/img/downarrow.png" border="0" alt="Вниз" title="Вниз" /></a></td>
                            
                            <td>
                                <a href="/admin/currency/active/<?=$page['id']?>/"><?php
                                if($page['active'] == 1)
                                    echo '<img src="/img/visible.png" width="16px" height="16px" border="0" title="Деактивация" />';
                                else
                                    echo '<img src="/img/not-visible.png" width="16px" height="16px" border="0" title="Активация" />';
                                ?></a>
                                <a href="/admin/currency/edit/<?=$page['id']?>/"><img src="/img/edit.png" width="16px" height="16px" border="0" title="Редактировать" /></a>
                                <a onclick="return confirm('Удалить?')" href="/admin/currency/del/<?=$page['id']?>/"><img src="/img/del.png" border="0" alt="Удалить" title="Удалить" /></a>
                            </td>
                        </tr>
                        <?php
                    }
                    ?>
                </table>
            </div>
        </td>
    </tr>
</table>
<?php
include("footer.php");
?>