<?= $head ?>
<?= $header ?>

    <div id="wrapper">
    <div id="layout-static">
<?= $left_sidebar ?>
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

                                <table class="table table-striped table-bordered">
                                    <thead>
                                    <tr bgcolor="#EEEEEE">
                                        <th valign="top">ID</th>
                                        <th valign="top" style="text-align: center !important; width: 100px">
                                            Активный<br/>
                                            <a href="/admin/users/?filter_users_active=1"><img
                                                        src="<?=GENERAL_DOMAIN?>/img/admin/active-1.png" title="Показать только активных"/></a>
                                            <?php if (userdata('filter_users_active') !== false) { ?>
                                                <a href="/admin/users/?filter_users_active=all"><img
                                                            style="opacity: 0.8" src="<?=GENERAL_DOMAIN?>/img/admin/active-all.png"
                                                            title="Сбросить фильтр (Показать всех)"/></a>
                                            <?php } ?>
                                            <a href="/admin/users/?filter_users_active=0"><img
                                                        src="<?=GENERAL_DOMAIN?>/img/admin/active-0.png"
                                                        title="Показать только не активных"/></a>
                                        </th>
                                        <th valign="top">Аватар</th>
                                        <th style="vertical-align: top !important;">Логин</th>
                                        <th valign="top">Имя</th>
                                        <th valign="top">e-mail</th>
                                        <th valign="top">Пол</th>
                                        <th valign="top" style="text-align: center">
                                            Тип<br/>
                                            <form method="post">
                                                <select onchange="submit()" id="filter-user-type"
                                                        name="filter-user-type">
                                                    <option value="all">- Все -</option>
                                                    <?php
                                                    if (isset($usertypes)) {
                                                        foreach ($usertypes as $type) {
                                                            echo '<option value="' . $type['value'] . '"';
                                                            if (userdata('filter-user-type') == $type['value']) echo ' selected';
                                                            echo '>' . $type['name'] . '</option>';
                                                        }
                                                    }
                                                    ?>
                                                </select>
                                            </form>
                                        </th>
                                        <th valign="top">Действия</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    if ($users) {
                                        $count = count($users);
                                        for ($i = 0; $i < $count; $i++) {
                                            $user = $users[$i];
                                            ?>
                                            <tr class="list">
                                                <td><?= $user['id'] ?></td>
                                                <td style="text-align: center">
                                                    <img class="row-active"
                                                         src="<?=GENERAL_DOMAIN?>/img/admin/active-<?= $user['active'] ?>.png"
                                                         type="users"
                                                         row_id="<?= $user['id'] ?>"
                                                         status="<?= $user['active'] ?>"
                                                         id="row-active-<?= $user['id'] ?>"
                                                         title="<?= ($user['active'] == 0 ? 'Активировать' : 'Деактивировать'); ?>"/>
                                                </td>
                                                <td>
                                                    <?php
                                                    if ($user['avatar'] != '') {
                                                        ?>
                                                        <a href="/admin/users/edit/<?= $user['id'] ?>/"
                                                           title="Перейти к редактированию">
                                                            <img src="<?= $user['avatar'] ?>" height="50px" border="0"/>
                                                        </a>
                                                        <?php
                                                    }
                                                    ?>
                                                </td>
                                                <td><a href="/admin/users/edit/<?= $user['id'] ?>/"
                                                       title="Перейти к редактированию"><?= $user['login'] ?></a></td>
                                                <td><?= $user['name'] ?></td>
                                                <td><?= $user['email'] ?></td>
                                                <td><?= $user['sex'] ?></td>
                                                <td>
                                                    <?= $user['type'] ?>
                                                </td>

                                                <td>
                                                    <a href="/admin/users/edit/<?= $user['id'] ?>/"
                                                       class="btn btn-default btn-xs btn-label"><i
                                                                class="fa fa-pencil"></i>Редактировать</a><br/>
                                                    <a href="#"
                                                       class="row-del btn btn-danger btn-xs btn-label"
                                                       id="del-<?= $user['id'] ?>"
                                                       type="users"
                                                       row_id="<?= $user['id'] ?>">

                                                        <i class="fa fa-trash-o"></i>Удалить
                                                    </a>
                                                </td>
                                            </tr>
                                            <?php
                                        }
                                    } else echo '<tr><td colspan="9" style="text-align: center">Ничего не найдено...</td></tr>';
                                    ?>
                                    </tbody>
                                </table>
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
?>
<?=$footer?>