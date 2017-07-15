<?php if(isset($head)) echo $head; ?>
<?php if(isset($header)) echo $header; ?>
    <div id="wrapper">
    <div id="layout-static">
<?php if(isset($left_sidebar)) echo $left_sidebar; ?>
    <div class="static-content-wrapper">
    <div class="static-content">
        <div class="page-content">
            <ol class="breadcrumb">

                <li><a href="/">Главная</a></li>
                <li class="active"><a href="<?= $_SERVER['REQUEST_URI'] ?>"><?= $title ?></a></li>

            </ol>
            <div class="page-heading">
                <h1><?= $title ?></h1>
                <div class="options">
                    <div class="btn-toolbar">
                        <a href="#" class="btn btn-default"><i class="fa fa-fw fa-wrench"></i></a>
                    </div>
                </div>
            </div>
            <div class="container-fluid">

                <div class="row">
                    <div class="col-md-12">

                        <div class="panel">
                            <div class="panel-body panel-no-padding">

                                <div class="pagination"><?= $pager ?></div>
                                <table class="table table-striped table-bordered">
                                    <thead>
                                    <tr>
                                        <th>Активен</th>
                                        <th>Дата</th>
                                        <th>Автор</th>
                                        <th>Текст</th>
                                        <th style="text-align: center">Инфо</th>
                                        <th width="125px" align="center">Действия</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    if ($comments) {
                                        $count = count($comments);
                                        for ($i = 0; $i < $count; $i++) {
                                            $c = $comments[$i];

                                            $url = false;
                                            if($c['article_id'] != 0) {                                 // Если коммент к статье
                                                $art = $this->art->getArticleById($c['article_id']);
                                                $carr = explode("*", $art['category_id']);
                                                $cat_id = $carr[0];
                                                $cat = $this->cat->getCategoryById($cat_id);
                                                $parent = '';
                                                if ($cat['parent'] != 0) {
                                                    $parent = $this->cat->getCategoryById($cat['parent']);
                                                }
                                                $url = getFullUrl($art);
                                            } elseif ($c['page_id'] != 0){                                 // Если коммент к странице
                                                $page = $this->pages->getPageById($c['page_id']);
                                                if($page)
                                                    $url = '/'.$page['url'].'/';
                                            }

                                            $user = false;
                                            if($c['user_id'] != 0)
                                                $user = $this->users->getUserById($c['user_id']);
                                            else $user = $this->users->getUserByLogin($c['login']);

                                            ?>
                                            <tr id="tr-<?= $c['id'] ?>">
                                                <td style="text-align: center">
                                                    <img class="row-active"
                                                         src="<?=GENERAL_DOMAIN?>/img/admin/active-<?= $c['active'] ?>.png"
                                                         type="comments"
                                                         row_id="<?= $c['id'] ?>"
                                                         status="<?= $c['active'] ?>"
                                                         id="row-active-<?= $c['id'] ?>"
                                                         title="<?= ($c['active'] == 0 ? 'Активировать' : 'Деактивировать'); ?>"/>
                                                </td>
                                                <td>
                                                    <?=$c['date']?> <?=$c['time']?>
                                                </td>
                                                <td>
                                                    <?=$c['login']?>
                                                </td>
                                                <td>
                                                    <?=$c['comment']?>
                                                </td>
                                                <td>
                                                    Автор: <?php
                                                    if($user)
                                                        echo '<a target="_blank" href="/admin/users/edit/'.$user['id'].'/">';
                                                    echo $c['login'];
                                                    if($user)
                                                        echo '</a>';
                                                    ?><br />
                                                    IP: <?=$c['ip']?><br />

                                                </td>
                                                <td>
                                                    <?php if(($url) && $c['active'] == 1) { ?>
                                                    <a href="<?= $url ?>#comment-<?=$c['id']?>" target="_blank"
                                                                   class="btn btn-success btn-xs btn-label"><i
                                                                        class="fa fa-search"></i>Просмотр</a><br/>
                                                    <?php } ?>
                                                    <!--a href="/admin/articles/edit/<?= $c['id'] ?>/"
                                                       class="btn btn-default btn-xs btn-label"><i
                                                            class="fa fa-pencil"></i>Редактировать</a><br/-->

                                                    <a href="#"
                                                       class="row-del btn btn-danger btn-xs btn-label"
                                                       id="del-<?= $c['id'] ?>"
                                                       type="comments"
                                                       row_id="<?= $c['id'] ?>"><i
                                                            class="fa fa-trash-o"></i>Удалить</a>
                                                </td>
                                            </tr>
                                            <?php
                                        }
                                    }
                                    ?>
                                    </tbody>
                                </table>
                                <div class="pagination"><?= $pager ?></div>
                            </div>
                        </div>
                    </div>
                </div>

            </div> <!-- .container-fluid -->
        </div> <!-- #page-content -->
    </div>
    <div id="result"></div>

        <?php
        $adding_scripts = "";
        if(isset($footer)) {
            $footer = str_replace('[adding_scripts]', $adding_scripts, $footer);
            echo $footer;
        }
        ?>
