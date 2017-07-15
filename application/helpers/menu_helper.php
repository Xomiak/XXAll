<?php  if (!defined('BASEPATH'))
	exit('No direct script access allowed');

function showSlider($name, $noJs = false)
{
	//echo file_get_contents('https://'.$_SERVER['SERVER_NAME'].'/slider.php?name='.$name);
	?>
<!--	<iframe src="https://--><?//=$_SERVER['SERVER_NAME']?><!--/slider.php?name=--><?//=$name?><!--" width="100%" height="443px" border="0" style="border: 0px; overflow: hidden"></iframe>-->
	<div class="revslider" data-alias="<?=$name?>"></div>
	<?php if(!$noJs) { ?>
<!--	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>-->

<?php } ?>
	<?php
}
//function showSlider($class = "bxslider")
//{
//	echo getSlider($class);
//}
//function getSlider($class = "bxslider")
//{
//	$CI = & get_instance();
//
//	$data = "";
//
//	$CI->db->where('active', 1);
//	$CI->db->where('position', 'slider');
//	$CI->db->order_by('num','desc');
//	$slider = $CI->db->get('banners')->result_array();
//
//	if($slider)
//	{
//		$data = '<ul class="'.$class.'">';
//		$count = count($slider);
//		for($i = 0; $i < $count; $i++)
//		{
//			$s = $slider[$i];
//			if($s['url'] != '') $data .= '<a href="'.$s['url'].'">';
//			$data .= '<li><img src="'.$s['image'].'" alt="'.$s['name'].'" /></li>';
//			if($s['url'] != '') $data .= '</a>';
//		}
//		$data .= '</ul>';
//	}
//
//	return $data;
//}

function getMenu($type){
	$CI = & get_instance();

	$CI->db->where('position', $type);
	$CI->db->where('parent_id', '0');
	$CI->db->where('active', '1');
	$CI->db->order_by('num', 'ASK');
	$result = $CI->db->get('menus')->result_array();
	//var_dump($result);
	return $result;
}

function showTopMenu($config = false)
{
	$topMenu = new MenuTree('top', $config);
	echo $topMenu->createTree(0, 0, false, '', false);
}

function mobileMenu()
{

	$config = array(
		'rootOpenTag' => '<ul class = "dropdown-menu" role = "menu">',
		'rootCloseTag' => '</ul>',
		'childOpenTag' => '<ul class="drop_down">',
		'childCloseTag' => '</ul>',

		'rootItemOpenTag' => '<li class="rootItem">',
		'rootItemTitleOpenTag' => '',
		'rootItemTitleCloseTag' => '',
		'rootItemCloseTag' => '</li>',

		'itemOpenTag' => '<li class="item" >',
		'itemTitleOpenTag' => '',
		'itemTitleCloseTag' => '',
		'itemCloseTag' => '</li>'
	);
	$topMenu = new MenuTree('bottom', $config);
	echo $topMenu->createTree(0, 0, 0);
}

function showBottomMenu()
{
	$topMenu = new MenuTree('bottom');
	echo $topMenu->createTree(0, 0, 0);
}


function showLeftMenu()
{
	$CI = & get_instance();

	$CI->db->where('type', 'left');
	$CI->db->where('parent_id', '0');
	$CI->db->where('active', '1');
	$CI->db->order_by('num', 'ASK');
	$elem = $CI->db->get('menus')->result_array();
	if ($elem) {
		$count = count($elem);
		echo '<div class = "cont_category">';
		for ($i = 0; $i < $count; $i++) {
			$m = $elem[$i];
			$url = $m['url'];
			echo '<h3>' . getLangText($m['name']) . '</h3>';

			$CI->db->where('parent_id', $m['id']);
			$CI->db->where('type', 'left');
			$CI->db->where('active', '1');
			$CI->db->order_by('num', 'ASK');
			$submenu = $CI->db->get('menus')->result_array();
			if ($submenu) {
				$count2 = count($submenu);
				for ($i2 = 0; $i2 < $count2; $i2++) {
					$m2 = $submenu[$i2];
					$url2 = $m2['url'];
					// 3 LEVEL
					$CI->db->where('parent_id', $m2['id']);
					$CI->db->where('type', 'left');
					$CI->db->where('active', '1');
					$CI->db->order_by('num', 'ASK');
					$submenu2 = $CI->db->get('menus')->result_array();
					if ($submenu2) {
						?>
						<h5 class = "acord_category"><?= getLangText($m2['name']) ?></h5>
						<ul class = "row_category">
							<?php
							$count3 = count($submenu2);
							for ($i3 = 0; $i3 < $count3; $i3++) {
								$m3 = $submenu2[$i3];
								$url3 = $m3['url'];
								?>
								<li>
									<?php
									if ($m3['params'] == 'no_click') {
										echo '<span class ="" >' . getLangText($m3['name']) . '</span>';
									} else {
										?>
										<a href = "http://<?= $_SERVER['SERVER_NAME'] ?><?= getUrl($url3) ?>"><?= getLangText($m3['name']) ?></a>
									<?php
									} ?>
								</li>
							<?php
							}
							?>
						</ul>
					<?php
					} else {
						echo '<h5><a href = "http://' . $_SERVER['SERVER_NAME'] . getUrl($url2) . '">' . getLangText($m2['name']) . '</a></h5>';
					}
				}
			}
		}
		echo '</div>';
	}
}

function showGalleryLeftMenu()
{
	$CI = & get_instance();

	$CI->db->where('active', '1');
	$CI->db->where('parent_id', '0');
	$CI->db->order_by('num', 'ASK');
	$elem = $CI->db->get('gallery_categories')->result_array();
	if ($elem) {
		//	echo '<div class="left_menu">';
		$count = count($elem);
		for ($i = 0; $i < $count; $i++) {
			echo '<p class="left_menu"><a id="left_menu';
			if ($_SERVER['REQUEST_URI'] == '/gallery/' . $elem[$i]['url'] . '/')
				echo '_current';
			echo '" href="http://' . $_SERVER['SERVER_NAME'] . '/gallery/' . $elem[$i]['url'] . '/" title="' . $elem[$i]['name'] . '">' . $elem[$i]['name'] . '</a></p>';
			$parent = $elem[$i]['url'];

			$CI->db->where('active', '1');
			$CI->db->where('parent_id', $elem[$i]['id']);
			$CI->db->order_by('num', 'ASK');
			$child = $CI->db->get('gallery_categories')->result_array();
			if ($child) {
				$ccount = count($child);
				for ($j = 0; $j < $ccount; $j++) {
					$ch = $child[$j];
					$uri = '/gallery/' . $parent . '/' . $ch['url'] . '/';
					echo '<p class="left_menu"><span style="color: #496A97; margin: 0 12px;">•</span><a id="left_menu';
					if ($_SERVER['REQUEST_URI'] == $uri)
						echo '_current';
					echo '" href="http://' . $_SERVER['SERVER_NAME'] . '/gallery/' . $parent . '/' . $ch['url'] . '/" title="' . $ch['name'] . '">' . $ch['name'] . '</a></p>';
				}
			}
		}
		//	echo '</div>';
	}
}

//function getBanners($position){
//    $model = getModel('banners');
//    return $model->getBanners($position);
//}

function getBanners($position)
{
    $CI = & get_instance();

    $CI->db->where('active', '1');
    $CI->db->where('position', $position);
    return $CI->db->get('banners')->result_array();
}

function showBanners($position)
{
	$CI = & get_instance();

	$CI->db->where('active', '1');
	$CI->db->where('position', $position);
	$banners = $CI->db->get('banners')->result_array();
	if ($banners) {

		$maxFrequency = 0;
		$border = 0;
		$count = count($banners);
		for ($i = 0; $i < $count; $i++) {
			$maxFrequency += intval($banners[$i]['frequency']);
			$banners[$i]['l_border'] = $border;
			$banners[$i]['r_border'] = $maxFrequency;
			$border = $maxFrequency;
		}
		$rand = rand(0, $maxFrequency);

		for ($i = 0; $i < $count; $i++) {
			if ($rand >= $banners[$i]['l_border'] && $rand <= $banners[$i]['r_border']) {
				echo '<div class="banner';
				if ($position == 'bottom')
					echo '-bottom';
				echo '">';
				$b = $banners[$i];
				if ($b['url'] != '')
					echo '<a href="/banner/' . $b['id'] . '/">';
				$b['content'] = str_replace('<p>', '', $b['content']);
				$b['content'] = str_replace('</p>', '', $b['content']);
				echo '<img src="' . $b['image'] . '" />';
				if ($b['url'] != '')
					echo '</a>';
				echo '</div>';
			}
		}
	}
}

function userMenu()
{
	$CI = & get_instance();

	if ($CI->session->userdata('login') != null && $CI->session->userdata('pass') != null && $CI->session->userdata('type') != null) {
		$login = $CI->session->userdata('login');
		$pass = $CI->session->userdata('pass');
		$type = $CI->session->userdata('type');
		$CI->db->where('login', $login);
		$CI->db->limit(1);
		$user = $CI->db->get('users')->result_array();
		if ($user) {
			$user = $user[0];
			?>
			<div class = "user_menu">
				Добро пожаловать,&nbsp;
				<strong>
					<a rel = "nofollow" href = "/user/mypage/">
						<?= $user['login'] ?>
					</a>!
				</strong>
				<table border = "0" cellpadding = "2" cellspacing = "2">
					<tr>
						<td>
							<a rel = "nofollow" href = "/user/mypage/">
								<?php
								if ($user['avatar'] != '') {
									?>

									<img src = "<?= $user['avatar'] ?>" height = "75px" border = "0" alt = "Персональная страница пользователя <?= $user['login'] ?>" title = "Персональная страница пользователя <?= $user['login'] ?>"/>
								<?php
								} else {
									?>

									<img src = "/img/no_ava.png" height = "75px" border = "0" alt = "Персональная страница пользователя <?= $user['login'] ?>" title = "Персональная страница пользователя <?= $user['login'] ?>"/>
								<?php
								}
								?>
							</a>
						</td>
						<td>
							<?php
							$new_msg_count = 0;
							$myarticles_count = 0;
							$CI->db->where('login', $user['login']);
							$CI->db->where('active', 1);
							$articles = $CI->db->get('articles')->result_array();
							if ($articles)
								$myarticles_count = count($articles);

							if ($user['type'] == 'admin')
								echo '<a rel="nofollow" href="/admin/">Админка</a><br />';
							?>
							<a rel = "nofollow" href = "/user/mypage/">Моя страница</a>
							<br/>
							<a rel = "nofollow" href = "/add/article/">Добавить статью</a>
							<br/>
							<a rel = "nofollow" href = "/user/mypage/#articles">Мои статьи [<strong><?= $myarticles_count ?></strong>]</a>
							<br/>
							<a rel = "nofollow" href = "/login/logout/">Выход</a>
						</td>
					</tr>
				</table>
			</div>
		<?php
		}
	} else {
		?>
		<strong>Авторизация</strong>
		<?php
		if ($CI->session->userdata('login_err') != null) {
			?>
			<div class = "login_err">
				<?= $CI->session->userdata('login_err') ?>
			</div>
			<?php
			$CI->session->unset_userdata('login_err');
		}
		?>
		<form method = "post" action = "/login/">
			<input type = "text" name = "login" onblur = "if (this.value == '') {this.value = 'Логин'; this.style.color=''}" onfocus = "if (this.value == 'Логин') {this.value = ''; this.style.color='#000'}" value = "Логин"/>
			<br/>
			<input type = "password" name = "pass" onblur = "if (this.value == '') {this.value = 'Пароль'; this.style.color=''}" onfocus = "if (this.value == 'Пароль') {this.value = ''; this.style.color='#000'}" value = "Пароль"/>
			<br/>
			<a rel = "nofollow" href = "/register/">Регистрация</a>
			<br/>
			<a rel = "nofollow" href = "/register/forgot/">Забыли пароль?</a>
			<br/>
			<input type = "submit" value = "Вход"/>

		</form>
	<?php
	}
}


