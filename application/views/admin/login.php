<!DOCTYPE html>
<html lang="en" class="coming-soon">
<head>
    <meta charset="utf-8">
    <title><?=$this->config->item('cms_name')?> v.<?=$this->config->item('cms_version')?></title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0, user-scalable=no">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-touch-fullscreen" content="yes">
    <meta name="description" content="">
    <meta name="author" content="KaijuThemes">

    <link href='http://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700' rel='stylesheet' type='text/css'>
    <link type="text/css" href="<?=GENERAL_DOMAIN?>/includes/assets/plugins/iCheck/skins/minimal/blue.css" rel="stylesheet">
    <link type="text/css" href="<?=GENERAL_DOMAIN?>/includes/assets/fonts/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <link type="text/css" href="<?=GENERAL_DOMAIN?>/includes/assets/css/styles.css" rel="stylesheet">

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries. Placeholdr.js enables the placeholder attribute -->
    <!--[if lt IE 9]>
    <link type="text/css" href="<?=GENERAL_DOMAIN?>/includes/assets/css/ie8.css" rel="stylesheet">
    <script type="text/javascript" src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->

    <!-- The following CSS are included as plugins and can be removed if unused-->

</head>

<body class="focused-form">


<div class="container" id="login-form">

    <a href="//xx.org.ua/" class="login-logo"><img alt="<?=$this->config->item('cms_name')?> v.<?=$this->config->item('cms_version')?>" src="<?=GENERAL_DOMAIN?>/img/admin/logo2.png"></a>
    <div style="text-align: center; font-size: 18px; font-weight: bolder" c;ass="site-name"><?=getOption('site_name')?></div><br />
    <div class="row">

        <div class="col-md-4 col-md-offset-4">
            <div class="panel panel-default">
                <div class="panel-heading"><h2>Панель управления</h2>&nbsp;&nbsp;v.<?=$this->config->item('cms_version')?> (Build: <?=$this->config->item('cms_build')?>)</div>
                <div class="panel-body">

                    <form action="/admin/login/" method="post" style="text-align: center">

                        <div class="login_login">Ваш логин</div>
                        <div class="input_login"><input required type="text" name="login" /></div>
                        <div class="login_password">Пароль</div>
                        <div class="input_password"><input required type="password" name="pass" /></div>
                        <br />
                        <div class="login_button"><input type="submit" style="background: url(/img/admin/admin_enter.png) no-repeat; width: 173px; height: 46px;" value="" /></div>

                    </form>

                    <h3 style="font-size: 18px">Выберите, через какую службу авторизироваться:</h3>

                    <?php
                    if(userdata('login_err') !== false)
                    {
                        ?>
                        <div class="login_err"><?=userdata('login_err')?></div>
                        <?php
                        unset_userdata('login_err');
                    }
                    ?>

                    <script src="//ulogin.ru/js/ulogin.js"></script>
                    <div id="uLogin4f2eaecf" data-ulogin="display=panel;fields=first_name,last_name,email;optional=phone,city,country,photo_big,photo,nickname,bdate,sex;verify=1;providers=google,vkontakte,odnoklassniki,facebook,mailru,yandex;hidden=twitter,livejournal,openid,lastfm,linkedin,liveid,soundcloud,steam,flickr,uid,youtube,webmoney,foursquare,tumblr,googleplus,vimeo,instagram,wargaming;redirect_uri=http:%2F%2F<?=$_SERVER['SERVER_NAME']?>%2Fadmin%2Flogin%2Fsoc%2F"></div>
                    <br>



                </div>
            </div>
        </div>



        <!-- Load site level scripts -->

        <!-- <script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
        <script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.9.2/jquery-ui.min.js"></script> -->

        <script type="text/javascript" src="<?=GENERAL_DOMAIN?>/includes/assets/js/jquery-1.10.2.min.js"></script> 							<!-- Load jQuery -->
        <script type="text/javascript" src="<?=GENERAL_DOMAIN?>/includes/assets/js/jqueryui-1.9.2.min.js"></script> 							<!-- Load jQueryUI -->

        <script type="text/javascript" src="<?=GENERAL_DOMAIN?>/includes/assets/js/bootstrap.min.js"></script> 								<!-- Load Bootstrap -->


        <script type="text/javascript" src="<?=GENERAL_DOMAIN?>/includes/assets/plugins/easypiechart/jquery.easypiechart.js"></script> 		<!-- EasyPieChart-->
        <script type="text/javascript" src="<?=GENERAL_DOMAIN?>/includes/assets/plugins/sparklines/jquery.sparklines.min.js"></script>  		<!-- Sparkline -->
        <script type="text/javascript" src="<?=GENERAL_DOMAIN?>/includes/assets/plugins/jstree/dist/jstree.min.js"></script>  				<!-- jsTree -->

        <script type="text/javascript" src="<?=GENERAL_DOMAIN?>/includes/assets/plugins/codeprettifier/prettify.js"></script> 				<!-- Code Prettifier  -->
        <script type="text/javascript" src="<?=GENERAL_DOMAIN?>/includes/assets/plugins/bootstrap-switch/bootstrap-switch.js"></script> 		<!-- Swith/Toggle Button -->

        <script type="text/javascript" src="<?=GENERAL_DOMAIN?>/includes/assets/plugins/bootstrap-tabdrop/js/bootstrap-tabdrop.js"></script>  <!-- Bootstrap Tabdrop -->

        <script type="text/javascript" src="<?=GENERAL_DOMAIN?>/includes/assets/plugins/iCheck/icheck.min.js"></script>     					<!-- iCheck -->

        <script type="text/javascript" src="<?=GENERAL_DOMAIN?>/includes/assets/js/enquire.min.js"></script> 									<!-- Enquire for Responsiveness -->

        <script type="text/javascript" src="<?=GENERAL_DOMAIN?>/includes/assets/plugins/bootbox/bootbox.js"></script>							<!-- Bootbox -->

        <script type="text/javascript" src="<?=GENERAL_DOMAIN?>/includes/assets/plugins/simpleWeather/jquery.simpleWeather.min.js"></script> <!-- Weather plugin-->

        <script type="text/javascript" src="<?=GENERAL_DOMAIN?>/includes/assets/plugins/nanoScroller/js/jquery.nanoscroller.min.js"></script> <!-- nano scroller -->

        <script type="text/javascript" src="<?=GENERAL_DOMAIN?>/includes/assets/plugins/jquery-mousewheel/jquery.mousewheel.min.js"></script> 	<!-- Mousewheel support needed for jScrollPane -->

        <script type="text/javascript" src="<?=GENERAL_DOMAIN?>/includes/assets/js/application.js"></script>
        <script type="text/javascript" src="<?=GENERAL_DOMAIN?>/includes/assets/demo/demo.js"></script>
        <script type="text/javascript" src="<?=GENERAL_DOMAIN?>/includes/assets/demo/demo-switcher.js"></script>

        <!-- End loading site level scripts -->
        <!-- Load page level scripts-->


        <!-- End loading page level scripts-->
</body>
</html>