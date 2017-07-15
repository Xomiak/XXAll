<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Languages extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->helper('login_helper');
        isAdminLogin();
        $this->load->model('Model_admin', 'ma');
        $this->load->model('Model_languages', 'languages');
    }

    function upload_foto($name)
    {        // Функция загрузки и обработки фото
        if (!file_exists('upload/languages/'))
            mkdir('upload/languages/' , 0777);
        $config['upload_path'] = 'upload/languages/';
        $config['allowed_types'] = 'jpg|png|gif|jpe';
        $config['max_size'] = '0';
        $config['max_width'] = '0';
        $config['max_height'] = '0';
        $config['encrypt_name'] = true;
        $config['overwrite'] = false;

        $this->load->library('upload', $config);

        if (!$this->upload->do_upload($name)) {
            echo $this->upload->display_errors();
            die();
        } else {
            $ret = $this->upload->data();
            return $ret;
        }
    }

    function upload_file($name)
    {        // Функция загрузки и обработки фото
        if (!file_exists('upload/languages/'))
            mkdir('upload/languages/' , 0777);
        $config['upload_path'] = 'upload/languages/';
        $config['allowed_types'] = 'jpg|png|gif|jpe|zip|rar|doc|docx|xls|xlsx';
        $config['max_size'] = '0';
        $config['max_width'] = '0';
        $config['max_height'] = '0';
        $config['encrypt_name'] = false;
        $config['overwrite'] = false;

        $this->load->library('upload', $config);

        if (!$this->upload->do_upload($name)) {
            echo $this->upload->display_errors();
            die();
        } else {
            $ret = $this->upload->data();
            return $ret;
        }
    }

    public function index()
    {
        $languages = $this->languages->getlanguages();
        if(isset($_GET['refresh']) && $_GET['refresh'] == true)
        {
            foreach ($languages as $language)
            {
                $code = $language['code'];
                $this->addToAll($code);
            }
        }
        $data['title'] = "Языки";
        $data['languages'] = $languages;
        $data['head'] = $this->load->view('common/head.php',$data, true);
        $data['header'] = $this->load->view('common/header.php',$data, true);
        $data['left_sidebar'] = $this->load->view('common/left_sidebar.php',$data, true);
        $data['footer'] = $this->load->view('common/footer.php',$data, true);
        $this->load->view('languages/languages', $data);
    }

    private function addToAll($code)
    {
        // ДОБАВЛЯЕМ ПОЛЯ В ТАБЛИЦЫ
        $this->addNewColumns('articles', $code);
        $this->addNewColumns('products', $code);
        $this->addNewColumnsToMain($code);
        $this->addNewColumnsToCategories($code);
        $this->addNewColumnsToPages($code);
        $this->addNewColumnsToMenus($code);
        $this->addNewColumnsToGallery($code);
    }


    public function add()
    {
        $err = false;

        if (isset($_POST['name'])) {
            if (!$this->languages->getByCode($_POST['code'])) {
                $code = $_POST['code'];

                $this->addToAll($code);

                $dbins = array(
                    'name' => trim($_POST['name']),
                    'code' => trim($_POST['code']),
                    'num' => $_POST['num']
                );

                if (isset($_FILES['icon'])) { // проверка, выбран ли файл картинки
                    if ($_FILES['icon']['name'] != '') {
                        $filearr = $this->upload_foto('icon');
                        $file = '/upload/languages/' . $filearr['file_name'];
                        $dbins['icon'] = $file;
                    }
                }

                if (isset($_POST['default']) && $_POST['default'] == true) $dbins['default'] = 1; else $dbins['default'] = 0;
                if (isset($_POST['active']) && $_POST['active'] == true) $dbins['active'] = 1; else $dbins['active'] = 0;

                $this->db->insert('languages', $dbins);

                redirect('/admin/languages/');
            } else $err['code'] = "Такой языковой код уже есть!";
        }

        $data['title'] = "Добавление языка";
        $data['action'] = "add";
        $data['err'] = $err;
        $data['num'] = $this->languages->getNewNum();
        //$data['languages'] = $this->languages->getlanguages();

        $data['head'] = $this->load->view('common/head.php',$data, true);
        $data['header'] = $this->load->view('common/header.php',$data, true);
        $data['left_sidebar'] = $this->load->view('common/left_sidebar.php',$data, true);
        $data['footer'] = $this->load->view('common/footer.php',$data, true);
        $this->load->view('languages/add_edit', $data);
    }

    public function edit($id)
    {
        //
        $err = false;

        $language = $this->languages->getById($id);

        if (isset($_POST['name'])) {
            $dbins = array(
                'name' => trim($_POST['name']),
//                'code' => trim($_POST['code']),
                'num' => $_POST['num']
            );
            if (isset($_POST['default']) && $_POST['default'] == true) {
                $dbins['default'] = 1;
                $def = $this->languages->getDefaultLanguage();
                if($def['id'] != $id)
                {
                    $this->db->where('id <>', $id);
                    $this->db->update('languages', array('default' => 0));
                }
            }
            else
                $dbins['default'] = 0;

            if (isset($_POST['active']) && $_POST['active'] == true) $dbins['active'] = 1; else $dbins['active'] = 0;

            if (isset($_POST['icon_del']) && $_POST['icon_del'] == true) {
                if (file_exists($_SERVER['DOCUMENT_ROOT'] . $language['icon']))
                    unlink($_SERVER['DOCUMENT_ROOT'] . $language['icon']);
                $dbins['icon'] = '';
            }

            if (isset($_FILES['icon'])) { // проверка, выбран ли файл картинки
                if ($_FILES['icon']['name'] != '') {
                    if($language['icon'] != '' && $language['icon'] != NULL)
                    {
                        if (file_exists($_SERVER['DOCUMENT_ROOT'] . $language['icon']))
                            unlink($_SERVER['DOCUMENT_ROOT'] . $language['icon']);
                    }

                    $filearr = $this->upload_foto('icon');
                    $file = '/upload/languages/' . $filearr['file_name'];
                    $dbins['icon'] = $file;
                }
            }

            $this->db->where('id', $id);
            $this->db->limit(1);
            $this->db->update('languages', $dbins);

            redirect('/admin/languages/');
        }

        $data['title'] = "Редактирование языка";
        $data['action'] = "edit";
        $data['err'] = $err;
        $data['language'] = $language;
        //$data['num'] = $this->languages->getNewNum();
        //$data['languages'] = $this->languages->getlanguages();

        $data['head'] = $this->load->view('common/head.php',$data, true);
        $data['header'] = $this->load->view('common/header.php',$data, true);
        $data['left_sidebar'] = $this->load->view('common/left_sidebar.php',$data, true);
        $data['footer'] = $this->load->view('common/footer.php',$data, true);
        $this->load->view('languages/add_edit', $data);
    }

    public function up($id)
    {
        $cat = $this->languages->getPageById($id);
        if (($cat) && $cat['num'] > 0) {
            $num = $cat['num'] - 1;
            $oldcat = $this->languages->getPageByNum($num);
            $dbins = array('num' => $num);
            $this->db->where('id', $id)->limit(1)->update('languages', $dbins);
            if ($oldcat) {
                $dbins = array('num' => ($num + 1));
                $this->db->where('id', $oldcat['id'])->limit(1)->update('languages', $dbins);
            }
        }
        redirect('/admin/languages/');
    }

    public function down($id)
    {
        $cat = $this->languages->getPageById($id);
        if (($cat) && $cat['num'] < ($this->languages->getNewNum() - 1)) {
            $num = $cat['num'] + 1;
            $oldcat = $this->languages->getPageByNum($num);
            $dbins = array('num' => $num);
            $this->db->where('id', $id)->limit(1)->update('languages', $dbins);
            if ($oldcat) {
                $dbins = array('num' => ($num - 1));
                $this->db->where('id', $oldcat['id'])->limit(1)->update('languages', $dbins);
            }
        }
        redirect('/admin/languages/');
    }

    public function del($id)
    {
        $language = $this->languages->getById($id);

        $this->delColumns('articles',$language['code']);
        $this->delColumns('products',$language['code']);
        $this->delColumnsToMain($language['code']);
        $this->delColumnsToCategories($language['code']);
        $this->delColumnsToPages($language['code']);
        $this->delColumnsToMenus($language['code']);
        $this->delColumnsToGallery($language['code']);
        
        $this->db->where('id', $id)->limit(1)->delete('languages');
        redirect("/admin/languages/");
    }

    public function active($id)
    {
        $this->ma->setActive($id, 'languages');
        redirect('/admin/languages/');
    }


    //////////////////////////////////////////////////
    ///// Добавляем необходимые ячейки в таблицы /////
    //////////////////////////////////////////////////
    private function addNewColumns($table, $code)
    {
        $this->load->dbforge();
        // ДОБАВЛЯЕМ ПОЛЯ В $table
        $dbins = array();
        $this->load->model('Model_' . $table, 'table');

        $settings = $this->table->getSettings(1);
        foreach ($settings as $s) {
            $name = $s['name'] . '_' . $code;
            $type = $this->ma->getFieldtypeByName($s['type']);

            $type_config = array(
                'type' => $type['type']
            );
            if ($type['constraint'] > 0)
                $type_config['constraint'] = $type['constraint'];

            if ($type['type'] == 'int' || $type['type'] == 'double' || $type['type'] == 'float')
                $type_config['default'] = 0.0;
            else $type_config['null'] = true;

            $fields = array(
                $name => $type_config
            );
//            vd($table); vd($name);
//            vdd(isColumnExists($table, $name));
            if(! isColumnExists($table, $name)) {
                $if_column_added = $this->dbforge->add_column($table, $fields);
                if (!$if_column_added) {
                    alert("Ощибка!");
                    return false;
                }
            }
        }
    }

    private function addNewColumnsToMain($code)
    {
        $this->load->dbforge();
        // ДОБАВЛЯЕМ ПОЛЯ В main
        $name = 'h1_' . $code;

        $type_config = array(
            'type' => 'varchar',
            'constraint' => 255,
            'null' => true
        );

        $type_config_text = array(
            'type' => 'text',
            'null' => true
        );

        $fields = array(
            $name => $type_config
        );
        if(! isColumnExists('main', $name)) {
            $if_column_added = $this->dbforge->add_column('main', $fields);
            if (!$if_column_added) {
                alert("Ощибка при добавлении ячейки в таблицу main!");
                return false;
            }
        }
        //////////////////////////////
        $name = 'title_' . $code;
        $fields = array(
            $name => $type_config
        );
        if(! isColumnExists('main', $name)) {
            $if_column_added = $this->dbforge->add_column('main', $fields);
            if (!$if_column_added) {
                alert("Ощибка при добавлении ячейки в таблицу main!");
                return false;
            }
        }
        //////////////////////////////
        $name = 'keywords_' . $code;
        $fields = array(
            $name => $type_config
        );
        if(! isColumnExists('main', $name)) {
            $if_column_added = $this->dbforge->add_column('main', $fields);
            if (!$if_column_added) {
                alert("Ощибка при добавлении ячейки в таблицу main!");
                return false;
            }
        }
        //////////////////////////////
        $name = 'description_' . $code;
        $fields = array(
            $name => $type_config
        );
        if(! isColumnExists('main', $name)) {
            $if_column_added = $this->dbforge->add_column('main', $fields);
            if (!$if_column_added) {
                alert("Ощибка при добавлении ячейки в таблицу main!");
                return false;
            }
        }
        //////////////////////////////
        $name = 'seo_' . $code;
        $fields = array(
            $name => $type_config_text
        );
        if(! isColumnExists('main', $name)) {
            $if_column_added = $this->dbforge->add_column('main', $fields);
            if (!$if_column_added) {
                alert("Ощибка при добавлении ячейки в таблицу main!");
                return false;
            }
        }
        //////////////////////////////
        $name = 'content_' . $code;
        $fields = array(
            $name => $type_config_text
        );
        if(! isColumnExists('main', $name)) {
            $if_column_added = $this->dbforge->add_column('main', $fields);
            if (!$if_column_added) {
                alert("Ощибка при добавлении ячейки в таблицу main!");
                return false;
            }
        }
    }

    private function addNewColumnsToCategories($code)
    {
        $this->load->dbforge();
        // ДОБАВЛЯЕМ ПОЛЯ В categories
        $name = 'name_' . $code;

        $type_config = array(
            'type' => 'varchar',
            'constraint' => 255,
            'null' => true
        );

        $type_config_text = array(
            'type' => 'text',
            'null' => true
        );

        $fields = array(
            $name => $type_config
        );
        if(! isColumnExists('categories', $name)) {
            $if_column_added = $this->dbforge->add_column('categories', $fields);
            if (!$if_column_added) {
                alert("Ощибка при добавлении ячейки в таблицу categories!");
                return false;
            }
        }
        //////////////////////////////
        $name = 'title_' . $code;
        $fields = array(
            $name => $type_config
        );
        if(! isColumnExists('categories', $name)) {
            $if_column_added = $this->dbforge->add_column('categories', $fields);
            if (!$if_column_added) {
                alert("Ощибка при добавлении ячейки в таблицу categories!");
                return false;
            }
        }
        //////////////////////////////
        $name = 'keywords_' . $code;
        $fields = array(
            $name => $type_config
        );
        if(! isColumnExists('categories', $name)) {
            $if_column_added = $this->dbforge->add_column('categories', $fields);
            if (!$if_column_added) {
                alert("Ощибка при добавлении ячейки в таблицу categories!");
                return false;
            }
        }
        //////////////////////////////
        $name = 'description_' . $code;
        $fields = array(
            $name => $type_config
        );
        if(! isColumnExists('categories', $name)) {
            $if_column_added = $this->dbforge->add_column('categories', $fields);
            if (!$if_column_added) {
                alert("Ощибка при добавлении ячейки в таблицу categories!");
                return false;
            }
        }
        //////////////////////////////
        $name = 'seo_' . $code;
        $fields = array(
            $name => $type_config_text
        );
        if(! isColumnExists('categories', $name)) {
            $if_column_added = $this->dbforge->add_column('categories', $fields);
            if (!$if_column_added) {
                alert("Ощибка при добавлении ячейки в таблицу categories!");
                return false;
            }
        }
        //////////////////////////////
        $name = 'short_content_' . $code;
        $fields = array(
            $name => $type_config_text
        );
        if(! isColumnExists('categories', $name)) {
            $if_column_added = $this->dbforge->add_column('categories', $fields);
            if (!$if_column_added) {
                alert("Ощибка при добавлении ячейки в таблицу categories!");
                return false;
            }
        }
    }

    private function addNewColumnsToPages($code)
    {
        $this->load->dbforge();
        // ДОБАВЛЯЕМ ПОЛЯ В pages

        $type_config = array(
            'type' => 'varchar',
            'constraint' => 255,
            'null' => true
        );

        $type_config_text = array(
            'type' => 'text',
            'null' => true
        );

        $name = 'name_' . $code;
        $fields = array(
            $name => $type_config
        );
        if(! isColumnExists('pages', $name)) {
            $if_column_added = $this->dbforge->add_column('pages', $fields);
            if (!$if_column_added) {
                alert("Ощибка при добавлении ячейки в таблицу pages!");
                return false;
            }
        }
        //////////////////////////////
        $name = 'title_' . $code;
        $fields = array(
            $name => $type_config
        );
        if(! isColumnExists('pages', $name)) {
            $if_column_added = $this->dbforge->add_column('pages', $fields);
            if (!$if_column_added) {
                alert("Ощибка при добавлении ячейки в таблицу pages!");
                return false;
            }
        }
        //////////////////////////////
        $name = 'keywords_' . $code;
        $fields = array(
            $name => $type_config
        );
        if(! isColumnExists('pages', $name)) {
            $if_column_added = $this->dbforge->add_column('pages', $fields);
            if (!$if_column_added) {
                alert("Ощибка при добавлении ячейки в таблицу pages!");
                return false;
            }
        }
        //////////////////////////////
        $name = 'description_' . $code;
        $fields = array(
            $name => $type_config
        );
        if(! isColumnExists('pages', $name)) {
            $if_column_added = $this->dbforge->add_column('pages', $fields);
            if (!$if_column_added) {
                alert("Ощибка при добавлении ячейки в таблицу pages!");
                return false;
            }
        }

        //////////////////////////////
        $name = 'seo_' . $code;
        $fields = array(
            $name => $type_config_text
        );
        if(! isColumnExists('pages', $name)) {
            $if_column_added = $this->dbforge->add_column('pages', $fields);
            if (!$if_column_added) {
                alert("Ощибка при добавлении ячейки в таблицу pages!");
                return false;
            }
        }
        //////////////////////////////
        $name = 'content_' . $code;
        $fields = array(
            $name => $type_config_text
        );
        if(! isColumnExists('pages', $name)) {
            $if_column_added = $this->dbforge->add_column('pages', $fields);
            if (!$if_column_added) {
                alert("Ощибка при добавлении ячейки в таблицу pages!");
                return false;
            }
        }
    }

    private function addNewColumnsToMenus($code)
    {
        $this->load->dbforge();
        // ДОБАВЛЯЕМ ПОЛЯ В menus

        $type_config = array(
            'type' => 'varchar',
            'constraint' => 255,
            'null' => true
        );

        $type_config_text = array(
            'type' => 'text',
            'null' => true
        );

        $name = 'name_' . $code;
        $fields = array(
            $name => $type_config
        );
        if(! isColumnExists('menus', $name)) {
            $if_column_added = $this->dbforge->add_column('menus', $fields);
            if (!$if_column_added) {
                alert("Ощибка при добавлении ячейки в таблицу menus!");
                return false;
            }
        }
    }
    
    private function addNewColumnsToGallery($code)
    {
        $this->load->dbforge();
        // ДОБАВЛЯЕМ ПОЛЯ В menus

        $type_config = array(
            'type' => 'varchar',
            'constraint' => 255,
            'null' => true
        );

        $type_config_text = array(
            'type' => 'text',
            'null' => true
        );

        $name = 'name_' . $code;
        $fields = array(
            $name => $type_config
        );
        if(! isColumnExists('gallery_categories', $name)) {
            $if_column_added = $this->dbforge->add_column('gallery_categories', $fields);
            if (!$if_column_added) {
                alert("Ощибка при добавлении ячейки в таблицу menus!");
                return false;
            }
        }
        ///////////////////////////////////////
        $name = 'title_' . $code;
        $fields = array(
            $name => $type_config
        );
        if(! isColumnExists('gallery_categories', $name)) {
            $if_column_added = $this->dbforge->add_column('gallery_categories', $fields);
            if (!$if_column_added) {
                alert("Ощибка при добавлении ячейки в таблицу menus!");
                return false;
            }
        }
        ///////////////////////////////////////
        $name = 'keywords_' . $code;
        $fields = array(
            $name => $type_config
        );
        if(! isColumnExists('gallery_categories', $name)) {
            $if_column_added = $this->dbforge->add_column('gallery_categories', $fields);
            if (!$if_column_added) {
                alert("Ощибка при добавлении ячейки в таблицу menus!");
                return false;
            }
        }
        ///////////////////////////////////////
        $name = 'description_' . $code;
        $fields = array(
            $name => $type_config
        );
        if(! isColumnExists('gallery_categories', $name)) {
            $if_column_added = $this->dbforge->add_column('gallery_categories', $fields);
            if (!$if_column_added) {
                alert("Ощибка при добавлении ячейки в таблицу menus!");
                return false;
            }
        }
        ///////////////////////////////////////
        $name = 'seo_' . $code;
        $fields = array(
            $name => $type_config
        );
        if(! isColumnExists('gallery_categories', $name)) {
            $if_column_added = $this->dbforge->add_column('gallery_categories', $fields);
            if (!$if_column_added) {
                alert("Ощибка при добавлении ячейки в таблицу menus!");
                return false;
            }
        }
    }



    //////////////////////////////////////////////////
    ///// Удаляем необходимые ячейки в таблицы /////
    //////////////////////////////////////////////////
    private function delColumns($table, $code)
    {
        $this->load->dbforge();
        // УДАЛЯЕМ ПОЛЯ В $table
        $dbins = array();
        $this->load->model('Model_' . $table, 'table');

        $settings = $this->table->getSettings(true);
        foreach ($settings as $s) {
            $name = $s['name'] . '_' . $code;
            if(isColumnExists($table, $name))
                $this->dbforge->drop_column($table, $name);
        }
    }

    private function delColumnsToMain($code)
    {
        $this->load->dbforge();
        // УДАЛЯЕМ ПОЛЯ В main
        $table = 'main';
        //////////////////////////////
        $name = 'title_' . $code;
        if(isColumnExists($table, $name))
            $this->dbforge->drop_column($table, $name);
        //////////////////////////////
        $name = 'keywords_' . $code;
        if(isColumnExists($table, $name))
            $this->dbforge->drop_column($table, $name);
        //////////////////////////////
        $name = 'description_' . $code;
        if(isColumnExists($table, $name))
            $this->dbforge->drop_column($table, $name);
        //////////////////////////////
        $name = 'seo_' . $code;
        if(isColumnExists($table, $name))
            $this->dbforge->drop_column($table, $name);
        //////////////////////////////
        $name = 'h1_' . $code;
        if(isColumnExists($table, $name))
            $this->dbforge->drop_column($table, $name);
    }

    private function delColumnsToCategories($code)
    {
        $this->load->dbforge();
        // УДАЛЯЕМ ПОЛЯ В categories
        $table = 'categories';
        $name = 'name_' . $code;

        if(isColumnExists($table, $name))
            $this->dbforge->drop_column($table, $name);
        //////////////////////////////
        $name = 'title_' . $code;
        if(isColumnExists($table, $name))
            $this->dbforge->drop_column($table, $name);
        //////////////////////////////
        $name = 'keywords_' . $code;
        if(isColumnExists($table, $name))
            $this->dbforge->drop_column($table, $name);
        //////////////////////////////
        $name = 'description_' . $code;
        if(isColumnExists($table, $name))
            $this->dbforge->drop_column($table, $name);
        //////////////////////////////
        $name = 'seo_' . $code;
        if(isColumnExists($table, $name))
            $this->dbforge->drop_column($table, $name);
        //////////////////////////////
        $name = 'short_content_' . $code;
        if(isColumnExists($table, $name))
            $this->dbforge->drop_column($table, $name);
    }

    private function delColumnsToPages($code)
    {
        $this->load->dbforge();
        // УДАЛЯЕМ ПОЛЯ В pages
        $table = 'pages';
        $name = 'name_' . $code;

        if(isColumnExists($table, $name))
            $this->dbforge->drop_column($table, $name);
        //////////////////////////////
        $name = 'title_' . $code;
        if(isColumnExists($table, $name))
            $this->dbforge->drop_column($table, $name);
        //////////////////////////////
        $name = 'keywords_' . $code;
        if(isColumnExists($table, $name))
            $this->dbforge->drop_column($table, $name);
        //////////////////////////////
        $name = 'description_' . $code;
        if(isColumnExists($table, $name))
            $this->dbforge->drop_column($table, $name);
        //////////////////////////////
        $name = 'seo_' . $code;
        if(isColumnExists($table, $name))
            $this->dbforge->drop_column($table, $name);
        //////////////////////////////
        $name = 'content_' . $code;
        if(isColumnExists($table, $name))
            $this->dbforge->drop_column($table, $name);
    }

    private function delColumnsToMenus($code)
    {
        $this->load->dbforge();
        // УДАЛЯЕМ ПОЛЯ В menus
        $table = 'menus';
        $name = 'name_' . $code;
        if(isColumnExists($table, $name))
            $this->dbforge->drop_column($table, $name);
    }

    private function delColumnsToGallery($code)
    {
        $this->load->dbforge();
        // УДАЛЯЕМ ПОЛЯ В pages
        $table = 'gallery_categories';
        $name = 'name_' . $code;

        if(isColumnExists($table, $name))
            $this->dbforge->drop_column($table, $name);
        //////////////////////////////
        $name = 'title_' . $code;
        if(isColumnExists($table, $name))
            $this->dbforge->drop_column($table, $name);
        //////////////////////////////
        $name = 'keywords_' . $code;
        if(isColumnExists($table, $name))
            $this->dbforge->drop_column($table, $name);
        //////////////////////////////
        $name = 'description_' . $code;
        if(isColumnExists($table, $name))
            $this->dbforge->drop_column($table, $name);
        //////////////////////////////
        $name = 'seo_' . $code;
        if(isColumnExists($table, $name))
            $this->dbforge->drop_column($table, $name);
        //////////////////////////////
    }
}
