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
                                <div id="adress-search" style="<?php if(isset($map)) echo 'display:none;'?>">
                                    <form method="post">
                                        Поиск по адресу:<br/>
                                        <input placeholder="Одесса, Пушкинская, 57" type="text" name="adress"
                                               value="<?= post('adress') ?>"/>
                                        <div class="help">Внимание!!! Для точного определения местоположения Вашей организации обязательно укажите город!</div>
                                        <input type="submit" name="adressSearch" value="Поехали!"/>
                                    </form>
                                </div>

                                <?php
                                if (isset($map)) {
                                    ?>
                                    <a id="showAdressInput" style="cursor: pointer">повторить поиск</a>
                                    <?php
                                    echo $map['html'];
                                    ?>
                                    <div class="help">Вы можете изменить положение указателя перетаскиванием</div>

                                    <br />
                                    <form method="post">
                                        <input type="hidden" name="coordsLat" id="coordsLat" value="<?=$coords[0]?>" />
                                        <input type="hidden" name="coordsLng" id="coordsLng" value="<?=$coords[1]?>" />
                                        <input type="hidden" name="article_id" value="<?=$article['id']?>" />
                                        <table style="width: 100%">
                                            <tr>
                                                <td style="vertical-align: top;">Адрес:</td>
                                                <td><input required type="text" name="adress" value="<?php if(isset($_POST['adress'])) echo post('adress'); elseif(isset($adress['adress'])) echo $adress['adress']; ?>"/></td>
                                            </tr>
                                            <tr>
                                                <td style="vertical-align: top;">Описание:</td>
                                                <td>
                                                    <textarea name="description" placeholder="Школа №33"><?php if(isset($_POST['description'])) echo post('description'); elseif(isset($adress['description'])) echo $adress['description']; ?></textarea>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td colspan="2">
                                                    <?php if(isset($adress)) { ?>
                                                        <input type="submit" name="editAdress" value="Сохранить адрес" />
                                                    <?php } else {?>
                                                        <input type="submit" name="addAdress" value="Добавить адрес" />
                                                    <?php } ?>
                                                </td>
                                            </tr>
                                        </table>
                                    </form>
                                    <?php
                                }
                                ?>
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