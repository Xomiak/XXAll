<?php
$this->lang->load('shop', $current_lang);
/*
$full_price = 0;
$my_orders = array();
if (isset($sort) && !empty($sort) && $sort !== 'all') {
    if ($sort === 'incart') {
        for($i = 0; $i < count($my_cart_and_orders); $i++){
        	if(!isset($my_cart_and_orders[$i]['status'])) {
        	   $my_orders[] = $my_cart_and_orders[$i];
        	}
        }        
    } else {
        for($i = 0; $i < count($my_cart_and_orders); $i++){
        	if(isset($my_cart_and_orders[$i]['status']) && $my_cart_and_orders[$i]['status'] == $sort) {
        	   $my_orders[] = $my_cart_and_orders[$i];
        	}
        }
    }    
} else */
$my_orders = $my_cart_and_orders;

?>

<!--script type="text/javascript">
var j = jQuery.noConflict();
j(document).ready(function() {
    j('select[name=sort]').on('change', function() {
        j('#form_sort').submit();
    });
});
</script-->
<h2><?= $this->lang->line('mypage_my_cart_table_title') . '&nbsp;' . $user['name'] ?></h2>
<div class = "col-md-12 cabinet-table-iteams">
	<?php
	if (!isset($my_orders) || empty($my_orders)) {
		?>
		<center><?= $this->lang->line('mypage_my_cart_table_empty') ?></center>
	<?php
	} else {
		for ($i = 0; $i < count($my_orders); $i++, $full_price = 0) {
			$order = $my_orders[$i];
			?>
			<table width = "100%">
				<tr>
					<td class = "cabinet-zakaz-header center" colspan = "5">Заказ <?= $this->lang->line('mypage_my_cart_table_order_id') . ' №' . $order['id'] ?>
						<span class = "done"><?php
							if (isset($order['status'])) {
								switch ($order['status']) {
									case 'new':
										echo '<span class="order-processed">' . $this->lang->line('mypage_my_cart_table_status_new') . '</span>';
										break;
									case 'payed':
										echo '<span class="order-payed">' . $this->lang->line('mypage_my_cart_table_status_payed') . '</span>';
										break;
									case 'sended':
										echo '<span class="order-sended">' . $this->lang->line('mypage_my_cart_table_status_sended') . '</span>';
										break;
									case 'done':
										echo '<span class="order-ready">' . $this->lang->line('mypage_my_cart_table_status_done') . '</span>';
										break;
									default:
										echo 'err';
										break;
								}
							} else
								echo $this->lang->line('mypage_my_cart_table_status_incart');
							?></span></td>
				</tr>
				<tr class = "cabinet-col-desc center weight">
					<td width = "20%"><?= $this->lang->line('mypage_my_cart_table_th_1') ?></td>
					<td width = "32%"><?= $this->lang->line('mypage_my_cart_table_th_2') ?></td>
					<td width = "8%"><?= $this->lang->line('mypage_my_cart_table_th_3') ?></td>
					<td width = "20%"><?= $this->lang->line('mypage_my_cart_table_th_4') ?></td>
					<td width = "20%"><?= $this->lang->line('mypage_my_cart_table_th_5') ?></td>
				</tr>
				<?php
				$p = 0;
				$full_price = 0;
				$prod_count = 0;
				$order['products'] = unserialize($order['products']);
				for (; $p < count($order['products']); $p++) {
					$prod = $this->model_products->getProductById($order['products'][$p]['product_id']);
					$prod_url = getFullUrl($prod);
					if ($prod) {
						?>

						<tr class = "cabinet-col-desc center">
							<td width = "20%"><a href = "<?= $prod_url ?>">
									<img src = "<?= CreateThumb2(76, 82, (isset($prod['image']) && !empty($prod['image'])) ? $prod['image'] : '/img/net_foto.png', 'cart'); ?>"/>
								</a></td>
							<td width = "32%"><a href = "<?= $prod_url ?>">
									<?= getLangText($prod['name']) ?>
								</a></td>
							<td width = "8%"><?= $order['products'][$p]['kolvo'] ?> </td>
							<td width = "20%" class = "cost"><?= get_price($prod['price']) ?>
								<span class = "currency"><?= $currency['view'] ?></span></td>
							<td width = "20%" class = "cost" id = "summ_<?= $order['products'][$p]['product_id'] ?>"><?php
								$product_full_price = get_price($prod['price']) * $order['products'][$p]['kolvo'];
								echo $product_full_price . '&nbsp;';
								$full_price += $product_full_price;
								?><span class = "currency"><?= $currency['view'] ?></span></td>
						</tr>
						<tr class = "cabinet-col-desc">
							<td class = "order-date" colspan = "2"><?= $this->lang->line('mypage_my_cart_table_date') . ' ' . $order['date'] ?></td>
							<td></td>
							<td class = "sum-total" colspan = "2"><?php printf($this->lang->line('mypage_my_cart_table_total'), $prod_count += $order['products'][$p]['kolvo'], $full_price, $currency['view']); ?></td>

						</tr>

					<?php
					}
				}?>
			</table>
		<?php
		}
	}
	?>
</div>