<?php
$filter_max_price = getOption('filter_max_price');
$filter_step = getOption('filter_step');

$min_price = userdata('min_price');
$max_price = userdata('max_price');

if (!$min_price)
	$min_price = 0;
if (!$max_price)
	$max_price = $filter_max_price;
$this->lang->load('mod');
?>
<script>
	var j = jQuery.noConflict();
	j(function () {
		j('#price').change(function () {
			var val = j(this).val();
			j('#slider_price').slider("values", 0, val);
		});

		j('#price2').change(function () {
			var val2 = j(this).val();
			j('#slider_price').slider("values", 1, val2);
		});

		j("#slider_price").slider({
			range: true,
			//orientation: "vertical",
			min: 0,
			step:<?=$filter_step?>,
			max: <?=$filter_max_price?>,
			values: [ <?=$min_price?>, <?=$max_price?> ],
			slide: function (event, ui) {
				//j( "#amount" ).val( "j" + ui.values[ 0 ] + " - j" + ui.values[ 1 ] );
				j('#price').val(ui.values[0]);
				j('#price2').val(ui.values[1]);
			}
		});
		//j( "#amount" ).val( "j" + j( "#slider-range" ).slider( "values", 0 ) +
		//" - j" + j( "#slider-range" ).slider( "values", 1 ) );
		j('#price').val(j('#slider_price').slider("values", 0));
		j('#price2').val(j('#slider_price').slider("values", 1));
	});
</script>
<section id = "product-filter">
	<h2 class = "title"><?=$this->lang->line('mod_filters_title')?></h2>

	<div class = "filter-price pull-left">
		<h3><?=$this->lang->line('mod_filter_by_price')?></h3>

		<div id = "buy_price"></div>
		<form class = "diapazon" method = "post">
			<input name = "min_price" type = "text" value = "30" class = "price-range"> -
			<input name = "max_price" type = "text" value = "2200" class = "price-range">
			<input class = "btn btn-small" type = "submit" value = "OK">
		</form>
	</div>
</section>