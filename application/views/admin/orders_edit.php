<?php
include("header.php");
?>
	<table width = "100%" cellpadding = "0" cellspacing = "0">
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
						<div class = "top_menu_link"><a href = "/admin/orders/">Заказы</a></div>
					</div>
					<strong><font color = "Red"><?= $err ?></font></strong>

					<form enctype = "multipart/form-data" action = "<?= $_SERVER['REQUEST_URI'] ?>" method = "post">
						<table>
							<tr>
								<td>ID:</td>
								<td>
									<input disabled type = "text" name = "id" size = "50" value = "<?= $order['id'] ?>"/>
								</td>
							</tr>
							<tr>
								<td>Дата:</td>
								<td>
									<input disabled type = "text" size = "50" value = "<?= $order['date'] ?> <?= $order['time'] ?>"/>
								</td>
							</tr>
							<tr>
								<td>Клиент:</td>
								<td>
									<a target = "_blank" href = "/admin/users/edit/<?= $order['user_id'] ?>/"><?= $user['name'] ?></a>
								</td>
							</tr>
							<tr>
								<td>Оплата:</td>
								<td><input disabled type = "text" size = "50" value = "<?= $order['payment'] ?>"/></td>
							</tr>
							<tr>
								<td>Доставка:</td>
								<td><input disabled type = "text" size = "50" value = "<?= $order['delivery'] ?>"/></td>
							</tr>
							<tr>
								<td>Статус:</td>
								<td>
									<SELECT name = "status">
										<option value = "new"<?php if ($order['status'] == 'new')
											echo ' selected'; ?>>new
										</option>
										<option value = "payed"<?php if ($order['status'] == 'payed')
											echo ' selected'; ?>>payed
										</option>
										<option value = "sended"<?php if ($order['status'] == 'sended')
											echo ' selected'; ?>>sended
										</option>
										<option value = "done"<?php if ($order['status'] == 'done')
											echo ' selected'; ?>>done
										</option>
									</SELECT>
								</td>
							</tr>
							<tr>
								<td>Заказ:</td>
								<td>
									<table class = "products" border = "1">
										<th>Товар</th>
										<th>Кол-во</th>
										<?php
										$my_cart = unserialize($order['products']);
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
													<a href = "/<?php if ($parent)
														echo $parent['url'] . '/'; ?><?= $cat['url'] ?>/<?= $product['url'] ?>/" target = "_blank"><?= $product['name'] ?></a><br />
													<?= ($mc['filters'])?filtersToString($mc['filters']) : '' ?>
												</td>
												<td align = "center">
													<?= $mc['kolvo'] ?>
												</td>
											</tr>
										<?php
										}
										?>
									</table>
								</td>
							</tr>
							<tr>
								<td>Адрес:</td>
								<td><textarea name = "adress"><?= $order['adress'] ?></textarea></td>
							</tr>
							<tr>
								<td>Комментарий:</td>
								<td><textarea name = "adress"><?= $order['comment'] ?></textarea></td>
							</tr>

							<?php
							if ($order['pay_answer'] != '') {
								?>
								<tr>
									<td>Ответ платёжной системы:</td>
									<td>
										<?php
										var_dump(unserialize($order['pay_answer']));
										?>
									</td>
								</tr>
							<?php
							}
							?>

							<tr>
								<td colspan = "2"><input type = "checkbox" name = "active"<? if ($order['active'] == 1)
										echo ' checked' ?> /> Активный
								</td>
							</tr>
							<tr>
								<td><input type = "submit" name = "save" value = "Сохранить"/></td>
								<td><input type = "submit" name = "save_and_stay" value = "Сохранить и остаться"/></td>
							</tr>
						</table>
					</form>
				</div>


			</td>
		</tr>
	</table>
<?php
include("footer.php");
?>