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
            
            <script>
                $(function () {
                    $('.img_button').click(function () {
                        var res = this.parentNode.parentNode.id;                        
                        var noeditId = res;
                        if (res.indexOf('noedit') == -1) {
                            noeditId = res.replace("edit","noedit");
                        }
                        var editId = noeditId.replace("noedit","edit");
                       
                        switch ($(this).attr('data-action')) {
                            case 'edit':
                                console.log('edit');
                                $("#"+noeditId).hide();
                                $("#"+editId).show();
                                break;
                            case 'cancel':
                                console.log('cancel edit');
                                $("#"+editId).hide();
                                $("#"+noeditId).show();
                                break;
                        }
                       // alert(noeditId);
                        //alert(editId);
                        //$form = getParentForm($(this));
                        //console.log($form);
                    });
                });
            </script>
            
            <div class="content">
                <div class="top_menu">
                    <div class = "top_menu_link"><a href = "/admin/filters/">Фильтры</a></div>
                    <div class = "top_menu_link"><a href = "/admin/filters/langs/">Языковые настройки фильтров</a></div>
                </div>
                <div class="top_menu filters_form">
                    <form method="post" action="<?=request_uri()?>">
                        <select name="lang_lang" onchange="this.form.submit()">
                            <option selected value="false">- Все языки -</option>
                            <?php
                            $count = count($langs);
                            for($i = 1; $i < $count; $i++)
                            {
                                
                                echo '<option';
                                if(userdata('lang_lang') == $langs[$i]) echo ' selected';
                                echo ' value="'.$langs[$i].'">'.$langs[$i].'</option>';
                            }
                            ?>
                            
                        </select>
                    </form>
                    
                    <form method="post" action="<?=request_uri()?>">
                        <select name="lang_table" onchange="this.form.submit()">
                            <option selected value="false">- Все таблицы -</option>
                            <?php
                            $count = count($tables);
                            for($i = 0; $i < $count; $i++)
                            {
                                echo '<option';
                                if(userdata('lang_table') == $tables[$i]['name']) echo ' selected';
                                echo ' value="'.$tables[$i]['name'].'">'.$tables[$i]['title'].'</option>';
                            }
                            ?>
                            
                        </select>
                    </form>
                </div>
                
                <div class="top_menu add_value">
                </div>

                <table width="100%" cellpadding="1" cellspacing="1">
                    <tr bgcolor="#EEEEEE">
    
                        <th>Язык</th>
                        <th>Таблица</th>
                        <th>Оригинал</th>
                        <th>Значение</th>                        
                        <th>Действия</th>
    
                    </tr>
                    <?php
                    $count = count($langs_values);
                    //vdd($langs_values);
                    for($i = 0; $i < $count; $i++)
                    {
                        $lang = $langs_values[$i];
                        ?>
                        <tr class="list" id="noedit-<?=$lang['id']?>">
                            <td><?=$lang['lang']?></td>
                            <td><?=$tables[$lang['table']]['title']?></td>
                            <td><?=$lang['original']?></td>
                            <td><?=$lang['value']?></td>
                                                                                    
                            <td>
                                
                                <img class="img_button" data-action="edit" src="/images/admin/24_24/enabled.png" title="Редактировать" />
                                <img class="img_button" data-action="del" src="/images/admin/24_24/delete.png" title="Удалить" />
                            </td>
                        </tr>
                        
                        <!-- СТРОКА РЕДАКТИРОВАНИЯ -->
                        <form id="formValue_<?=$lang['id']?>">
                        <tr class="list" id="edit-<?=$lang['id']?>" style="display: none">
                            <td>
                                <select name="lang_lang">                                    
                                    <?php
                                    $lcount = count($langs);
                                    for($j = 1; $j < $lcount; $j++)
                                    {
                                        
                                        echo '<option';
                                        if($lang['lang'] == $langs[$j]) echo ' selected';
                                        echo ' value="'.$langs[$j].'">'.$langs[$j].'</option>';
                                    }
                                    ?>                                    
                                </select>
                            </td>
                            <td>
                                <select name="lang_table" >
                                    <?php
                                    $lcount = count($tables);
                                    for($j = 0; $j < $lcount; $j++)
                                    {
                                        echo '<option';
                                        if($lang['table'] == $tables[$j]['name']) echo ' selected';
                                        echo ' value="'.$tables[$j]['name'].'">'.$tables[$j]['title'].'</option>';
                                    }
                                    ?>
                                    
                                </select>                                
                            </td>
                            <td><?=$lang['original']?></td>
                            <td><input type="text" name="value" value="<?=$lang['value']?>"/></td>
                            
                                                                                    
                            <td>                                
                                <img class="img_button" data-action="save" src="/images/admin/24_24/ok.png" title="Сохранить" />
                                <img class="img_button" data-action="cancel" src="/images/admin/24_24/undo.png" title="Отмена" />
                            </td>
                        </tr>
                        </form>
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