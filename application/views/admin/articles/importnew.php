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
                        русский <a href="/en<?=$_SERVER['REQUEST_URI']?>">english</a>
                        <span class="back_to_site"><a href="/" target="_blank" title="Открыть сайт в новом окне">Вернуться на сайт ></a></span>
                        <span class="exit"><a href="/admin/login/logoff/">Выйти</a></span>
                    </div>
                </div>

                <div class="content">
                    <?php
                    include("application/views/admin/articles/articles_menu.inc.php");
                    ?>

                    <?=$msg?>

                    <form enctype="multipart/form-data" action="<?=$_SERVER['REQUEST_URI']?>" method="post">
                        <table>
                            <tr>
                                <td>XLS/XLSX файл:</td>
                                <td><input required type="file" name="userfile" /></td>
                            </tr>
                            <!--tr>
                                <td><input type="checkbox" name="price_only" checked />Только цены</td>
                                        </tr-->

                            <tr>
                                <td colspan="2"><input type="submit" value="Добавить" /></td>
                            </tr>
                        </table>
                    </form>

                    <?php
                    if(file_exists('upload/import/'.$user_id.'_importnew.xlsx')){
                        ?>
                        <script type = "text/javascript" src = "/js/jquery-1.7.2.min.js"></script>
                        Система готова начать импорт. Ждём Вашей команды, Сэр!<br />

<!--                        <input type="checkbox" id="no-repeat"--><?php //if(userdata('no-repeat') !== false) echo ' checked'; ?><!-- />-->

                        <button id="start" >Начать!</button> <a href="/admin/articles/importnew/?end_import">Отмена</a><br />
                        <textarea id="result" style="width: 600px;height: 300px" ></textarea><br />
                        <div id="question" style="display: none;">
                            <button id="renew">Обновить найденный</button><button id="add-new">Добавить как новый</button>
                        </div>
                        
                        
                        <script>
                            $(document).ready(function () {
                                
                                $("#start").click(function () {
                                    $("#result").val("");
                                    addLine("Приступаем к работе...");
                                    addNextArticle();
                                });

                                $("#no-repeat").change(function () {
                                    if($("#no-repeat").is(':checked')){
                                        userdata('set','no-repeat','true');
                                        addLine("Не вопрос, буду пропускать, Шэф!");
                                    }else{
                                        userdata('set','no-repeat','false');
                                        addLine("Ок, буду спрашивать каждый раз, Шэф!");
                                    }
                                });
                            });

                            function addNextArticle(line = 1) {
                                $.ajax({
                                    url: '/admin/ajax/import/?line=' + line,
                                    method: 'post',
                                    data: {
                                        "line": line
                                    },

                                }).done(function (data) {
                                    if(data.indexOf("end") != -1){
                                        addLine("Работа завершена!");
                                        return;
                                    }
                                    addLine(data);
                                    setTimeout(function () {
                                        addLine("------------------------------------");
                                        addLine((line+1)+". Идём дальше...");
                                        addNextArticle(line+1);
                                    }, 500); // время в мс

                                });
                            }
                        </script>
                        
                        
                        
                        <?php
                    }
                    ?>


                </div>
            </td>
        </tr>
    </table>
<?php
include("application/views/admin/footer.php");
?>