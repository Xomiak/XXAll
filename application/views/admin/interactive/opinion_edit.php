<?php
include("application/views/admin/header.php");
?>
	<table width = "100%" height = "100%" cellpadding = "0" cellspacing = "0">
		<tr>
			<td width = "200px" valign = "top"><?php include("application/views/admin/menu.php"); ?></td>
			<td width = "20px"></td>
			<td valign = "top">
				<div class = "title_border">
					<div class = "content_title"><h1><?= $title ?></h1></div>
					<div class = "back_and_exit">
						русский <a href = "/en<?= $_SERVER['REQUEST_URI'] ?>">english</a>

						<span class = "back_to_site"><a href = "/" target = "_blank" title = "Открыть сайт в новом окне">Вернуться на сайт ></a></span>
						<span class = "exit"><a href = "/admin/login/logoff/">Выйти</a></span>
					</div>
				</div>

				<div class = "content">
					<div class = "top_menu">
						<div class = "top_menu_link"><a href = "/admin/interactive/questions/">Вопросы</a></div>
					</div>

					<form enctype = "multipart/form-data" action = "<?= $_SERVER['REQUEST_URI'] ?>" method = "post">
						<table>
							<tr>
								<td>Имя:</td>
								<td>
									<input required type = "text" name = "name" size = "50" value = "<?= $opinion['user_name'] ?>"/>
								</td>
							</tr>
							<tr>
								<td>Email:</td>
								<td>
									<input required type = "text" name = "email" size = "50" value = "<?= $opinion['user_email'] ?>"/>
								</td>
							</tr>
							<tr>
								<td>Отзыв:</td>
								<td>
									<textarea class = "ckeditor" name = "opinion">
										<?= $opinion['opinion'] ?>
									</textarea>
								</td>
							</tr>
							<tr>
								<td colspan = "2">
									<input type = "checkbox" name = "active"<?= ($opinion['active'] == 1) ? ' checked' : '' ?> /> Активный
								</td>
							</tr>

							<tr>
								<td colspan = "2"><input type = "submit" value = "Сохранить"/></td>
							</tr>
						</table>
					</form>
				</div>
			</td>
		</tr>
	</table>
<?php
include("application/views/admin/footer.php");
?>