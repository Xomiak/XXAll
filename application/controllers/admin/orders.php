<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Orders extends CI_Controller {

         public function __construct()
        {
            parent::__construct();
	    $this->load->helper('login_helper');
	    isAdminLogin();
            $this->load->model('Model_admin','ma');
            $this->load->model('Model_shop','shop');
            $this->load->model('Model_users','users');
            $this->load->model('Model_categories','categories');
        }
	
	
           
	public function index()
	{
            $data['title']  = "Заказы";
            $data['pages'] = $this->shop->getOrders();
            $this->load->view('orders',$data);
	}
        
        
        
        public function edit($id)
        {
	 //var_dump($_POST);die();
		  
            $err = '';
            if(isset($_POST['status']))
            {  
                $dbins = array(
                                   'adress'	=> $_POST['adress'],
				   'status'	=> $_POST['status']
                               );
                $this->db->where('id',$id);
                $this->db->limit(1);
                $this->db->update('orders',$dbins);
		  if(isset($_POST['save_and_stay']))
			   redirect($_SERVER['REQUEST_URI']);
		  else
			   redirect("/admin/orders/");
            }

            
            $data['order'] = $this->shop->getOrderById($id);
            $data['user'] = $this->users->getUserById($data['order']['user_id']);

            $data['title']  = "Редактирование заказа";
            $data['err'] = $err;
            $this->load->view('orders_edit',$data);
        }
        
        public function up($id)
        {
            $cat = $this->mp->getPageById($id);
            if(($cat) && $cat['num'] > 0)
            {
                $num = $cat['num']-1;
                $oldcat = $this->mp->getPageByNum($num);
                $dbins = array('num' => $num);
                $this->db->where('id',$id)->limit(1)->update('pages',$dbins);
                if($oldcat)
                {
                    $dbins = array('num' => ($num+1));
                    $this->db->where('id',$oldcat['id'])->limit(1)->update('pages',$dbins);
                }
            }
            redirect('/admin/pages/');
        }
        public function down($id)
        {
            $cat = $this->mp->getPageById($id);
            if(($cat) && $cat['num'] < ($this->mp->getNewNum()-1))
            {
                $num = $cat['num']+1;
                $oldcat = $this->mp->getPageByNum($num);
                $dbins = array('num' => $num);
                $this->db->where('id',$id)->limit(1)->update('pages',$dbins);
                if($oldcat)
                {
                    $dbins = array('num' => ($num-1));
                    $this->db->where('id',$oldcat['id'])->limit(1)->update('pages',$dbins);
                }
            }
            redirect('/admin/pages/');
        }
        
        public function del($id)
        {
            $this->db->where('id',$id)->limit(1)->delete('orders');
            redirect("/admin/orders/");
        }
	
	public function active($id)
	{
		  $this->ma->setActive($id,'pages');
		  redirect('/admin/pages/');
	}
        
        function upload_foto(){								// Функция загрузки и обработки фото
		  $config['upload_path'] 	= 'upload/fotos';
		  $config['allowed_types'] 	= 'jpg|png|gif|jpe';
		  $config['max_size']		= '0';
		  $config['max_width']  	= '0';
		  $config['max_height']  	= '0';
		  $config['encrypt_name']	= true;
		  $config['overwrite']  	= false;
  
		  $this->load->library('upload', $config);
		    
		  if ( ! $this->upload->do_upload())
		  {
			  echo $this->upload->display_errors();
			  die();
		  }
		  else
		  {
		    $ret = $this->upload->data();
			  return $ret;
		  }
	 }
	 
	 function upload_file($page_id){								// Функция загрузки и обработки фото
		  
		  if(!file_exists('upload/files/'.$page_id))
			   mkdir('upload/files/'.$page_id,0777);
		  $config['upload_path'] 	= 'upload/files/'.$page_id;
		  $config['allowed_types'] 	= 'jpg|png|gif|jpe|zip|rar|doc|docx|xls|xlsx';
		  $config['max_size']		= '0';
		  $config['max_width']  	= '0';
		  $config['max_height']  	= '0';
		  $config['encrypt_name']	= false;
		  $config['overwrite']  	= false;
  
		  $this->load->library('upload', $config);
		    
		  if ( ! $this->upload->do_upload())
		  {
			  echo $this->upload->display_errors();
			  die();
		  }
		  else
		  {
		    $ret = $this->upload->data();
			  return $ret;
		  }
	 }
}