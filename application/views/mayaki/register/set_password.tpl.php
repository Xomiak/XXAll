<?php include("application/views/head.php"); ?>
<?php include("application/views/header.php"); ?>
<?php $this->lang->load('account', $current_lang); ?>
	<div class = "content">
		<div class = "catalog">
			<div class = "page_tpl_wrap contact_wrap" style="min-height:500px;">
				<div>
					<h1 class = "long"><?= $this->lang->line('account_set_pass_title') ?></h1>
				</div>

				<?php
				if(isset($err['err']) && $err['err'] != '')
				{
					?>
					<div class="error"><?=$err['err']?></div>
				<?php
				}
				?>

				<form action="<?=$_SERVER['REQUEST_URI']?>" method="post">
					<table border="0" cellpadding="1" cellspacing="1">
						<tr>
							<td align="right" valign="top">
								<?= $this->lang->line('account_form_password') ?> *:
							</td>
							<td>
								<input required type="password" name="pass" size="50" />
							</td>
						</tr>
						<tr>
							<td align="right" valign="top">
								<?= $this->lang->line('account_form_password2') ?> *:
							</td>
							<td>
								<input required type="password" name="pass2" size="50" />
							</td>
						</tr>

						<tr>
							<td colspan="2" align="center">
								<input type="submit" value="<?= $this->lang->line('account_set_pass_butt_submit') ?>" />
							</td>
						</tr>
					</table>
				</form>
				<p class="warning"><?= $this->lang->line('account_set_pass_warning') ?></p>
			</div>

		</div>
	</div>
<?php include("application/views/footer.php"); ?>