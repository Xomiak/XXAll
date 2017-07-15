<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Cron extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        //$this->load->helper('login_helper');
        $this->load->model('Model_articles', 'articles');
        $this->load->model('Model_adresses', 'adresses');
        $this->load->model('Model_users', 'users');
        $this->load->model('Model_comments', 'comments');
    }

    function setAdresses($category_id = false){
        //$articles = $this->articles->

        ?>
<!--        <script src="/libs/jquery/jquery-2.2.4.min.js"></script>-->
<!--        -->
<!--        <script>-->
<!--            function func() {-->
<!--                $.ajax({-->
<!--                    /* адрес файла-обработчика запроса */-->
<!--                    url: '/ajax/adresses/'+category_id+'/',-->
<!--                    /* метод отправки данных */-->
<!--                    method: 'POST',-->
<!--                    /* данные, которые мы передаем в файл-обработчик */-->
<!--                    data: {-->
<!--                        "city_id": city_id-->
<!--                    },-->
<!---->
<!--                }).done(function (data) {-->
<!--                    console.log(data);-->
<!--                    if(data != 'no') {-->
<!--                        $("#" + output_id).html(data);-->
<!--                        $("#" + output_id+"-div").show();-->
<!--                    } else {-->
<!--                        $("#" + output_id).html("");-->
<!--                        $("#" + output_id+"-div").hide();-->
<!--                    }-->
<!--                });-->
<!--            }-->
<!---->
<!--            setTimeout(func, 5000);-->
<!--        </script>-->
<?php
//$last_id = userdata('adresses_updater_last_id');
        if(isset($_GET['last_id'])) $last_id = $_GET['last_id'];
        if(!$category_id){
            $this->generateXMLMarker();
            $cats = $this->model_categories->getCategoriesIds(1,'organizations',false);
            if($cats){
                vd(count($cats));
                foreach ($cats as $catt) {
                    $this->generateXMLMarker($catt['id']);
                    
                    echo $catt['name'].' done<br />';
                }
            }
        } else $this->generateXMLMarker($category_id); 
    }

    function generateXMLMarker($categoey_id = false){
        $file = $categoey_id;
        if(!$categoey_id) $file = 'all';
        $results = false;
        if(!$categoey_id){
            $results = $this->adresses->getAdresses(1);
        } else {
            $results = $this->adresses->getAdressesByCategory($categoey_id, 1);
        }
        if($results){
            $html = '<?xml version="1.0"?>
            <markers>';
            foreach ($results as $result){
                $result['name'] = str_replace('&','&amp;', $result['name']);
                //$result['description'] = str_replace("\n","<br />",$result['description']);
                $html .= '
                <marker>
                <name>'.trim(strip_tags($result['name'])).'</name>
                <address>'.trim(strip_tags($result['adress'])).'</address>
                <lat>'.$result['lat'].'</lat>
                <lng>'.$result['lng'].'</lng>
                <description>'.$result['description'].'</description>';
                if($result['icon'] != '') {
                    $html .= '
                <icon>' . CreateThumb2(32, 32, $result['icon'], 'maps') . '</icon>
                <logo>'.  CreateThumb2(64, 64, $result['icon'], 'maps') . '</logo>';
                }
                $html .='
                </marker>
                ';
            }
            $html .= '
            </markers>';
            file_put_contents('./maps/'.$file.'.xml',$html);
            //echo $html;
        }
    }
}