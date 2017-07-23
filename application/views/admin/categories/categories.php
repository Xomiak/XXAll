<?=$head?>
<?=$header?>
<div id="wrapper">
    <div id="layout-static">
        <?=$left_sidebar?>
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
                    <?php include(X_PATH.'/application/views/admin/'.$type.'/menu.inc.php'); ?>
                    <div class="container-fluid">
                        

                        <div class="row">
                            <div class="col-md-12">


                                <?php
                                if ($categories) {
                                ?>
                                <div id="result"></div>
                                <table class="table table-striped table-bordered">
                                    <thead>
                                    <tr bgcolor="#EEEEEE">
                                        <th>ID</th>
                                        <th>Название</th>
                                        <th>Путь</th>
                                        <th>Тип</th>
                                        <th>Иконка</th>
                                        <th colspan="2">Позиция</th>
                                        <th>Шаблон</th>
                                        <th colspan="2" style="text-align: center; width: 100px">Действия</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    $adminCategoriesTree = new AdminElementsTree('category');
                                    echo $adminCategoriesTree->createTreeForCategoriesPage($categories, 0, '', -1);
                                    } else {
                                        echo '<tr><td colspan="3">Пусто...</td></tr>';
                                    }
                                    ?>
                                    </tbody>
                                </table>
<!--                                <div class="text-center">-->
<!--                                    <div class="pagination">-->
<!--                                        --><?//= $pager ?>
<!--                                    </div>-->
<!--                                </div>-->
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
?>
    <?=$footer?>
