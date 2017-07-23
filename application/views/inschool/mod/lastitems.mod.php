<?php
$this->lang->load('mod', $current_lang);
echo '<h2>' . $this->lang->line('mod_recommended') . '</h2>';
	$this->db->where('recommended', '1');
	$this->db->limit(6);
	$this->db->order_by('id', 'DESC');
	$recommended = $this->db->get('products')->result_array();
	for ($lp = 0; $lp < count($recommended); $lp++) {
		$a = $recommended[$lp];
		?>
		<div class = "col-md-2 last-iteam">
		<div class = "iteam">
			<a href = "<?= getFullUrl($a) ?>"><img src = "<?= CreateThumb(150, 200, $a['image'], 'catalog') ?>"/></a>
			<h4><a href = "<?= getFullUrl($a) ?>"><?= getLangText($a['name']) ?></a></h4>
			<table class = "iteam-table" border = "0" width = "100%" align = "center">
				<tr>
					<td><?php
						if ($a['old_price']) {
							?>
							<p class = "old-price"><?= get_price($a['old_price']) . ' ' . $currency['view'] ?></p>
						<?php
						} else echo '<p class = "old-price"> </p>';
						?></td>
					</tr>
				<tr>
					<td><span class = "count-iteam"><?= get_price($a['price']) . ' ' . $currency['view'] ?></span>
					</td>
				</tr>
				<tr>
					<td><?= printCompare($a['id']) ?></td>
				</tr>
				<tr>
					<td>
						<a class = "buy-btn" href = "<?= getFullUrl($a) ?>"><?= $this->lang->line('catalog_one_butt_buy') ?></a>
					</td>
				</tr>
			</table>



			<!--img src = "<?= CreateThumb(150, 200, $a['image'], 'recommended') ?>" alt = "">
			<h4><a href = "<?= getFullUrl($a) ?>"><?= getLangText($a['name']) ?></a></h4>
			<?php
			if (!empty($a['old_price']))
				echo '<p class = "old-price">' . get_price($a['old_price']) . ' <span class="currency">' . $currency['view'] . '</p>';
			?>
			<p class = "price"><?= get_price($a['price']) . ' ' . $currency['view'] ?></p>
			<a class = "buy-btn" href = "#"><?= $this->lang->line('catalog_one_buy'); ?></a-->
		</div>
		</div>
	<?php
}
?>