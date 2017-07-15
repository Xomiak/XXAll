<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Update extends CI_Controller
{
    private $workingPath = 'upload/temp/application/';

    public function __construct()
    {
        parent::__construct();
        $this->load->helper('login_helper');
        isAdminLogin();
        $this->load->model('Model_admin', 'ma');
        $this->load->model('Model_articles', 'articles');
        $this->load->model('Model_products', 'products');
        $this->load->helper('file');
        $this->load->helper('update_helper');
        $this->load->library('zip');
        $this->load->dbforge();
    }

    public function index(){
        $data['title'] = "Обновление системы";
        $data['head'] = $this->load->view('common/head.php',$data, true);
        $data['header'] = $this->load->view('common/header.php',$data, true);
        $data['left_sidebar'] = $this->load->view('common/left_sidebar.php',$data, true);
        $data['footer'] = $this->load->view('common/footer.php',$data, true);
        $this->load->view('update/update.tpl.php', $data);
    }

    public function create(){
        // Собираем сборку...

        /// DATABASE
        $database = $this->db->database;
        $tablesArr = array();
        $tCount = 0;
        $tables = $this->db->list_tables();
        foreach ($tables as $table){
            $tablesArr[$tCount]['name'] = $table;
            $columns = $this->db->field_data($table);
            $fieldsArr = array();
            $cCount = 0;
            foreach ($columns as $column){
                
                // Проверяем, клиентское это поле или нет
                $isSetting = false;
                if($table == 'articles') {
                    $isSetting = $this->articles->isSetting($column->name);
                    if(!$isSetting){
                        $settings = $this->articles->getSettings(1);
                        $languages = getLanguages();
                        foreach ($settings as $setting){
                            foreach ($languages as $language){
                                if($column->name == $setting['name'].'_'.$language['code']) {
                                    $isSetting = true;
                                    break;
                                }
                            }
                        }
                    }
                }
                if($table == 'products') {
                    $isSetting = $this->products->isSetting($column->name);
                    if(!$isSetting){
                        $settings = $this->products->getSettings(1);
                        $languages = getLanguages();
                        foreach ($settings as $setting){
                            foreach ($languages as $language){
                                if($column->name == $setting['name'].'_'.$language['code']) {
                                    $isSetting = true;
                                    break;
                                }
                            }
                        }
                    }
                }

                if(!$isSetting) {   // если поле не клиентское, добавляем его в массив
                    $fieldsArr[$cCount]['name'] = $column->name;
                    $fieldsArr[$cCount]['type'] = $column->type;
                    $fieldsArr[$cCount]['default'] = $column->default;
                    $fieldsArr[$cCount]['max_length'] = $column->max_length;
                    $fieldsArr[$cCount]['primary_key'] = $column->primary_key;

                    $cCount++;
                }
            }

            $tablesArr[$tCount]['fields'] = $fieldsArr;

//            if($table == 'articles')
//                vdd($tablesArr[$tCount]);

            $tCount++;
        }
//vdd($tablesArr);
        /// ФАЙЛЫ
        $workingPath = $this->workingPath;

        if(!file_exists($workingPath))
            mkdir($workingPath, 0777);

        @mkdir($workingPath.'controllers/');
        @mkdir($workingPath.'controllers/admin');
        @mkdir($workingPath.'models/');
        @mkdir($workingPath.'helpers/');
        @mkdir($workingPath.'libraries/');
        @mkdir($workingPath.'views/');
        @mkdir($workingPath.'views/admin/');


        //$this->zip->read_dir($path, FALSE);
        $root = 'application/';
        $now = 'controllers/admin/';
//        $this->copyToTemp('controllers/admin/');
        $this->copyToTemp('controllers/');
        $this->copyToTemp('helpers/');
        $this->copyToTemp('models/');
        $this->copyToTemp('libraries/');
        $this->copyToTemp('views/admin/');
        if(!file_exists($workingPath.'config/'))
            mkdir($workingPath.'config/');
        copy('application/config/routes.php', $workingPath . 'config/routes.php');
        copy('application/config/autoload.php', $workingPath . 'config/autoload.php');

        $this->zip->read_dir($workingPath, FALSE);
        $this->zip->add_data("db.json", json_encode($tablesArr));
        //$this->zip->read_dir('includes/assets/', FALSE);
        //$this->zip->download('latest_stuff.zip');

        $build = date("ymd");

        @mkdir('upload/builds/');
        $this->zip->archive('upload/builds/'.$build.'.zip');

        delete_files('upload/temp/application', true);

        $data['build_link'] = '<a href="/upload/builds/'.$build.'.zip">http://'.$_SERVER['SERVER_NAME'].'/upload/builds/'.$build.'.zip</a>';
        $data['head'] = $this->load->view('common/head.php',$data, true);
        $data['header'] = $this->load->view('common/header.php',$data, true);
        $data['left_sidebar'] = $this->load->view('common/left_sidebar.php',$data, true);
        $data['footer'] = $this->load->view('common/footer.php',$data, true);
        $data['build'] = $build;
        $data['title'] = "Создание новой сборки";

        $this->load->view('update/create.tpl.php', $data);
    }

    public function createBackup(){
        if(isset($_POST['createBackup'])) {
            //$tempFiltesPath = 'upload/backups/temp/';
            if (!file_exists('upload/backups/temp/mysql/'))
                @mkdir('upload/backups/temp/mysql/');
            $pathDb = db_backup('upload/backups/temp/mysql/');
            if (!file_exists('upload/backups/'))
                @mkdir('upload/backups/');
            if (!file_exists('upload/backups/temp/'))
                @mkdir('upload/backups/temp/');
            if (!file_exists('upload/backups/temp/application/'))
                @mkdir('upload/backups/temp/application/');

            copyDirectory('application', 'upload/backups/temp/application/');
            copyDirectory('css', 'upload/backups/temp/css/');
            copyDirectory('js', 'upload/backups/temp/js/');

            $backupPath = 'upload/backups/' . date("Y-m-d_H-i-s") . '_backup.zip';

            $this->zip->read_dir('upload/backups/temp/application/',false);
            $this->zip->read_dir('upload/backups/temp/css/',false);
            $this->zip->read_dir('upload/backups/temp/js/',false);
            $this->zip->read_dir('upload/backups/temp/mysql/',false);
            //$this->zip->read_file($pathDb);
            $this->zip->archive($backupPath);

            delete_files('upload/backups/temp', true);

            $data['backupPath'] = $backupPath;
        }

        $data['title'] = "Бэкап данных";
        $backups = get_filenames('upload/backups/');
        arsort ($backups);
        $data['backups'] = $backups;
        $data['head'] = $this->load->view('common/head.php',$data, true);
        $data['header'] = $this->load->view('common/header.php',$data, true);
        $data['left_sidebar'] = $this->load->view('common/left_sidebar.php',$data, true);
        $data['footer'] = $this->load->view('common/footer.php',$data, true);
        $this->load->view('update/backup.tpl.php', $data);
    }

    public function clear(){
        $result = "";
        if(isset($_POST['clear'])){
            // зачищаем статьи
            if(isset($_POST['articles'])){
                $this->db->query('TRUNCATE TABLE `articles`');
                delete_files('upload/articles', true);
                $result .= '<p>Статьи очищены!</p>';
            }
            // зачищаем товары
            if(isset($_POST['products'])){
                $this->db->query('TRUNCATE TABLE `products`');
                delete_files('upload/products', true);
                $result .= '<p>Товары очищены!</p>';
            }
            // зачищаем categories
            if(isset($_POST['categories'])){
                $this->db->query('TRUNCATE TABLE `categories`');
                delete_files('upload/categories', true);
                $result .= '<p>Разделы очищены!</p>';
            }
            // зачищаем pages
            if(isset($_POST['pages'])){
                $this->db->query('TRUNCATE TABLE `pages`');
                delete_files('upload/pages', true);
                $result .= '<p>Страницы очищены!</p>';

                $dbins = array();
                $dbins['title'] = $dbins['keywords'] = $dbins['description'] = $dbins['name'] = $dbins['content'] = 'Ошибка 404';
                $dbins['active'] = $dbins['required'] = 1;
                $dbins['url'] = 'err404';
                $dbins['template'] = '404.tpl.php';
                $this->db->insert('pages', $dbins);
            }
            // зачищаем pages
            if(isset($_POST['menus'])){
                $this->db->query('TRUNCATE TABLE `menus`');
                delete_files('upload/pages', true);
                $result .= '<p>Пункты меню очищены!</p>';
            }
            // зачищаем images
            if(isset($_POST['images'])){
                $this->db->query('TRUNCATE TABLE `images`');
                delete_files('upload/images', true);
                $result .= '<p>Картинки очищены!</p>';
            }
            // зачищаем tags
            if(isset($_POST['tags'])){
                $this->db->query('TRUNCATE TABLE `tags`');
                $result .= '<p>Тэги очищены!</p>';
            }
        }
        // TRUNCATE TABLE `admin_main`
        $data['title'] = "Очистка данных";
        $data['result'] = $result;
        $data['head'] = $this->load->view('common/head.php',$data, true);
        $data['header'] = $this->load->view('common/header.php',$data, true);
        $data['left_sidebar'] = $this->load->view('common/left_sidebar.php',$data, true);
        $data['footer'] = $this->load->view('common/footer.php',$data, true);
        $this->load->view('update/clear.tpl.php', $data);
    }

    private function copyToTemp($path, $level = 0, $root = 'application/'){
      //  if($level != 0) vd($path);
        $workingPath = $this->workingPath;
        $scandirPath = $root.$path;
        $controllers = scandir($scandirPath);
        foreach ($controllers as $controller){
            if($controller != '.' && $controller != '..') {
                if (is_file($scandirPath . $controller)) {
                    if(!file_exists($workingPath.$path))
                        mkdir($workingPath.$path);
                    copy($scandirPath . $controller, $workingPath . $path . $controller);
                } elseif (is_dir($scandirPath . $controller)) {
                    $this->copyToTemp($path.$controller.'/',1);
                }
            }
        }
    }




    public function updating($path = 'upload/update/latest.zip'){
        $dontUpdateFilesArr = array('db.json','update_helper.php','Update.php');
        if(file_exists($path)){
            $zip = new ZipArchive;
            $tempPath = 'upload/temp/update/';
            if ($zip->open($path) === TRUE) {
                $zip->extractTo($tempPath);
                $zip->close();

                $filesUpdated = copyDirectory($tempPath,'.', true, $dontUpdateFilesArr);
                if(!$filesUpdated) echo 'При обновлении возникла проблема. Некоторые файлы не были изменены!';

                // Сравнение таблиц и полей базы
                $dbJson = file_get_contents('upload/temp/update/db.json');
                if($dbJson){
                    $newDbArr = json_decode($dbJson, true);
                    if(is_array($newDbArr)){
                        foreach ($newDbArr as $table){
                            // Проверяем, существует ли в базе таблица
                            if( !$this->db->table_exists($table['name'])) {
                                $this->dbforge->add_field('id');
                                $this->dbforge->create_table($table['name']);
                            }
                            if( !$this->db->table_exists($table['name'])) {
                                $newFieldsArr = array();
                                $fields = $table['fields'];
                                foreach ($fields as $field){
                                    // Проверяем существование поля
                                    if(! $this->db->field_exists($field['name'], $table['name'])){      // Поле в таблице не найдено
                                        // убираем лишние элементы
                                        if($field['default'] == NULL) {
                                            unset($field['default']);
                                            $field['Null'] = true;
                                        }
                                        if($field['max_length'] != NULL) {
                                            $field['type'] .= '('.$field['max_length'].')';
                                            unset($field['max_length']);
                                        }

                                        $fieldName = $field['name'];
                                        unset($field['name']);

                                        echo 'Добавляем поле '.$fieldName.' '.$field['type'].' в таблицу '.$table['name'].'<br>';
                                        // добавляем поле:
                                        $newFieldsArr[$fieldName] = $field;
                                    }
                                }
                                if($newFieldsArr) {
                                    echo 'Обновляем таблицу '.$table['name'].'...<br>';
                                    $this->dbforge->add_column($table['name'], $newFieldsArr);
                                }

                                //vdd($newFieldsArr);
                            }
                            echo $table['name'].'<br>';
                            //die();
                        }
                    } else echo 'Не получен массив значений базы!';
                } else echo 'Не найден файл сравнения баз!';
            }
        } else echo 'Файл обновлений не найден!';
    }

    public function getLatestVersion(){
        
    }

}