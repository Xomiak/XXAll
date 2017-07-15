<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Quest extends CI_Controller {

         public function __construct()
        {
            parent::__construct();
	    $this->load->helper('login_helper');
	    isAdminLogin();
            $this->load->model('Model_admin','ma');
            $this->load->model('Model_quest','quest');
        }
	
	public function index()
	{
		  if($this->session->userdata('quest_module_name') !== false)
			   $data['quest'] = $this->quest->getOptionsByModule($this->session->userdata('quest_module_name'));
		  else
			   $data['quest'] = $this->quest->getAllOptions();
            $data['title']  = "Опции";
	    $data['modules'] = $this->quest->getAllModules();
            
            $this->load->view('admin/quest',$data);
	}
        
        public function add()
        {
            $err = false;
            if(isset($_POST['name']))
            {
                $name = trim($_POST['name']);
                $value_1_true = 0;
                if(isset($_POST['value_1_true']) && $_POST['value_1_true'] == true) $value_1_true = 1;
                $value_2_true = 0;
                if(isset($_POST['value_2_true']) && $_POST['value_2_true'] == true) $value_2_true = 1;
                $value_3_true = 0;
                if(isset($_POST['value_3_true']) && $_POST['value_3_true'] == true) $value_3_true = 1;
                $value_4_true = 0;
                if(isset($_POST['value_4_true']) && $_POST['value_4_true'] == true) $value_4_true = 1;
		    
                //if($value == '')
                    //$err['value'] = "Значение не может быть пустым!";
                
                if(!$err)
                {
                    $dbins = array(
			   'name'      	=> $name,
			   'value_1'    => $_POST['value_1'],
                           'value_2'    => $_POST['value_2'],
                           'value_3'    => $_POST['value_3'],
                           'value_4'    => $_POST['value_4'],
                           'value_1_true'   => $value_1_true,
                           'value_2_true'   => $value_2_true,
                           'value_3_true'   => $value_3_true,
                           'value_4_true'   => $value_4_true,
                    );
                    $this->db->insert('quest',$dbins);
                    redirect('/admin/quest/');
                }
            }
	    
            $data['title']  = "Добавление вопроса";
            $data['err'] = $err;            
            $this->load->view('admin/quest_add',$data);
        }
        
        public function edit($id)
        {
            $err = false;
            if(isset($_POST['name']))
            {
                $name = trim($_POST['name']);
                $value_1_true = 0;
                if(isset($_POST['value_1_true']) && $_POST['value_1_true'] == true) $value_1_true = 1;
                $value_2_true = 0;
                if(isset($_POST['value_2_true']) && $_POST['value_2_true'] == true) $value_2_true = 1;
                $value_3_true = 0;
                if(isset($_POST['value_3_true']) && $_POST['value_3_true'] == true) $value_3_true = 1;
                $value_4_true = 0;
                if(isset($_POST['value_4_true']) && $_POST['value_4_true'] == true) $value_4_true = 1;
                
                if(!$err)
                {
                    $dbins = array(
			   'name'      	=> $name,
			   'value_1'    => $_POST['value_1'],
                           'value_2'    => $_POST['value_2'],
                           'value_3'    => $_POST['value_3'],
                           'value_4'    => $_POST['value_4'],
                           'value_1_true'   => $value_1_true,
                           'value_2_true'   => $value_2_true,
                           'value_3_true'   => $value_3_true,
                           'value_4_true'   => $value_4_true,
                    );
                    $this->db->where('id', $id)->update('quest', $dbins);
                    redirect('/admin/quest/');
                }
            }
	    $data['type'] = $this->session->userdata('type');
            $data['quest'] = $this->quest->getOptionById($id);
            $data['title']  = "Редактирование вопроса";
            $data['err'] = $err;            
            $this->load->view('admin/quest_edit',$data);
        }

        public function del($id)
        {
            $this->db->where('id',$id)->limit(1)->delete('quest');
            redirect("/admin/quest/");
        }
	
	public function set_module($module = false)
	{
	 if(isset($_POST['module']))
	 {
		  $module = $_POST['module'];
	 }
	 if($module)
	 {
		  if($module == 'all')
		  {
			   $this->session->unset_userdata('quest_module_name');
		  }
		  else
		  {
			   $mod = $this->quest->getModule($module);
			   if($mod)
			   {
				    $this->session->set_userdata('quest_module_name', $module);
			   }
		  }
	 }
	 redirect("/admin/quest/");
	}
}