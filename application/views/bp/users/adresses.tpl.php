<?php
include("application/views/head.php");
include("application/views/header.php");
$this->lang->load('main', $current_lang);
?>

    <!-- START MAIN-SECTION- -->
    <section class="sections">
        <div class="container">
            <div class="row">
                <?php include('application/views/users/my_organizations.inc.php'); ?>

                <div class="col-md-8">
                    <div class="page-section-center">

                        <?php include("application/views/mod/breadcrumbs.mod.php") ?>

                        <section class="add-organization">

                            <h1><?= $h1 ?></h1>

                            <div class="col-md-12 ">
                                <a href="/user/add-adress/<?=$article['id']?>/">Добавить новый адрес</a>
                                <table class="my-organizations-table" style="width: 100%; border: groove 1px #aaaaaa">
                                    <tr style="border: 1px ridge #aaaaaa">
                                        <th></th>
                                        <th>Адрес</th>
                                        <th>Город</th>
                                        <th>Описание</th>
                                        <th style="text-align: center">Статус</th>
                                        <th>Действия</th>
                                    </tr>

                                    <?php
                                    $i = 0;
                                    if ($adresses) {
                                        foreach ($adresses as $adress) {
                                            $i++;
                                            $cat = $this->model_categories->getCategoryById($article['category_id']);
                                            ?>
                                            <tr style="border: 1px ridge #aaaaaa">
                                                <td valign="top"><?= $i ?>.</td>
                                                <td valign="top"><?=str_replace($adress['city'].',','',$adress['adress'])?></td>
                                                <td valign="top" style="text-align: center">
                                                    <?php
                                                    if($adress['city'] == '')
                                                        echo '<img src="/img/warning.png" title="Рекомендуется указать город в адресе!" />';
                                                    else echo $adress['city'];
                                                    ?>
                                                </td>
                                                <td valign="top">
                                                    <?=str_replace("\n","<br />",$adress['description'])?>
                                                </td>
                                                <td valign="top" style="text-align: center">
                                                    <?php
                                                    if ($adress['active'] == 0)
                                                        echo 'Ожидает модерации';
                                                    elseif ($adress['active'] == 1)
                                                        echo 'Активен';
                                                    ?>
                                                </td>
                                                <td valign="top">
                                                    <a href="/user/edit-adress/<?= $adress['id'] ?>/">Редактировать</a><br/>
                                                    <a onclick="return confirm('Вы точно хотите удалить адрес?')" href="/user/del-adress/<?= $adress['id'] ?>/">Удалить</a>
                                                </td>
                                            </tr>
                                            <?php
                                        }
                                    } else echo '<tr><td colspan="4">Вами не было добавлено ни одного адреса...</td></tr>';
                                    ?>

                                </table>
                            </div>

                        </section>
                    </div>
                </div>
                <?php include('application/views/users/menu.inc.php'); ?>

            </div>
        </div>
    </section>

    <!-- END MAIN-SECTION- -->
    <section class="main-section">
        <?php include('application/views/bottom.tpl.php'); ?>
    </section>

<?php include("application/views/footer.php"); ?>