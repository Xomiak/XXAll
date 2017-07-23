<?php
include("application/views/head.php");
include("application/views/header.php");
$this->lang->load('main', $current_lang);
?>

<!-- START MAIN-SECTION- -->
<section class="sections">
	<div class="container">
		<div class="row">
			<?php include('application/views/left.tpl.php'); ?>

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
							<form method="post" enctype="multipart/form-data">

								<label for="for-name">Название <span class="star">*</span>:</label>
								<input id="for-name" type="text" name="name" placeholder="Жасмин" required/>

								<label for="for-first-category">Категория <span class="star">*</span>:</label>
								<select id="for-first-category" name="first_category_id" required>
									<option>Выберите категорию</option>
									<?php
									foreach ($categories as $category) {
										echo '<option value="' . $category['id'] . '">' . $category['name'] . '</option>';
									}
									?>
								</select>


								<div id="for-sub-category-div" style="display: none">
									<label for="for-sub-category">Подкатегория <span class="star">*</span>:</label>
									<select id="for-sub-category" name="sub_category_id" required>
										<option></option>
									</select>
								</div>
								<div id="for-category-div" style="display: none">
									<label for="for-category">Направление <span class="star">*</span>:</label>
									<select id="for-category" name="three_category_id">
										<option></option>
									</select>
								</div>
								<input type="hidden" name="category_id" required id="category_id" value=""/>

								<label for="for-image">Логотип:</label>
							<span class="info tooltip" data-tooltip="Поддерживаются только форматы: jpg, png либо gif">
								<img src="/img/admin/info.png">
							</span>
								<br/>
								<input id="for-image" type="file" name="userfile"/>

								<label for="for-short_content">Краткая информация <span class="star">*</span>:</label>
								<input id="for-short_content" type="text" name="short_content"
									   placeholder="Студия танца" required/>

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
													echo ' class="primary-city" selected';
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
												echo '<option value="'.$area['id'].'">'.$area['name'].'</option>';
											}
										}
										?>
									</select>
								</div>

								<!--label for="for-adress">Адрес(а) <span class="star">*</span>:</label>
							<span class="info tooltip" data-tooltip="Строго по одному в строке">
								<img src="/img/admin/info.png">
							</span>
								<textarea name="adress" id="for-adress" placeholder="Садовая, 3" required></textarea-->

								<label for="for-email">E-mail <span class="star">*</span>:</label>
								<input id="for-email" type="email" name="email" placeholder="Садовая, 3"
									   value="<?= $user['email'] ?>" required/>

								<label for="for-site">Сайт:</label>
								<input id="for-site" type="text" name="site" placeholder="http://hobby.od.ua" value=""/>

								<label for="for-soc">Соц. сети:</label>
							<span class="info tooltip" data-tooltip="Строго по одной в строке">
								<img src="/img/admin/info.png">
							</span>
								<textarea name="soc" id="for-soc" placeholder="https://vk.com/hobby_odessa"></textarea>

								<label for="for-tel">Телефоны <span class="star">*</span>:</label>
							<span class="info tooltip" data-tooltip="Строго по одному в строке">
								<img src="/img/admin/info.png">
							</span>
								<textarea name="tel" id="for-tel" placeholder="(048) 705-10-52" required></textarea>

								<label for="for-trener">ФИО тренера:</label><br/>
								<input id="for-trener" type="text" name="trener" placeholder="Иванов Иван Иванович"
									   value=""/>

								<label for="for-how">Как Вы о нас узнали? <span class="star">*</span></label><br/>
								<select name="how" id="for-how" required>
									<option></option>
									<option>Интернет</option>
									<option>Реклама на улице</option>
									<option>Реклама в маршрутках</option>
									<option>От знакомых</option>
									<option value="other">Другой вариант</option>
								</select>
								<div id="how-other-div" style="display: none">
									<label for="for-how-other">Укажите как: <span class="star">*</span></label><br/>
									<input id="for-how-other" type="text" name="how-other" placeholder=""
										   value=""/>
								</div>

								<br>
								<span class="star">*</span> - поля, обязательные для заполнения

								<input type="submit" name="add_organization" value="Добавить"/>
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

			<?php include('application/views/right.tpl.php'); ?>
		</div>
	</div>
</section>

<!-- END MAIN-SECTION- -->
<section class="main-section">
	<?php include('application/views/bottom.tpl.php'); ?>
</section>

<?php include("application/views/footer.php"); ?>