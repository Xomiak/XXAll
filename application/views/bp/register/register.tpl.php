<?php include("application/views/head.php"); ?>
<?php include("application/views/header.php"); ?>
<?php $this->lang->load('account', $current_lang); ?>
<article>
		
		<div class="container-full row">
			<?php include("application/views/mod/sidebar_left.mod.php");?>
			<div class="col-md-10 row contact">					
				<h1><?= $this->lang->line('account_page_title') ?></h1>
				<div class="col-md-12">
					<?php if (isset($err) && !empty($err))
						foreach ($err as $er) {
							echo $er . '<br />';
						}
					?>
					<form method = "post" action = "/register/">
						<ul class = "user-register">
							<li>
								<input name = "first_name" type = "text" value = "<?=(isset($_POST['first_name']))?$_POST['first_name']:''?>" required placeholder = "<?= $this->lang->line('account_form_first_name') ?>" class = "input-text-style">
							</li>
							<li>
								<input name = "email" type = "email" value = "<?=(isset($_POST['email']))?$_POST['email']:''?>" required placeholder = "<?= $this->lang->line('account_form_email') ?>" class = "input-text-style">
							</li>
							<li>
								<input name = "tel" type = "tel" value = "<?=(isset($_POST['tel']))?$_POST['tel']:''?>" placeholder = "<?= $this->lang->line('account_form_tel') ?>" class = "input-text-style">
							</li>
							<li>
								<input name = "pass" type = "password" value = "<?=(isset($_POST['password']))?$_POST['password']:''?>" required placeholder = "<?= $this->lang->line('account_form_password') ?>" class = "input-text-style">
							</li>
							<li>
								<textarea name = "adress" value = "<?=(isset($_POST['adress']))?$_POST['adress']:''?>" placeholder = "<?= $this->lang->line('account_form_address') ?>" class = "input-text-style"></textarea>
							</li>
							<li>
								<input type = "submit"  class = "buy-btn" value = "<?= $this->lang->line('account_form_butt_submit') ?>"/>
							</li>
						</ul>
					</form>	
				</div>				
			</div>
		</div>		
	</article>		
<?php include("application/views/footer.php"); ?>