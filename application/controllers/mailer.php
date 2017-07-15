<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Mailer extends CI_Controller {
	public function __construct()
        {
            parent::__construct();
	    $this->load->helper('login_helper');
            $this->load->model('Model_articles','articles');
            $this->load->model('Model_categories','categories');
            $this->load->model('Model_users','users');
            $this->load->model('Model_options','options');
            $this->load->model('Model_mailer','mailer');
            $this->load->helper('mail_helper');
        }
	
        public function index()
        {
            if($this->mailer->getOption('send_emails') != 0)
            {
                $last = $this->mailer->getLastMailer();
                if(!$last) $this->send();
                else
                {
                    $date_now = date("Y-m-d");
                    $mk_now = mktime();
                    $darr = explode('-',$last['date']);
                    $tarr = explode(':',$last['time']);
                    $mk_last = mktime($tarr[0],$tarr[1],0,$darr[1],$darr[2],$darr[0]);
                    $diff = $mk_now - $mk_last;
                    $days =  intval($diff/60/60/24);
                    if($this->mailer->getOption('sending_frequency') < $days)
                    {
                        $this->send();
                    }
                    else echo 'Ещё рано!';
                    echo $days;
                }
            }
            else echo 'Рассылка отключена!';
        }
        
	public function send()
	{            
            $send_emails = $this->mailer->getOption('send_emails');
            if($send_emails)
            {
                $message = $this->mailer->getOption('header');
                $send = false;
                $last = $this->mailer->getLastMailer();
                $sending_frequency = $this->mailer->getOption('sending_frequency');
                $articles = $this->articles->getMailerArticles();
                
                if($articles)
                {
                    $count = count($articles);
                    for($i = 0; $i < $count; $i++)
                    {
                        $a = $articles[$i];
                        $carr = explode('*', $a['category_id']);
                        $category = '';
                        $parent = false;
                        if($carr)
                        {
                            $category = $this->categories->getCategoryById($carr[0]);
                            //var_dump($category.'<br /><br />');
                            if($category['parent'] != 0)
                            {
                                $category = $this->categories->getCategoryById($category['parent']);
                                //var_dump($category.'<br /><br />');
                            }
                        }
                        
                        
                        $message .= $a['date'].' '.$a['time'].' ';
                        $message .= '<a href="http://'.$_SERVER['SERVER_NAME'].'/';                        
                        $message .= $category['url'].'/';
                        $message .= $a['url'];
                        $message .= '/">'.$a['name'].'</a><br />';
                        if($a['short_content'] != '')
                            $message .= $a['short_content'];
                        else $message .= substr(strip_tags(substr($a['content'],0,210)),0,-1).'...';
                        //$message .= '<br />';
                        $message .= '<a href="http://'.$_SERVER['SERVER_NAME'].'/';                  
                        $message .= $category['url'].'/';
                        $message .= $a['url'];
                        $message .= '/">Читать далее...</a>';
                        $message .= '<hr />';
                        
                        // Убераем mailer у текущей статьи
                        /*
                        $dbins = array(
                            'mailer'    => 0
                        );
                        $this->db->where('id',$a['id']);
                        $this->db->update('articles', $dbins);
                        */
                        //
                    }
                    //$this->load->view('admin/options_add',$data);
                }
                
                $message .= $this->mailer->getOption('footer');
                
                $emails = '';
                $users = $this->users->getMailerUsers();
                if($users)
                {
                    $count = count($users);
                    for($i = 0; $i < $count; $i++)
                    {
                        if($i != 0)
                            $emails .= ', ';
                        $emails .= $users[$i]['email'];
                    }
                }
                
                $additional_emails = $this->mailer->getOption('additional_emails');
                if($additional_emails != '')
                    $emails .= ', '.$additional_emails;
                    
                mail_send($emails, "Новости", $message);
                
                $dbins = array(
                    'date'      => date("Y-m-d"),
                    'time'      => date("H:i"),
                    'emails'    => $emails,
                    'content'   => $message
                );
                $this->db->insert('mailer', $dbins);
                
                echo $emails;
                
                echo $message;                
            }
        }
}