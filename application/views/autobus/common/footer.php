<!-- footer
			================================================== -->


<section class="bottom-bar">
    <div class="container">
        <div class="text pull-left">
            <p><a style="color: white" href="//<?=$_SERVER['SERVER_NAME']?>"><img height="30px" src="<?=getOption('logo')?>" alt="<?=getOption('site_name')?>" title="<?=getOption('site_name')?>" /> &nbsp;&nbsp;<?=getOption('site_name')?></a> &copy; 2017. Все права защищены!</p>
        </div>
        <div class="social pull-right">
            <a style="color: white" href="//fabrika-umh.com" target="_blank">Сайт разработан «Фабрикой идей» &nbsp;&nbsp;<img src="/img/umh.png" height="30px" alt="Сайт разработан «Фабрикой идей UMH" title="Сайт разработан «Фабрикой идей UMH" /></a>
            <!--ul class="list-inline">
                <li><a href="#"><i class="fa fa-facebook"></i></a></li>
                <li><a href="#"><i class="fa fa-twitter"></i></a></li>
                <li><a href="#"><i class="fa fa-dribbble"></i></a></li>
                <li><a href="#"><i class="fa fa-google-plus"></i></a></li>
                <li><a href="#"><i class="fa fa-pinterest"></i></a></li>
                <li><a href="#"><i class="fa fa-instagram"></i></a></li>
            </ul-->
        </div>
    </div>
</section>

<?=getScripts()?>

<?php if(isset($GLOBALS['type']) && isset($GLOBALS['currentId'])) echo getAdminPanelForFrontend($GLOBALS['type'], $GLOBALS['currentId']); ?>
</body>
</html>