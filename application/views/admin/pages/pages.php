<?=$head?>
<?=$header?>
    <div id="wrapper">
    <div id="layout-static">
        <?=$left_sidebar?>
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
                    <?php include(X_PATH.'/application/views/admin/' . $type . '/menu.inc.php'); ?>
                    <div class="container-fluid">

                        <div class="row">
                            <div class="col-md-12">

                                <div class="panel">
                                    <div class="panel-body panel-no-padding">

                                        <table class="table table-striped table-bordered">
                                            <thead>
                                            <tr>
                                                <th style="width: 60px!important">ID</th>
                                                <th style="width: 50px">Активная</th>
                                                <th>Название</th>
                                                <th>Url</th>
                                                <th>Позиция</th>
                                                <th>Действия</th>

                                            </tr>
                                            </thead>
                                            <tbody>
                                            <?php
                                            $count = count($pages);
                                            for ($i = 0; $i < $count; $i++) {
                                                $page = $pages[$i];
                                                $page['name'] = getLangText($page['name']);
                                                ?>
                                                <tr id="tr-<?= $page['id'] ?>" class="list">
                                                    <td><a href="/admin/pages/edit/<?= $page['id'] ?>/"
                                                           title="Перейти к редактированию"><?= $page['id'] ?></a></td>
                                                    <td style="text-align: center">
                                                        <?php if ($page['required'] != 1) { ?>
                                                            <img class="row-active"
                                                                 src="<?=GENERAL_DOMAIN?>/img/admin/active-<?= $page['active'] ?>.png"
                                                                 type="pages"
                                                                 row_id="<?= $page['id'] ?>"
                                                                 status="<?= $page['active'] ?>"
                                                                 id="row-active-<?= $page['id'] ?>"
                                                                 title="<?= ($page['active'] == 0 ? 'Активировать' : 'Деактивировать'); ?>"/>
                                                        <?php } ?>
                                                    </td>

                                                    <td><a href="/admin/pages/edit/<?= $page['id'] ?>/"
                                                           title="Перейти к редактированию"><?= $page['name'] ?></a>
                                                    </td>
                                                    <td><a target="_blank"
                                                           href="/<?= $page['url'] ?>/">/<?= $page['url'] ?>/</a></td>
                                                    <td>
                                                        <div style="float:left; 75%">
                                                            <?= $page['num'] ?>
                                                        </div>
                                                        <div
                                                            style="float: right; text-align: right; width: 25%">
                                                            <a href="/admin/pages/up/<?= $page['id'] ?>/"><img
                                                                    src="<?=GENERAL_DOMAIN?>/img/uparrow.png" border="0" alt="Вверх"
                                                                    title="Вверх"/></a><a
                                                                href="/admin/pages/down/<?= $page['id'] ?>/"><img
                                                                    src="<?=GENERAL_DOMAIN?>/img/downarrow.png" border="0" alt="Вниз"
                                                                    title="Вниз"/></a>
                                                        </div>
                                                    </td>

                                                    <td>
                                                        <?php
                                                        $url = getFullUrl($page);
                                                        if ($page['active'] != 1) $url .= '?admin_preview'
                                                        ?>
                                                        <a href="<?= $url ?>" target="_blank"
                                                           class="btn btn-success btn-xs btn-label"><i
                                                                class="fa fa-search"></i>Просмотр</a><br/>
                                                        <a href="/admin/pages/edit/<?= $page['id'] ?>/"
                                                           class="btn btn-default btn-xs btn-label"><i
                                                                class="fa fa-pencil"></i>Редактировать</a><br/>
                                                        <a href="/admin/menus/add/?from=page&id=<?= $page['id'] ?>"
                                                           class="btn btn-orange btn-xs btn-label">Добавить в
                                                            меню</a><br/>
                                                        <?php if ($page['required'] != 1) { ?>
                                                            <a href="#"
                                                               class="row-del btn btn-danger btn-xs btn-label"
                                                               id="del-<?= $page['id'] ?>"
                                                               type="pages"
                                                               row_id="<?= $page['id'] ?>">

                                                                <i class="fa fa-trash-o"></i>Удалить
                                                            </a>
                                                        <?php } ?>

                                                    </td>
                                                </tr>
                                                <?php
                                            }
                                            ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div> <!-- .container-fluid -->
        </div> <!-- #page-content -->
    </div>
    <div id="result"></div>

<?php
$adding_scripts = "";
include("application/views/admin/common/footer.php");
?>