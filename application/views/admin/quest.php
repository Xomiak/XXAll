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
                    <div class="top_menu_link">
                        <form method="post" action="/admin/quest/set_module/">
                            Выбор раздела:
                            <SELECT name="module" onchange="submit();">
                                <option value="all">Все</option>                    
                                <?php
                                if($modules)
                                {
                                    $count = count($modules);
                                    for($i = 0; $i < $count; $i++)
                                    {
                                        $m = $modules[$i];
                                        echo '<option value="'.$m['name'].'"';
                                        if($this->session->userdata('quest_module_name') == $m['name']) echo ' selected';
                                        echo '>'.$m['title'].'</option>';                           
                                    }
                                }
                                ?>
                            </SELECT>
                        </form>
                    </div>
                    <div class="top_menu_link"><a href="/admin/quest/">Вопросы</a></div>
                    <div class="top_menu_link"><a href="/admin/quest/add/">Добавить вопрос</a></div>
                </div>
                
            
                <table width="100%" cellpadding="1" cellspacing="1">
                    <tr bgcolor="#EEEEEE">
                        
                        <th>#</th>
                        <th>Название</th>
                        <th>Ответы</th>
                        <th>Действия</th>
                    </tr>
                    <?php
                    $count = count($quest);
                    for($i = 0; $i < $count; $i++)
                    {
                        $q = $quest[$i];
                        ?>
                        <tr class="list">
                            <td><a href="/admin/quest/edit/<?=$q['id']?>/" title="Перейти к редактированию"><?=$q['id']?></a></td>
                            <td><?=$q['name']?></td>
                            <td>
                                <table>
                                    <tr>
                                        <td><?=$q['value_1']?></td>
                                        <td><?php if($q['value_1_true'] == 1) echo '+'; else echo '-'; ?></td>
                                    </tr>
                                    <tr>
                                        <td><?=$q['value_2']?></td>
                                        <td><?php if($q['value_2_true'] == 1) echo '+'; else echo '-'; ?></td>
                                    </tr>
                                    <tr>
                                        <td><?=$q['value_3']?></td>
                                        <td><?php if($q['value_3_true'] == 1) echo '+'; else echo '-'; ?></td>
                                    </tr>
                                    <tr>
                                        <td><?=$q['value_4']?></td>
                                        <td><?php if($q['value_4_true'] == 1) echo '+'; else echo '-'; ?></td>
                                    </tr>
                                </table>
                            </td>
                            <td>                            
                                <a href="/admin/quest/edit/<?=$q['id']?>/"><img src="/img/edit.png" width="16px" height="16px" border="0" title="Редактировать" /></a>
                                
                                <a onclick="return confirm('Удалить?')" href="/admin/quest/del/<?=$q['id']?>/"><img src="/img/del.png" border="0" alt="Удалить" title="Удалить" /></a>
                                                         
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