<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Cache extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->helper('login_helper');
        isAdminLogin();
        $this->load->model('Model_admin', 'ma');
        $this->load->helper('admin_helper');
    }
    //////////////////////////////////////

    public function index(){
        $data['title'] = "Кэш";
        $data['main'] = $this->ma->getMain();
        $data['head'] = $this->load->view('common/head.php',$data, true);
        $data['header'] = $this->load->view('common/header.php',$data, true);
        $data['left_sidebar'] = $this->load->view('common/left_sidebar.php',$data, true);
        $data['footer'] = $this->load->view('common/footer.php',$data, true);
        $this->load->view('cache/index', $data);
    }
}