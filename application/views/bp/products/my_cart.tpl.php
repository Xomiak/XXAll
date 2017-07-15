<?php
include("application/views/head.php");
include("application/views/header.php");
$this->lang->load('shop', $current_lang); ?>

	<script type = "text/javascript">
		$(document).ready(function () {
			$('.buy-btn.show_checkout').click(function () {
				$('#cart-order-info').show();
				$(this).hide();
			});

			$('#form_address').on('submit', function () {
				var valid = true;
				/*
				 if ($("input[name=delivery]:checked").length < 1) {
				 $('.msg_delivery').html('Выберите способ доставки');
				 valid = false;
				 } else {
				 $('.msg_delivery').empty();
				 }
				 */
				if ($("input[name=payment]:checked").length < 1) {
					$('.msg_payment').html('Выберите способ оплаты');
					alert('Выберите способ оплаты');
					valid = false;
				} else {
					$('.msg_payment').empty();
				}
				if ((typeof a !== "undefined") && !pass_valid) {
					valid = false;
				}
				//alert(valid);
				return valid;
			});
			$('#form_my_cart input').keypress(function (event) {
				if (event.which == '13') {
					event.preventDefault();
					$(this).blur();
				}
			});

			$('input, select', '#form_my_cart').change(function () {
				if ($(this).parents('.my_cart_product').length) {
					var prodIndx = $(this).parents('.my_cart_product').attr('data-prodIndex');
					var elemName = $(this).attr('name');
					var elemValue = $(this).val();
					if (elemName == 'kolvo' && elemValue == '0') {
						$(this).val(1);
						//$('tr[data-prodIndex="' + prodIndx + '"').find('.mycart_del').click();
						return;
					}
					$.post('/ajax/cart_save/',
						{
							index: prodIndx,
							name: elemName,
							value: elemValue
						}
					).done(
						function (data) {
							//alert(data);
							var resp = JSON.parse(data);
							if (resp.done) {
								if (typeof resp.prod_summ !== 'undefined') {
									$('tr[data-prodIndex="' + prodIndx + '"').find('.summ').text(resp.prod_summ);
									$('.price_result').text(resp.total);
									$('#cart_count').text(resp.my_cart_count);
								}
							} else {
								alert(resp.msg);
							}
						}
					);
				}
			});
		});
	</script>
	<article>
		<div class = "container-full row">
			<?php include("application/views/mod/sidebar_left.mod.php"); ?>
			<div class = "col-md-10 row contact">

				<?php
				if (empty($my_cart)) {
					echo '<div style="text-align:center;margin-top:30px;">' . sprintf($this->lang->line('shop_my_cart_empty'), '/katalog/') . '</div>';
				} else {
					$count = count($my_cart);
					$full_price = 0;
					?>
					<h2><i></i><?= $this->lang->line('shop_my_cart_title') ?></h2>
					<span><?= (userdata('msg')) ? userdata('msg') : '' ?></span>
					<!--TABLE-COUNT-ITEAMS-->
					<form id = "form_my_cart" method = "post" action = "/my_cart/">
						<table class = "basket-iteams">
							<tr class = "header-basket">
								<td width = "12%"><?= $this->lang->line('shop_my_cart_table_th1') ?></td>
								<td width = "40%" style = "text-align:left"><?= $this->lang->line('shop_my_cart_table_th2') ?></td>
								<td width = "12%"><?= $this->lang->line('shop_my_cart_table_th3') ?></td>
								<td width = "12%"><?= $this->lang->line('shop_my_cart_table_th4') ?></td>
								<td width = "12%"><?= $this->lang->line('shop_my_cart_table_th5') ?></td>
								<td width = "12%"><?= $this->lang->line('shop_my_cart_table_th6') ?></td>
							</tr>
							<?php
							for ($i = 0; $i < $count; $i++) {
								$mc = $my_cart[$i];
								$products = $this->products->getProductById($mc['product_id']);
								$products = parseFilters($products, true, true, -1, array('id', 'value'));
								$products['name'] = getLangText($products['name']);
								?>
								<tr class = "my_cart_product" data-prodIndex = "<?= $i ?>"> <!--DON`T DELETE ** class = "my_cart_product" data-prodIndex = "" -->
									<td><a href = "<?= getFullUrl($products) ?>">
											<img src = "<?= CreateThumb(76, 82, $products['image'], 'cart'); ?>"/>
										</a></td>
									<td class = "name-iteam"><a href = "<?= getFullUrl($products) ?>">
											<?= $products['name'] ?>
										</a></td>
									<td>
										<div class = "number">
											<span class = "plus"></span>
											<input data-oldVal = "" name = "kolvo" type = "num" value = "<?= $mc['kolvo'] ?>"/>
											<span class = "minus"></span>
										</div>


									</td>
									<td><?= get_price($products['price']) ?>&nbsp;<span class = "currency"><?= $currency["view"] ?></span>
									</td>
									<td class = "price summ"><?php
										$product_full_price = get_price($products['price']) * $mc['kolvo'];
										echo $product_full_price . '&nbsp;';
										$full_price += $product_full_price;
										?><span class = "currency"><?= $currency["view"] ?></span></td>
									<td>
										<a class = "mycart_del" href = "/my_cart/del_products/<?= $mc['hash'] ?>/" onclick = "return confirm('Вы действительно хотите удалить?');">
											<span class = "glyphicon glyphicon-remove delete-iteam" aria-hidden = "true"></span>
										</a>
									</td>
								</tr>


							<?php
							}
							?>
							<tr>
								<td colspan = "6" class = "sum-iteams"><?= $this->lang->line('shop_my_cart_table_total_cost') ?>
									<span class = "price_result"><?= $product_full_price ?></span>
									<span class = "currency"><?= $currency["view"] ?></span></td>
							</tr>
							<tr>
								<td colspan = "5">
									<a class = "back-buy" href = "/katalog/"><?= $this->lang->line('shop_my_cart_continue') ?></a>
								</td>
								<td colspan = "1">
									<a class = "buy-btn show_checkout "><?= $this->lang->line('shop_my_cart_checkout') ?></a>
								</td>
							</tr>
						</table>
					</form>
					<!--END table-->
					<script type = "text/javascript">
						$(document).ready(function () {
							$('.minus').click(function () {
								var $input = $(this).parent().find('input');
								var count = parseInt($input.val()) - 1;
								count = count < 1 ? 1 : count;
								$input.val(count);
								$input.change();
								return false;
							});
							$('.plus').click(function () {
								var $input = $(this).parent().find('input');
								$input.val(parseInt($input.val()) + 1);
								$input.change();
								return false;
							});
						});
					</script>
					<!--TABLE-CHECKOUT-->
					<div id = "cart-order-info" style = "display: none">
						<form id = "form_address" method = "post" action = "<?= $_SERVER['REQUEST_URI'] ?>">
							<input type = "hidden" name = "action" value = "order"/>
							<table class = "checkout" >
								<tr class = "header-basket">
									<td style="max-width: 300px; min-width: 150px;"><?= $this->lang->line('shop_my_cart_address_table_th1') ?></td>
									<td colspan = "2" width = "45%" style = "text-align:left"><?= $this->lang->line('shop_my_cart_address_table_th2') ?></td>
									<td width = "15%"><?= $this->lang->line('shop_my_cart_address_table_th3') ?></td>
									<td width = "15%"><?= $this->lang->line('shop_my_cart_address_table_th4') ?></td>
								</tr>
								<tr>
									<td style="max-width: 300px; min-width: 150px;">
										<input type = "text" name = "name" placeholder = "<?= $this->lang->line('shop_my_cart_address_form_name') ?>" value = "<?= ($user) ? $user['name'] : '' ?>" required/>
									</td>
									<td style="max-width: 300px; min-width: 150px;">
										<input type = "text" name = "city" placeholder = "<?= $this->lang->line('shop_my_cart_address_form_country') ?>" required/>
									</td>
									<td rowspan = "3"  style="max-width: 300px; min-width: 250px;">
										<textarea name = "comment" placeholder = "<?= $this->lang->line('shop_my_cart_address_form_comment') ?>"></textarea>
									</td>
									<!--td>
										<input type = "radio" name = "delivery" id = "cash2" checked value = "<?= $this->lang->line('shop_my_cart_address_form_delivery_cur') ?>"><label for = "cash2"><?= $this->lang->line('shop_my_cart_address_form_delivery_cur') ?>
									</td-->
									<td>
										<input type = "radio" checked name = "delivery" id = "cash1" value = "<?= $this->lang->line('shop_my_cart_address_form_delivery_nova_pochta') ?>"><label for = "cash1"><?= $this->lang->line('shop_my_cart_address_form_delivery_nova_pochta') ?></label>
									</td>
									<td>
										<input type = "radio" name = "payment" id = "cash" checked value = "<?= $this->lang->line('shop_my_cart_address_form_payment_cash') ?>"><label for = "cash"><?= $this->lang->line('shop_my_cart_address_form_payment_cash') ?></label>
									</td>
								</tr>
								<tr>
									<td>
										<input type = "text" name = "tel" placeholder = "<?= $this->lang->line('shop_my_cart_address_form_phone') ?>" required/>
									</td>
									<td>
										<input type = "text" name = "adress" placeholder = "<?= $this->lang->line('shop_my_cart_address_form_address') ?>" required/>
									</td>
									<td>

									</td>

								</tr>
								<tr>
									<td>
										<input type = "email" name = "email" placeholder = "<?= $this->lang->line('shop_my_cart_address_form_email') ?>">
									</td>
									<td>

									</td>
									<td></td>
									<td></td>
								</tr>
								<tr>
									<td colspan = "5" class = "sum-iteams" style = "padding:25 0;"><?= $this->lang->line('shop_my_cart_table_total_cost') ?>
										<span class = "price_result"><?= $full_price ?></span>
										<span class = "currency"><?= $currency["view"] ?></span></td>
								</tr>
								<tr>
									<td colspan = "4"></td>
									<td colspan = "1" style = "padding:0;">
										<input type = "submit" class = "buy-btn pull-right" value = "<?= $this->lang->line('shop_my_cart_send') ?>" data-animation = "fade"/>


									</td>
								</tr>
							</table>
							<!--END table-->
						</form>
					</div>
				<?php
				}
				?>
			</div>
		</div>

		<div class = "container-full row delivery">
			<?php include_once("application/views/mod/pre_footer.mod.php"); ?>
		</div>
	</article>
<?php include("application/views/footer.php"); ?>