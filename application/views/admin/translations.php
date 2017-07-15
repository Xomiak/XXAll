<?php
include("header.php");
?>
	<table width = "100%" height = "100%" cellpadding = "0" cellspacing = "0">
		<tr>
			<td width = "200px" valign = "top"><?php include("menu.php"); ?></td>
			<td width = "20px"></td>
			<td valign = "top">
				<div class = "title_border">
					<div class = "content_title"><h1><?= $title ?></h1></div>
					<div class = "back_and_exit">
						<span class = "back_to_site"><a href = "/" target = "_blank" title = "Открыть сайт в новом окне">Вернуться на сайт ></a></span>
						<span class = "exit"><a href = "/admin/login/logoff/">Выйти</a></span>
					</div>
				</div>

				<div class = "content">
					<div class = "top_menu">
					</div>
					<?php
					if ($langsFolders) {
						?>
						<div style = "width: 20%; color: green; float: left">
							<?php
							foreach ($langsFolders as $lang => $files) {
								echo $lang;
								foreach ($files as $filename)
									echo '</br>&nbsp;|-&nbsp;<a href="/admin/translations/' . $lang . '/' . $filename . '">' . $filename . '</a>';
								echo '</br></br>';
							}
							?>
						</div>
						<?php
						if (isset($translations)) {
							?>
							<div style = "width: 80%; color: red; float: right;">
								<?php
								?>
								<table style = "width: 100%">
									<tr>
										<th style = "width: 50%;">Ключ</th>
										<th style = "width: 50%;">Значение</th>
									</tr>
									<?php
									foreach ($translations as $key => $val) {
										?>
										<tr>
											<td>
												<input style = "width: 100%" name = "key" value = "<?= $key ?>" required/>
											</td>
											<td>
												<textarea style = "width: 100%" name = "value" required><?= htmlspecialchars($val) ?>
												</textarea>
											</td>
										</tr>
									<?php
									}
									?>
								</table>
							</div>
						<?php
						} ?>
					<?php
					} else
						echo 'пусто..';
					?>
					<div style = "clear: both"></div>
				</div>
			</td>
		</tr>
	</table>
<?php
include("footer.php");
?>