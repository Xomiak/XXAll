<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Mailer extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->helper('login_helper');
        isAdminLogin();
        $this->load->model('Model_admin', 'ma');
        $this->load->model('Model_mailer', 'mailer');
    }

    function upload_foto()
    {                                // Функция загрузки и обработки фото
        $config['upload_path'] = 'upload/fotos';
        $config['allowed_types'] = 'jpg|png|gif|jpe';
        $config['max_size'] = '0';
        $config['max_width'] = '0';
        $config['max_height'] = '0';
        $config['encrypt_name'] = true;
        $config['overwrite'] = false;

        $this->load->library('upload', $config);

        if (!$this->upload->do_upload()) {
            echo $this->upload->display_errors();
            die();
        } else {
            $ret = $this->upload->data();
            return $ret;
        }
    }

    private function upload_file($filename = 'userfile')
    {                                // Функция загрузки и обработки фото
        $config['upload_path'] = 'upload/mailer';
        $config['allowed_types'] = 'jpg|png|gif|jpe|doc|docx|xls|xlsx|pdf';
        $config['max_size'] = '0';
        $config['max_width'] = '0';
        $config['max_height'] = '0';
        $config['encrypt_name'] = true;
        $config['overwrite'] = false;

        $this->load->library('upload', $config);

        if (!$this->upload->do_upload($filename)) {
            echo $this->upload->display_errors();
            die();
        } else {
            $ret = $this->upload->data();
            return $ret;
        }
    }

    public function send($id){
        $data['title'] = "Запуск рассылки";
        $data['mailer'] = $this->mailer->getById($id);
        $data['head'] = $this->load->view('common/head.php',$data, true);
        $data['header'] = $this->load->view('common/header.php',$data, true);
        $data['left_sidebar'] = $this->load->view('common/left_sidebar.php',$data, true);
        $data['footer'] = $this->load->view('common/footer.php',$data, true);
        $this->load->view('mailer/send', $data);
    }

    public function view($id){
        $mailer = $this->mailer->getById($id);
        echo $mailer['content'];
    }

    public function index()
    {
        if(isset($_GET['test'])){
            $this->load->helper('mail_helper');
            $ret = mail_send("xomiak@rap.org.ua","test","test","/upload/mailer/14ef2c5ee77dff67683c152dd89a83c5.pdf");
            vd($ret);
        }
        $data['title'] = "Рассылка";
        $data['options'] = $this->mailer->getAll();
        $data['head'] = $this->load->view('common/head.php',$data, true);
        $data['header'] = $this->load->view('common/header.php',$data, true);
        $data['left_sidebar'] = $this->load->view('common/left_sidebar.php',$data, true);
        $data['footer'] = $this->load->view('common/footer.php',$data, true);
        $this->load->view('mailer/mailer', $data);
    }

    public function add()
    {
        $err = false;
        if (isset($_POST['name'])) {
            $name = trim($_POST['name']);
            $content = trim($_POST['content']);

            if (!$err) {
                $date = date("Y-m-d");
                $time = date("H:i");
                $unix = time();
                $for_users = 0;
                if(isset($_POST['for_users'])) $for_users = 1;
                $for_organizations = 0;
                if(isset($_POST['for_organizations'])) $for_organizations = 1;

                $dbins = array(
                    'name' => $name,
                    'content' => $content,
                    'date' => $date,
                    'time' => $time,
                    'unix' => $unix,
                    'emails' => post('emails'),
                    'for_users' => $for_users,
                    'for_organizations' => $for_organizations
                );

                $dbins['file'] = '';
                if (isset($_FILES['userfile'])) { // проверка, выбран ли файл картинки
                    if ($_FILES['userfile']['name'] != '') {
                        $imagearr = $this->upload_file();
                        $dbins['file'] = '/upload/mailer/' . $imagearr['file_name'];
                    }
                }

                $this->db->insert('mailer', $dbins);

                $this->db->where('unix', $unix);
                $this->db->where('name', $name);
                $ret = $this->db->get('mailer')->result_array();
                if (!$ret) {
                    echo 'Error!';
                    die();
                }
                redirect('/admin/mailer/edit/' . $ret[0]['id'] . '/');
            }
        }

        $data['title'] = "Создание новой рассылки";
        $data['err'] = $err;

        $data['head'] = $this->load->view('common/head.php',$data, true);
        $data['header'] = $this->load->view('common/header.php',$data, true);
        $data['left_sidebar'] = $this->load->view('common/left_sidebar.php',$data, true);
        $data['footer'] = $this->load->view('common/footer.php',$data, true);

        $this->load->view('mailer/add', $data);
    }

    public function edit($id)
    {
        $err = false;
        if (isset($_POST['name'])) {
            $name = trim($_POST['name']);
            $content = trim($_POST['content']);
            $for_users = 0;
            if(isset($_POST['for_users'])) $for_users = 1;
            $for_organizations = 0;
            if(isset($_POST['for_organizations'])) $for_organizations = 1;

            if (!$err) {
                $dbins = array(
                    'name' => $name,
                    'content' => $content,
                    'emails' => post('emails'),
                    'for_users' => $for_users,
                    'for_organizations' => $for_organizations
                );

                $dbins['file'] = '';
                if (isset($_POST['file_old']))
                    $dbins['file'] = $_POST['file_old'];

                if(isset($_POST['file_del'])) {
                    @unlink($_SERVER['DOCUMENT_ROOT'] . $dbins['file']);
                    $dbins['file'] = '';
                }

                if (isset($_FILES['userfile'])) { // проверка, выбран ли файл картинки
                    if ($_FILES['userfile']['name'] != '') {
                        if($dbins['file'] != '') {
                            @unlink($_SERVER['DOCUMENT_ROOT'] . $dbins['file']);
                            $dbins['file'] = '';
                        }
                        $imagearr = $this->upload_file();
                        $dbins['file'] = '/upload/mailer/' . $imagearr['file_name'];
                    }
                }

                $this->db->where('id', $id)->update('mailer', $dbins);
                if(isset($_POST['save_and_send']))
                    redirect('/admin/mailer/send/' . $id . '/');
                else
                    redirect('/admin/mailer/edit/' . $id . '/');
            }
        }

        $data['title'] = "Редактирование рассылки";
        $data['mailer'] = $this->mailer->getById($id);
        $data['err'] = $err;

        $data['head'] = $this->load->view('common/head.php',$data, true);
        $data['header'] = $this->load->view('common/header.php',$data, true);
        $data['left_sidebar'] = $this->load->view('common/left_sidebar.php',$data, true);
        $data['footer'] = $this->load->view('common/footer.php',$data, true);
        $this->load->view('mailer/edit', $data);
    }

    public function up($id)
    {
        $cat = $this->mp->getPageById($id);
        if (($cat) && $cat['num'] > 0) {
            $num = $cat['num'] - 1;
            $oldcat = $this->mp->getPageByNum($num);
            $dbins = array('num' => $num);
            $this->db->where('id', $id)->limit(1)->update('pages', $dbins);
            if ($oldcat) {
                $dbins = array('num' => ($num + 1));
                $this->db->where('id', $oldcat['id'])->limit(1)->update('pages', $dbins);
            }
        }
        redirect('/admin/pages/');
    }

    public function down($id)
    {
        $cat = $this->mp->getPageById($id);
        if (($cat) && $cat['num'] < ($this->mp->getNewNum() - 1)) {
            $num = $cat['num'] + 1;
            $oldcat = $this->mp->getPageByNum($num);
            $dbins = array('num' => $num);
            $this->db->where('id', $id)->limit(1)->update('pages', $dbins);
            if ($oldcat) {
                $dbins = array('num' => ($num - 1));
                $this->db->where('id', $oldcat['id'])->limit(1)->update('pages', $dbins);
            }
        }
        redirect('/admin/pages/');
    }

    public function del($id)
    {
        $this->db->where('id', $id)->limit(1)->delete('pages');
        redirect("/admin/pages/");
    }

    public function active($id)
    {
        $this->ma->setActive($id, 'pages');
        redirect('/admin/pages/');
    }
}