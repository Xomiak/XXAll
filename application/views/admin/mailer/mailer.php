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

                        <span class="back_to_site"><a href="/" target="_blank" title="Открыть сайт в новом окне">Вернуться на сайт ></a></span>
                        <span class="exit"><a href="/admin/login/logoff/">Выйти</a></span>
                    </div>
                </div>

                <div class="content">
                    <div class="top_menu">
                        <div class="top_menu_link"><a href="/admin/mailer/">Рассылка</a></div>
                        <div class="top_menu_link"><a href="/admin/mailer/add/">Создать рассылку</a></div>
                    </div>

            <table width="100%" cellpadding="1" cellspacing="1">
                <tr bgcolor="#EEEEEE">
                    <td><strong>Название</strong></td>
                    <td><strong>Дата</strong></td>
                    <td><strong>Статус</strong></td>
                    <td><strong>Действия</strong></td>
                </tr>
                
                <?php
                if($options)
                {
                    $count = count($options);
                    
                    for($i = 0; $i < $count; $i++)
                    {
                        $o = $options[$i];
                        
                        ?>
                        
                        <tr id="tr-<?=$o['id']?>" class="list">
                            <td valign="top">
                                <a href="/admin/mailer/edit/<?=$o['id']?>/" title="Перейти к редактированию">
                                    <?=$o['name']?>
                                </a>
                            </td>
                            <td valign="top">
                                    <?=$o['date']?> <?=$o['time']?>
                            </td>
                            <td valign="top">
                                    <?=$o['status']?>
                            </td>
                            <td>
                                <a href="/admin/mailer/view/<?=$o['id']?>/" class="gallery"><img src="/img/admin/preview.png" width="16px" height="16px" border="0" title="Просмотреть" /></a>
                                <?php if($o['ended'] != 1){ ?>
                                <a href="/admin/mailer/send/<?=$o['id']?>/"><img src="/img/admin/send.png" width="16px" height="16px" border="0" title="Приступить к отправке..." /></a>
                                <?php } ?>
                                <a href="/admin/mailer/edit/<?=$o['id']?>/"><img src="/img/edit.png" width="16px" height="16px" border="0" title="Редактировать" /></a>
                                <img id="del-<?=$o['id']?>" class="row-del" border="0" title="Удалить" alt="Удалить" src="/img/del.png" row_id="<?=$o['id']?>" type="mailer">
                            </td>
                        </tr>
                        
                        <?php
                    }
                }
                ?>
                
            </table>
                </div>
            </td>
        </tr>
    </table>
    <link rel="stylesheet" type="text/css" href="/fancybox/jquery.fancybox.css" media="screen" />
    <script type="text/javascript" src="/fancybox/jquery-1.3.2.min.js"></script>
    <script type="text/javascript" src="/fancybox/jquery.easing.1.3.js"></script>
    <script type="text/javascript" src="/fancybox/jquery.fancybox-1.2.1.pack.js"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            $("a.gallery, a.iframe").fancybox();

            $("a.gallery").fancybox(
                {
                    "frameWidth" : 800,	 // ширина окна, px (425px - по умолчанию)
                    "frameHeight" : 600 // высота окна, px(355px - по умолчанию)

                });
        });
    </script>
<?php
include("application/views/admin/footer.php");
?>