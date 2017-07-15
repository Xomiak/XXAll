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
                    <div class="top_menu_link"><a href="/admin/quest/">Вопросы</a></div>
                    <div class="top_menu_link"><a href="/admin/quest/add/">Добавить вопрос</a></div>
                </div>
                
                <form enctype="multipart/form-data" action="<?=$_SERVER['REQUEST_URI']?>" method="post">
                   <table>
                       <tr>
                           <td>Вопрос:</td>
                           <td>
                               <input required type="text" name="name" size="50" value="<?=$quest['name']?>" />
                               <?php
                               if(isset($err['rus']))
                               {
                                   ?>
                                   <div class="error"><?=$err['rus']?></div>
                                   <?php
                               }
                               ?>
                           </td>
                       </tr>
                       <tr>
                           <td>Вариант 1:</td>
                           <td>
                               <input  type="text" name="value_1" size="50" value="<?=$quest['value_1']?>" />
                               <input type="checkbox" name="value_1_true"<?php if($quest['value_1_true'] == '1') echo ' checked'; ?> />Правильный
                           </td>
                       </tr>
                       
                       <tr>
                           <td>Вариант 2:</td>
                           <td>
                               <input  type="text" name="value_2" size="50" value="<?=$quest['value_2']?>" />                        
                               <input type="checkbox" name="value_2_true"<?php if($quest['value_2_true'] == '1') echo ' checked'; ?> />Правильный
                           </td>
                       </tr>
                       
                       <tr>
                           <td>Вариант 3:</td>
                           <td>
                               <input  type="text" name="value_3" size="50" value="<?=$quest['value_3']?>" />
                               <input type="checkbox" name="value_3_true"<?php if($quest['value_3_true'] == '1') echo ' checked'; ?> />Правильный
                           </td>
                       </tr>
                       
                       <tr>
                           <td>Вариант 4:</td>
                           <td>
                               <input  type="text" name="value_4" size="50" value="<?=$quest['value_4']?>" />                               
                               <input type="checkbox" name="value_4_true"<?php if($quest['value_4_true'] == '1') echo ' checked'; ?> />Правильный
                           </td>
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