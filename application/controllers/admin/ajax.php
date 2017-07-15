<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Ajax extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->helper('login_helper');
        isAdminLogin();
        $this->load->model('Model_admin', 'ma');
        $this->load->helper('admin_helper');
        beforeOutput();
    }

    /////////////////////////////////////////////////////////////////////////

    public function menus($action)
    {
        $ret = "";
        $menu = post('menu');
        if ($action == 'save_positions') {
            $serialized = post('serialized');
            $arr = json_decode($serialized, true, 64);

            $readbleArray = parseJsonArray($arr);
            $num = 0;
            foreach ($readbleArray as $key => $value) {
                if (is_array($value)) {
                    $data = array(
                        'num' => $key,
                        'parent_id' => $value['parentID']
                    );

                    $this->db->where('id', $value['id'])->limit(1)->update('menus', $data);
                    $ret .= $key . ' num: ' . $key . '<br />';
                    $num++;
                }
            }
            echo $ret;
        } elseif ($action == 'get_by_position') {
            $position = post('position');
            if ($position) {
                $this->load->model('Model_menus', 'menus');
                $menus = $this->menus->getMenuByPosition($position);
                if ($menus) {
                    foreach ($menus as $m)
                        echo '<option value="' . $m['id'] . '">' . $m['name'] . '</option>';
                }
            }
        }
    }

    public function file($action)
    {
        $filePath = post('filePath');
        if ($filePath) {
            if ($action == 'delete') {
                @unlink($filePath);
            }
        }
    }

    public function tags($action)
    {
        $this->load->model('Model_tags', 'tags');
        if (isset($_GET['tag_search'])) $_POST['tag_search'] = $_GET['tag_search'];
        if (isset($_GET['id'])) $_POST['id'] = $_GET['id'];
        if ($action == 'search' && post('tag_search') != false) {                     // TEG_SEARCH
            $search = post('tag_search');
            $tags = $this->tags->search($search, 10);
            $json = [];
            if ($tags) {
                foreach ($tags as $tag) {
                    $json[] = $tag['name'];
                }
            }
            echo json_encode($json);
        } elseif ($action == 'recount') {                                             // RECOUNT
            $tagId = post('id');
            if ($tagId) {
                $tag = $this->tags->getById($tagId);
                if ($tag) {
                    $count = $this->tags->getCountOfUses($tag['name']);
                    echo $count;
                } else echo '0';
            } else echo '0';
        }
    }

    public function cache($action)
    {
        if ($action == 'clear_db' || $action == 'clear_all') {
            $this->db->update('articles', array('url_cache' => NULL));
            echo '<div>Кэш статей успешно очищен!</div>';
            $this->db->update('products', array('url_cache' => NULL));
            echo '<div>Кэш товаров успешно очищен!</div>';
            $this->db->query("TRUNCATE TABLE `breadcrumbs_cache` ");
            echo '<div>Кэш хлебных крошек успешно очищен!</div>';
        }
        if ($action == 'clear_files' || $action == 'clear_all') {
            $cachePath = 'application/cache/';
            $this->load->helper('file');
            $cache = get_filenames($cachePath);
            foreach ($cache as $item) {
                if ($item != '.htaccess' && $item != 'index.html') {
                    $ret = unlink($cachePath . $item);
                    echo '<div>Файл: ' . $cachePath . $item . ' удалён!</div>';
                }
            }
        }
        echo '<div><strong>Операция прошла успешно!</strong></div>';
    }

    public function update($action)
    {
        if ($action == 'get_latest_build') {
            $build = file_get_contents("http://update.xx.org.ua/latest_build.php");
            if ($build) {
                echo $build;
            } else echo 'Сбой опперации...(';
        } elseif ($action == 'create') {
            $build = file_get_contents("//" . $_SERVER['SERVER_NAME'] . "/admin/update/create/");
            if ($build) {
                echo $build;
            } else echo 'Сбой опперации...(';
        } elseif ($action == 'create_backup') {

        }

    }

    public function getFullUrl($type, $id)
    {
        $item = false;
        if ($type == 'category') {
            $item = $this->model_categories->getCategoryById($id);
        } elseif ($type == 'page') {
            $this->load->model('Model_pages', 'pages');
            $item = $this->pages->getPageById($id);
        }

        if ($item && $type != 'page')
            echo getFullUrl($item);
        elseif ($item && $type == 'page')
            echo '/' . $item['url'] . '/';
        else echo 'error';
    }

    public function getNameOf($type, $id, $lang = false)
    {
        $item = false;
        if ($type == 'category') {
            $item = $this->model_categories->getCategoryById($id);
        } elseif ($type == 'page') {
            $this->load->model('Model_pages', 'pages');
            $item = $this->pages->getPageById($id);
        }

        if ($item) {
            $name = 'name';
            if ($lang) $name .= '_' . $lang;
            echo $item[$name];
        } else echo 'error';
    }

    public function ping()
    {
        $url = post('url');

        echo 'ping';
    }

    public function modules_action($module)
    {
        // Module: Todo List
        if ($module == 'todo_list') {
            $id = post('id');
            $status = post('status');
            if ($id && $status) {
                $this->db->where('id', $id)->limit(1)->update('module_todo_list', array('status' => $status));
                echo "Статус Todo id: " . $id . ' изменён на: ' . $status;
            }
        }
    }

    public function set_user_details()
    {
        $login = userdata('login');
        $data = post('data');
        //vdd($data);
        $data = json_decode($data, true);
        //vdd($data['notes']);
        $ret = $this->db->where('login', $login)->limit(1)->update('users', $data);
        if ($ret) showMessageDone("", "Сохранено успешно!");
        else showMessageError("", "Ошибка сохранения!!!");
    }

    public function notification($action)
    {
        $id = post('id');
        if (!$id && isset($_GET['id'])) $id = $_GET['id'];
        if ($id) {
            if ($action == 'get') {
                $ret = $this->ma->getNotification($id);
                header("Content-type:application/json");
                echo json_encode($ret);
            } elseif ($action == 'set_status') {
                $status = post('status');
                $this->db->where('id', $id)->limit(1)->update('admin_notifications', array('status' => $status));
            }
        }
    }

    public function option($action)
    {
        $this->load->model('Model_fieldtypes', 'ft');
        if (isset($_GET['name'])) $_POST['name'] = $_GET['name'];
        if (isset($_GET['value'])) $_POST['value'] = $_GET['value'];
        if (post('name') !== false) {
            $name = post('name');
            $value = post('value');

            if ($action == 'get_option') {
                $notId = post('id');
                //alert($notId);
                $option = getOption($name, true, $notId);
                if ($option) echo $option['value'];
                elseif (!isset($option['id']))
                    echo 'false';
            } elseif ($action == 'set') {
                $this->db->where('name', post('name'))->limit(1)->update('options', array('value' => post('value')));
                echo 'Опция ' . post('name') . ' была изменена на: ' . post('value');
            } elseif ($action == 'get_form_fieldtype') {                                                                     // Вытаскивваем поле для редактирования, нужного нам типа
                $option = false;
                if (isset($_POST['option'])) $option = json_decode(post('option'));
                ?>
                <div class="form-group">
                    <label class="col-sm-2 control-label">
                        Значение:
                    </label>
                    <div class="col-sm-8">
                        <?php
                        $fieldtype = $this->ft->getByName($name);
                        $inputType = 'text';
                        $formElem = 'input';
                        if ($fieldtype['view'] == 'number' || $fieldtype['view'] == 'double-number') $inputType = 'number';
                        elseif ($fieldtype['view'] == 'email') $inputType = 'email';
                        elseif ($fieldtype['view'] == 'file') $inputType = 'file';
                        elseif ($fieldtype['view'] == 'checkbox') $inputType = 'checkbox';
                        elseif ($fieldtype['view'] == 'textarea') $formElem = 'textarea';
                        elseif ($fieldtype['view'] == 'select') $formElem = 'select';
                        elseif ($fieldtype['view'] == 'youtube') {
                            $formElem = 'input';
                            $inputType = 'text';
                        } elseif ($fieldtype['view'] == 'editor') {
                            $formElem = 'textarea';
                            $inputType = 'editor';
                        }

                        if ($formElem == 'input') {
                            if ($fieldtype['view'] == 'checkbox') {
                                echo '<input class="bootstrap-switch" name="value" type="checkbox" id="inp_value" data-size="mini" data-on-color="success" data-off-color="default" data-on-text="I" data-off-text="O">';
                            }
                            else {
                                ?>
                                <input value_type="<?= $fieldtype['view'] ?>" id="inp_value" class="form-control"
                                       type="<?= $inputType ?>" name="value"
                                       value="<?php if (isset($option['value'])) echo $option['value']; ?>">
                                <?php
                                if ($fieldtype['view'] == 'tags'){
                                    ?>
                        <link type="text/css" href="<?=GENERAL_DOMAIN?>/includes/assets/plugins/form-select2/select2.css"
                              rel="stylesheet">                        <!-- Select2 -->
                            <script type="text/javascript"
                                    src="<?= GENERAL_DOMAIN ?>/includes/assets/js/jquery-1.10.2.min.js"></script>
                            <script type="text/javascript" src="<?= GENERAL_DOMAIN ?>/includes/assets/plugins/form-select2/select2.min.js"></script>
                            <script>
                                var j = jQuery.noConflict();
                                j(document).ready(function () {
                                    j("#inp_value").select2({width: "100%", tags:["red", "white", "purple", "orange", "yellow"]});
                                });


                            </script>
                                    <?php
                                }
                                elseif ($fieldtype['view'] == 'youtube')
                                    echo '<div id="value_youtube">video</div>';
                                ?>
                                    <script type="text/javascript"
                                            src="<?= GENERAL_DOMAIN ?>/includes/assets/js/jquery-1.10.2.min.js"></script>
                                    <script>
                                        $(document).ready(function () {
                                            $("#inp_value").change(function () {
                                                var value = $('#inp_value').val();
                                                console.log('Yutube: ' + value);
                                                value = value.replace('https://youtu.be/', '');
                                                value = value.replace('https://www.youtube.com/watch?v=', '');
                                                $("#value_youtube").html('<iframe width="560" height="315" src="https://www.youtube.com/embed/' + value + '" frameborder="0" allowfullscreen></iframe>');
                                            });

                                        });
                                    </script>
                                <?php
                                }

                        } elseif ($formElem == 'textarea') {
                            echo '<textarea id="opt_value" name="value" class="form-control';
                            if ($inputType == 'editor') echo ' adv_editor ckeditor';
                            echo '">';
                            if (isset($option['value']))
                                echo $option['value'];
                            echo '</textarea>';

                            if ($inputType == 'editor') {
                                echo '
                            <script type="text/javascript" src="' . GENERAL_DOMAIN . '/includes/assets/js/jquery-1.10.2.min.js"></script> 							<!-- Load jQuery -->

                            <script>
                                //Fix since CKEditor can\'t seem to find it\'s own relative basepath
                                CKEDITOR_BASEPATH  =  "' . GENERAL_DOMAIN . '/includes/assets/plugins/form-ckeditor/";
                            </script>
                            <script type="text/javascript" src="' . GENERAL_DOMAIN . '/includes/assets/plugins/form-ckeditor/ckeditor.js"></script>
                            <script>
                                $.noConflict();
                                jQuery(document).ready(function($) {
                                    CKEDITOR.replace( \'opt_value\',{}); 
                                });
                            </script>
                            ';
                            }
                        }
                        elseif ($formElem == 'select') {
                            ?>
                            <input type="text" name="value" class="form-control tokenfield" id="inp_value" value=""
                                   placeholder="Вводите значения, разделяя их запятой"/>
                            <link type="text/css"
                                  href="<?= GENERAL_DOMAIN ?>/includes/assets/plugins/form-tokenfield/bootstrap-tokenfield.css"
                                  rel="stylesheet">        <!-- Tokenfield -->
                                <script type="text/javascript"
                                        src="<?= GENERAL_DOMAIN ?>/includes/assets/js/jquery-1.10.2.min.js"></script>
                                <script type="text/javascript"
                                        src="<?= GENERAL_DOMAIN ?>/includes/assets/plugins/form-tokenfield/bootstrap-tokenfield.min.js"></script>                <!-- Tokenfield -->
                                <script>
                                    $(document).ready(function () {
                                        $('.tokenfield').tokenfield();
                                    });
                                </script>
                            <?php
                        }
                        elseif ($formElem == 'youtube') {
                            ?>
                            <input name="value" type="text" class="form-control tokenfield" id="inp_value" value=""
                               placeholder="Вводите значения, разделяя их запятой"/>
                            <link type="text/css"
                              href="<?= GENERAL_DOMAIN ?>/includes/assets/plugins/form-tokenfield/bootstrap-tokenfield.css"
                              rel="stylesheet">        <!-- Tokenfield -->
                            <script type="text/javascript"
                                    src="<?= GENERAL_DOMAIN ?>/includes/assets/js/jquery-1.10.2.min.js"></script>
                            <script type="text/javascript"
                                    src="<?= GENERAL_DOMAIN ?>/includes/assets/plugins/form-tokenfield/bootstrap-tokenfield.min.js"></script>                <!-- Tokenfield -->
                            <script>
                                $(document).ready(function () {
                                    $('.tokenfield').tokenfield();
                                });
                            </script>
                            <?php
                        }
                        ?>

                    </div>
                </div>
                <?php
            }
        }
    }

    public function categories($action)
    {
        if ($action == 'get_categories_templates') {                                                          // ПОЛУЧАЕМ СПИСОК ШАБЛОНОВ КАТЕГОРИЙ
            $type = post('type');
            if ($type) {
                $this->load->helper('file');
                $files = get_filenames(X_PATH . '/application/views/' . SITE . '/templates/categories/' . $type . '/');
                $count = count($files);
                if (isset($files[0]) && $files[0] != '') {
                    echo '<option value="">- шаблон раздела -</option>';

                    sort($files);
                    for ($i = 0; $i < $count; $i++) {
                        echo '<option value="' . $files[$i] . '"';
                        if (isset($_POST['template']) && $_POST['template'] == $files[$i])
                            echo ' selected';
                        elseif (isset($cat['template']) && $cat['template'] == $files[$i])
                            echo ' selected';
                        echo '>' . $files[$i] . '</option>';
                    }
                } else echo '<option value="">нет шаблонов</option>';
            }
        } elseif ($action == 'get_content_templates') {                                                       // ПОЛУЧАЕМ СПИСОК ШАБЛОНОВ КОНТЕНТА
            $type = post('type');
            if ($type) {
                $this->load->helper('file');
                $files = get_filenames(X_PATH . '/application/views/' . SITE . '/templates/' . $type . '/');
                $count = count($files);
                if (isset($files[0]) && $files[0] != '') {
                    echo '<option value="">- шаблон раздела -</option>';

                    sort($files);
                    for ($i = 0; $i < $count; $i++) {
                        echo '<option value="' . $files[$i] . '"';
                        if (isset($_POST['template']) && $_POST['template'] == $files[$i])
                            echo ' selected';
                        elseif (isset($cat['template']) && $cat['template'] == $files[$i])
                            echo ' selected';
                        echo '>' . $files[$i] . '</option>';
                    }
                } else echo '<option value="">нет шаблонов</option>';
            }
        } elseif ($action == 'get_category_type') {                                                           // ПОЛУЧАЕМ ТИП РАЗДЕЛА
            $category_id = post('category_id');
            if ($category_id) {
                $category = $this->model_categories->getCategoryById($category_id);
                if ($category) {
                    echo $category['type'];
                }
            }
        }
    }


    public function send_foto()
    {
        echo "asd";
    }

    function adresses($action)
    {
        if ($action == 'add') {
            $this->load->model('Model_adresses', 'adresses');
            $old = $this->adresses->getByLatLng($_GET['lat'], $_GET['lng'], $_GET['article_id']);
            if (!$old) {        // Добавление адреса
                //vd($_GET);
                $dbins = array(
                    'article_id' => $_GET['article_id'],
                    'adress' => $_GET['adress'],
                    'lat' => $_GET['lat'],
                    'lng' => $_GET['lng'],
                    'description' => $_GET['descr'],
                    'icon' => $_GET['icon'],
                    'city' => $_GET['city']
                );
                $this->db->insert('adresses', $dbins);
                echo "Адрес успешно добавлен в базу";
            } else echo "Такая запись уже есть в базе адресов!";
        } elseif ($action == 'del') {        // Удаление адреса
            $ret = $this->db->where('id', $_GET['adress_id'])->limit(1)->delete('adresses');
            if ($ret) echo 'Адрес удалён!';
            else echo 'Ошибка удаления';
        } elseif ($action == 'show') {
            // vd($_GET['search']);
            $this->load->library('googlemaps');
            $onclick = '
        $("#coordsLat").val(event.latLng.lat());
        $("#coordsLng").val(event.latLng.lng());
        ';
            $config = array(
                'apiKey' => 'AIzaSyDL-ughU0ynX4JHYIU7m32K3zVF_-0fKgQ',
                'region' => 'ua',
                'https' => true,
                //'center'	=> $article['city'].', '.$article['adress'],
                'zoom' => 'auto',
                'map_div_id' => 'googleMap',
                'scrollwheel' => false,
                'geocodeCaching' => TRUE,
                'onclick' => $onclick

            );

            $this->googlemaps->initialize($config);

            $coords = $this->googlemaps->get_lat_long_from_address($_GET['search']);
            if ($coords[0] != 0 && $coords[1] != 0) {
                $marker['position'] = $coords[0] . ',' . $coords[1];
                $this->googlemaps->add_marker($marker);
            }

            $map = $this->googlemaps->create_map();
            // echo  $map['js'];
            echo $map['html'];
        }
    }

    function json_msg($msg, $err = 0, $value = "null")
    {
        $arr = array(
            'msg' => $msg,
            'err' => $err,
            'value' => $value
        );
        echo json_encode($arr);
    }

    function send_mail()
    {
        echo "test";
        if(isset($_POST['order'])){
            loadHelper('mail');
            $admin_email = getOption('admin_email');
            $message = "Имя: ".post('name').'<br>';
            $message .= "Тел: ".post('tel').'<br>';
            $message .= "Сообщение:<br>".post('message');
            $result = mail_send($admin_email, "Заказ с сайта", $message);
            if($result) echo 'ok';
            else echo 'error';
        }
    }

    function mailer($action)
    {
        $this->load->model('Model_mailer', 'mailer');
        $id = post('id');
        if (!$id && isset($_GET['id'])) $id = $_GET['id'];
        if (!$id) {
            echo $this->json_msg("не передан id рассылки!", 1);
            die();
        }
        $mailer = $this->mailer->getById($id);

        if ($action == 'count') {           // Получаем кол-во писем к отправке
            $count = 0;
            $arr = array();
            $i = 0;

            if ($mailer) {
                if ($mailer['for_users'] == 1) {
                    $this->load->model('Model_users', 'users');
                    $users = $this->users->getUsers();
                    $count = $count + count($users);
                    foreach ($users as $user) {
                        if ($user['mailer'] == 1) {    // проверяем, отправлять ли пользователю
                            $arr[$i] = $user['email'];
                            $i++;
                        }
                    }
                }
                if ($mailer['for_organizations'] == 1) {
                    $this->load->model('Model_articles', 'articles');
                    $articles = $this->articles->getArticlesWithEmails();
                    $count = $count + count($articles);
                    foreach ($articles as $article) {
                        //if ($article['mailer'] == 1) {    // проверяем, отправлять ли организациям
                        $arr[$i] = $article['email'];
                        $i++;
                        //}
                    }
                }
                if ($mailer['emails'] != '') {
                    $emails = explode(',', $mailer['emails']);
                    if (!is_array($emails)) {
                        $count = $count + 1;
                        $arr[$i] = $emails;
                        $i++;
                    } else {
                        $count = $count + count($emails);
                        foreach ($emails as $email) {
                            $arr[$i] = trim($email);
                            $i++;
                        }
                    }
                }
                $dbins = array(
                    'emails_arr' => json_encode($arr),
                    'started' => 1
                );
                $this->db->where('id', $id)->limit(1)->update('mailer', $dbins);

                $ret = array(
                    'count' => $count,
                    'msg' => 'Всего необходимо отправить ' . $count . ' писем',
                    'err' => false
                );

                echo json_encode($ret);
            } else $this->json_msg('рассылка не найдена!', 1);
        } elseif ($action == 'send') {  // ОТПРАВКА ПИСЕМ
            if ($mailer['ended'] == 1) {
                $this->json_msg("Рассылка завершена!", 0, 'ended');
                die();
            }
            $arr = json_decode($mailer['emails_arr']);
            if (is_array($arr) && isset($arr[0])) {
                //vd($arr[0]);
                $arr[0] = trim($arr[0]);
                $this->load->helper('mail_helper');
                $validation = checkEmail($arr[0]);
                $attach = false;
                if ($mailer['file'] != '' && $mailer['file'] != NULL) $attach = $mailer['file'];
                if ($validation) {
                    $ret = mail_send($arr[0], $mailer['name'], $mailer['content'], $attach);
                    if ($ret) {
                        echo $this->json_msg($arr[0] . ' письмо успешно отправлено.');
                    } else $this->json_msg($arr[0] . ' ошибка отправки письма!', 1);
                } else $this->json_msg($arr[0] . ' не является корректным e-mail адресом!', 1);
                // Создаём новый массив ещё не отправленных адресов
                $c = count($arr);
                if (($c - 1) == 0) {
                    //echo $this->json_msg('Рассылка завершена!',0,'ended');
                    $this->db->where('id', $id)->limit(1)->update('mailer', array('ended' => 1, 'status' => 'ended'));
                    die();
                }
                $newarr = array();
                for ($i = 1; $i < $c; $i++) {
                    $newarr[$i - 1] = $arr[$i];
                }
                $arr = $newarr;

                // сохраняем изминения в базу
                $dbins = array(
                    'emails_arr' => json_encode($arr)
                );
                $this->db->where('id', $id)->limit(1)->update('mailer', $dbins);

            } else $this->json_msg('Проблемы с массивом адресов в базе!', 1);
        }
    }

    public function userdata($action)
    {
        if (isset($_GET['name'])) $_POST['name'] = $_GET['name'];
        if (isset($_GET['value'])) $_POST['value'] = $_GET['value'];
        $name = $this->input->post('name');
        $value = $this->input->post('value');
        if ($action == 'set') {
            set_userdata($name, $value);
        } elseif ('unset') unset_userdata($name);
    }

    function saveImageToUpload($image, $name) // Вытаскиваем фото на нащ сервак
    {
        if ($image != '') {
            $opts = array(
                'http' => array(
                    'protocol_version' => '1.1',
                    'method' => 'GET',
                    'user_agent' => 'prawwwda.com'
                )
            );
            $context = stream_context_create($opts);

            $string = file_get_contents($image, false, $context);
            if ($string) {
                $path = $_SERVER['DOCUMENT_ROOT'] . '/upload/articles/' . date("Y-m-d") . '/';
                //var_dump($path);die();
                @mkdir($_SERVER['DOCUMENT_ROOT'] . '/upload/articles/' . date("Y-m-d") . '/');
                $ipos = strrpos($image, '/');
                $iname = substr($image, $ipos + 1);
                $rpos = strrpos($iname, '.');
                $razr = substr($iname, $rpos + 1);
                $url = translitRuToEn($name);

                $qpos = strpos($razr, '?');
                if ($qpos !== false) $razr = substr($razr, 0, $qpos);

                // проверка расширения фото
                if ($razr != 'jpg' && $razr != 'png' && $razr != 'gif') {
                    $razr = 'jpg';
                    echo 'Шэф, обрати внимание на это фото! Возможно, оно будет отображаться не корректно, т.к. у него не стандартное расширение!';
                }

                $iname = $url . '.' . $razr;

                file_put_contents($_SERVER['DOCUMENT_ROOT'] . '/upload/articles/' . date("Y-m-d") . '/' . $iname, $string);
                $image = '/upload/articles/' . date("Y-m-d") . '/' . $iname;

                return $image;
            }
        }
        return false;
    }

    public function import()
    {
        $this->load->model('Model_users', 'users');
        $user = $this->users->getUserByLogin(userdata('login'));
        $user_id = 0;
        if (isset($user['id'])) $user_id = $user['id'];

        $line = 1;
        if (isset($_GET['line'])) $line = $_GET['line'];
        if (isset($_POST['line'])) $line = $_POST['line'];
        $path = 'upload/import/';
        $file = $user_id . '_importnew.xlsx';
        if (file_exists($path . $file)) {
            $this->load->model('Model_articles', 'articles');
            $this->load->helper('translit');
            $filepath = $path . $file;
            //vd($filepath);
            $this->load->library('excel');
            $arr = $this->excel->getExcelArray($filepath);


            $count = count($arr);
            $columns = $arr[0];
            // Проверяем правильность полей
            $ccount = count($columns);
            for ($i = 0; $i < $ccount; $i++) {
                if ($columns[$i] == '' || $columns[$i] == NULL) unset($columns[$i]);
            }
            $dbins = array();
            // перегоняем значения в массив $dbins
            $ccount = count($columns);

            for ($ci = 0; $ci < $ccount; $ci++) {
                $name = $columns[$ci];
                $dbins[$name] = $arr[$line][$ci];
                //echo $dbins[$name].' ';
            }
            if ($dbins['name'] == '') die('end');

            $dbins['date'] = date("Y-m-d");
            $dbins['time'] = date("H:i");

            $dbins['title'] = $dbins['description'] = $dbins['keywords'] = $dbins['name'];

            if ($dbins['id'] == '') { // Добавляем новую
                //if (!$add_new) {
                $search = $this->articles->getArticleByName($dbins['name']);
                //vdd($search);
                if ($search) {       // Если в базе найдено такое-же название
                    set_userdata('import_question', 'В базе найдено соответствие по названию: ' . $dbins['name']);
                    set_userdata('import_article_id', $search['id']);

                    set_userdata('import_start', $i);

                    echo 'Шэф, я нашёл статью с таким-же названием! Оставлю это на тебя.' . "\n\r" . '--------------------------------------------------------------';

                    die();
                }
                //}
//
                unset($dbins['id']);

                // Вытаскиваем фото на нащ сервак
                if ($dbins['image'] != '') {
                    $dbins['image'] = $this->saveImageToUpload($dbins['image'], $dbins['name']);
                    if ($dbins['image'])
                        echo 'Загружено фото: ' . $dbins['name'] . ' - ' . $dbins['image'] . "\n\r";
                    else echo 'Шэф, у нас траблы! Ошибка загрузки фото! ' . $dbins['name'] . "\n\r";;
                }


                if ($dbins['category_id'] != NULL && $dbins['category_id'] != '') {
                    $cat = $this->model_categories->getCategoryById($dbins['category_id']);
                    $dbins['parent_category_id'] = $cat['parent'];
                    $first = $this->model_categories->getFirstLevelCategory($cat);
                    $dbins['first_category_id'] = $first['id'];

                    $dbins['url'] = translitRuToEn($dbins['name']);
                    $this->db->insert('articles', $dbins);
                    echo 'Добавление новой позиции "' . $dbins['name'] . '" - успешно!' . "\n\r";
                } else {
                    //alert('Ошибка добавления! У ' . $dbins['name'] . ' не указана category_id!');
                    echo 'Ошибка добавления новой позиции! У ' . $dbins['name'] . ' не указана category_id!' . "\n\r";
                }

                $add_new = false;
                //vdd($dbins);
            } else { // изменяем существующую
                // Вытаскиваем фото на нащ сервак
                if ($dbins['image'] != '' && substr($dbins['image'], 0, 4) == 'http') {
                    $dbins['image'] = $this->saveImageToUpload($dbins['image'], $dbins['name']);
                    if ($dbins['image'])
                        echo 'Загружено фото: ' . $dbins['name'] . ' - ' . $dbins['image'] . "\n\r";
                    else echo 'Шэф, у нас ошибка загрузки фото к "' . $dbins['name'] . '"' . "\n\r";;
                }
                if ($dbins['category_id'] != NULL) {
                    $cat = $this->model_categories->getCategoryById($dbins['category_id']);
                    $dbins['parent_category_id'] = $cat['parent'];
                    $first = $this->model_categories->getFirstLevelCategory($cat);
                    $dbins['first_category_id'] = $first['id'];
                } else echo 'Шэф, у нас Ошибка! Основная категория для "' . $dbins['name'] . '" не присвоена!' . "\n\r";
                $this->db->where('id', $dbins['id']);
                $this->db->limit(1);
                $this->db->update('articles', $dbins);
                echo 'Шэф, обновление позиции id=' . $dbins['id'] . ' "' . $dbins['name'] . '" прошло успешно!)' . "\n\r";
            }

        } else echo 'no file';
    }

    public function set_active($type, $id, $active)
    {
        $active_mail_sended = false;
        //alert($_SERVER['REQUEST_URI']);
        if ($type == 'articles') {
            $send_active_mail = getOption('send_active_mail');
            if ($send_active_mail == 1) {
                $this->load->model('Model_articles', 'articles');
                $article = $this->articles->getArticleById($id);
//                if ($article['active_mail_sended'] == 0) {
//                    $ret = $this->send_mail('active_mail_sended', $id, true);
//                    if ($ret) $active_mail_sended = true;
//                }
            }
        }

        $dbins = array('active' => $active);
        $this->db->where('id', $id)->limit(1)->update($type, $dbins);
        $status = 'ID: ' . $id . ' в таблице ' . $type . ' был присвоен active=' . $active;
        $params = false;
        if ($active_mail_sended) {
            $status .= '. Создателю отправлено уведомление об активации.';
            $params = 'active_mail_sended';
        }
        exit_status($status, $params);
    }

    public function delete($type, $id)
    {
        $this->db->where('id', $id)->limit(1)->delete($type);
        exit_status('ID: ' . $id . ' в таблице ' . $type . ' был удалён!');
    }

    function set_category_top()
    {
        $category_id = false;
        $top = false;
        $top_position = false;
        if (isset($_GET['category_id'])) $category_id = $_GET['category_id'];
        if (isset($_POST['category_id'])) $category_id = $_POST['category_id'];
        if (isset($_GET['top'])) $top = $_GET['top'];
        if (isset($_POST['top'])) $top = $_POST['top'];
        if (isset($_GET['top_position'])) $top_position = $_GET['top_position'];
        if (isset($_POST['top_position'])) $top_position = $_POST['top_position'];

        $dbins = array(
            'top' => $top,
            'top_position' => $top_position
        );

        $ret = $this->db->where('id', $category_id)->limit(1)->update('categories', $dbins);
        if ($ret) exit_status('Статус категории ID: ' . $category_id . ' изменён');

        else exit_status('Ошибка применения!');
    }

    function upload_files($type = "articles", $article = false)
    {
        $random_name = true;

        $path = 'temp';
        //$upload_dir = 'upload/';
        $upload_dir = 'upload/' . $type . '/'; //Создадим папку для хранения изображений
        $allowed_ext = array('jpg', 'jpeg', 'png', 'gif');      // $allowed_ext - форматы для загрузки
        if (isset($_POST['allowed_ext'])) $allowed_ext = json_decode(post('allowed_ext'));

        //alert(var_dump($allowed_ext));

        if (!file_exists($_SERVER['DOCUMENT_ROOT'] . '/' . $upload_dir))
            mkdir($_SERVER['DOCUMENT_ROOT'] . '/' . $upload_dir, 0777);
//
        $upload_dir .= date("Y-m-d") . '/';
//
        if (!file_exists($_SERVER['DOCUMENT_ROOT'] . '/' . $upload_dir))
            mkdir($_SERVER['DOCUMENT_ROOT'] . '/' . $upload_dir, 0777);

        if (strtolower($_SERVER['REQUEST_METHOD']) != 'post') {
            exit_status('Ошибка при отправке запроса на сервер!');
        }


        if (array_key_exists('file', $_FILES) && $_FILES['file']['error'] == 0) {

            $pic = $_FILES['file'];

            if (!in_array(get_extension($pic['name']), $allowed_ext)) {
                exit_status('Разрешена загрузка следующих форматов: ' . implode(',', $allowed_ext));
            }


            //Загружаем файл во на сервер в нашу папку и посылаем команду о том, что все ОК и файл загружен


            $extantion = substr($pic['name'], stripos($pic['name'], '.')+1);
            $pic['name'] = translitRuToEn(substr($pic['name'],0,-4), true).'.'.$extantion;
            if (file_exists($_SERVER['DOCUMENT_ROOT'] . '/' . $upload_dir . $pic['name']))
                $pic['name'] = str_replace('.', '-1.', $pic['name']);

            if (file_exists($_SERVER['DOCUMENT_ROOT'] . '/' . $upload_dir . $pic['name']))
                $pic['name'] = str_replace('.', time().'.', $pic['name']);

            if (move_uploaded_file($pic['tmp_name'], $upload_dir . $pic['name'])) {

                $image = '/' . $upload_dir . $pic['name'];

                //  if ($type == 'articles') {
                $this->load->Model('Model_images', 'images');
                $article_id = 0;
                if (isset($_POST['article_id'])) $article_id = $_POST['article_id'];
                $show_in_bottom = 0;
                if (isset($_POST['show_in_bottom'])) $show_in_bottom = $_POST['show_in_bottom'];
                $active = 0;
                if (isset($_POST['active'])) $active = $_POST['active'];
                $product_id = 0;
                if (isset($_POST['product_id'])) $product_id = $_POST['product_id'];
                $category_id = 0;
                if (isset($_POST['category_id'])) $category_id = $_POST['category_id'];
                $num = 0;

                $dbins = array(
                    'image' => $image,
                    'article_id' => $article_id,
                    'product_id' => $product_id,
                    'category_id' => $category_id,
                    'show_in_bottom' => $show_in_bottom,
                    'active' => $active,
                    'num' => $num,
                    'date' => date("Y-m-d H:i"),
                    'date_unix' => time(),
                    'login' => userdata('login')
                );

                $this->db->insert('images', $dbins);
                exit_status('Файл Был успешно загружен!', $image);
                //  } else exit_status('Не верный тип, куда кидать!');
            } else exit_status('Ошибка сохранения файла на сервере!');

        }

        exit_status('Во время загрузки произошли ошибки');
    }

    function images_sort_save()
    {
        $article_id = false;
        if (isset($_GET['article_id'])) $article_id = $_GET['article_id'];
        vd($article_id);
        $error = false;
        $order = $_POST['order'];
        vd($order);
        foreach ($order as $i => $id) {
            $post['sort'] = $i;
            $id = str_replace("image-", "", $id);
            //$this->db->where('id', $id)
            vd($id);

            //$result = base::sql_edit("my_table", $post, "where id_sitemap = '$id'"); // update в базе
            if (!$result) $error = true;
        }
        if ($error) {
            // обработка ошибки
        }
    }

    function get_images()
    {
        $category_id = $product_id = $article_id = false;
        if (isset($_POST['article_id'])) $article_id = $_POST['article_id'];
        elseif (isset($_GET['article_id'])) $article_id = $_GET['article_id'];
        elseif (isset($_POST['product_id'])) $product_id = $_POST['product_id'];
        elseif (isset($_GET['product_id'])) $product_id = $_GET['product_id'];
        elseif (isset($_POST['category_id'])) $category_id = $_POST['category_id'];
        elseif (isset($_GET['category_id'])) $category_id = $_GET['category_id'];
        else exit_status('no article id!');

        $this->load->model('Model_images', 'images');
        $images = false;
        if ($article_id)
            $images = $this->images->getByArticleId($article_id);
        elseif ($product_id)
            $images = $this->images->getByProductId($product_id);
        elseif ($category_id)
            $images = $this->images->getByCategoryId($category_id);
        if ($images) {
            ?>

            <div class="scripts">


            </div>

            <?php
            $count = count($images);
            for ($i = 0; $i < $count; $i++) {
                $image = $images[$i];
                if($category_id)
                    showAddingCategoryFoto($image);
                else
                    showAddingFoto($image);
                ?>

                <?php
            }
            ?>


            <?php
        }
    }


    function action_image($image_id = false)
    {
        if (!$image_id && isset($_POST['image_id'])) $image_id = $_POST['image_id'];
        if (!$image_id && isset($_GET['image_id'])) $image_id = $_GET['image_id'];

        $param = false;
        $value = false;

        if (!$param && isset($_POST['param'])) $param = $_POST['param'];
        if (!$param && isset($_GET['param'])) $param = $_GET['param'];

        if (!$value && isset($_POST['value'])) $value = $_POST['value'];
        if (!$value && isset($_GET['value'])) $value = $_GET['value'];

        if ($param == 'delete') { // удаление картинки
            $result = $this->db->where('id', $image_id)->limit(1)->delete('images');
            if ($result) echo 'deleted'; else echo 'delete_error';
        } elseif ($param == 'edit') {    // редактирование картинки
            if (isset($_GET['active'])) $_POST['active'] = $_GET['active'];
            if (isset($_GET['text'])) $_POST['text'] = $_GET['text'];
            if (isset($_GET['type'])) $_POST['type'] = $_GET['type'];
            $dbins = array();
            $active = post('active');
            if ($active !== false)
                $dbins['active'] = $active;
            $text = post('text');
            if ($text !== false)
                $dbins['text'] = $text;
            $type = post('type');
            if ($type !== false)
                $dbins['type'] = $type;

            //$dbins[$param] = $value;
            $ret = $this->db->where('id', $image_id)->limit(1)->update('images', $dbins);
            if ($ret) echo 'saved';
            else echo 'save_error';
        }
    }


    function admin_save_price()
    {
        if (isset($_POST['price']) && isset($_POST['product_id']) && isAdminLoginHidden() == true) {
            $this->load->helper('login_helper');

            $dbins = array(
                'price' => $_POST['price']
            );
            $this->db->where('id', $_POST['product_id']);
            $this->db->limit(1);
            $this->db->update('products', $dbins);

            return $_POST['price'];
        }

    }
}