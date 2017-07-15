<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Currency extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->helper('login_helper');
        isAdminLogin();
        $this->load->model('Model_admin', 'ma');
        $this->load->model('Model_currency', 'currency');
    }

   

    public function index() {
        $data['title'] = "Валюты";
        $data['pages'] = $this->currency->getCurrencies();

        $data['head'] = $this->load->view('common/head.php',$data, true);
        $data['header'] = $this->load->view('common/header.php',$data, true);
        $data['left_sidebar'] = $this->load->view('common/left_sidebar.php',$data, true);
        $data['footer'] = $this->load->view('common/footer.php',$data, true);

        $this->load->view('currency', $data);
    }

    public function add() {
        if (isset($_POST['name']))
        {
            if(isset($_POST['main']) && $_POST['main'] == true)
            {
                $dbins = array('main' => 0);
                $this->db->update('currency', $dbins);
            }
            
            $active = 0;
            if(isset($_POST['active']) && $_POST['active'] == true) $active = 1;
            $main = 0;
            if(isset($_POST['main']) && $_POST['main'] == true) $main = 1;
            
            $dbins = array(
                'name'      => $_POST['name'],
                'code'      => $_POST['code'],
                'view'      => $_POST['view'],
                'rate'      => $_POST['rate'],
                'active'    => $active,
                'main'      => $main
            );
            
            $this->db->insert('currency', $dbins);
            
            redirect('/admin/currency');
        }
        
        $data['title'] = "Добавление валюты";
    //    $data['err'] = $err;
        $data['num'] = $this->currency->getNewNum();
        //$data['pages'] = $this->mp->getPages();

        $data['head'] = $this->load->view('common/head.php',$data, true);
        $data['header'] = $this->load->view('common/header.php',$data, true);
        $data['left_sidebar'] = $this->load->view('common/left_sidebar.php',$data, true);
        $data['footer'] = $this->load->view('common/footer.php',$data, true);

        $this->load->view('currency_add_edit', $data);
    }

    public function edit($id) {
        
        if (isset($_POST['name']))
        {
            if(isset($_POST['main']) && $_POST['main'] == true)
            {
                $dbins = array('main' => 0);
                $this->db->update('currency', $dbins);
            }
            
            $active = 0;
            if(isset($_POST['active']) && $_POST['active'] == true) $active = 1;
            $main = 0;
            if(isset($_POST['main']) && $_POST['main'] == true) $main = 1;
            
            $dbins = array(
                'name'      => $_POST['name'],
                'code'      => $_POST['code'],
                'view'      => $_POST['view'],
                'rate'      => $_POST['rate'],
                'active'    => $active,
                'main'      => $main
            );
            
            $this->db->where('id', $id);
            $this->db->limit(1);
            $this->db->update('currency', $dbins);
            
            redirect('/admin/currency');
        }
        
        
        $data['currency'] = $this->currency->getById($id);
        $data['title'] = "Редактирование страницы";
        $data['num'] = $this->currency->getNewNum();

        $data['head'] = $this->load->view('common/head.php',$data, true);
        $data['header'] = $this->load->view('common/header.php',$data, true);
        $data['left_sidebar'] = $this->load->view('common/left_sidebar.php',$data, true);
        $data['footer'] = $this->load->view('common/footer.php',$data, true);

        $this->load->view('currency_add_edit', $data);
    }

    public function up($id) {
        $cat = $this->currency->getById($id);
        if (($cat) && $cat['num'] > 0) {
            $num = $cat['num'] - 1;
            $oldcat = $this->currency->getByNum($num);
            $dbins = array('num' => $num);
            $this->db->where('id', $id)->limit(1)->update('currency', $dbins);
            if ($oldcat) {
                $dbins = array('num' => ($num + 1));
                $this->db->where('id', $oldcat['id'])->limit(1)->update('currency', $dbins);
            }
        }
        redirect('/admin/currency/');
    }

    public function down($id) {
        $cat = $this->currency->getById($id);
        if (($cat) && $cat['num'] < ($this->currency->getNewNum() - 1)) {
            $num = $cat['num'] + 1;
            $oldcat = $this->currency->getByNum($num);
            $dbins = array('num' => $num);
            $this->db->where('id', $id)->limit(1)->update('currency', $dbins);
            if ($oldcat) {
                $dbins = array('num' => ($num - 1));
                $this->db->where('id', $oldcat['id'])->limit(1)->update('currency', $dbins);
            }
        }
        redirect('/admin/currency/');
    }

    public function del($id) {
        $this->db->where('id', $id)->limit(1)->delete('currency');
        redirect("/admin/currency/");
    }

    public function active($id) {
        $this->ma->setActive($id, 'currency');
        redirect('/admin/currency/');
    }

}
