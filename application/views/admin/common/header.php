</head>
<body class="infobar-offcanvas">

<div id="headerbar">
	<div class="container-fluid">
		<div class="row">
			<div class="col-xs-6 col-sm-2">
				<a href="#" class="shortcut-tile tile-brown">
					<div class="tile-body">
						<div class="pull-left"><i class="fa fa-pencil"></i></div>
					</div>
					<div class="tile-footer">
						Create Post
					</div>
				</a>
			</div>
			<div class="col-xs-6 col-sm-2">
				<a href="#" class="shortcut-tile tile-grape">
					<div class="tile-body">
						<div class="pull-left"><i class="fa fa-group"></i></div>
						<div class="pull-right"><span class="badge">2</span></div>
					</div>
					<div class="tile-footer">
						Contacts
					</div>
				</a>
			</div>
			<div class="col-xs-6 col-sm-2">
				<a href="#" class="shortcut-tile tile-primary">
					<div class="tile-body">
						<div class="pull-left"><i class="fa fa-envelope-o"></i></div>
						<div class="pull-right"><span class="badge">10</span></div>
					</div>
					<div class="tile-footer">
						Messages
					</div>
				</a>
			</div>
			<div class="col-xs-6 col-sm-2">
				<a href="#" class="shortcut-tile tile-inverse">
					<div class="tile-body">
						<div class="pull-left"><i class="fa fa-camera"></i></div>
						<div class="pull-right"><span class="badge">3</span></div>
					</div>
					<div class="tile-footer">
						Gallery
					</div>
				</a>
			</div>

			<div class="col-xs-6 col-sm-2">
				<a href="#" class="shortcut-tile tile-midnightblue">
					<div class="tile-body">
						<div class="pull-left"><i class="fa fa-cog"></i></div>
					</div>
					<div class="tile-footer">
						Settings
					</div>
				</a>
			</div>
			<div class="col-xs-6 col-sm-2">
				<a href="#" class="shortcut-tile tile-orange">
					<div class="tile-body">
						<div class="pull-left"><i class="fa fa-wrench"></i></div>
					</div>
					<div class="tile-footer">
						Plugins
					</div>
				</a>
			</div>
		</div>
	</div>
</div>
<header id="topnav" class="navbar navbar-midnightblue navbar-fixed-top clearfix" role="banner">

	<span id="trigger-sidebar" class="toolbar-trigger toolbar-icon-bg">
		<a data-toggle="tooltips" data-placement="right" title="Toggle Sidebar"><span class="icon-bg"><i class="fa fa-fw fa-bars"></i></span></a>
	</span>

	<a class="navbar-brand" href="/admin/" title="<?= $this->config->item('cms_name') ?> <?= $this->config->item('cms_version') ?> (Build: <?=$this->config->item('cms_build')?>)"><?= $this->config->item('cms_name') ?> <?= $this->config->item('cms_version') ?> (Build: <?=$this->config->item('cms_build')?>)</a>

<!--	<span id="trigger-infobar" class="toolbar-trigger toolbar-icon-bg">-->
<!--		<a data-toggle="tooltips" data-placement="left" title="Toggle Infobar"><span class="icon-bg"><i class="fa fa-fw fa-bars"></i></span></a>-->
<!--	</span>-->


	<div class="yamm navbar-left navbar-collapse collapse in">
		<ul class="nav navbar-nav">
			<li><a href="/admin/"><i class="fa fa-home"></i><span> Главная</span></a></li>
			<li><a target="_blank" href="/"><span> Перейти на сайт <i class="fa fa-angle-double-right" aria-hidden="true"></i></span></a></li>
<!--			--><?php
//			$this->db->where('active',1);
//			$this->db->where('parent_id',0);
//			$this->db->where('is_link',0);
//			$this->db->order_by('num','ASC');
//			$separators = $this->db->get('admin_menu')->result_array();
//			if($separators){
//				foreach ($separators as $separator){
//					echo '<li class="nav-separator">'.$separator['name'].'</li>';
//
//					// достаём подпункты
//					$this->db->where('active',1);
//					$this->db->where('parent_id', $separator['id']);
//					$this->db->order_by('num','ASC');
//					$links = $this->db->get('admin_menu')->result_array();
//					if($links){
//						echo '<li class="dropdown"><a class="dropdown-toggle" data-toggle="dropdown" href="'.$separator['url'].'"><i class="'.$separator['class'].'"></i><span>'.$separator['name'].'</span></a>';
//						// Выводим разделы меню
//						foreach ($links as $link){
//							// проверяем, есть ли подпункты у раздела
//							$this->db->where('active',1);
//							$this->db->where('parent_id', $link['id']);
//							$this->db->order_by('num','ASC');
//							$sublinks = $this->db->get('admin_menu')->result_array();
//							if($sublinks){
//								// выводим подпункты
//								echo '<li><a href="javascript:;"><i class="'.$link['class'].'"></i><span>'.$link['name'].'</span><span class="badge badge-primary">'.count($sublinks).'</span></a>';
//								echo '<ul class="acc-menu">';
//								foreach ($sublinks as $sublink){
//									echo '<li><a href="'.$sublink['url'].'">'.$sublink['name'].'</a></li>';
//								}
//								echo '</ul>';
//							} else{
//								echo '<li><a href="'.$link['url'].'"><i class="'.$link['class'].'"></i><span>'.$link['name'].'</span></a>';
//							}
//						}
//						echo '</li>';
//					} else echo '<li><a href="'.$separator['url'].'"><i class="'.$separator['class'].'"></i><span>'.$separator['name'].'</span></a></li>';
//
//				}
//			}
			?>
			<!--li class="dropdown">
				<a href="#" class="dropdown-toggle" data-toggle="dropdown">Megamenu<span class="caret"></span></a>
				<ul class="dropdown-menu" style="width: 900px;">
					<li>
						<div class="yamm-content container-sm-height">
							<div class="row row-sm-height yamm-col-bordered">
								<div class="col-sm-3 col-sm-height yamm-col">

									<h3 class="yamm-category">Sidebar</h3>
									<ul class="list-unstyled mb20">
										<li><a href="layout-fixed-sidebars.html">Stretch Sidebars</a></li>
										<li><a href="layout-sidebar-scroll.html">Scroll Sidebar</a></li>
										<li><a href="layout-static-leftbar.html">Static Sidebar</a></li>
										<li><a href="layout-leftbar-widgets.html">Sidebar Widgets</a></li>
									</ul>

									<h3 class="yamm-category">Infobar</h3>
									<ul class="list-unstyled">
										<li><a href="layout-infobar-offcanvas.html">Offcanvas Infobar</a></li>
										<li><a href="layout-infobar-overlay.html">Overlay Infobar</a></li>
										<li><a href="layout-chatbar-overlay.html">Chatbar</a></li>
										<li><a href="layout-rightbar-widgets.html">Infobar Widgets</a></li>
									</ul>

								</div>
								<div class="col-sm-3 col-sm-height yamm-col">

									<h3 class="yamm-category">Page Content</h3>
									<ul class="list-unstyled mb20">
										<li><a href="layout-breadcrumb-top.html">Breadcrumbs on Top</a></li>
										<li><a href="layout-page-tabs.html">Page Tabs</a></li>
										<li><a href="layout-fullheight-panel.html">Full-Height Panel</a></li>
										<li><a href="layout-fullheight-content.html">Full-Height Content</a></li>
									</ul>

									<h3 class="yamm-category">Misc</h3>
									<ul class="list-unstyled">
										<li><a href="layout-topnav-options.html">Topnav Options</a></li>
										<li><a href="layout-horizontal-small.html">Horizontal Small</a></li>
										<li><a href="layout-horizontal-large.html">Horizontal Large</a></li>
										<li><a href="layout-boxed.html">Boxed</a></li>
									</ul>

								</div>
								<div class="col-sm-3 col-sm-height yamm-col">

									<h3 class="yamm-category">Analytics</h3>
									<ul class="list-unstyled mb20">
										<li><a href="charts-flot.html">Flot</a></li>
										<li><a href="charts-sparklines.html">Sparklines</a></li>
										<li><a href="charts-morris.html">Morris</a></li>
										<li><a href="charts-easypiechart.html">Easy Pie Charts</a></li>
									</ul>

									<h3 class="yamm-category">Components</h3>
									<ul class="list-unstyled">
										<li><a href="ui-tiles.html">Tiles</a></li>
										<li><a href="custom-knob.html">jQuery Knob</a></li>
										<li><a href="custom-jqueryui.html">jQuery Slider</a></li>
										<li><a href="custom-ionrange.html">Ion Range Slider</a></li>
									</ul>

								</div>
								<div class="col-sm-3 col-sm-height yamm-col">
									<h3 class="yamm-category">Rem</h3>
									<img src="http://placehold.it/300&text=Placeholder" class="mb20 img-responsive" style="width: 100%;">
									<p>Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium. totam rem aperiam eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo.</p>
								</div>
							</div>
						</div>
					</li>
				</ul>
			</li>
			<li class="dropdown" id="widget-classicmenu">
				<a href="#" class="dropdown-toggle" data-toggle="dropdown">Dropdown<span class="caret"></span></a>
				<ul class="dropdown-menu" role="menu">
					<li><a href="#">Action</a></li>
					<li><a href="#">Another action</a></li>
					<li><a href="#">Something else here</a></li>
					<li class="divider"></li>
					<li><a href="#">Separated link</a></li>
					<li class="divider"></li>
					<li><a href="#">One more separated link</a></li>
				</ul>
			</li-->
		</ul>
	</div>

	<ul class="nav navbar-nav toolbar pull-right">
		<li class="dropdown toolbar-icon-bg">
			<a href="#" id="navbar-links-toggle" data-toggle="collapse" data-target="header>.navbar-collapse">
				<span class="icon-bg">
					<i class="fa fa-fw fa-ellipsis-h"></i>
				</span>
			</a>
		</li>

<!--		<li class="dropdown toolbar-icon-bg demo-search-hidden">-->
<!--			<a href="#" class="dropdown-toggle tooltips" data-toggle="dropdown"><span class="icon-bg"><i class="fa fa-fw fa-search"></i></span></a>-->
<!---->
<!--			<div class="dropdown-menu dropdown-alternate arrow search dropdown-menu-form">-->
<!--				<div class="dd-header">-->
<!--					<span>Search</span>-->
<!--					<span><a href="#">Advanced search</a></span>-->
<!--				</div>-->
<!--				<div class="input-group">-->
<!--					<input type="text" class="form-control" placeholder="">-->
<!---->
<!--					<span class="input-group-btn">-->
<!---->
<!--						<a class="btn btn-primary" href="#">Search</a>-->
<!--					</span>-->
<!--				</div>-->
<!--			</div>-->
<!--		</li>-->

<!--		<li class="toolbar-icon-bg demo-headerdrop-hidden">-->
<!--			<a href="#" id="headerbardropdown"><span class="icon-bg"><i class="fa fa-fw fa-level-down"></i></span></i></a>-->
<!--		</li>-->
<!---->
<!--		<li class="toolbar-icon-bg hidden-xs" id="trigger-fullscreen">-->
<!--			<a href="#" class="toggle-fullscreen"><span class="icon-bg"><i class="fa fa-fw fa-arrows-alt"></i></span></i></a>-->
<!--		</li>-->

		<?php
		$this->load->helper('admin_helper');
		//showNotifications();
		?>



<!--		<li class="dropdown toolbar-icon-bg hidden-xs">-->
<!--			<a href="#" class="hasnotifications dropdown-toggle" data-toggle='dropdown'><span class="icon-bg"><i class="fa fa-fw fa-envelope"></i></span></a>-->
<!--			<div class="dropdown-menu dropdown-alternate messages arrow">-->
<!--				<div class="dd-header">-->
<!--					<span>Messages</span>-->
<!--					<span><a href="#">Settings</a></span>-->
<!--				</div>-->
<!---->
<!--				<div class="scrollthis scroll-pane">-->
<!--					<ul class="scroll-content">-->
<!--						<li class="">-->
<!--							<a href="#">-->
<!--								<img class="msg-avatar" src="/includes/assets/demo/avatar/avatar_09.png" alt="avatar" />-->
<!--								<div class="msg-content">-->
<!--									<span class="name">Steven Shipe</span>-->
<!--									<span class="msg">Nonummy nibh epismod lorem ipsum</span>-->
<!--								</div>-->
<!--								<span class="msg-time">30s</span>-->
<!--							</a>-->
<!--						</li>-->
<!--						<li>-->
<!--							<a href="#">-->
<!--								<img class="msg-avatar" src="/includes/assets/demo/avatar/avatar_01.png" alt="avatar" />-->
<!--								<div class="msg-content">-->
<!--									<span class="name">Roxann Hollingworth <i class="fa fa-paperclip attachment"></i></span>-->
<!--									<span class="msg">Lorem ipsum dolor sit amet consectetur adipisicing elit</span>-->
<!--								</div>-->
<!--								<span class="msg-time">5m</span>-->
<!--							</a>-->
<!--						</li>-->
<!--						<li>-->
<!--							<a href="#">-->
<!--								<img class="msg-avatar" src="/includes/assets/demo/avatar/avatar_05.png" alt="avatar" />-->
<!--								<div class="msg-content">-->
<!--									<span class="name">Diamond Harlands</span>-->
<!--									<span class="msg">:)</span>-->
<!--								</div>-->
<!--								<span class="msg-time">3h</span>-->
<!--							</a>-->
<!--						</li>-->
<!--						<li>-->
<!--							<a href="#">-->
<!--								<img class="msg-avatar" src="/includes/assets/demo/avatar/avatar_02.png" alt="avatar" />-->
<!--								<div class="msg-content">-->
<!--									<span class="name">Michael Serio <i class="fa fa-paperclip attachment"></i></span>-->
<!--									<span class="msg">Sed distinctio dolores fuga molestiae modi?</span>-->
<!--								</div>-->
<!--								<span class="msg-time">12h</span>-->
<!--							</a>-->
<!--						</li>-->
<!--						<li>-->
<!--							<a href="#">-->
<!--								<img class="msg-avatar" src="/includes/assets/demo/avatar/avatar_03.png" alt="avatar" />-->
<!--								<div class="msg-content">-->
<!--									<span class="name">Matt Jones</span>-->
<!--									<span class="msg">Temporibus autem quibusdam et aut officiis debitis aut rerum necessitatibus saepe eveniet ut et voluptates repudiandae sint et mole</span>-->
<!--								</div>-->
<!--								<span class="msg-time">2d</span>-->
<!--							</a>-->
<!--						</li>-->
<!--						<li>-->
<!--							<a href="#">-->
<!--								<img class="msg-avatar" src="/includes/assets/demo/avatar/avatar_07.png" alt="avatar" />-->
<!--								<div class="msg-content">-->
<!--									<span class="name">John Doe</span>-->
<!--									<span class="msg">Neque porro quisquam est qui dolorem</span>-->
<!--								</div>-->
<!--								<span class="msg-time">7d</span>-->
<!--							</a>-->
<!--						</li>-->
<!--					</ul>-->
<!--				</div>-->
<!---->
<!--				<div class="dd-footer"><a href="#">View all messages</a></div>-->
<!--			</div>-->
<!--		</li>-->



		<li class="dropdown toolbar-icon-bg">
			<a href="#" class="dropdown-toggle" data-toggle='dropdown'><span class="icon-bg"><i class="fa fa-fw fa-user"></i></span></a>
			<ul class="dropdown-menu userinfo arrow">
<!--				<li><a href="#"><span class="pull-left">--><?//=getLine('Профиль')?><!--</span> <span class="badge badge-info">80%</span></a></li>-->
<!--				<li><a href="#"><span class="pull-left">--><?//=getLine('Аккаунт')?><!--</span> <i class="pull-right fa fa-user"></i></a></li>-->
<!--				<li><a href="#"><span class="pull-left">--><?//=getLine('Настройки')?><!--</span> <i class="pull-right fa fa-cog"></i></a></li>-->
<!--				<li class="divider"></li>-->
<!--				<li><a href="#"><span class="pull-left">Earnings</span> <i class="pull-right fa fa-line-chart"></i></a></li>-->
<!--				<li><a href="#"><span class="pull-left">Statement</span> <i class="pull-right fa fa-list-alt"></i></a></li>-->
<!--				<li><a href="#"><span class="pull-left">Withdrawals</span> <i class="pull-right fa fa-dollar"></i></a></li>-->
<!--				<li class="divider"></li>-->
				<li><a onclick="return confirm('Вы точно хотите покинуть админку?')" href="/admin/login/logoff/"><span class="pull-left"><?=getLine('Выход')?></span> <i class="pull-right fa fa-sign-out"></i></a></li>
			</ul>
		</li>

	</ul>

</header>