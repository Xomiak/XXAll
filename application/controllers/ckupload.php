<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Ckupload extends CI_Controller {

         public function __construct()
        {
            parent::__construct();
            //$this->load->helper('login_helper');
            //isAdminLogin();
            //$this->load->model('Model_admin','ma');	    
            $this->load->model('Model_options','options');
        }
        
        function upload_file($type = 'jpg|png|gif|jpe'){								// Функция загрузки и обработки фото
            if(!isset($_GET['CKEditorFuncNum'])) err404();
            
            $callback = $_GET['CKEditorFuncNum'];
            $http_path = '';
            $error = '';
            
		 // Проверка наличия папки текущей даты. Если нет, то создать
		 if (!file_exists($_SERVER['DOCUMENT_ROOT'] . '/upload/articles/' . date("Y-m-d") . '/')) {
			 mkdir($_SERVER['DOCUMENT_ROOT'] . '/upload/articles/' . date("Y-m-d") . '/', 0777);
		 }
		  $config['upload_path'] = 'upload/articles/' . date("Y-m-d");
		  $config['allowed_types'] 	= $type;
		  $config['max_size']		= '0';
		  $config['max_width']  	= '0';
		  $config['max_height']  	= '0';
		  $config['encrypt_name']	= true;
		  $config['overwrite']  	= false;
          
          $width = getOption('upload_image_max_width');
          $height = getOption('upload_image_max_height');
  
		  $this->load->library('upload', $config);
		    
		  if ( ! $this->upload->do_upload('upload'))
		  {
			  $error = 'Загрузка файла не удалась.';
		  }
		  else
		  {
			   
			   $ret = $this->upload->data('upload');
			   
			   $config['image_library'] 	= 'GD2';
			   $config['create_thumb'] 	= TRUE;
			   $config['maintain_ratio'] 	= TRUE;			   
			   $config['width'] 			= $width;
			   $config['height'] 			= $height;
			   $config['source_image'] 	= $ret["file_path"].$ret['file_name'];
			   $config['new_image']		= $ret["file_path"].$ret['file_name'];
			   $config['thumb_marker']	= '';
			   $this->image_lib->initialize($config);
			   $this->image_lib->resize();
			   
			   if($this->model_options->getOption('articles_watermark') == 1)
			   {			   
				    $config['source_image'] = $ret["file_path"].$ret['file_name'];
				    $config['create_thumb'] = FALSE;
				    $config['wm_type'] = 'overlay';
				    $config['wm_overlay_path'] = $this->model_options->getOption('watermark_file');
				    if($config['wm_overlay_path'])
				    {
					     $config['wm_hor_alignment'] = 'right';
					     $this->image_lib->initialize($config);
					     $this->image_lib->watermark();
				    }
			   }
			   if($ret['image_width'] < $width) $width = $ret['image_width'];
			   if($ret['image_height'] < $height) $height = $ret['image_height'];
			   
			   
		  
		  	   $ret = $this->upload->data();
			   
               $http_path = '/upload/articles/' . date("Y-m-d") . '/' . $ret['file_name'];               
			  
		  }
          echo "<script type=\"text/javascript\">window.parent.CKEDITOR.tools.callFunction(".$callback.",  \"".$http_path."\", \"".$error."\" );</script>";
	}
}