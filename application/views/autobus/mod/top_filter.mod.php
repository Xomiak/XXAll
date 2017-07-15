<?php
$filters = $this->model_filters->getFiltersByCategoryId($category['id'], array('id', 'title', 'name', 'show_type', 'classes'), array('id', 'value'), -1, 1);
?>
<h2 class = "title">Фильтры</h2>
<form action = "<?= $_SERVER['REQUEST_URI'] ?>" method = "post">
	<?php
	if ($filters['size']) {
		$filterSize = $filters['size'];
		?>
		<div class = "filter-size pull-left">
			<h3><?= getLangText($filterSize['title']) ?>:</h3>
			<ul class = "no-indents">
				<?php
				for ($v = 0; $v < count($filterSize['values']); $v++)
					echo '<li><input name="filters[' . $filterSize['name'] . '][]" value="' . $filterSize['values'][$v]['id'] . '" type = "checkbox" ' . ((isset($_POST['filters'][$filterSize['name']]) && in_array($filterSize['values'][$v]['id'], $_POST['filters'][$filterSize['name']])) ? 'checked' : '') . '><label>' . getlangText($filterSize['values'][$v]['value']) . '</label></li>';
				?>
			</ul>
		</div>
	<?php
	}
	/*
	if ($filters['color']) {
		$filterColor = $filters['color'];
		?>
		<div class = "filter-color pull-left">
			<h3><?= getLangText($filterColor['title']) ?>:</h3>
			<table>
				<tr>
					<?php
					for ($v = 0; $v < count($filterColor['values']); $v++) {
						if (($v + 1) % 4 == 0)
							echo '</tr><tr>';
						echo '<td><input name="filters[' . $filterColor['name'] . '][]" value="' . $filterColor['values'][$v]['id'] . '" type = "checkbox"' . ((isset($_POST['filters'][$filterColor['name']]) && in_array($filterColor['values'][$v]['id'], $_POST['filters'][$filterColor['name']])) ? 'checked' : '') . '><label>' . getlangText($filterColor['values'][$v]['value']) . '</label></td>';
					}
					?>
				</tr>
			</table>
		</div>
	<?php
	}*/
	?>

	<div class = "filter-price pull-left">
		<h3>По цене:</h3>

		<div id = "buy_price"></div>

		<input id = "minCost" name = "filters[price][min_price]" type = "text" value = "<?= (isset($_POST['filters']['price']['min_price']) ? $_POST['filters']['price']['min_price'] : '0') ?>" class = "price-range"/> -
		<input id = "maxCost" name = "filters[price][max_price]" type = "text" value = "<?= (isset($_POST['filters']['price']['max_price']) ? $_POST['filters']['price']['max_price'] : '3000') ?>" class = "price-range"/>
		<input class = "btn btn-small" type = "submit" value = "OK">
	</div>
	<div class = "clear">
		<a rel = "nofollow" href = "?filters_reset" class = "btn-text"><?=$this->lang->line('mod_filter_reset')?></a>
	</div>
</form>