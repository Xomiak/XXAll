<div class = "menu_border">
	<div class = "menu_title">Меню</div>
</div>
<div class = "menu">
	<?php
	$this->db->where('active', '1');
	$menuss = $this->db->get('admin_menu')->result_array();
	$count = count($menuss);
	for ($i = 0; $i < $count; $i++) {
		$menuuuu = $menuss[$i];
		?>
		<div class = "menu_category">
			<a href = "<?= $menuuuu['url'] ?>"><?= $menuuuu['name'] ?></a>
			<img src = "/img/admin/menu_<?php if ($_SERVER['REQUEST_URI'] != $menuuuu['url'])
				echo 'not_'; ?>active.png" width = "13px" height = "11px" alt = "<?= $menuuuu['name'] ?>" title = "<?= $menuuuu['name'] ?>"/>
		</div>
		<?php

		if ($_SERVER['REQUEST_URI'] == $menuuuu['url'] && $menuuuu['view'] != '') {
			if ($menuuuu['view'] == 'categories_articles') {
				$this->db->where('parent', '0');
				$this->db->where('type', 'articles');
				$mcats = $this->db->get('categories')->result_array();

				$menuTree = new AdminElementsTree('category');
				$config = array(
					'rootOpenTag' => '<ul class = "root">',
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
				$menuTree->setTreeTemplateConfig($config);
				echo $menuTree->createTreeForMainMenu($mcats, 0, '/admin/articles/category');
				/*$mcatscount = count($mcats);
				for ($j = 0; $j < $mcatscount; $j++) {
					$mcat = $mcats[$j];
					$mcat['name'] = getLangText($mcat['name']);
					?>
					<div class = "menu_subcategory">
						<a href = "/admin/articles/category/<?= $mcat['id'] ?>/"><?= $mcat['name'] ?></a>
						<img src = "/img/admin/menu_sub_<?php if ($_SERVER['REQUEST_URI'] != $menuuuu['url'])
							echo 'not_'; ?>active.png" width = "13px" height = "11px" alt = "<?= $mcat['name'] ?>" title = "<?= $mcat['name'] ?>"/>
					</div>
					<?php


					$this->db->where('parent', $mcat['id']);
					$msubcats = $this->db->get('categories')->result_array();
					if ($msubcats) {
						$msubcatscount = count($msubcats);
						for ($j2 = 0; $j2 < $msubcatscount; $j2++) {
							$msubcat = $msubcats[$j2];
							$msubcat['name'] = @unserialize($msubcat['name']);
							?>
							<div class = "menu_subsubcategory">
								<a href = "/admin/articles/category/<?= $msubcat['id'] ?>/"><?= $msubcat['name'] ?></a>
								<img src = "/img/admin/menu_sub_<?php if ($_SERVER['REQUEST_URI'] != $menuuuu['url'])
									echo 'not_'; ?>active.png" width = "13px" height = "11px" alt = "<?= $msubcat['name'] ?>" title = "<?= $msubcat['name'] ?>"/>
							</div>
						<?php
						}
					}
				}*/
			} elseif ($menuuuu['view'] == 'categories_shop') {
				$this->db->where('parent', '0');
				$this->db->where('type', 'shop');
				$mcats = $this->db->get('categories')->result_array();
				$menuTree = new AdminElementsTree('category');
				$config = array(
					'rootOpenTag' => '<ul class = "">',
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
				$menuTree->setTreeTemplateConfig($config);
				echo $menuTree->createTreeForMainMenu($mcats, 0, '/admin/shop/category');
				/*$mcatscount = count($mcats);
				for ($j = 0; $j < $mcatscount; $j++) {
					$mcat = $mcats[$j];
					$mcat['name'] = getLangText($mcat['name']);
					?>
					<div class = "menu_subcategory">
						<a href = "/admin/shop/category/<?= $mcat['id'] ?>/"><?= $mcat['name'] ?></a>
						<img src = "/img/admin/menu_sub_<?php if ($_SERVER['REQUEST_URI'] != $menuuuu['url'])
							echo 'not_'; ?>active.png" width = "13px" height = "11px" alt = "<?= $mcat['name'] ?>" title = "<?= $mcat['name'] ?>"/>
					</div>
					<?php


					$this->db->where('parent', $mcat['id']);
					$msubcats = $this->db->get('categories')->result_array();
					if ($msubcats) {
						$msubcatscount = count($msubcats);
						for ($j2 = 0; $j2 < $msubcatscount; $j2++) {
							$msubcat = $msubcats[$j2];
							$msubcat['name'] = getLangText($msubcat['name']);
							?>
							<div class = "menu_subsubcategory">
								<a href = "/admin/shop/category/<?= $msubcat['id'] ?>/"><?= $msubcat['name'][$langs[0]] ?></a>
								<img src = "/img/admin/menu_sub_<?php if ($_SERVER['REQUEST_URI'] != $menuuuu['url'])
									echo 'not_'; ?>active.png" width = "13px" height = "11px" alt = "<?= $msubcat['name'] ?>" title = "<?= $msubcat['name'] ?>"/>
							</div>
						<?php
						}
					}
				}*/
			} elseif ($menuuuu['view'] == 'categories_products') {
				$this->db->where('parent', '0');
				$this->db->where('type', 'products');
				$mcats = $this->db->get('categories')->result_array();
				$menuTree = new AdminElementsTree('category');
				$config = array(
					'rootOpenTag' => '<ul class = "root">',
					'rootCloseTag' => '</ul>',
					'childOpenTag' => '<span>[+]</span><ul>',
					'childCloseTag' => '</ul>',

					'rootItemOpenTag' => '<li>',
					'rootItemTitleOpenTag' => '',
					'rootItemTitleCloseTag' => '',
					'rootItemCloseTag' => '</li>',

					'itemOpenTag' => '<li>',
					'itemTitleOpenTag' => '',
					'itemTitleCloseTag' => '',
					'itemCloseTag' => '</li>'
				);
				$menuTree->setTreeTemplateConfig($config);
				echo $menuTree->createTreeForMainMenu($mcats, 0, '/admin/products/category');
				/*$mcatscount = count($mcats);
				for ($j = 0; $j < $mcatscount; $j++) {
					$mcat = $mcats[$j];
					$mcat['name'] = getLangText($mcat['name']);
					?>
					<div class = "menu_subcategory">
						<a href = "/admin/products/category/<?= $mcat['id'] ?>/"><?= $mcat['name'] ?></a>
						<!--img src="/img/admin/menu_sub_<?php if ($_SERVER['REQUEST_URI'] != $menuuuu['url'])
							echo 'not_'; ?>active.png" width="13px" height="11px" alt="<?= $mcat['name'] ?>" title="<?= $mcat['name'] ?>" /-->
					</div>
					<?php
					$this->db->where('parent', $mcat['id']);
					$msubcats = $this->db->get('categories')->result_array();
					if ($msubcats) {
						$msubcatscount = count($msubcats);
						for ($j2 = 0; $j2 < $msubcatscount; $j2++) {
							$msubcat = $msubcats[$j2];
							$msubcat['name'] = getLangText($msubcat['name']);
							?>
							<div class = "menu_subsubcategory">
								<a href = "/admin/products/category/<?= $msubcat['id'] ?>/"><?= $msubcat['name'] ?></a>
								<img src = "/img/admin/menu_sub_<?php if ($_SERVER['REQUEST_URI'] != $menuuuu['url'])
									echo 'not_'; ?>active.png" width = "13px" height = "11px" alt = "<?= $msubcat['name'] ?>" title = "<?= $msubcat['name'] ?>"/>
							</div>
						<?php
						}
					}
				}*/
			}
		}
	}
	?>
</div>

