<?php
$user = $this->model_users->getUserByLogin(userdata('login'));
?>
<div class="static-sidebar-wrapper sidebar-midnightblue">
    <div class="static-sidebar">
        <div class="sidebar">
            <div class="widget stay-on-collapse" id="widget-welcomebox">
                <div class="widget-body welcome-box tabular">
                    <div class="tabular-row">
                        <div class="tabular-cell welcome-avatar">
                            <?php if($user['avatar'] != '') { ?>
                            <a href="#"><img src="<?=$user['avatar']?>" class="avatar"></a>
                            <?php } ?>
                        </div>
                        <div class="tabular-cell welcome-options">
                            <span class="welcome-text">Приветствую,</span>
                            <a href="#" class="name"><?=$user['name']?> <?=$user['lastname']?></a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="widget stay-on-collapse" id="widget-sidebar">
                <nav role="navigation" class="widget-body">
                    <ul class="acc-menu">
                        <li><a href="/admin/"><i class="fa fa-home"></i><span>Главная</span></a></li>
                        <?php
                        $this->db->where('active',1);
                        $this->db->where('parent_id',0);
                        $this->db->where('is_link',0);
                        $this->db->order_by('num','ASC');
                        $separators = $this->db->get('admin_menu')->result_array();

                        if($separators){
                            foreach ($separators as $separator){
                                echo '<li class="nav-separator">'.$separator['name'].'</li>';

                                // достаём подпункты
                                $this->db->where('active',1);
                                $this->db->where('parent_id', $separator['id']);
                                $this->db->order_by('num','ASC');
                                $links = $this->db->get('admin_menu')->result_array();
                                if($links){
                                    // Выводим разделы меню
                                    foreach ($links as $link){
                                        // проверяем, есть ли подпункты у раздела
                                        $this->db->where('active',1);
                                        $this->db->where('parent_id', $link['id']);
                                        $this->db->order_by('num','ASC');
                                        $sublinks = $this->db->get('admin_menu')->result_array();
                                        if($sublinks){
                                            // выводим подпункты
                                            echo '<li><a href="javascript:;"><i class="'.$link['class'].'"></i><span>'.$link['name'].'</span><span class="badge badge-primary">'.count($sublinks).'</span></a>';
                                            echo '<ul class="acc-menu">';
                                            foreach ($sublinks as $sublink){
                                                echo '<li><a href="'.$sublink['url'].'">'.$sublink['name'].'</a></li>';
                                            }
                                            echo '</ul>';
                                        } else{
                                            echo '<li><a href="'.$link['url'].'"><i class="'.$link['class'].'"></i><span>'.$link['name'].'</span>';
                                            if($link['adding'] != NULL){
                                                $adding = json_decode($link['adding']);
                                                $adding = (array)$adding;
                                                //vd($params['action']);
                                                $sql = '';
                                                if(isset($adding['select']))
                                                    $sql .= 'SELECT '.$adding['select'].' ';
                                                if(isset($adding['from']))
                                                    $sql .= 'FROM '.$adding['from'].' ';
                                                if(isset($adding['where']))
                                                    $sql .= 'WHERE '.$adding['where'].' ';
                                                if($sql) {
                                                    $res = $this->db->query($sql)->result_array();
                                                    if(isset($res[0][$adding['select']]) && $res[0][$adding['select']] != 0 && $res[0][$adding['select']] != '') echo ' <span class="menu-adding">(<span class="menu-adding-value">'.$res[0][$adding['select']].'</span>)</span>';
                                                }
                                            }
                                            echo '</a>';
                                        }
                                    }
                                }
                            }
                        }
                        ?>

                        
                    </ul>
                </nav>
            </div>
        </div>
    </div>
</div>