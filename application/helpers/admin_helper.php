<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

function showMessageDone($msg, $strongText = false)
{
    ?>
    <!--    <div id="alert_to_user" class="alert alert-dismissable alert-success">-->
    <!--        <i class="fa fa-fw fa-check"></i>&nbsp; --><?php //if($strongText) echo '<strong>'.$strongText.'</strong>';
                                                           ?><!-- --><?//=$msg
    ?>
    <!--        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>-->
    <!--    </div>-->
    <!--    <script>-->
    <!--        hideMessage('alert_to_user');-->
    <!--    </script>-->
    <script>
        new PNotify({
            title: '<?=$strongText?>',
            text: '<?=$msg?>',
            type: 'success',
            styling: 'fontawesome'
        });
    </script>
    <?php
}

function showMessageWarning($msg, $strongText = false)
{
    ?>
    <div class="alert alert-dismissable alert-warning">
        <i class="fa fa-fw fa-warning"></i>&nbsp; <?php if ($strongText) echo '<strong>' . $strongText . '</strong>'; ?> <?= $msg ?>
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
    </div>
    <?php
}

function showMessageError($msg, $strongText = false)
{
    ?>
    <div class="alert alert-dismissable alert-danger">
        <i class="fa fa-fw fa-times"></i>&nbsp; <?php if ($strongText) echo '<strong>' . $strongText . '</strong>'; ?> <?= $msg ?>
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
    </div>
    <?php
}

function showAllAboutArticle($article)
{
    $CI = &get_instance();
    $CI->load->model('Model_users', 'users');
    $user = $CI->users->getUserByLogin($article['created_by']);
    ?>
    <?php if ($article['image'] != '') echo '<span><img width="125px" src="' . $article['image'] . '"></span>'; ?>
    <span>
	<?php
    if ($article['moderated_by'] == NULL) {
        $article['moderated_date'] = $article['moderated_ip'] = $article['moderated_by'] = "Нет";
    }
    ?>
        ID: <?= $article['id'] ?><br/>
        <?php if ($user) { ?>
            Добавил:<br/>
			Имя: <?= $user['name'] ?> <?= $user['lastname'] ?><br/>
			Логин: <?= $article['created_by'] ?><br/>
			IP: <?= $article['created_ip'] ?><br/>
			Дата: <?= $article['created_date'] ?><br/>
            <br/>
        <?php } ?>
        Модерировал: <br>
			Логин: <?= $article['moderated_by'] ?><br/>
			IP: <?= $article['moderated_ip'] ?><br/>
			Дата: <?= $article['moderated_date'] ?><br/>
        <?php if ($article['image'] != '') echo '<img width="125px" src="' . $article['image'] . '">'; ?>
	</span>
    <?php
}

function getModules($active = -1)
{
    $CI = &get_instance();
    $CI->load->model('Model_options', 'options');
    return $CI->options->getAllModules($active);
}

//// NOTIFICATIONS
function showNotifications()
{
    $CI = &get_instance();
    $CI->load->model('Model_admin', 'admin');
    $notificationsCount = $CI->admin->getNotificationsCount(false, 0);
    $notifications = $CI->admin->getNotifications(false, 0);
    ?>
    <li class="dropdown toolbar-icon-bg">
        <a href="#" class="hasnotifications dropdown-toggle" data-toggle='dropdown'><span class="icon-bg"><i
                        class="fa fa-fw fa-bell"></i></span><span id="notifications_count"
                                                                  class="badge badge-info"><?= $notificationsCount ?></span></a>
        <div class="dropdown-menu dropdown-alternate notifications arrow">
            <div class="dd-header">
                <span>Уведомления</span>
                <span><a href="#">Настройки</a></span>
            </div>
            <div class="scrollthis scroll-pane">
                <ul class="scroll-content">
                    <?php
                    if ($notifications) {
                    foreach ($notifications as $notification) {
                    $took = 0;
                    $tookWhat = 'м';
                    $took = time() - $notification['date_unix'];
                    if ($took < 3600) {
                        $took = $took / 60;
                        $tookWhat = 'м';
                    } elseif ($took < 86400) {
                        $took = $took / 60 / 24;
                        $tookWhat = 'ч';
                    } else {
                        $tookWhat = 'с';
                    }
                    ?>
                    <li id="notification-<?= $notification['id'] ?>" class="">
                        <a data-toggle="modal" href="#myModal" notification_id="<?= $notification['id'] ?>"
                           class="notification notification-<?= $notification['type'] ?>">
                            <div class="notification-icon"><i
                                        class="fa fa-<?= $notification['subtype'] ?> fa-fw"></i></div>
                            <div class="notification-content"><?= $notification['name'] ?></div>
                            <div class="notification-time"><?= round($took) ?> <?= $tookWhat ?></div>
                        </a>


                        <?php
                        }
                        }
                        ?>
                </ul>
            </div>
            <div class="dd-footer">
                <a href="#">Просмотреть все уведомления</a>
            </div>
        </div>

        <?php
        }

        /////////////////////////////////////////////////////////////////////
        // MODULES

        // TODO LIST
        function adminShowTodoList($login)
        {
        $CI = &get_instance();
        $CI->load->model('Model_modules', 'modules');
        $privateTodo = $CI->modules->getTodoList($login, 0, false);
        $publicTodo = $CI->modules->getPublicTodoList($login, 0, false);
        $privateTodoDone = $CI->modules->getTodoList($login, 1, false);
        $publicTodoDone = $CI->modules->getPublicTodoList($login, 0, false);
        //vd($todo);echo '<hr>';vd($todoDone);
        ?>
        <div class="col-md-6">
            <div class="panel panel-default" data-widget=''>
                <div class="panel-heading">
                    <h2>Мои пометки</h2>
                    <div class="panel-ctrls button-icon-bg"
                         data-actions-container=""
                         data-action-collapse='{"target": ".panel-body"}'
                         data-action-expand=''
                         data-action-colorpicker=''
                         data-action-edit=''
                         data-action-close=''
                    >
                    </div>
                </div>
                <div class="panel-editbox" data-widget-controls=""></div>
                <div class="panel-body panel-no-padding panel-todo">
                    <?php
                    if ($privateTodo) {
                    echo '<ul class="connectedSortable" id="sortable-todo">';
                    foreach ($privateTodo as $item) {
                    ?>
    <li class="">
    <span class="drag-todo">
                    <div class="checkbox-inline icheck"><input class="todo_cb" todo_id="<?= $item['id'] ?>"
                                                               id="todo_<?= $item['id'] ?>"
                                                               status="<?= $item['status'] ?>" type="checkbox"></div>
                </span>
    <p class="todo-description">
        <?= $item['content'] ?>
    </p>

    <?php
}
    echo '</ul>';
    echo '<span class="todo-header"></span>';
}

if ($publicTodo) {
    echo '<ul class="connectedSortable" id="sortable-todo">';
foreach ($publicTodo as $item) {
    ?>
    <li class="">
    <span class="drag-todo">
                    <div class="checkbox-inline icheck"><input class="todo_cb" todo_id="<?= $item['id'] ?>"
                                                               id="todo_<?= $item['id'] ?>"
                                                               status="<?= $item['status'] ?>" type="checkbox"></div>
                </span>
    <p class="todo-description">
        <?= $item['content'] ?>
    </p>

    <?php
}
    echo '</ul>';
    echo '<span class="todo-header"></span>';
}

if ($privateTodoDone) {
    echo '<ul class="todo-completed connectedSortable" id="completed-todo">';
foreach ($privateTodoDone as $item) {
    ?>
    <li class="">
    <span class="drag-todo">
                    <div class="checkbox-inline icheck"><input class="todo_cb" todo_id="<?= $item['id'] ?>"
                                                               id="todo_<?= $item['id'] ?>"
                                                               status="<?= $item['status'] ?>" type="checkbox" checked>
                    </div>
                    <span class="drag-image"></span>
                </span>
    <p class="todo-description">
        <?= $item['content'] ?>
    </p>


    <?php
}
    echo '</ul>';
    echo '<span class="todo-header"></span>';
}

if ($publicTodoDone) {
    echo '<ul class="todo-completed connectedSortable" id="completed-todo">';
foreach ($publicTodoDone as $item) {
    ?>
    <li class="">
                <span class="drag-todo">
                    <div class="checkbox-inline icheck"><input class="todo_cb" todo_id="<?= $item['id'] ?>"
                                                               id="todo_<?= $item['id'] ?>"
                                                               status="<?= $item['status'] ?>" type="checkbox" checked>
                    </div>
                    <span class="drag-image"></span>
                </span>
        <p class="todo-description">
            <?= $item['content'] ?>
        </p>


        <?php
        }
        echo '</ul>';
        echo '<span class="todo-header"></span>';
        }
        ?>
        <div class="todo-footer clearfix">
            <a href="#" class="btn btn-sm btn-success"><i
                        class="visible-xs fa fa-plus"></i> <span
                        class="hidden-xs">Новый</span></a>
            <a href="#" class="btn btn-sm btn-default"><i
                        class="visible-xs fa fa-check"></i> <span class="hidden-xs">Отметить все</span></a>
            <a href="/admin/modules/todo_list/" class="btn-link btn-sm pull-right"
               style="padding-right: 0">На страницу списка</a>
        </div>
        </div>
        </div>
        </div>
        <?php
        }

        function adminShowCalendar($login)
        {
            ?>
            <div class="col-md-6">
                <div class="panel panel-default" data-widget=''>
                    <div class="panel-heading">
                        <h2>Calendar</h2>
                        <div class="panel-ctrls button-icon-bg"
                             data-actions-container=""
                             data-action-collapse='{"target": ".panel-body"}'
                             data-action-expand=''
                             data-action-colorpicker=''
                             data-action-edit=''
                             data-action-close=''
                        >
                            <a href="#" class="button-icon custom-icon has-bg"><i class="fa fa-cog"></i></a>
                        </div>
                    </div>
                    <div class="panel-editbox" data-widget-controls=""></div>
                    <div class="panel-body">
                        <div id="calendar-drag"></div>
                    </div>
                </div>
            </div>
            <?php
        }

        function getDbins($settings, $item = false, $type = 'articles', $action = 'add', $use_translations = -1)
        {
            $CI = &get_instance();
            //loadHelper('images');
            if ($use_translations == -1)
                $use_translations = getOption('use_translations');

            $langs = array();
            $languages = getLanguages();
            for ($i = 0; $i < count($languages); $i++) {
                $langs[$i] = $languages[$i]['code'];
            }

            $languagesCount = languagesCount(1);
            $default_lang = getDefaultLanguage();

            if (isset($default_lang['code'])) $default_lang = $default_lang['code'];
            $dbins = array();

            $count = count($settings);
            for ($i = 0; $i < $count; $i++) {
                $s = $settings[$i];
                $fieldtype = getFieldtypeByName($s['type']);

                $name = $s['name'];

                echo $name . ' = ' . $s['type'] . ' (' . $fieldtype['view'] . ')<br />';

                if ($name == 'category_id') {                                                                                           // category_id
                    $category_id = '';
                    $main_category_id = 0;
                    $cat_ids = $_POST['category_id'];
                    $ccount = count($cat_ids);
                    for ($ci = 0; $ci < $ccount; $ci++) {
                        if ($ci == 0) $main_category_id = $cat_ids[$ci];              // основная категория
                        $category_id .= '*' . $cat_ids[$ci] . '*';
                        if (($ci + 1) < $ccount)
                            $category_id .= '|';
                    }
                    //vdd($main_category_id);
                    $dbins['category_id'] = $category_id;
                    $dbins['main_category_id'] = $main_category_id;

                    $parent_category_id = 0;
                    $parent_category = $CI->model_categories->getParentById($main_category_id);
                    // vdd($parent_category);
                    if (isset($parent_category['id']))
                        $parent_category_id = $parent_category['id'];

                    $dbins['parent_category_id'] = $parent_category_id;
                    $firstCategory = $CI->model_categories->getFirstParentId($main_category_id);
                    //vdd($firstCategory);
                    if ($firstCategory == NULL) $firstCategory = 0;
                    $dbins['first_category_id'] = $firstCategory;
                    //if(isset($firstCategory['id'])) $dbins['first_category_id'] = $firstCategory['id'];
                } elseif ($name == 'url') {                                                                                              // URL
                    if ($_POST['url'] == '') {
                        $CI->load->helper('translit_helper');

                        ////////////////////////////
                        $res = '';
//                    if ($languagesCount > 1) {   // если больше 1-го языка
//                    }
                        //if ($languagesCount < 2) $_POST[$name . '_' . $langs[0]] = post($name);
                        if (isset($_POST['name_' . $langs[0]])) {
                            $res = $_POST['name_' . $langs[0]];
                        } else $res = post('name');
                        ////////////////////////////
                        $dbins['url'] = createUrl($res);
                    } elseif ($action == 'add') {
                        $CI->load->helper('translit_helper');
                        $dbins['url'] = createUrl(post('url'));
                    } else {
//                if (preg_match("/[а-я]/i", $_POST['url'])) { // проверяем, нет ли в строке русских букв
//                    $CI->load->helper('translit_helper');
//                    $_POST['url'] = createUrl($_POST['url']);
//                }
                        $dbins['url'] = $_POST['url'];
                    }
                } elseif ($name == 'date') {                                                                                            // CREATING DATE
                    if (post('date') === false)
                        $_POST['date'] = date("Y-m-d H:i");
                    $dbins['date'] = post('date');
                    $darr = false;
                    $tarr = false;
                    if (isset($_POST['date'])) {
                        $dtarr = explode(' ', post('date'));
                        if (isset($dtarr[0]))
                            $darr = explode('-', $dtarr[0]);
                        else $darr = array(0 => date("Y"), 1 => date('m'), 2 => date('d'));
                        if (isset($dtarr[1]))
                            $tarr = explode(':', $dtarr[1]);
                        else $tarr = array(0 => 0, 1 => 0);
                    }
                    if (is_array($darr) && is_array($tarr))
                        $dbins['date_unix'] = mktime($tarr[0], $tarr[1], 0, $darr[1], $darr[2], $darr[0]);
                    //vdd($dbins['date_unix']);
                } elseif ($fieldtype['view'] == 'datetime') {                                                                                           // DATETIME
                    $dbins[$name] = post($name);
                    $darr = false;
                    $tarr = false;
                    if (isset($_POST[$name])) {
                        $dtarr = explode(' ', post($name));
                        if (isset($dtarr[0]))
                            $darr = explode('-', $dtarr[0]);
                        //else $darr = array(0 => date("Y"), 1 => date('m'), 2 => date('d'));
                        if (isset($dtarr[1]))
                            $tarr = explode(':', $dtarr[1]);
                        //else $tarr = array(0 => 0, 1 => 0);
                    }
                    if (is_array($darr) && is_array($tarr))
                        $dbins[$name . '_unix'] = mktime($tarr[0], $tarr[1], 0, $darr[1], $darr[2], $darr[0]);
                    //vdd($dbins['date_unix']);
                } elseif ($fieldtype['view'] == 'date') {                                                                                           // DATE
                    $dbins[$name] = post($name);

                    $darr = false;
                    if (isset($_POST[$name])) {
                        $darr = explode('-', post($name));
                        if (isset($darr[0]) && isset($darr[1]) && isset($darr[2])) {
                            $dbins[$name . '_unix'] = mktime(0, 0, 0, $darr[1], $darr[2], $darr[0]);
                        }
                    }
                } elseif ($fieldtype['view'] == 'time') {                                                                                           // TIME
                    $dbins[$name] = post($name);
//            $darr = false;
//            $tarr = false;
//            if (isset($_POST[$name])) {
//                $darr = explode('-', post($name));
//                if(isset($darr[0]) && isset($darr[1]) && isset($darr[2])){
//                    $dbins[$name.'_unix'] = mktime(0, 0, 0, $darr[1], $darr[2], $darr[0]);
//                }
//            }
                } elseif ($fieldtype['view'] == 'checkbox') {                                                                           // CHECKBOX
                    $res = 0;
                    if (isset($_POST[$name]) && $_POST[$name] == true)
                        $res = 1;
                    $dbins[$name] = $res;
                } elseif ($fieldtype['view'] == 'image') {                                                                               // IMAGE

                    // Удаляем не нужную картинку
                    if (isset($_POST[$name . "_del"])) {
                        //vdd($dbins[$name]);
                        @unlink($_SERVER['DOCUMENT_ROOT'] . $dbins[$name]);
                        $article[$name] = "";
                    }

                    if (isset($_FILES[$name])) { // проверка, выбран ли файл картинки
                        if ($_FILES[$name]['name'] != '') {
                            // Удаляем не нужную картинку
                            if (isset($item[$name]))
                                @unlink($_SERVER['DOCUMENT_ROOT'] . $item[$name]);

                            $extantion = substr($_FILES[$name]['name'], stripos($_FILES[$name]['name'], '.') + 1);

                            //var_dump($extantion);
                            /** @var $generatedName - ГЕНЕРИРУЕМ ИМЯ ФАЙЛА */
                            $filename = date('Y-m-d_H:i:s');
                            if (isset($item['name']))
                                $filename = $item['name'];

                            $watermark = false;
                            if (getOption($type . '_watermark') == 1)
                                $watermark = true;

                            $config = array(
                                'name' => $filename,
                                'file' => $name,
                                'type' => $type,
                                'encrypt_name' => true,
                                'extantion' => $extantion,
                                'watermark' => $watermark
                            );
                            //vd($config);
                            $filearr = uploadFile($config);
                            //$filearr = upload_file($type, $name, true, array('name'=> $generatedName));
                            $file = '/upload/' . $type . '/' . date("Y-m-d") . '/' . $filearr['file_name'];
                            $dbins[$name] = $file;
                        }
                    }
                } elseif ($fieldtype['view'] == 'youtube') {                                                                            // YOUTUBE
                    $res = "";
                    if (isset($_POST[$name]) && $_POST[$name] != '') {
                        $res = $_POST[$name];
                        $res = str_replace('https://www.youtube.com/watch?v=', '', $res);
                        $res = str_replace('https://youtu.be/', '', $res);
                        if ($res != '') {
                            if (!isset($_FILES['images'])) {
                                $image = file_get_contents('https://i.ytimg.com/vi/' . $res . '/hqdefault.jpg?custom=true&w=504&h=282');
                                if ($image) {
                                    $path = $_SERVER['DOCUMENT_ROOT'] . '/upload/' . $type . '/' . date("Y-m-d") . '/';
                                    if (!file_exists($path))
                                        mkdir($path);
                                    $file = $path . $res . '.jpg';
                                    if (file_put_contents($file, $image)) {
                                        $dbins['image'] = '/upload/' . $type . '/' . date("Y-m-d") . '/' . $res . '.jpg';
                                    } else {
                                        echo 'Файл картинки с Youtube не был скачан((';
                                    }
                                }
                            }
                        }

                    }
                    $dbins[$name] = $res;
                } elseif ($fieldtype['view'] == 'file') {                                                                                       // FILE

                    // Удаляем не нужную картинку
                    if (isset($_POST[$name . "_del"])) {
                        //vdd($dbins[$name]);
                        @unlink($_SERVER['DOCUMENT_ROOT'] . $dbins[$name]);
                        $article[$name] = "";
                    }

                    if (isset($_FILES[$name])) { // проверка, выбран ли файл картинки
                        if ($_FILES[$name]['name'] != '') {
                            $filearr = upload_file($type, $name);
                            $file = '/upload/' . $type . '/' . date("Y-m-d") . '/' . $filearr['file_name'];
                            $dbins[$name] = $file;
                        }
                    }
                } elseif ($fieldtype['view'] == 'tags' && $name == 'tags') {                                                                  // TAGS
                    $CI->load->model('Model_tags', 'tags');
                    $dbins['tags'] = $tags = post('tags');
                    if ($tags != '') {
                        $arr = explode(',', $tags);
                        foreach ($arr as $tag) {
                            $tag = trim($tag);
                            $inDb = $CI->tags->getByName($tag);   // ищем тэг
                            if (!$inDb) {                             // если тэга нет в бд, то добавляем
                                $CI->load->helper('translit_helper');
                                $tagUrl = translitRuToEn($tag);
                                $newTag = array(
                                    'name' => $tag,
                                    'url' => $tagUrl
                                );
                                $CI->db->insert('tags', $newTag);
                            } else {                                // если тэг найден, увеличиваем его count
                                $inDb['count'] = $inDb['count'] + 1;
                                $CI->db->where('id', $inDb['id'])->limit(1)->update('tags', $inDb);
                            }
                        }
                    }
                } elseif ($fieldtype['view'] == 'multiple-select') {                                                                        // MULTIPLE-SELECT
                    $dbins[$name] = json_encode(post($name));
                } else {                                                                                                                    // ОСТАЛЬНЫЕ ПОЛЯ
                    if (isset($_POST[$name]))
                        $dbins[$name] = post($name);
                    if ($s['multilanguage'] == 1) {
                        // Если текущее поле мультиязычно
                        ////////////////////////////

                        if ($languagesCount > 1) {   // если больше 1-го языка
                            $value = '';
                            foreach ($langs as $lang) {
                                if (isset($_POST[$name . '_' . $lang]) && $_POST[$name . '_' . $lang] != '') {
                                    $value = post($name . '_' . $lang);
                                    //vdd($use_translations);
                                    if (($use_translations) && ($s['translation_table'] == 1) && ($lang != $default_lang)) {          // если переводы храним в специальной таблице...
                                        $new = 0;
                                        if ($itemId != false)
                                            $itemId = 0;
                                        else {
                                            $itemId = getUserId();
                                            $new = 1;
                                        }
                                        $translate = addOrEditTranslate($itemId, $name, $lang, $type, $value, $new);

                                        // вставляем вместо текста ID текущего перевода
                                        $value = "[**translate:" . $translate['id'] . ']';
                                    }
                                    if ($lang == $default_lang) {
                                        //vd("LANG");vd(post($name . '_' . $lang));
                                        $dbins[$name] = $value;
                                    } else
                                        $dbins[$name . '_' . $lang] = $value;
                                } elseif (isset($_POST[$name]))
                                    $dbins[$name] = post($name);
                            }
                        }
                    }
                }
            }
            //die();
            //vd($dbins);die();
            return $dbins;
        }

        /**
         * @param string $type
         * @param string $file
         * @param bool $encrypt_name
         * @param array $cfg
         * @return mixed
         */
        function upload_file($type = 'articles', $file = 'userfile', $encrypt_name = true, $cfg = array('name' => false), $newUploader = true)
        {
            if ($newUploader) {
                $config['type'] = $type;
                $config['file'] = $file;
                $config['encrypt_name'] = $encrypt_name;
                $config['name'] = $cfg['name'];
                return uploadFile($config);
            }
            //vdd($type);
            // Проверка наличия папки текущей даты. Если нет, то создать
            $path = 'upload/' . $type . '/' . date("Y-m-d") . '/';
            if (!file_exists('./' . $path)) {
//vd($file);
                mkdir('./' . $path, 0777);
            }
            /*
            if (!file_exists($_SERVER['DOCUMENT_ROOT'] . '/upload/original/' . date("Y-m-d") . '/')) {
                mkdir($_SERVER['DOCUMENT_ROOT'] . '/upload/original/' . date("Y-m-d") . '/', 0777);
            }
            */
            //////
            // Функция загрузки и обработки фото
            $config['upload_path'] = $path;
            $config['allowed_types'] = 'jpg|png|gif|jpe|pdf|doc|docx|xls|xlsx';
            $config['max_size'] = '0';
            $config['max_width'] = '0';
            $config['max_height'] = '0';
            $config['encrypt_name'] = $encrypt_name;
            $config['overwrite'] = true;

            $CI = &get_instance();

            $CI->load->library('upload', $config);

            if (!$CI->upload->do_upload($file)) {
                echo $CI->upload->display_errors();
                die();
            } else {
                $ret = $CI->upload->data();

                $res = strpos($ret['file_type'], 'image');
                if ($res !== false && $ret['image_type'] != 'png') {
                    $width = false;
                    $height = false;
                    if (isset($cfg['width']) && isset($cfg['height'])) {
                        $width = $cfg['width'];
                        $height = $cfg['height'];
                    }
                    if (!$width && !$height) {
                        $width = getOption($type . '_foto_max_width');
                        $height = getOption($type . '_foto_max_height');
                    }

                    if ($width != false && $height != false) {
                        if (($ret['image_width'] != '') && $ret['image_width'] < $width)
                            $width = $ret['image_width'];
                        if (($ret['image_height'] != '') && $ret['image_height'] < $height)
                            $height = $ret['image_height'];

                        $config['width'] = $width;
                        $config['height'] = $height;

                        $config['image_library'] = 'GD2';
                        $config['create_thumb'] = false;
                        $config['maintain_ratio'] = TRUE;

                        /** Генерируем мля файла */
                        if (isset($cfg['name']) && $cfg['name'] != '') {
                            //vdd("gen");
                            $ret['file_name'] = createFilename($cfg['name'], $ret['file_ext'], $type);
                            var_dump($ret['file_name']);
                            die();
                        }

                        $config['source_image'] = $ret["file_path"] . $ret['file_name'];
                        $config['new_image'] = $ret["file_path"] . $ret['file_name'];
                        $config['thumb_marker'] = '';
                        $CI->image_lib->initialize($config);
                        $CI->image_lib->resize();
                    }

                    // Проверяем нужен ли водяной знак на картинках в статьях
                    $article_watermark = getOption('article_watermark');
                    if ($article_watermark === false)
                        $article_watermark = 1;
                    if ($article_watermark) {
                        // Получаем файл водяного знака
                        $watermark_file = getOption('watermark_file');
                        if ($watermark_file === false)
                            $watermark_file = 'img/logo.png';
                        //
                        // Получаем вертикальную позицию водяного знака
                        $watermark_vertical_alignment = getOption('watermark_vertical_alignment');
                        if ($watermark_vertical_alignment === false)
                            $watermark_vertical_alignment = 'bottom';
                        // Получаем горизонтальную водяного знака
                        $watermark_horizontal_alignment = getOption('watermark_horizontal_alignment');
                        if ($watermark_horizontal_alignment === false)
                            $watermark_horizontal_alignment = 'center';
                        //
                        // Получаем прозрачность водяного знака
                        $watermark_opacity = getOption('watermark_opacity');
                        if ($watermark_opacity === false)
                            $watermark_opacity = '20';
                        //

                        $config['source_image'] = $ret["file_path"] . $ret['file_name'];
                        $config['create_thumb'] = FALSE;
                        $config['wm_type'] = 'overlay';
                        $config['wm_type'] = 'overlay';
                        $config['wm_opacity'] = $watermark_opacity;
                        $config['wm_overlay_path'] = $watermark_file;
                        $config['wm_hor_alignment'] = $watermark_horizontal_alignment;
                        $config['wm_vrt_alignment'] = $watermark_vertical_alignment;
                        $CI->image_lib->initialize($config);
                        $CI->image_lib->watermark();
                    }
                }
                //vdd($ret);
                return $ret;
            }
        }

        /**
         * Новая функция для загрузки файла
         * с генерацией, либо транслитерацией
         * имени файла
         *
         * @param array $config
         * @return mixed
         */


        function getModuleTitle($name, $modulesArr)
        {
            if (is_array($modulesArr)) {
                foreach ($modulesArr as $module) {
                    if ($module['name'] == $name) ;
                    return $module['title'];
                }
            }
        }

        // Перебераем пункты меню рекурсивно
        function parseJsonArray($jsonArray, $parentID = 0)
        {
            $return = array();
            foreach ($jsonArray as $subArray) {
                $returnSubSubArray = array();
                if (isset($subArray['children'])) {
                    $returnSubSubArray = parseJsonArray($subArray['children'], $subArray['id']);
                }
                $return[] = array('id' => $subArray['id'], 'parentID' => $parentID);
                $return = array_merge($return, $returnSubSubArray);
            }
            return $return;
        }

        function adminSetShortCodes($value, $shortCodes = array())
        {
            foreach ($shortCodes as $key => $item) {
                $value = str_replace($key, $item, $value);
            }
            return $value;
        }

        function showAddingFoto($image){
        $imgPath = $image['image'];
        //                            var_dump(X_PATH.$imgPath);
        //                            var_dump(file_exists(X_PATH.$imgPath));
        $noImgFile = false;
        $inputImgPath = $imgPath;
        if (!file_exists($_SERVER['DOCUMENT_ROOT'] . $imgPath)) {
            if (file_exists(X_PATH . $imgPath)) {
                $imgPath = GENERAL_DOMAIN . $imgPath;
                $inputImgPath = $imgPath;
            } else
                $noImgFile = true;
        }
        ?>

    <li id="image-<?= $image['id'] ?>" class="article-image ui-state-default">
        <div style="float: left">
            <div class="article-img" style="">
                <?php if (!$noImgFile) { ?>
                    <img src="<?= $imgPath ?>"
                         style="max-width: 250px; max-height: 160px;  line-height: 250px !important"/>
                <?php } else echo 'Файл картинки не найден на сервере!'; ?>
            </div>

            <div style="display: none">
                <input class="image_show_in_buttom" type="checkbox" image_id="<?= $image['id'] ?>"
                       name="show_in_bottom"<?php if ($image['show_in_bottom'] == 1) echo ' checked'; ?> />Показать
                внизу<br/>
            </div>

            <?php
            $articles_adding_images_types = getOption('articles_adding_images_types');
            if ($articles_adding_images_types) {
                $typesArr = explode(',', $articles_adding_images_types);
                if (is_array($typesArr)) {
                    ?>
                    Тип:<br/>
                    <select class="form-control adding-image-type" id="image-<?= $image['id'] ?>-type"
                            image_id="<?= $image['id'] ?>" name="type">
                        <option></option>
                        <?php
                        foreach ($typesArr as $item) {
                            $item = trim($item);
                            $image['type'] = trim($image['type']);
                            echo '<option value="' . $item . '"';
                            if ($item == $image['type']) echo ' selected';
                            echo '>' . $item . '</option>';
                        }
                        ?>
                    </select><br/>
                    <?php
                }
            }
            ?>


            <input id="image-<?= $image['id'] ?>-active" class="bootstrap-switch switch-alt image_active"
                   data-on-color="success" data-off-color="default" data-on-text="ДА" data-off-text="НЕТ"
                   type="checkbox" image_id="<?= $image['id'] ?>"
                   name="active"<?php if ($image['active'] == 1) echo ' checked'; ?> /> Активный<br/>

        </div>
        <div style="float:left; padding-left: 20px">
            <textarea id="image-<?= $image['id'] ?>-text" style="width: 600px; height: 400px"
                      class="form-control ckeditor" name="text"
                      image_id="<?= $image['id'] ?>"><?= $image['text'] ?></textarea>
            <?php
            echo '
                                    <script>
                            $(document).ready(function () {
                                if ( typeof CKEDITOR !== \'undefined\' ) {
                                    CKEDITOR.addCss( \'img {max-width:; height: auto;}\' );
                                    var editor = CKEDITOR.replace( \'image-' . $image['id'] . '-text\', {
                                        extraPlugins: \'uploadimage,image2,codemirror\',
                                        removePlugins: \'image\',
                                        height: \'150px\',
                                        width: \'100%\'
                                    } );
                                    CKFinder.setupCKEditor( editor );
                                } else {
                                    document.getElementById( \'editor1\' ).innerHTML = \'<div class="tip-a tip-a-alert">This sample requires working Internet connection to load CKEditor from CDN.</div>\'
                                }
                            });
                        </script>
                                    ';
            ?>
        </div>


        <div style="clear: both;width: 100%"></div>
        Путь к файлу:<br/>
        <input class="active-input" type="text"
               value="<?= $inputImgPath ?>" style="width: 100%"/><br>

        <button type="button" class="btn btn-primary image-save" image_id="<?= $image['id'] ?>" data-toggle="button"
                style="width: 80%; float: left">Сохранить изменения
        </button>

        <button type="button" data-loading-text="Loading..." image_id="<?= $image['id'] ?>"
                class="loading-example-btn btn btn-danger image_delete" style="width: 20%; float: right">Удалить
        </button>

        <?php
        }

        function showAddingCategoryFoto($image){
        $imgPath = $image['image'];
        //                            var_dump(X_PATH.$imgPath);
        //                            var_dump(file_exists(X_PATH.$imgPath));
        $noImgFile = false;
        $inputImgPath = $imgPath;
        if (!file_exists($_SERVER['DOCUMENT_ROOT'] . $imgPath)) {
            if (file_exists(X_PATH . $imgPath)) {
                $imgPath = GENERAL_DOMAIN . $imgPath;
                $inputImgPath = $imgPath;
            } else
                $noImgFile = true;
        }
        ?>

    <li id="image-<?= $image['id'] ?>" class="article-image ui-state-default">
        <div style="float: left">
            <div class="article-img" style="">
                <?php if (!$noImgFile) { ?>
                    <img src="<?= $imgPath ?>"
                         style="max-width: 250px; max-height: 160px;  line-height: 250px !important"/>
                <?php } else echo 'Файл картинки не найден на сервере!'; ?>
            </div>

            <div style="display: none">
                <input class="image_show_in_buttom" style="display: none" type="checkbox" image_id="<?= $image['id'] ?>"
                       name="show_in_bottom" checked/>Показать внизу<br/>
            </div>

            <?php
            $articles_adding_images_types = getOption('articles_adding_images_types');
            if ($articles_adding_images_types) {
                $typesArr = explode(',', $articles_adding_images_types);
                if (is_array($typesArr)) {
                    ?>
                    Тип:<br/>
                    <select style="display: none" class="form-control adding-image-type"
                            id="image-<?= $image['id'] ?>-type" image_id="<?= $image['id'] ?>" name="type">
                        <option></option>
                        <?php
                        foreach ($typesArr as $item) {
                            $item = trim($item);
                            $image['type'] = trim($image['type']);
                            echo '<option value="' . $item . '"';
                            if ($item == $image['type']) echo ' selected';
                            echo '>' . $item . '</option>';
                        }
                        ?>
                    </select><br/>
                    <?php
                }
            }
            ?>


            <input id="image-<?= $image['id'] ?>-active" class="bootstrap-switch switch-alt image_active"
                   data-on-color="success" data-off-color="default" data-on-text="ДА" data-off-text="НЕТ"
                   type="checkbox" image_id="<?= $image['id'] ?>"
                   name="active"<?php if ($image['active'] == 1) echo ' checked'; ?> /> Активный<br/>

        </div>
        <div style="display:none; float:left; padding-left: 20px">
            <textarea id="image-<?= $image['id'] ?>-text" style="width: 600px; height: 400px"
                      class="form-control" name="text"
                      image_id="<?= $image['id'] ?>"><?= $image['text'] ?></textarea>
            <?php
            echo '
 
';
            ?>
        </div>

        <div style="clear: both;width: 100%"></div>
        Путь к файлу:<br/>
        <input class="active-input" type="text"
               value="<?= $inputImgPath ?>" style="width: 100%"/><br>

        <button type="button" class="btn btn-primary image-save" image_id="<?= $image['id'] ?>" data-toggle="button"
                style="width: 80%; float: left">Сохранить изменения
        </button>

        <button type="button" data-loading-text="Loading..." image_id="<?= $image['id'] ?>"
                class="loading-example-btn btn btn-danger image_delete" style="width: 20%; float: right">Удалить
        </button>

        <?php
        }

        function showAdminPanelOnFrontend($type, $id = false){
        ?>
        <link rel="stylesheet" href="<?= GENERAL_DOMAIN ?>/css/admin-panel.css">

        <!-- Switcher -->
        <div class="demo-options">
            <div class="demo-options-icon"><i class="fa fa-cog fa-spin"></i></div>
            <div class="demo-heading">Настройки</div>

            <div class="demo-body">
                <div class="tabular">
                    <div class="tabular-row">
                        <div class="option-title">
                            <a href="/admin/">Панель администратора</a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="demo-body">
                <div class="tabular">
                    <div class="tabular-row">
                        <div class="option-title">
                            <a href="/admin/banners/?type-slider">Слайдер</a>
                        </div>
                    </div>
                </div>
            </div>

            <?php if ($type == 'pages') { ?>
                <div class="demo-body">
                    <div class="tabular">
                        <div class="tabular-row">
                            <div class="option-title">
                                <h5>Страница:</h5>
                                <a href="/admin/pages/edit/<?= $id ?>">Редактировать страницу</a><br/>
                                <a href="/admin/pages/add/">Создать страницу</a><br/>
                                <a href="/admin/pages/">Все страницы</a><br/>
                            </div>
                        </div>
                    </div>
                </div>
            <?php } ?>

            <?php if ($type == 'articles') { ?>
                <div class="demo-body">
                    <div class="tabular">
                        <div class="tabular-row">
                            <div class="option-title">
                                <h5>Статья:</h5>
                                <a href="/admin/articles/edit/<?= $id ?>/">Редактировать статью</a><br/>
                                <a href="/admin/articles/add/">Добавить статью</a><br/>
                                <a href="/admin/articles/">Все статьи</a>
                            </div>
                        </div>
                    </div>
                </div>
            <?php } ?>

            <?php if ($type == 'products') { ?>
                <div class="demo-body">
                    <div class="tabular">
                        <div class="tabular-row">
                            <div class="option-title">
                                <h5>Товар:</h5>
                                <a href="/admin/products/edit/<?= $id ?>/">Редактировать товар</a><br/>
                                <a href="/admin/products/add/">Добавить товар</a><br/>
                                <a href="/admin/products/">Все товары</a>
                            </div>
                        </div>
                    </div>
                </div>
            <?php } ?>

            <?php if ($type == 'categories') { ?>
                <div class="demo-body">
                    <div class="tabular">
                        <div class="tabular-row">
                            <div class="option-title">
                                <h5>Раздел: <strong>[category_name]</strong></h5>
                                <a href="/admin/categories/edit/<?= $id ?>/">Редактировать раздел</a><br/>
                                <a href="/admin/categories/add/">Создать раздел</a><br/>
                                <a href="/admin/articles/add/?category_id=<?= $id ?>">Добавить статью</a><br/>
                                <a href="/admin/categories/">Все разделы</a>
                            </div>
                        </div>
                    </div>
                </div>
            <?php } ?>

            <div class="demo-body">
                <div class="tabular">
                    <div class="tabular-row">
                        <div class="option-title">
                            <a href="/login/logout/">Выход</a>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        </div>
        <!--    <script type="text/javascript" src="--><? //=GENERAL_DOMAIN
        ?><!--/includes/assets/js/bootstrap.min.js"></script> 								<!-- Load Bootstrap -->
        <!--    <script type="text/javascript" src="//new.xx.org.ua/application/views/favorit/assets/js/jquery.min.js"></script>-->
        <!-- /Switcher -->
        <script type="text/javascript"
                src="<?= GENERAL_DOMAIN ?>/includes/assets/plugins/bootstrap-switch/bootstrap-switch.js"></script>
        <!-- Swith/Toggle Button -->
        <script type="text/javascript" src="<?= GENERAL_DOMAIN ?>/js/admin/switcher.js"></script>
        <!-- Swith/Toggle Button -->
    <?php
}