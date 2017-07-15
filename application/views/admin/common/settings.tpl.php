<?php
$myType = userdata('type');
$languages = $this->model_languages->getLanguages();
$defaultLanguage = $this->model_languages->getDefaultLanguage();
$languagesCount = $this->model_languages->languagesCount(1);
?>
<?php if(isset($head)) echo $head; ?>
<?php if(isset($header)) echo $header; ?>
<?php
?>
    <div id="wrapper">
    <div id="layout-static">
<?php if(isset($left_sidebar)) echo $left_sidebar; ?>
    <div class="static-content-wrapper">
    <div class="static-content">
    <div class="page-content">
    <ol class="breadcrumb">

        <li><a href="/admin/">Главная</a></li>
        <li><a href="/admin/<?= $settingsType ?>/"><?= $settingsName ?></a></li>
        <li class="active"><a href="<?= $_SERVER['REQUEST_URI'] ?>">Настройка полей статей</a></li>

    </ol>
    <div class="page-heading">
        <h1><?= $title ?></h1>
        <div class="options">
            <div class="btn-toolbar">
                <a href="#" class="btn btn-default"><i class="fa fa-fw fa-wrench"></i></a>
            </div>
        </div>
    </div>
<?php include(X_PATH.'/application/views/admin/'.$type.'/menu.inc.php'); ?>

    <div data-widget-group="group1">

    <div class="panel panel-1" data-widget='{"draggable": "false"}'>
        <div class="panel-heading">
            <h2>Поля статьи:</h2>
            <div class="panel-ctrls"
                 data-actions-container=""
                 data-action-collapse='{"target": ".panel-body"}'
            >
            </div>
        </div>
        <div class="panel-editbox" data-widget-controls=""></div>
        <div class="panel-body">

            <form action="<?= $_SERVER['REQUEST_URI'] ?>" method="post">
                <div class="table-vertical">
                <table class="table table-striped">
                    <tr bgcolor="#EEEEEE">
                        <th>Имя</th>
                        <th>Название</th>
                        <th>Тип</th>
                        <th>Мультиязычность</th>
                        <th>Обязательное</th>
                        <th>В таблице</th>
                        <th>Позиция</th>
                        <th>Действия</th>
                    </tr>

                    <?php
                    if ($settings) {
                        $count = count($settings);
                        for ($i = 0; $i < $count; $i++) {
                            $s = $settings[$i];

                            // Если редактируем текущее поле
                            if (isset($_GET['edit']) && $_GET['edit'] == $s['name'] && $s['not_edited'] != 1) {
                                if (isset($msg)) {
                                    ?>
                                    <tr>
                                        <td colspan="5">
                                            <div class="err"><?= $msg ?></div>
                                        </td>
                                    </tr>
                                    <?php
                                }
                                ?>
                                <tr class="edited_tr">
                                    <td data-title="Имя"><input required type="text" name="name"
                                               value="<?php if (isset($_POST['name'])) echo $_POST['name']; else echo $s['name'] ?>"
                                               placeholder="Имя (латиницей)"/></td>
                                    <td data-title="Название"><input required type="text" name="rus"
                                               value="<?php if (isset($_POST['rus'])) echo $_POST['rus']; else echo $s['rus'] ?>"
                                               placeholder="Название"/></td>
                                    <td data-title="Тип">
                                        <select required name="type" placeholder="Тип">
                                            <?php
                                            if ($fieldtypes) {
                                                $fcount = count($fieldtypes);
                                                for ($fi = 0; $fi < $fcount; $fi++) {
                                                    $ft = $fieldtypes[$fi];
                                                    ?>
                                                    <option<?php if ($s['type'] == $ft['name']) echo ' selected'; ?>
                                                        value="<?= $ft['name'] ?>"><?= $ft['name'] ?></option>
                                                    <?php
                                                }
                                            }
                                            ?>
                                        </select>
                                    </td>
                                    <td data-title="Мультиязычность"><input type="checkbox"
                                               name="multilanguage"<?php if ($s['multilanguage'] == 1) echo ' checked'; ?> />
                                    </td>
                                    <td data-title="Обязательное"><input type="checkbox"
                                               name="required"<?php if ($s['required'] == 1) echo ' checked'; ?> /></td>
                                    <td><input type="checkbox"
                                               name="admin_in_table"<?php if ($s['admin_in_table'] == 1) echo ' checked'; ?> />
                                    </td>
                                    <td data-title="Позиция">
                                        <input type="text" name="num" placeholder="Позиция"
                                               value="<?php if (isset($_POST['num'])) echo $_POST['num']; else echo $s['num'] ?>"/>
                                        <input type="hidden" name="cur_num" value="<?= $s['num'] ?>"/>
                                    </td>
                                    <td data-title="Действия">
                                        <input type="hidden" name="cur_name" value="<?= $s['name'] ?>"/>
                                        <input type="submit" name="saveSetting" value="Сохранить"/>
                                    </td>
                                </tr>
                                <?php
                            } else {
                                ?>
                                <tr id="tr-<?= $s['id'] ?>">
                                    <td data-title="Имя"><?= $s['name'] ?></td>
                                    <td data-title="Название"><?= $s['rus'] ?></td>
                                    <td data-title="Тип"><?= $s['type'] ?></td>
                                    <td data-title="Мультиязычность">
                                        <label class="checkbox-inline icheck">
                                            <input type="checkbox"
                                                   <?php if ($s['multilanguage'] == 1) echo ' checked'; ?> />
                                        </label>
                                    </td>
                                    <td data-title="Обязательное">
                                        <label class="checkbox-inline icheck">
                                            <input type="checkbox"
                                                   <?php if ($s['required'] == 1) echo ' checked'; ?> />
                                        </label>
                                    </td>
                                    <td data-title="Показывать в таблицы">
                                        <label class="checkbox-inline icheck">
                                            <input type="checkbox"
                                                   <?php if ($s['admin_in_table'] == 1) echo ' checked'; ?> />
                                        </label>
                                    </td>
                                    <td data-title="Позиция">
                                        <?= $s['num'] ?>
                                        <?php
                                        if ($s['num'] > 0) {
                                            ?>
                                            <a href="/admin/<?= $settingsType ?>/settings/down/<?= $s['id'] ?>/"><img
                                                    src="<?=GENERAL_DOMAIN?>/img/uparrow.png" border="0" alt="Вверх" title="Вверх"/></a>
                                            <?php
                                        } else echo '&nbsp;&nbsp;&nbsp;';

                                        if ($s['num'] < ($settingsNewNum - 1)) {
                                            ?>
                                            <a href="/admin/<?= $settingsType ?>/settings/up/<?= $s['id'] ?>/"><img
                                                    src="<?=GENERAL_DOMAIN?>/img/downarrow.png" border="0" alt="Вниз" title="Вниз"/></a>
                                            <?php
                                        }
                                        ?>


                                    </td>
                                    <?php
                                    if ($s['not_edited'] != 1) {
                                    ?>
                                    <td data-title="Действия">
                                        <a href="/admin/<?= $settingsType ?>/settings/?edit=<?= $s['name'] ?>"
                                           class="btn btn-default btn-xs btn-label"><i
                                                    class="fa fa-pencil"></i>Редактировать</a><br/>

                                        <a style="cursor: pointer"
                                           class="row-del btn btn-danger btn-xs btn-label"
                                           id="del-<?= $s['id'] ?>"
                                           type="<?= $settingsType ?>_settings"
                                           row_id="<?= $s['id'] ?>"><i
                                                    class="fa fa-trash-o"></i>Удалить</a>

                                            <!--a href="/admin/<?= $settingsType ?>/settings/?edit=<?= $s['name'] ?>"><img
                                                    src="/img/edit.png" width="16px" height="16px" border="0"
                                                    title="Редактировать"/></a>
                                            <a onclick="return confirm('Удалить?')"
                                               href="/admin/<?= $settingsType ?>/settings/del/<?= $s['name'] ?>/"><img
                                                    src="/img/del.png" border="0" alt="Удалить" title="Удалить"/></-->

                                    </td>
                                        <?php
                                    }
                                    ?>
                                </tr>
                                <?php
                            }
                        }
                    }
                    // Если не режим редактирования, то выводим возможность добавления
                    if (!isset($_GET['edit'])) {
                        ?>
                        <tr>
                            <td>&nbsp;</td>
                        </tr>
                        <tr>
                            <th colspan="5">Новое поле:</th>
                        </tr>
                        <?php
                        if (isset($msg)) {
                            ?>
                            <tr>
                                <td colspan="5">
                                    <div class="err"><?= $msg ?></div>
                                </td>
                            </tr>
                            <?php
                        }
                        ?>
                        <tr>
                            <td data-title="Имя"><input class="form-control" required type="text" name="name"
                                       value="<?php if (isset($_POST['name'])) echo $_POST['name']; ?>"
                                       placeholder="Имя (латиницей)"/></td>
                            <td data-title="Название"><input class="form-control" required type="text" name="rus"
                                       value="<?php if (isset($_POST['rus'])) echo $_POST['rus']; ?>"
                                       placeholder="Название"/></td>
                            <td data-title="Тип">
                                <select class="form-control" required name="type" placeholder="Тип">
                                    <option value="">-- Тип --</option>
                                    <?php
                                    if ($fieldtypes) {
                                        $count = count($fieldtypes);
                                        for ($i = 0; $i < $count; $i++) {
                                            $ft = $fieldtypes[$i];
                                            ?>
                                            <option<?php if (isset($_POST['type']) && $_POST['type'] == $ft['name']) echo ' selected'; ?>
                                                value="<?= $ft['name'] ?>"><?= $ft['name'] ?></option>
                                            <?php
                                        }
                                    }
                                    ?>
                                </select>
                            </td>
                            <td data-title="Мультиязычность">
                                <label class="checkbox-inline icheck">
                                    <input class="form-control" type="checkbox" name="multilanguage"/>
                                </label>
                            </td>
                            <td data-title="Обязательное">
                                <label class="checkbox-inline icheck">
                                    <input type="checkbox" name="required"/>
                                </label>
                            </td>
                            <td data-title="Показывать в таблице">
                                <label class="checkbox-inline icheck">
                                    <input type="checkbox" name="admin_in_table"/>
                                </label>
                            </td>
                            <td data-title="Позиция">
                                <input class="form-control" type="number" name="num" placeholder="Позиция"
                                       value="<?= $settingsNewNum ?>"/>
                            </td>
                            <td data-title="Действия">
                                <input class="btn-primary btn" type="submit" name="addNewSetting" value="Добавить"/>
                            </td>
                        </tr>
                        <?php
                    }
                    ?>
                </table>
</div>
            </form>
        </div>
    </div>


<?php
$adding_scripts = '';
if(isset($footer)) {
    $footer = str_replace('[adding_scripts]', $adding_scripts, $footer);
    echo $footer;
}
?>