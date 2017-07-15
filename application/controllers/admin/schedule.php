<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Schedule extends CI_Controller {

         public function __construct()
        {
            parent::__construct();
	    $this->load->helper('login_helper');
	    isAdminLogin();
            $this->load->model('Model_admin','ma');
            $this->load->model('Model_schedule','schedule');
	    $this->load->model('Model_categories','mcats');
	    $this->load->model('Model_options','options');
	    $this->load->model('Model_users','users');
            $this->load->model('Model_afisha','afisha');
        }
	
	public function index()
	{
		  $a = $this->db->count_all('schedule');
	    
	    // ПАГИНАЦИЯ //
		$this->load->library('pagination');
		$per_page = 50;
		$config['base_url'] = 'http://'.$_SERVER['HTTP_HOST'].'/admin/schedule/';
		$config['total_rows'] = $a;
		$config['num_links'] = 4;
		$config['first_link'] = 'в начало';
		$config['last_link'] = 'в конец';
		$config['next_link'] = 'далее';
		$config['prev_link'] = 'назад';
		
		$config['per_page'] = $per_page;
		$config['uri_segment']     = 3;
		$from = intval($this->uri->segment(3));
		$page_number=$from/$per_page+1;
		$this->pagination->initialize($config);
		$data['pager']	= $this->pagination->create_links();
		
		if($page_number > 1) $this->session->set_userdata('articlesFrom', $from);
		else $this->session->unset_userdata('articlesFrom');
		//////////
		
                $data['title']      = "Расписание";
		$data['articles'] = $this->schedule->getArticles($per_page,$from, 'DESC');
		
	    
            $this->load->view('admin/schedule',$data);
	}
	
	        
        public function add()
        {
	 
            $err = '';
            if(isset($_POST['afisha_id']) && $_POST['afisha_id'] != '')
            {
                
                $active = 0;
                if(isset($_POST['active']) && $_POST['active'] == true) $active = 1;
                
                $date_unix = 0;
                $darr = explode('-',$_POST['date']);
                $tarr = explode(':',$_POST['time']);
                $date_unix = mktime($tarr[0],$tarr[1],0,$darr[1],$darr[2],$darr[0]);
		
		$scene = 'Основная сцена';
		$afisha = $this->afisha->getArticleById($_POST['afisha_id']);
		if($afisha) $scene = $afisha['scene'];
                
                $dbins = array(
                               'afisha_id'         	=> $_POST['afisha_id'],
                               'date'            	=> $_POST['date'],
                               'time'            	=> $_POST['time'],
                               'date_unix'         	=> $date_unix,
                               'active'         	=> $active,
			       'scene'			=> $scene,
			       'price'			=> $_POST['price']
                               );
                $this->db->insert('schedule',$dbins);
                redirect("/admin/schedule/");
                //}
                //else $err = 'Такая страница уже существует!';
            }
	    
	    	    
            $data['title']  = "Добавление расписания";
            $data['afisha'] = $this->afisha->getArticles();
            $data['err'] = $err;
            $this->load->view('admin/schedule_add',$data);
        }
        
        public function edit($id)
        {
            $err = '';
            if(isset($_POST['afisha_id']) && $_POST['afisha_id'] != '')
            {
             
                
                $active = 0;
                if(isset($_POST['active']) && $_POST['active'] == true) $active = 1;
                
                $date_unix = 0;
                $darr = explode('-',$_POST['date']);
                $tarr = explode(':',$_POST['time']);
                $date_unix = mktime($tarr[0],$tarr[1],0,$darr[1],$darr[2],$darr[0]);
		
		$scene = 'Основная сцена';
		$afisha = $this->afisha->getArticleById($_POST['afisha_id']);
		if($afisha) $scene = $afisha['scene'];
                
                $dbins = array(
                               'afisha_id'         	=> $_POST['afisha_id'],
                               'date'            	=> $_POST['date'],
                               'time'            	=> $_POST['time'],
                               'date_unix'         	=> $date_unix,
                               'active'         	=> $active,
			       'scene'			=> $scene,
			       'price'			=> $_POST['price']
                               );
                $this->db->where('id',$id);
                $this->db->limit(1);
                $this->db->update('schedule',$dbins);
		
				
		if(isset($_POST['save_and_stay']))
		  redirect("/admin/afisha/edit/".$id."/");
	        else
		  redirect("/admin/schedule/");
            }
            
            $data['article'] = $this->schedule->getArticleById($id);
            $data['afisha'] = $this->afisha->getArticles();
            $data['title']  = "Редактирование расписания";
            $data['err'] = $err;
            $this->load->view('admin/schedule_edit',$data);
        }
        
                
        public function del($id)
        {
		  $this->db->where('id',$id);
		  $this->db->limit(1);
		  $art = $this->db->get('schedule')->result_array();
		 
		  $this->db->where('id',$id)->limit(1)->delete('schedule');
		  $url = '/admin/schedule/';
		  if($this->session->userdata('articlesFrom') !== false) $url .= $this->session->userdata('articlesFrom').'/';
		  redirect($url);
        }
	
	public function active($id)
	{
		  $this->ma->setActive($id,'schedule');
		  $url = '/admin/schedule/';
		  if($this->session->userdata('articlesFrom') !== false) $url .= $this->session->userdata('articlesFrom').'/';
		  redirect($url);
	}
	
}