<?php
include("header.php");
?>
	<table width = "100%" height = "100%" cellpadding = "0" cellspacing = "0">
		<tr>
			<td width = "200px" valign = "top"><?php include("menu.php"); ?></td>
			<td width = "20px"></td>
			<td valign = "top">
				<div class = "title_border">
					<div class = "content_title"><h1><?= $title ?></h1></div>
					<div class = "back_and_exit">
						русский <a href = "/en<?= $_SERVER['REQUEST_URI'] ?>">english</a>

						<span class = "back_to_site"><a href = "/" target = "_blank" title = "Открыть сайт в новом окне">Вернуться на сайт ></a></span>
						<span class = "exit"><a href = "/admin/login/logoff/">Выйти</a></span>
					</div>
				</div>

				<div class = "content">
					<div class = "top_menu">
						<div class = "top_menu_link"><a href = "/admin/pages/">Страницы</a></div>
						<div class = "top_menu_link"><a href = "/admin/pages/add/">Добавить страницу</a></div>
					</div>

					<table width = "100%" cellpadding = "1" cellspacing = "1">
						<tr bgcolor = "#EEEEEE">

							<th>ID</th>
							<th>Дата</th>
							<th>Статус</th>
							<th>Заказчик</th>
							<th>Сумма</th>
							<th>Товары</th>
							<th>Адрес</th>
							<th>Оплата</th>
							<th>Доставка</th>
							<th>Действия</th>

						</tr>
						<?php
						$count = count($pages);
						for ($i = 0; $i < $count; $i++) {
							$page = $pages[$i];
							$user = $this->users->getUserById($page['user_id']);
							?>
							<tr class = "list">
								<td><a href = "/admin/orders/edit/<?= $page['id'] ?>/"><?= $page['id'] ?><a/></td>
								<td><?= $page['date'] ?> <?= $page['time'] ?></td>
								<td><?= $page['status'] ?></td>
								<td><a href = "/admin/users/edit/<?= $page['user_id'] ?>/"><?= $user['name'] ?></a></td>
								<td align = "center"><?= $page['summa'] ?></td>
								<td>
									<table class = "products" border = "1">
										<th>Товар</th>
										<th>Кол-во</th>
										<?php
										$my_cart = unserialize($page['products']);
										$pcount = count($my_cart);
										for ($j = 0; $j < $pcount; $j++) {
											$mc = $my_cart[$j];
											$product = $this->model_products->getProductById($mc['product_id']);
											$product['name'] = getLangText($product['name']);
											$cat = $this->categories->getCategoryById($product['category_id']);
											$parent = false;
											if ($product['parent_category_id'] != 0)
												$parent = $this->categories->getCategoryById($product['parent_category_id']);

											?>
											<tr>
												<td>
													<a href = "<?= getFullUrl($product) ?>" target = "_blank"><?= $product['name'] ?></a>
												</td>
												<td align = "center">
													<strong>Всего: <?= $mc['kolvo'] ?></strong>
												</td>
											</tr>
										<?php
										}
										?>
									</table>
								</td>
								<td><?= $page['adress'] ?></td>
								<td><?= $page['payment'] ?></td>
								<td><?= $page['delivery'] ?></td>

								<td>
									<!--a href="/admin/pages/active/<?= $page['id'] ?>/"><?php
									if ($page['active'] == 1)
										echo '<img src="/img/visible.png" width="16px" height="16px" border="0" title="Деактивация" />';
									else
										echo '<img src="/img/not-visible.png" width="16px" height="16px" border="0" title="Активация" />';
									?></a-->
									<a href = "/admin/orders/edit/<?= $page['id'] ?>/"><img src = "/img/edit.png" width = "16px" height = "16px" border = "0" title = "Редактировать"/></a>
									<a onclick = "return confirm('Удалить?')" href = "/admin/orders/del/<?= $page['id'] ?>/"><img src = "/img/del.png" border = "0" alt = "Удалить" title = "Удалить"/></a>
								</td>
							</tr>
						<?php
						}
						?>
					</table>
				</div>
			</td>
		</tr>
	</table>
<?php
include("footer.php");
?>