<?php
include("application/views/head.php");
include("application/views/header.php");
$this->lang->load('shop', $current_lang);
?>
	<article>
		<div class = "container-full row">
			<?php include("application/views/mod/sidebar_left.mod.php"); ?>
			<div class = "col-md-10 row contact ">
				<h2><?= $this->lang->line('shop_sended_title_order_success') ?></h2>
				<?= $this->lang->line('shop_sended_desc') ?>
			</div>
		</div>
		<div class = "container-full row delivery">
			<?php include_once("application/views/mod/pre_footer.mod.php"); ?>
		</div>
	</article>
<?php include("application/views/footer.php"); ?>