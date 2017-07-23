<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class AdminElementsTree
{
    private $type;
    private $config;
    private $linkTemplate = "<a href = \"%s\">%s</a>";

    function __construct($type = 'category')
    {
        $this->type = $type;
    }

    function setSelectedOptions($selectedOpt)
    {
        $this->config['selectedOpt'] = $selectedOpt;
        if (!$selectedOpt && userdata('category_id') !== false) $this->config['selectedOpt'] = userdata('category_id');
    }

    function setTreeTemplateConfig($config)
    {
        $this->config = array(
            'rootOpenTag' => $config['rootOpenTag'],
            'rootCloseTag' => $config['rootCloseTag'],
            'childOpenTag' => $config['childOpenTag'],
            'childCloseTag' => $config['childCloseTag'],

            'rootItemOpenTag' => $config['rootItemOpenTag'],
            'rootItemTitleOpenTag' => $config['rootItemTitleOpenTag'],
            'rootItemTitleCloseTag' => $config['rootItemTitleCloseTag'],
            'rootItemCloseTag' => $config['rootItemCloseTag'],

            'itemOpenTag' => $config['itemOpenTag'],
            'itemTitleOpenTag' => $config['itemTitleOpenTag'],
            'itemTitleCloseTag' => $config['itemTitleCloseTag'],
            'itemCloseTag' => $config['itemCloseTag']
        );
    }

    function createOptionsTreeForSelect($elements, $lvl, $active = 1)
    {
        $resText = '';

        if ($elements) {
            foreach ($elements as $elem) {
                $selected = '';
//                if(userdata('category_id') == $elem['id'])
//                    $selected = 'selected';
                if (isset($this->config['selectedOpt']))
                    if (is_array($this->config['selectedOpt'])) {
                        if (in_array($elem['id'], $this->config['selectedOpt']))
                            $selected = 'selected';
                    } else
                        if ($elem['id'] == $this->config['selectedOpt'])
                            $selected = 'selected';
                $resText .= '<option value = "'
                    . $elem['id']
                    . '" ' . $selected . '>'
                    . (($lvl) ? $this->tab($lvl + 1) : '')
                    . getLangText($elem['name'])
                    . ' </option> ';
                if ($sub = $this->getChild($elem['id'], $active))
                    $resText .= $this->createOptionsTreeForSelect($sub, $lvl + 1);
            }
        } else
            return '';

        return $resText;
    }

    function createTreeForMenusPage($elements, $lvl, $url, $active = 1, $deeped = true)
    {
        $resText = '';
        if ($elements) {
            foreach ($elements as $elem) {
                if ($deeped)
                    $elemUrl = $url . (($elem['url'][0] == '/') ? '' : '/') . $elem['url'];
                else {
                    $elemUrl = $elem['url'];
                }

                ob_start();
                ?>
                <tr id="tr-<?= $elem['id'] ?>" class="list">
                    <td><?= $elem['id'] ?></td>
                    <td class="td_left">
                        <a href="/admin/menus/edit/<?= $elem['id'] ?>/"
                           title="Перейти к редактированию"><?= (($lvl) ? $this->tab($lvl + 1) : '') . getLangText($elem['name']) ?></a>
                    </td>

                    <td><?= $elem['position'] ?></td>
                    <td><a href="<?= $elemUrl ?>" target="_blank"><?= $elemUrl ?></a></td>
                    <td><?php
                        if ($elem['type'] == 'url') echo 'URL';
                        elseif ($elem['type'] == 'page') echo 'Страница';
                        elseif ($elem['type'] == 'category') echo 'Раздел';
                        ?></td>


                    <td>
                        <?= $elem['num'] ?>
                        <a href="/admin/menus/up/<?= $elem['id'] ?>/"><img src="/img/uparrow.png" border="0" alt="Вверх"
                                                                           title="Вверх"/></a>
                        <a href="/admin/menus/down/<?= $elem['id'] ?>/"><img src="/img/downarrow.png" border="0"
                                                                             alt="Вниз" title="Вниз"/></a>
                    </td>

                    <td style="text-align: center; width: 50px">
                        <img class="row-active"
                             src="/img/admin/active-<?= $elem['active'] ?>.png"
                             type="menus"
                             row_id="<?= $elem['id'] ?>"
                             status="<?= $elem['active'] ?>"
                             id="row-active-<?= $elem['id'] ?>"
                             title="<?= ($elem['active'] == 0 ? 'Активировать' : 'Деактивировать'); ?>"/>
                    </td>
                    <td style="text-align: center">
                        <!--a href="<?= $url ?>" target="_blank"
                           class="btn btn-success btn-xs btn-label"><i
                                class="fa fa-search"></i>Просмотр</a><br/-->
                        <a href="/admin/menus/edit/<?= $elem['id'] ?>/"
                           class="btn btn-default btn-xs btn-label"><i
                                class="fa fa-pencil"></i>Редактировать</a><br/>
                        <a href="#" class="row-del btn btn-danger btn-xs btn-label"
                           id="del-<?= $elem['id'] ?>"
                           type="menus"
                           row_id="<?= $elem['id'] ?>"><i
                                class="fa fa-trash-o"></i>Удалить</a>
                    </td>
                </tr>
                <?php
                $resText .= ob_get_clean();
                $sub = $this->getChild($elem['id'], $active);
                if ($sub)
                    $resText .= $this->createTreeForMenusPage($sub, $lvl + 1, $elemUrl, $active, false);
            }
        } else
            return '';

        return $resText;
    }

    function createTreeForMenusPageNew($elements, $lvl, $url, $active = 1, $deeped = true)
    {
        $resText = '';
        if ($elements) {
            foreach ($elements as $elem) {
                if ($deeped)
                    $elemUrl = $url . (($elem['url'][0] == '/') ? '' : '/') . $elem['url'];
                else {
                    $elemUrl = $elem['url'];
                }

                ob_start();
                ?>
                <li id="tr-<?= $elem['id'] ?>" class="dd-item dd3-item" data-id="<?= $elem['id'] ?>">
                <div class="dd-handle dd3-handle"></div>
                <div class="dd3-content">
                    <?= getLangText($elem['name']) ?>
                    <div class="actions" style="float: right">
                        <span class="element-link"><a href="<?= $elem['url'] ?>" target="_blank"><?= $elem['url'] ?></a></span>
                        <!--span class="element-num">(<?= $elem['num'] ?>)</span-->
                            <span class="nestable-action">
                            <a class="btn btn-default btn-xs btn-label" href="/admin/menus/edit/<?= $elem['id'] ?>/"><i
                                    class="fa fa-pencil"></i>
                                Редактировать</a>
                                </span>
                            <span class="nestable-action">
                            <a id="del-<?= $elem['id'] ?>" class="row-del btn btn-danger btn-xs btn-label" href="#"
                               type="menus" row_id="<?= $elem['id'] ?>">
                                <i class="fa fa-trash-o"></i>Удалить
                            </a>
                                </span>
                    </div>
                </div>


                <?php
                $resText .= ob_get_clean();
                $sub = $this->getChild($elem['id'], $active);
                $subText = '';
                if ($sub) {
                    $subText = '<ol class="dd-list">' . $this->createTreeForMenusPageNew($sub, $lvl + 1, $elemUrl, $active, false) . '</ol>';
                }
                $resText .= $subText;
                $resText .= '</li>';
            }
        } else
            return '';

        return $resText;
    }

    function createTreeForCategoriesPage($elements, $lvl, $url, $active = 1)
    {
        $resText = '';
        if ($elements) {
            foreach ($elements as $elem) {
                $elemUrl = $url . '/' . $elem['url'];
                $CI = &get_instance();
                $first_id = $CI->model_categories->getFirstParentId($elem['id']);
                ob_start();
                ?>
                <tr id="tr-<?= $elem['id'] ?>" class="list<?php if ($elem['active'] == 0) echo ' no-active'; ?>">
                    <td><?= $elem['id'] ?></td>
                    <td>
                        <a href="/admin/categories/edit/<?= $elem['id'] ?>/"
                           title="Редактировать раздел"><?= $this->tab($lvl + 1) . getLangText($elem['name']) ?></a>
                    </td>
                    <td><a href="<?= $elemUrl ?>/" target="_blank"><?= $elemUrl ?>/</a></td>

                    <td><?= $elem['type'] ?></td>
                    <td><?= $elem['icon_class'] ?></td>
                    <td><?= $elem['num'] ?></td>
                    <td>
                        <a href="/admin/categories/up/<?= $elem['id'] ?>/"><img src="<?=GENERAL_DOMAIN?>/img/uparrow.png" border="0"
                                                                                alt="Вверх" title="Вверх"/></a>
                        <a href="/admin/categories/down/<?= $elem['id'] ?>/"><img src="<?=GENERAL_DOMAIN?>/img/downarrow.png" border="0"
                                                                                  alt="Вниз" title="Вниз"/></a>
                    </td>
                    <td><?= $elem['template'] ?></td>


                    <td style="text-align: center; width: 50px">
                        <img class="row-active"
                             src="<?=GENERAL_DOMAIN?>/img/admin/active-<?= $elem['active'] ?>.png"
                             type="categories"
                             row_id="<?= $elem['id'] ?>"
                             status="<?= $elem['active'] ?>"
                             id="row-active-<?= $elem['id'] ?>"
                             title="<?= ($elem['active'] == 0 ? 'Активировать' : 'Деактивировать'); ?>"/>
                    </td>
                    <td style="text-align: center">
                        <!--a href="<?= $url ?>" target="_blank"
                           class="btn btn-success btn-xs btn-label"><i
                                class="fa fa-search"></i>Просмотр</a><br/-->
                        <a href="/admin/categories/edit/<?= $elem['id'] ?>/"
                           class="btn btn-default btn-xs btn-label"><i
                                class="fa fa-pencil"></i>Редактировать</a><br/>
                        <a href="/admin/menus/add/?from=category&id=<?= $elem['id'] ?>"
                           class="btn btn-orange btn-xs btn-label">Добавить в меню</a><br/>
                        <a href="#" class="row-del btn btn-danger btn-xs btn-label"
                           id="del-<?= $elem['id'] ?>"
                           type="categories"
                           row_id="<?= $elem['id'] ?>"><i
                                class="fa fa-trash-o"></i>Удалить</a>
                    </td>
                </tr>
                <?php
                $resText .= ob_get_clean();
                if ($sub = $this->getChild($elem['id'], $active))
                    $resText .= $this->createTreeForCategoriesPage($sub, $lvl + 1, $elemUrl, $active);
            }
        } else
            return '';

        return $resText;
    }

    function createTreeForMainMenu($elements, $lvl, $url)
    {
        $resTree = '';
        if ($lvl == 0)
            $resTree .= $this->config['rootOpenTag'];
        else
            $resTree .= $this->config['childOpenTag'];
        foreach ($elements as $elem) {
            if ($lvl == 0)
                $resTree .= $this->config['rootItemOpenTag'];
            else
                $resTree .= $this->config['itemOpenTag'];

            if ($lvl == 0) {
                $resTree .= $this->config['rootItemTitleOpenTag'] . sprintf($this->linkTemplate, $url . '/' . $elem['id'] . '/', getLangText($elem['name'])) . $this->config['rootItemTitleCloseTag'];
                //$resTree .= '<img src = "/img/admin/menu_sub_' . (($_SERVER['REQUEST_URI'] != $elem['url']) ? 'not_' : '') . 'active.png" width = "13px" height = "11px" />';
            } else {
                $resTree .= $this->config['itemTitleOpenTag'] . sprintf($this->linkTemplate, $url . '/' . $elem['id'] . '/', getLangText($elem['name'])) . $this->config['itemTitleCloseTag'];
                //$resTree .= '<img src = "/img/admin/menu_sub_' . (($_SERVER['REQUEST_URI'] != $elem['url']) ? 'not_' : '') . 'active.png" width = "13px" height = "11px" />';
            }

            if ($sub = $this->getChild($elem['id']))
                $resTree .= $this->createTreeForMainMenu($sub, $lvl + 1, $url);

            if ($lvl == 0)
                $resTree .= $this->config['rootItemCloseTag'];
            else
                $resTree .= $this->config['itemCloseTag'];
        }
        if ($lvl == 0)
            $resTree .= $this->config['rootCloseTag'];
        else
            $resTree .= $this->config['childCloseTag'];

        return $resTree;
    }

    private function getChild($elementId, $active = 1)
    {
        $CI = &get_instance();
        switch ($this->type) {
            case 'category' :
                $CI->load->model('Model_categories', 'cats');
                return $CI->cats->getSubCategories($elementId, $active);
            case 'menu':
                $CI->load->model('Model_menus', 'menus');
                return $CI->menus->getMenusWithParentId($elementId);
        }
    }

    private function tab($lvl)
    {
        $t = "";
        for ($i = 0; $i < $lvl; $i++) {
            $t .= "&nbsp;&nbsp;&nbsp;";
        }
        return $t . '└&nbsp;';
    }
}


class MenuTree
{
    private $config;
    private $linkTemplate = "<a href = \"http://%s\">%s</a>";
    private $imgTemplate = "<img src = \"%s\" alt=\"%s\" title=\"%s\" />";

    function __construct($position = 'top', $config = false)
    {
            if(isset($config['rootOpenTag']))
                $this->config['rootOpenTag'] = $config['rootOpenTag'];
            else $this->config['rootOpenTag'] = '<ul class = "nav navbar-nav navbar-left">';
            if(isset($config['rootCloseTag']))
                $this->config['rootCloseTag'] = $config['rootCloseTag'];
            else $this->config['rootCloseTag'] = '</ul>';
            if(isset($config['childOpenTag']))
                $this->config['childOpenTag'] = $config['childOpenTag'];
            else $this->config['childOpenTag'] = '<ul class="drop_down">';
            if(isset($config['childCloseTag']))
                $this->config['childCloseTag'] = $config['childCloseTag'];
            else $this->config['childCloseTag'] = '</ul>';

            if(isset($config['rootItemOpenTag']))
                $this->config['rootItemOpenTag'] = $config['rootItemOpenTag'];
            else $this->config['rootItemOpenTag'] = '<li>';
            if(isset($config['rootItemTitleOpenTag']))
                $this->config['rootItemTitleOpenTag'] = $config['rootItemTitleOpenTag'];
            else $this->config['rootItemTitleOpenTag'] = '<span data-hover="[name]">';
            if(isset($config['rootItemTitleCloseTag']))
                $this->config['rootItemTitleCloseTag'] = $config['rootItemTitleCloseTag'];
            else $this->config['rootItemTitleCloseTag'] = '</span>';
            if(isset($config['rootItemCloseTag']))
                $this->config['rootItemCloseTag'] = $config['rootItemCloseTag'];
            else $this->config['rootItemCloseTag'] = '</li>';

            if(isset($config['itemOpenTag']))
                $this->config['itemOpenTag'] = $config['itemOpenTag'];
            else $this->config['itemOpenTag'] = '<li class="item">';
            if(isset($config['itemTitleOpenTag']))
                $this->config['itemTitleOpenTag'] = $config['itemTitleOpenTag'];
            else $this->config['itemTitleOpenTag'] = '';
            if(isset($config['itemTitleCloseTag']))
                $this->config['itemTitleCloseTag'] = $config['itemTitleCloseTag'];
            else $this->config['itemTitleCloseTag'] = '';
            if(isset($config['itemCloseTag']))
                $this->config['itemCloseTag'] = $config['itemCloseTag'];
            else $this->config['itemCloseTag'] = '</li>';

        $CI = &get_instance();
        //$CI->db->where('parent_id', 70);
        $CI->db->where('position', $position);
        $CI->db->where('active', '1');
        $CI->db->order_by('num', 'ASC');
        $elems = $CI->db->get('menus')->result_array();
        $this->menu = array();
        foreach ($elems as $m) {
            /* for invert
            $elems_id[$m['id']][] = $m;
            */
            $this->menu[$m['parent_id']][$m['id']] = $m;
        }
    }

    function createTree($parent_id, $lvl, $deep = false, $url = '', $deeped = true)
    {
        $langs = array();
        $languages = getLanguages();
        $default_lang = getDefaultLanguageCode();
        //if ($default_lang) $default_lang = $default_lang['code'];
        for ($i = 0; $i < count($languages); $i++) {
            $langs[$i] = $languages[$i]['code'];
        }
        $current_lang = getCurrentLanguageCode();

        $resTree = '';
        if (isset($this->menu[$parent_id])) {

            if ($lvl == 0)
                $resTree .= $this->config['rootOpenTag'];
            else
                $resTree .= $this->config['childOpenTag'];

            foreach ($this->menu[$parent_id] as $item) {
                if ($lvl == 0)
                    $resTree .= $this->config['rootItemOpenTag'];
                else
                    $resTree .= $this->config['itemOpenTag'];

                if (($default_lang != $current_lang) && (isset($item['name_' . $current_lang])))
                    $translatedName = $item['name_' . $current_lang];
                else
                    $translatedName = getLangText($item['name']);
                if (isset($item['show_type']) && !empty($item['show_type']))
                    switch ($item['show_type']) {
                        case 'icon':
                            $itemName = sprintf($this->imgTemplate, ((isset($item['icon']) && !empty($item['icon'])) ? $item['icon'] : ''), $translatedName, $translatedName);
                            break;
                        case 'both':
                            $itemName = sprintf($this->imgTemplate, ((isset($item['icon']) && !empty($item['icon'])) ? $item['icon'] : ''), $translatedName, $translatedName);
                            //$this->config['rootItemTitleOpenTag'] = str_replace('[name]',$itemName, $this->config['rootItemTitleOpenTag']);
                            if ($lvl == 0)
                                $itemName = str_replace('[name]',$translatedName, $this->config['rootItemTitleOpenTag']) . $translatedName . $this->config['rootItemTitleCloseTag'];
                            else
                                $itemName = $this->config['itemTitleOpenTag'] . $translatedName . $this->config['itemTitleCloseTag'];
                            break;
                        default:
                            if ($lvl == 0)
                                $itemName = str_replace('[name]',$translatedName, $this->config['rootItemTitleOpenTag']) . $translatedName . $this->config['rootItemTitleCloseTag'];
                            else
                                $itemName = $this->config['itemTitleOpenTag'] . $translatedName . $this->config['itemTitleCloseTag'];
                            break;
                    }
                else
                    if ($lvl == 0)
                        $itemName = str_replace('[name]',$translatedName, $this->config['rootItemTitleOpenTag']) . $translatedName . $this->config['rootItemTitleCloseTag'];
                    else
                        $itemName = $this->config['itemTitleOpenTag'] . $translatedName . $this->config['itemTitleCloseTag'];

                if ($deeped) {
                    $itemUrl = $url . (($item['url'][0] != '/' && (!$url || $url[strlen($url) - 1] != '/')) ? '/' : '') . $item['url'] . (($item['url'][strlen($item['url']) - 1] != '/') ? '/' : '');
                    $itemUrl = getUrl($itemUrl);
                } else {
                    $itemUrl = $item['url'];
                    if($item['params'] == '[first_product]') {
                        $itemUrl = modules_getLastProductUrl();
                    }

                }

                if (isset($item['no_click']) && $item['no_click']) {
                    $resTree .= '<a>' . $itemName . '</a>';
                }
                else {
                    if ($lvl == 0)
                        $resTree .= sprintf($this->linkTemplate, $_SERVER['SERVER_NAME'] . getUrl($itemUrl), $itemName);
                    else
                        $resTree .= sprintf($this->linkTemplate, $_SERVER['SERVER_NAME'] . getUrl($itemUrl), $itemName);
                }


                if ($deep === false || $lvl < $deep)
                    $resTree .= $this->createTree($item['id'], $lvl + 1, $deep, $itemUrl, false);


                if ($lvl == 0)
                    $resTree .= $this->config['rootItemCloseTag'];
                else
                    $resTree .= $this->config['itemCloseTag'];
            }
            if ($lvl == 0)
                $resTree .= $this->config['rootCloseTag'];
            else
                $resTree .= $this->config['childCloseTag'];
        } else
            return null;

        return $resTree;
    }

    private function tab($lvl)
    {
        $t = "";
        for ($i = 0; $i < $lvl; $i++) {
            $t .= "\t";
        }
        return $t;
    }

    function find_parent($tmp, $cur_id)
    {
        if ($tmp[$cur_id][0]['parent_id'] != 0) {
            return find_parent($tmp, $tmp[$cur_id][0]['parent_id']);
        }
        return (int)$tmp[$cur_id][0]['id'];
    }

}

function getSubcategories($parent_id, $active = 1){
    $model = getModel('categories');
    return $model->getSubCategories($parent_id, $active);
}