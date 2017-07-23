<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Main extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->helper('login_helper');
        isAdminLogin();
        $this->load->model('Model_admin', 'ma');
        $this->load->model('Model_modules', 'modules');
        $this->load->helper('admin_helper');
    }

    public function index()
    {


        if(isset($_GET['clearcache'])){
            clearcache();
            echo 'Кэш очищен!';
        }

        $data['user'] = $this->model_users->getUserByLogin(userdata('login'));

        //$data['modules'] = $this->modules->getModulesByLogin(userdata('login'));
        //vdd("asd");
        $data['title'] = "Главная";
        //$data['main'] = $this->ma->getMain();
        $data['main'] = false;

        $data['head'] = $this->load->view('common/head.php',$data, true);
        $data['header'] = $this->load->view('common/header.php',$data, true);
        $data['left_sidebar'] = $this->load->view('common/left_sidebar.php',$data, true);
        $data['footer'] = $this->load->view('common/footer.php',$data, true);
        $this->load->view('main/main', $data);
    }

    public function clearcache(){
        clearcache();
        echo 'Кэш очищен!';
        $data['title'] = "Главная";
        $data['main'] = $this->ma->getMain();
        $this->load->view('admin/main', $data);
    }

    public function slider()
    {
        $data['title'] = "Слайдер";
        $data['head'] = $this->load->view('common/head.php',$data, true);
        $data['header'] = $this->load->view('common/header.php',$data, true);
        $data['left_sidebar'] = $this->load->view('common/left_sidebar.php',$data, true);
        $data['footer'] = $this->load->view('common/footer.php',$data, true);

        $this->load->view('slider', $data);
    }



    public function edit()
    {
        $langs = array();
        $languages = $this->model_languages->getLanguages();
        $default_lang = $this->model_languages->getDefaultLanguage();
        if ($default_lang) $default_lang = $default_lang['code'];
        for ($i = 0; $i < count($languages); $i++) {
            $langs[$i] = $languages[$i]['code'];
        }

        if (isset($_POST['save'])) {
            $dbins = array();


            for ($i = 0; $i < count($langs); $i++) {
                $lang = $langs[$i];
                if (isset($_POST[$langs[$i] . '_title']) && $_POST[$langs[$i] . '_title'] != '') {
                    if ($lang == $default_lang) {
                        $dbins['h1']    = $_POST[$lang . '_h1'];
                        $dbins['title']    = $_POST[$lang . '_title'];
                        $dbins['description']    = $_POST[$lang . '_description'];
                        $dbins['keywords']    = $_POST[$lang . '_keywords'];
                        $dbins['content']    = $_POST[$lang . '_content'];
                        $dbins['seo']    = $_POST[$lang . '_seo'];
                    } else {
                        $dbins['h1_' . $lang]    = $_POST[$lang . '_h1'];
                        $dbins['title_' . $lang]    = $_POST[$lang . '_title'];
                        $dbins['description_' . $lang]    = $_POST[$lang . '_description'];
                        $dbins['keywords_' . $lang]    = $_POST[$lang . '_keywords'];
                        $dbins['content_' . $lang]    = $_POST[$lang . '_content'];
                        $dbins['seo_' . $lang]    = $_POST[$lang . '_seo'];
                    }
                }
            }

            //vdd($dbins);
            $dbins['adding_scripts'] = $_POST['adding_scripts'];


            $this->db->where('id', 1);
            $this->db->update('main', $dbins);
            redirect('/admin/');

        }
        $data['title'] = "Главная - Редактирование";
        $data['main'] = $this->ma->getMain();
        $data['head'] = $this->load->view('common/head.php',$data, true);
        $data['header'] = $this->load->view('common/header.php',$data, true);
        $data['left_sidebar'] = $this->load->view('common/left_sidebar.php',$data, true);
        $data['footer'] = $this->load->view('common/footer.php',$data, true);
        $this->load->view('admin/main/main_edit', $data);
    }
}