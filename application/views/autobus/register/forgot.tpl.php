<?php include("application/views/head.php"); ?>
<?php include("application/views/header.php"); ?>
<?php $this->lang->load('account', $current_lang); ?>
	<article>
		<div class="container-full row">
			<?php include("application/views/mod/sidebar_left.mod.php");?>
			<div class="col-md-10 row news">
				<h1 class = "long"><?= $this->lang->line('account_forgot_title') ?></h1>

				<?php if (isset($err) && !empty($err))
					foreach ($err as $er) {
						echo $er . '<br />';
					}
				?>

				<p><?= $this->lang->line('account_forgot_desc') ?></p>

				<form action = "<?= $_SERVER['REQUEST_URI'] ?>" method = "post">
					<table border = "0" cellpadding = "1" cellspacing = "1" class="forgot-pass">
						<tr>

						<td colspan="2">
							<input required type = "email" name = "email" value = "<?php if (isset($_POST['email']))
							echo $_POST['email']; ?>" placeholder="<?= $this->lang->line('account_forgot_form_email') ?>"/>
							<?php
						if (isset($err['email']) && $err['email'] != '') {
							?>
								<div class = "error"><?= $err['email'] ?></div>
							<?php
						}
						?>
						</td>
					</tr>

						<tr>
							<td colspan="2">
								<?= $cap['image'] ?>

							</td>
						</tr>
						<tr>
							<td colspan="2">
								<input required type = "text" name = "captcha" value = "" placeholder="<?= $this->lang->line('account_forgot_form_captcha') ?>"/>
								<?php
								if (isset($err['captcha']) && $err['captcha'] != '') {
									?>
									<div class = "error"><?= $err['captcha'] ?></div>
								<?php
								}
								?>
							</td>
						</tr>
						<tr>
							<td colspan = "2" align = "center">
								<input type = "submit" class="buy-btn	" value = "<?= $this->lang->line('account_forgot_form_submit') ?>"/>
							</td>
						</tr>
					</table>
				</form>
				<!--p class = "warning"><?= $this->lang->line('account_forgot_form_warning') ?></p-->
			</div>
		</div>
		<div class="container-full row delivery">
			<?=include("application/views/mod/pre_footer.mod.php");?>
		</div>
	</article>

<?php include("application/views/footer.php"); ?>