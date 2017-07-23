<body>
	<?php if(isClientAdmin()) include(X_PATH."/application/views/admin/client/frontend_admin_panel.php"); ?>

    <!--========== HEADER ==========-->
    <header class="sliderbg">

        <div class="phone">
            <section class="icons span4">
                <a href="<?= getOption("link_twitter") ?>">
                    <div class="item">
                        <div><i class="icontwitter"></i></div>
                    </div>
                </a>
                <a href="<?= getOption("link_facebook") ?>">
                    <div class="item">
                        <div><i class="iconfacebook"></i></div>
                    </div>
                </a>
                <a href="<?= getOption("link_googleplus") ?>">
                    <div class="item">
                        <div><i class="icongoogle"></i></div>
                    </div>
                </a>
                <a href="#">
                    <div class="item">
                        <div><i class="iconrss"></i></div>
                    </div>
                </a>
                <a href="#">
                    <div class="item">
                        <div><i class="iconskype"></i></div>
                    </div>
                </a>
                <a href="<?= getOption("link_youube") ?>">
                    <div class="item">
                        <div><i class="iconyoutube"></i></div>
                    </div>
                </a>

            </section>
            <p>Contact Phones: &nbsp; &nbsp; <?= getOption("nomer-telefona-1") ?>&nbsp; &nbsp; &nbsp; &nbsp;<?= getOption("nomer-telefona-2") ?>&nbsp; &nbsp; &nbsp; &nbsp; <?= getOption("nomer-telefona-3") ?></p>
        </div>
    </header>

    <!-- menu -->
    <div class="container">
        <nav class="navbar row">
            <a class="navbar-brand" href="/">
                <img src="<?=$GLOBALS['logo']?>" alt="<?=$GLOBALS['site_name']?>"/>
            </a>

            <div class="navbar-header">
                <button class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse" type="button">
                    <span class="sr-only"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
            </div>

           
            <div class="collapse right navbar-collapse navbar-ex1-collapse">
                <div class="cl-effect-12">
                    <?php
                        $config = array(
                            'rootOpenTag'   =>  '<ul class="nav navbar-nav pull-right">',
                                    ''
                                );
                        showTopMenu($config);
                    ?>            <div class="collapse right navbar-collapse navbar-ex1-collapse">
                        <div class="cl-effect-12">
                            <ul class="nav navbar-nav pull-right">
                                <li><a class="dropdownhover" href="http://inschool.xx.org.ua/">Главная</a>
                            </ul>
                </div>
            </div>
        </nav>
    </div>
    <!-- menu end -->
    <!--========== END OF HEADER ==========-->