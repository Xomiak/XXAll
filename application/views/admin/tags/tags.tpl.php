<?= $head ?>
<?= $header ?>
<div id="wrapper">
    <div id="layout-static">
        <?= $left_sidebar ?>
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

                                        <div class="form-group pull-left" title="В процессе разработки...">
                                            <select name="action" id="mass_action" class="form-control" disabled>
                                                <option value="">- Массовые действия -</option>
                                                <option value="active">Активировать</option>
                                                <option value="not_active">Деактивировать</option>
                                                <option value="delete">Удалить</option>
                                            </select>

                                            <input disabled id="mass_action_submit" class="btn btn-default" type="button"
                                                   name="mass_action" value="Применить">
                                        </div>

                                        <table class="table table-striped table-bordered">
                                            <thead>
                                            <tr>
                                                <th style="width: 60px!important">ID</th>
                                                <th>Название</th>
                                                <th>Url</th>
                                                <th>Счётчик</th>
                                                <th>Действия</th>

                                            </tr>
                                            </thead>
                                            <tbody>
                                            <?php
                                            $count = count($tags);
                                            for ($i = 0; $i < $count; $i++) {
                                                $tag = $tags[$i];
                                                $tag['name'] = getLangText($tag['name']);
                                                ?>
                                                <tr id="tr-<?= $tag['id'] ?>" class="list">
                                                    <td><a href="/admin/tags/edit/<?= $tag['id'] ?>/"
                                                           title="Перейти к редактированию"><?= $tag['id'] ?></a></td>


                                                    <td><a href="/admin/tags/edit/<?= $tag['id'] ?>/"
                                                           title="Перейти к редактированию"><?= $tag['name'] ?></a>
                                                    </td>
                                                    <td><a target="_blank"
                                                           href="/tags/<?= $tag['url'] ?>/">/tags/<?= $tag['url'] ?>
                                                            /</a></td>

                                                    <td><span id="count_<?= $tag['id'] ?>"><?= $tag['count'] ?></span>
                                                    </td>
                                                    <td>
                                                        <a href="/tags/<?= $tag['url'] ?>/" target="_blank"
                                                           class="btn btn-success btn-xs btn-label"><i
                                                                class="fa fa-search"></i>Просмотр</a><br/>
                                                        <!--a href="/admin/tags/edit/<?= $tag['id'] ?>/"
                                                   class="btn btn-default btn-xs btn-label"><i
                                                        class="fa fa-pencil"></i>Редактировать</a><br/-->

                                                        <a
                                                            class="row-recount btn btn-primary btn-xs btn-label"
                                                            id="recount-<?= $tag['id'] ?>"
                                                            type="tags"
                                                            params="delFieldInArticlesAndProducts"
                                                            row_id="<?= $tag['id'] ?>">

                                                            <i class="fa fa-refresh"></i>Пересчитать
                                                        </a><br/>

                                                        <a href="#"
                                                           class="row-del btn btn-danger btn-xs btn-label"
                                                           id="del-<?= $tag['id'] ?>"
                                                           type="tags"
                                                           params="delFieldInArticlesAndProducts"
                                                           row_id="<?= $tag['id'] ?>">

                                                            <i class="fa fa-trash-o"></i>Удалить
                                                        </a>


                                                    </td>
                                                </tr>
                                                <?php
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

            <script>
                $(document).ready(function () {
                    $(".row-recount").click(function () {
                        var tag_id = $(this).attr('row_id');
                        recountTags(tag_id);
                    });
                });
            </script>
            <?php
            if(isset($footer)) {
                $adding_scripts = '';
                $footer = str_replace('[adding_scripts]', $adding_scripts, $footer);
                echo $footer;
            }
            ?>
