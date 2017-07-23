<body>
<?=getOption('google-analytics-code')?>
<?php if(isClientAdmin()) include(X_PATH."/application/views/admin/client/frontend_admin_panel.php"); ?>
<header class="container-full header">

    <div class="container header-container ">
        <div class="main-logo">
            <a href="/">
            <img src="/img/logo.png"
                 srcset="/img/logoPngPagespeedCeU1NJ0CGduY@2x.png 2x, /img/logoPngPagespeedCeU1NJ0CGduY@3x.png 3x"
                 class="wow fadeInDown">
            </a>
        </div>
        <div class="main-nav header-nav ">
            <?php showTopMenu(); ?>

        </div>
        <div id="mob_bg"></div>
        <div id="mobile_nav">
            <span></span>
            <span></span>
            <span></span>
        </div>
    </div>

</header>