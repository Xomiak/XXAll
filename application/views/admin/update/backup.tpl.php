<?php
include("application/views/admin/common/head.php");
include("application/views/admin/common/header.php");
?>
    <div id="wrapper">
    <div id="layout-static">
<?php include("application/views/admin/common/left_sidebar.php"); ?>
    <div class="static-content-wrapper">
    <div class="static-content">
        <div class="page-content">
            <ol class="breadcrumb">

                <li><a href="/admin/">Главная</a></li>
                <li><a href="/admin/update/">Обновление</a></li>
                <li class="active"><a href="<?= $_SERVER['REQUEST_URI'] ?>"><?= $title ?></a></li>

            </ol>
            <div class="page-heading">
                <h1><?= $title ?></h1>
                <div class="options">
                    <div class="btn-toolbar">
                        <a href="#" class="btn btn-default"><i class="fa fa-fw fa-wrench"></i></a>
                    </div>
                </div>
            </div>
            <div class="container-fluid">

                <div data-widget-group="group1">

                    <div class="panel panel-default" data-widget='{"draggable": "false"}'>
                        <div class="panel-heading">
                            <h2>Бэкап данных</h2>
                            <div class="panel-ctrls"
                                 data-actions-container=""
                                 data-action-collapse='{"target": ".panel-body"}'
                                 data-action-expand=''
                                 data-action-colorpicker=''
                            >
                            </div>
                        </div>
                        <div class="panel-editbox" data-widget-controls=""></div>
                        <div class="panel-body">

                            <div class="form-group">
                                <form method="post">
                                    <button onclick="submit()" name="createBackup" id="create_backup" class="btn-primary btn">Создать текущий бэкап</button>
                                </form>
                                <div id="create_backup_results"></div>
                            </div>

                            <p>
                                <?php
                                if(isset($backupPath) && file_exists($backupPath)){
                                    echo 'Бэкап успешно создан!<br/><a href="'.$backupPath.'">Скачать!</a>';
                                }
                                ?>
                            </p>
                            <ul>
                            <?php
                            if(isset($backups) && is_array($backups)){
                                $i = 0;
                                foreach ($backups as $backup){
                                    if($backup != '.' && $backup != '..' && $backup != 'temp')
                                        echo '<li id="backup-'.$i.'"><a href="/upload/backups/'.$backup.'">'.$backup.'</a> <span style="cursor: pointer; font-weight: bolder; color: red" class="delete_backup" backup="'.$backup.'" liid="'.$i.'" title="Удалить этот бэкап">X</a></li>';
                                    $i++;
                                }
                            }
                            ?>
                            </ul>


                        </div>
                    </div>
                </div>

                <script>
                    $(document).ready(function () {
                        $(".delete_backup").click(function () {
                            var file = $(this).attr('backup');
                            var liid = $(this).attr('liid');
                            if(confirm("Вы точно хотите удалить бэкап "+file+"?")){
                                $.ajax({
                                    type: "POST",
                                    url: "/admin/ajax/file/delete/",
                                    data: {
                                        'filePath': "upload/backups/"+file,
                                    },
                                    success: function(data) {
                                        showNotify("Файл удалён!",'Файл бэкапа успешно удалён с сервера!');
                                    },
                                    error: function(data) {
                                        showNotify("Ошибка удаления!",'Файл бэкапа небыл удалён с сервера!','error');
                                    }
                                });
                                $("#backup-"+liid).hide();
                            }
                        });
                    });
                </script>

            </div> <!-- .container-fluid -->
        </div> <!-- #page-content -->
    </div>
    <div id="result"></div>

<?php
$adding_scripts = "";
include("application/views/admin/common/footer.php");
?>