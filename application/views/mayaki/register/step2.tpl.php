<?php include("application/views/head.php"); ?>
<?php include("application/views/header.php"); ?>
<?php $this->lang->load('account', $current_lang); ?>
	<div id = "content" class = "container">
		<section id = "registration">
			<h2 class = "title-left"><?= $this->lang->line('account_page_title') ?></h2>
                <strong><?=$this->lang->line('account_step2_reg_success')?></strong>
                <?php
                if ($email_confirm == 1) {
                    ?>
                    <br />                                    
                    <?=$this->lang->line('account_step2_letter')?>
                    <?php
                }
                ?>
                <br /><br />
                <a href="/"><?=$this->lang->line('account_step2_back')?></a>
		</section>
		<section class = "seo-text clear">
			<?php include_once('application/views/mod/pre_footer.mod.php'); ?>
		</section>
	</div>
<?php include("application/views/footer.php"); ?>