<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Comments extends CI_Controller {

         public function __construct()
        {
            parent::__construct();
	    $this->load->helper('login_helper');            
	    isAdminLogin();
            $this->load->model('Model_admin','ma');	    
            $this->load->model('Model_categories','cat');
            $this->load->model('Model_articles','art');
            $this->load->model('Model_comments','comments');
            $this->load->model('Model_users','users');
            $this->load->model('Model_pages','pages');
        }
	
	
        
        public function index()
	{
		  if(isset($_POST['save']) && isset($_POST['comment_id']))
		  {
			   $dbins = array(
				    'comment'	=> post('comment')
			   );
			   $this->db->where('id', post('comment_id'));
			   $this->db->limit(1);
			   $this->db->update('comments', $dbins);
		  }
		  elseif(isset($_POST['delete']))
		  {			   
			   $this->db->where('id', $_POST['id']);
			   $this->db->limit(1);
			   $this->db->delete('comments');
		  }
		  elseif(isset($_POST['add']))
		  {
			   $dbins = array(
				    'name'	=> $_POST['name'],
				    'msg'	=> $_POST['msg'],
				    'date'	=> date('Y-m-d')
			   );
			   $this->db->insert('comments', $dbins);
		  }
	 
            $comments = $this->comments->getComments();
	    
	    
            // ПАГИНАЦИЯ //
            $this->load->library('pagination');
            $per_page = 50;
            $config['base_url'] = 'http://'.$_SERVER['HTTP_HOST'].'/admin/comments/';
            $config['total_rows'] = count($comments);
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
            //////////
            $data['comments']   = $this->comments->getComments($per_page, $from);
                
            $data['title']  = "Комментарии";
	    
            //$data['categories'] = $this->mcats->getCategories();

        $data['head'] = $this->load->view('common/head.php',$data, true);
        $data['header'] = $this->load->view('common/header.php',$data, true);
        $data['left_sidebar'] = $this->load->view('common/left_sidebar.php',$data, true);
        $data['footer'] = $this->load->view('common/footer.php',$data, true);
            $this->load->view('comments/comments', $data);
	}
        
        public function del($id)
        {
            $this->db->where('id',$id)->limit(1)->delete('comments');
	    
		  redirect("/admin/comments/");
        }
}