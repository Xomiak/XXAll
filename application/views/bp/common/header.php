<body>
	<?php if(isClientAdmin()) include(X_PATH."/application/views/admin/client/frontend_admin_panel.php"); ?>
    <!--========== HEADER ==========-->
    <header class="header navbar-fixed-top">
        <!-- Navbar -->
        <nav class="navbar" role="navigation">
            <div class="container">
                <!-- Brand and toggle get grouped for better mobile display -->
                <div class="menu-container">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".nav-collapse">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="toggle-icon"></span>
                    </button>

                    <!-- Logo -->
                    <div class="logo">
                        <a class="logo-wrap" href="/">
                            <img class="logo-img logo-img-main" src="/img/logo.png" alt="Asentus Logo">
                            <img class="logo-img logo-img-active" src="/img/logo-dark.png" alt="Asentus Logo">
                        </a>
                    </div>
                    <!-- End Logo -->
                </div>

                <!-- Collect the nav links, forms, and other content for toggling -->
                <div class="collapse navbar-collapse nav-collapse">
                    <div class="menu-container">

                        <ul class="navbar-nav navbar-nav-right">
                            <li class="nav-item"><a class="nav-item-child nav-item-hover active" href="/index.html">Home</a></li>
                            <li class="nav-item"><a class="nav-item-child nav-item-hover" href="/pricing.html">Pricing</a></li>
                            <li class="nav-item"><a class="nav-item-child nav-item-hover" href="/about.html">About</a></li>
                            <li class="nav-item"><a class="nav-item-child nav-item-hover" href="/products.html">Products</a></li>
                            <li class="nav-item"><a class="nav-item-child nav-item-hover" href="/faq.html">FAQ</a></li>
                            <li class="nav-item"><a class="nav-item-child nav-item-hover" href="/contact.html">Contact</a></li>

                            <?php
                            if(userdata('login') !== false){
                                echo '<li class="nav-item nav-user-first"><div class="nav-user-opacity"></div><a class="nav-item-child nav-item-hover" href="/user/my_page/">Личный кабинет</a></li>';
                            } else{
                                echo '<li class="nav-item nav-user-first"><div class="nav-user-opacity"></div><a data-fancybox data-src="#register_popup" href="javascript:;" class="nav-item-child nav-item-hover" href="#">Регистрация</a></li>';
                                echo '<li class="nav-item"><div class="nav-user-opacity"></div><a data-fancybox data-src="#login_popup" href="javascript:;" class="nav-item-child nav-item-hover" href="#">Вход</a></li>';
                            }
                            ?>
                        </ul>


                    </div>
                </div>
                <!-- End Navbar Collapse -->
            </div>
        </nav>
        <!-- Navbar -->

    </header>
    <!--========== END HEADER ==========-->