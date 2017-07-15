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

                <li><a href="/">Главная</a></li>
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

                <div class="row">
                    <div class="col-md-12">

                        <div class="panel">
                            <div class="panel-body panel-no-padding">

                                <?php include('application/views/admin/languages/menu.inc.php'); ?>
<!--                                <div class="pagination">--><?//= $pager ?><!--</div>-->

                                <!--        <div class="form-group pull-left" title="В процессе разработки...">-->
                                <!--            <select name="action" id="mass_action" class="form-control" disabled>-->
                                <!--                <option value="">- Массовые действия -</option>-->
                                <!--                <option value="active">Активировать</option>-->
                                <!--                <option value="not_active">Деактивировать</option>-->
                                <!--                <option value="delete">Удалить</option>-->
                                <!--            </select>-->
                                <!---->
                                <!--            <input disabled id="mass_action_submit" class="btn btn-default" type="button"-->
                                <!--                   name="mass_action" value="Применить">-->
                                <!--        </div>-->

                                <table  class="table table-striped table-bordered">
                                    <thead>
                                    <tr bgcolor="#EEEEEE">
                                        <th style="max-width: 32px">Иконка</th>
                                        <th>Название</th>
                                        <th>Код</th>
                                        <th>Основной</th>
                                        <th>Действия</th>

                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    $count = count($languages);
                                    for ($i = 0; $i < $count; $i++) {
                                        $language = $languages[$i];
                                        ?>
                                        <tr class="list">
                                            <td style="max-width: 32px">
                                                <?php if ($language['icon'] != "" && $language['icon'] != NULL) { ?>
                                                    <a href="/admin/languages/edit/<?= $language['id'] ?>/"
                                                       title="Перейти к редактированию"><img style="max-width: 32px"
                                                                                             src="<?= $language['icon'] ?>"/></a>
                                                <?php } ?>
                                            </td>
                                            <td><a href="/admin/languages/edit/<?= $language['id'] ?>/"
                                                   title="Перейти к редактированию"><?= $language['name'] ?></a></td>
                                            <td><?= $language['code'] ?></td>
                                            <td>
                                                <input disabled type="checkbox" id="default"
                                                       name="default" <?php if ($language['default'] == 1) echo 'checked'; ?> />
                                            </td>
                                            <!--td><a href="/admin/languages/up/<?= $language['id'] ?>/"><img src="/img/uparrow.png" border="0" alt="Вверх" title="Вверх" /></a><a href="/admin/languages/down/<?= $language['id'] ?>/"><img src="/img/downarrow.png" border="0" alt="Вниз" title="Вниз" /></a></td-->

                                            <td>
                                                <?php if ($language['default'] != 1) { ?>
                                                    <a href="/admin/languages/active/<?= $language['id'] ?>/"><?php
                                                        if ($language['active'] == 1)
                                                            echo '<img src="/img/visible.png" width="16px" height="16px" border="0" title="Деактивация" />';
                                                        else
                                                            echo '<img src="/img/not-visible.png" width="16px" height="16px" border="0" title="Активация" />';
                                                        ?></a>
                                                <?php } else echo '<img src="/img/visible.png" width="16px" height="16px" border="0" title="Деактевация не возможна" />'; ?>

                                                <a href="/admin/languages/edit/<?= $language['id'] ?>/"><img
                                                        src="/img/edit.png" width="16px" height="16px" border="0"
                                                        title="Редактировать"/></a>
                                                <?php if ($language['default'] != 1) { ?>
                                                    <a onclick="return confirm('Удалить?')"
                                                       href="/admin/languages/del/<?= $language['id'] ?>/"><img
                                                            src="/img/del.png" border="0" alt="Удалить"
                                                            title="Удалить"/></a>
                                                <?php } ?>
                                            </td>
                                        </tr>
                                        <?php
                                    }
                                    ?>
                                    </tbody>
                                </table>
<!--                                <div class="pagination">--><?//= $pager ?><!--</div>-->
                            </div>
                        </div>
                    </div>
                </div>

            </div> <!-- .container-fluid -->
        </div> <!-- #page-content -->
    </div>
    <div id="result"></div>

    <script>
        $(document).ready(function () {
            $(".row-recount").click(function () {
                var tag_id = $(this).attr('row_id');
                recountTags(tag_id);
            });
        });
    </script>
<?php
$adding_scripts = "";
include("application/views/admin/common/footer.php");
?>