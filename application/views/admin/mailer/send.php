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
                    <?php
                    if($mailer['ended'] == 1) {
                        echo 'Внимание! Эта рассылка уже была произведена!<br />';
                        echo '<button id="start">Рестарт</button>';
                    } else echo '<button id="start">Старт</button>';
                    ?>
                    <button id="stop" style="display: none">Стоп</button><br /><br>

                    <textarea id="result" style="width: 500px;height: 500px"></textarea>
                </div>
            </td>
        </tr>
    </table>
    <script src="/js/jquery-1.7.2.min.js"></script>
<script>
    var line = 1;
    var emailsCount = 0;
    $(document).ready(function () {
        $("#start").click(function () {
            addLine("Приступаем к рассылке...");
            $("#start").hide();
            getCount();
        });
    });

    // получаем общее число получателей и создаём общий список
    function getCount() {
        console.log("Приступаем к проверке");
        $.ajax({
            url: '/admin/ajax/mailer/count/?id=<?=$mailer['id']?>',
            method: 'post',
            data: {
                "id": <?=$mailer['id']?>
            },

        }).done(function (data) {
            var obj = jQuery.parseJSON(data);
            emailsCount = obj.count;
            console.log(obj.msg);
            addLine(obj.msg);
            send();
        });
    }

    // отправляем следующее письмо
    function send() {
        console.log("Приступаем к отправке");
        $.ajax({
            url: '/admin/ajax/mailer/send/?id=<?=$mailer['id']?>',
            method: 'post',
            data: {
                "id": <?=$mailer['id']?>
            },

        }).done(function (data) {
            var obj = jQuery.parseJSON(data);
            if(obj.value == 'ended') {
                console.log(obj.msg);
                addLine(obj.msg);
            }
            else {
                console.log(obj.msg);
                addLine(obj.msg);
                send();
            }
        });
    }

</script>
<?php
include("application/views/admin/footer.php");
?>