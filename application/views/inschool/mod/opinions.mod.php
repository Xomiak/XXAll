<?php
$this->lang->load('mod', $current_lang);
echo '<h2>' . $this->lang->line('mod_opinions_title') . '</h2>';
if (!isset($article['id']))
	echo '<p>' . $this->lang->line('mod_opinions_no_article_id') . '</p>';
else {
	//	if (userdata('msg'))
	//		echo '<p>' . userdata('msg') . '</p>';
	if (userdata('login')) {
		$this->load->model('Model_users', 'users');
		$user = $this->users->getUserByLogin(userdata('login'));
		if ($user) {
			$cap = createCaptcha();
			?>
			<div class = "rewies-form">
				<form action = "/opinions/add/" method = "post">
					<input type = "hidden" name = "user_id" value = "<?= $user['id'] ?>"/>
					<input type = "hidden" name = "article_id" value = "<?= $article['id'] ?>"/>
					<input type = "hidden" name = "back" value = "<?= $_SERVER['REQUEST_URI'] ?>"/>
					<input name = "name" type = "text" placeholder = "<?= $user['name'] ?>" disabled/>
					<br/>
					<textarea name = "opinion" placeholder = "<?= $this->lang->line('mod_opinions_form_opinion') ?>" required></textarea>
					<br/>
					<?= $cap['image'] ?><br/>
					<input type = "text" name = "captcha" placeholder = "<?= $this->lang->line('mod_opinions_form_captcha') ?>"/>
					<br/>
					<input class = "buy-btn" type = "submit" value = "<?= $this->lang->line('mod_opinions_butt_submit') ?>"/>
				</form>
			</div>
		<?php
		} else
			echo '<a rel = "nofollow" href = "/login/">' . $this->lang->line('mod_opinions_login_reg') . '</a><br/>';
	} else
		echo '<a rel = "nofollow" href = "/login/">' . $this->lang->line('mod_opinions_login_reg') . '</a><br/>';
	$opinions = $this->inter->getOpinions($article['id'], 3, 0, 'desc', 1);
	if ($opinions)
		for ($o = 0; $o < count($opinions); $o++) {
			echo '<div class="one-rewies">';
			echo '<h4>' . $opinions[$o]['user_name'] . '</h4>';
			echo '<p>' . $opinions[$o]['opinion'] . '</p>';
			echo '</div>';
		}
	else
		echo '<p>' . $this->lang->line('mod_opinions_no_opinions') . '</p>';
}
?>
