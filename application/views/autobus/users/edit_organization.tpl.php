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
                            <h1 class = "long"><?=$h1?></h1>

                            <?php
                            if(isset($err) && ($err)) echo '<div class="error">'.$err.'</div>';

                            if(isset($msg) && ($msg)) echo '<div class="msg">'.$msg.'</div>';
                            else {
                                ?>
                                <div class="msg">Внимание!!! При внесении изменений в анкету организации потребуется повторная проверка и активация организации администратором!</div>
                                <h2>Адрес(а):</h2>
                                
                                <form method="post" enctype="multipart/form-data">

                                    <label for="for-name">Название <span class="star">*</span>:</label>
                                    <input id="for-name" type="text" name="name" placeholder="Жасмин" value="<?=$article['name']?>" required/>

                                    <label for="for-first-category">Категория <span class="star">*</span>:</label>
                                    <select id="for-first-category" name="first_category_id" required>
                                        <option>Выберите категорию</option>
                                        <?php
                                        foreach ($categories as $category) {
                                            echo '<option value="' . $category['id'] . '"';
                                            if($category['id'] == $first_cat['id']) echo ' selected';
                                            echo '>' . $category['name'] . '</option>';
                                        }
                                        ?>
                                    </select>
                                    <script src="/libs/jquery/jquery-2.2.4.min.js"></script>
                                    <script>
                                        $(document).ready(function () {
                                            $("#for-first-category").change(function () {
                                                var category_id = $("#for-first-category").val();
                                                getSubcategories(category_id, 'for-sub-category');
                                                $("#category_id").val(category_id);
                                            });
                                            $("#for-sub-category").change(function () {
                                                var category_id = $("#for-sub-category").val();
                                                getSubcategories(category_id, 'for-category');
                                                $("#category_id").val(category_id);
                                            });
                                            $("#for-category").change(function () {
                                                var category_id = $("#for-category").val();
                                                $("#category_id").val(category_id);
                                            });

                                        });
                                    </script>

                                    <div id="for-sub-category-div" style="">
                                        <label for="for-sub-category">Подкатегория <span class="star">*</span>:</label>
                                        <select id="for-sub-category" name="sub_category_id" required>
                                            <option></option>
                                            <?php
                                            if($parent_categories){
                                                foreach ($parent_categories as $item){
                                                    echo '<option value="'.$item['id'].'"';
                                                    if($item['id'] == $parent_cat['id'] || $item['id'] == $article['category_id']) echo ' selected';
                                                    echo '>'.$item['name'].'</option>';
                                                }
                                            }
                                            ?>
                                        </select>
                                    </div>
                                    <div id="for-category-div" style="<?php if(!$three_categories) echo 'display:none';?>">
                                        <label for="for-category">Направление <span class="star">*</span>:</label>
                                        <select id="for-category" name="three_category_id">
                                            <option></option>
                                            <?php
                                            if($three_categories){
                                                foreach ($three_categories as $item){
                                                    echo '<option value="'.$item['id'].'"';
                                                    if($item['id'] == $article['category_id']) echo ' selected';
                                                    echo '>'.$item['name'].'</option>';
                                                }
                                            }
                                            ?>
                                        </select>
                                    </div>
                                    <input type="hidden" name="category_id" required id="category_id" value="<?=$article['category_id']?>"/>

                                    <label for="for-image">Логотип:</label>
							<span class="info tooltip" data-tooltip="Поддерживаются только форматы: jpg, png либо gif">
								<img src="/img/admin/info.png">
							</span>
                                    <br/>
                                    <div class="wrap-org-img">
                                        <?php if($article['image'] != '') echo '<img style="max-width: 200px; max-height: 200px;" src="'.$article['image'].'" alt="" />'; ?>
                                        <input id="for-image" type="file" name="userfile"/>
                                    </div>

                                    <label for="for-short_content">Краткая информация <span class="star">*</span>:</label>
                                    <input id="for-short_content" type="text" name="short_content"
                                           placeholder="Студия танца" value="<?=$article['short_content']?>" required/>

                                    <div id="for-city-div" style="">
                                        <label for="for-city">Город <span class="star">*</span>:</label>
                                        <select id="for-city" name="city_id" required>
                                            <option></option>
                                            <?php
                                            $last_city_id = false;
                                            $cities = $this->cities->getCitiesByRegionId(1);
                                            if($cities){
                                                foreach ($cities as $city) {
                                                    echo '<option value="'.$city['id'].'"';
                                                    if($city['primary_city'] == 1){
                                                        echo ' class="primary-city"';
                                                        $last_city_id = $city['id'];
                                                    }
                                                    if($city['id'] == $article['city_id']) {
                                                        echo ' selected';
                                                        $last_city_id = $city['id'];
                                                    }
                                                    elseif($city['name'] == $article['city']) {
                                                        echo ' selected';
                                                        $last_city_id = $city['id'];
                                                    }
                                                    echo '>'.$city['name'].'</option>';
                                                }
                                            }
                                            ?>
                                        </select>
                                    </div>

                                    <?php
                                    $city_areas = false;
                                    if($last_city_id){
                                        $city_areas = $this->cities->getAreasByCityId($last_city_id, 1);
                                    }
                                    ?>
                                    <div id="for-city-area-div" style="<?php if(!$city_areas) echo 'display:none;'?>">
                                        <label for="for-city-area">Район:</label>
                                        <select id="for-city-area" name="city_area_id">
                                            <option></option>
                                            <?php
                                            if($city_areas){
                                                foreach ($city_areas as $area) {
                                                    echo '<option value="'.$area['id'].'"';
                                                    if($area['id'] == $article['city_area_id']) echo ' selected';
                                                    echo '>'.$area['name'].'</option>';
                                                }
                                            }
                                            ?>
                                        </select>
                                    </div>

                                    <!--label for="for-adress">Адрес(а) <span class="star">*</span>:</label>
							        <span class="info tooltip" data-tooltip="Строго по одному в строке">
								<img src="/img/admin/info.png">
							</span>
                                    <textarea name="adress" id="for-adress" placeholder="Садовая, 3" required><?php
//                                        $adress = getAdressArray($article['adress']);
//                                        if(is_array($adress)){
//                                            $first = true;
//                                            foreach ($adress as $item){
//                                                if(!$first) echo '
//';
//                                                echo trim(str_replace('adress=','',$item['adress']));
//                                                $first = false;
//                                            }
//                                        } else echo str_replace('adress=','',$article['adress']);
                                        ?></textarea-->

                                    <label for="for-email">E-mail <span class="star">*</span>:</label>
                                    <input id="for-email" type="email" name="email" placeholder="Садовая, 3"
                                           value="<?=$article['email']?>" required/>

                                    <label for="for-site">Сайт:</label>
                                    <input id="for-site" type="text" name="site" placeholder="http://hobby.od.ua" value="<?=$article['site']?>"/>

                                    <label for="for-soc">Соц. сети:</label>
							<span class="info tooltip" data-tooltip="Строго по одной в строке">
								<img src="/img/admin/info.png">
							</span>
                                    <textarea name="soc" id="for-soc" placeholder="https://vk.com/hobby_odessa"><?php
                                        $soc = explode('|', $article['soc']);
                                        if(is_array($soc)){
                                            $first = true;
                                            foreach ($soc as $item){
                                                if(!$first) echo '
';
                                                echo trim($item);
                                                $first = false;
                                            }
                                        } else echo $article['soc'];
                                        ?></textarea>

                                    <label for="for-tel">Телефоны <span class="star">*</span>:</label>
							<span class="info tooltip" data-tooltip="Строго по одному в строке">
								<img src="/img/admin/info.png">
							</span>
                                    <textarea name="tel" id="for-tel" placeholder="(048) 705-10-52" required><?php
                                        $tel = explode('|', $article['tel']);
                                        if(is_array($tel)){
                                            $first = true;
                                            foreach ($tel as $item){
                                                if(!$first) echo '
';
                                                echo trim($item);
                                                $first = false;
                                            }
                                        } else {
                                            $tel = explode(',', $article['tel']);
                                            if(is_array($tel)){
                                                $first = true;
                                                foreach ($tel as $item){
                                                    if(!$first) echo '
';
                                                    echo trim($item);
                                                    $first = false;
                                                }
                                            }
                                            echo $article['tel'];
                                        }
                                        ?></textarea>

                                    <label for="for-trener">ФИО тренера:</label><br/>
                                    <input id="for-trener" type="text" name="trener" placeholder="Иванов Иван Иванович"
                                           value="<?=$article['trener']?>"/>

                                    <br>
                                    <span class="star">*</span> - поля, обязательные для заполнения

                                    <input type="submit" name="edit_organization" value="Сохранить"/>
                                </form>
                                <?php
                            }
                            ?>
                        </section>
                    </div>
                </div>
                <script src="/libs/jquery/jquery-2.2.4.min.js"></script>
                <script>
                    $(document).ready(function () {
                        $("#for-first-category").change(function () {
                            var category_id = $("#for-first-category").val();
                            getSubcategories(category_id, 'for-sub-category');
                            $("#category_id").val(category_id);
                        });
                        $("#for-sub-category").change(function () {
                            var category_id = $("#for-sub-category").val();
                            getSubcategories(category_id, 'for-category');
                            $("#category_id").val(category_id);
                        });

                        $("#for-city").change(function () {
                            var city_id = $("#for-city").val();
                            getCityAreas(city_id, 'for-city-area');
                        });

                        $("#for-how").change(function () {
                            if($("#for-how").val() == 'other'){
                                $("#how-other-div").show();
                                $("#for-how-other").attr('required', true);
                            } else {
                                $("#how-other-div").hide();
                                $("#for-how-other").attr('required', false);
                            }
                        });
                    });
                </script>
                <?php include('application/views/users/menu.inc.php'); ?>
            </div>
        </div>
    </section>

    <!-- END MAIN-SECTION- -->
    <section class="main-section">
        <?php include('application/views/bottom.tpl.php'); ?>
    </section>

<?php include("application/views/footer.php"); ?>