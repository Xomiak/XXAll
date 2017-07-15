<div class = "col-md-2 left-menu">
	<?php
	$this->lang->load('mod', $current_lang);
	$lastProd = $this->model_products->getLastProducts(2, 0);
	showLeftMenu();
	if ($lastProd) {
		echo '<h2>' . $this->lang->line('mod_sidebar_new') . '</h2>';
		for ($i = 0; $i < count($lastProd); $i++) {
			echo '<div class = "iteam">';
			if ($lastProd[$i]['image'])
				echo '<a href = "' . getFullUrl($lastProd[$i]) . '"><img src = "' . CreateThumb(150, 200, $lastProd[$i]['image'], 'last_prod') . '" alt = "' . getLangText($lastProd[$i]['name']) . '"></a>';
			echo '<h4><a href = "' . getFullUrl($lastProd[$i]) . '">' . getLangText($lastProd[$i]['name']) . '</a></h4>';
			if ($lastProd[$i]['old_price'])
				echo '<p class = "old-price">' . get_price($lastProd[$i]['old_price']) . ' ' . $currency['view'] . '</p>';
			echo '<p class = "price">' . get_price($lastProd[$i]['price']) . ' ' . $currency['view'] . '</p>';
			echo '<a class = "buy-btn" href = "' . getFullUrl($lastProd[$i]) . '">' . $this->lang->line('mod_sidebar_buy') . '</a>';
			echo '</div>';

		}
	}
	?>
	<script type = "text/javascript">
		$(document).ready(function () {

			/*$(".cont_category h3").eq(2).addClass("active_link_category");
			 $(".cont_category .row_category").eq(2).show();
			 */
			$(".row_category").hide();
			$(".cont_category .acord_category").click(function () {
				$(this).next(".row_category").slideToggle("row_category")
					.siblings(".row_category:visible").slideUp("slow");
				$(this).toggleClass("active_link_category");
				$(this).siblings(".acord_category").removeClass("active_link_category");
			});
		});
	</script>
</div>

