<!--========== FOOTER ==========-->
<footer id="pageFooter" class="footer">
    <!-- Footer Widgets -->
    <!-- End of Footer Widgets -->
    <!-- Copyright -->
    <div class="copyright">
        <div class="container">
            <p class="text-center" style="margin: 0">Copyright ©  <span id="copyright-year"></span> <a href="//<?=$_SERVER['SERVER_NAME']?>/">Рекламная Одесса</a>. Все права зищищены</p>
        <div class="umh footer-logo">
            <iframe src="//banner.fabrika-umh.com/responsive/?from=<?=urlencode('//'.$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'])?>&background-color=181818" width="150px" height="150px"></iframe>

            <a class="footer-logo" target="_blank" href="//fabrika-umh.com"><img src="/img/fabrika_white_text.png" alt="Разработка сайта: Фабрика Идей" title="Разработка сайта: Фабрика Идей" /></a>
        </div>


<!--            <a class="footer-logo" target="_blank" href="//fabrika-umh.com"><img src="//fabrika-umh.com/img/logos/150x150/logo_white.png" alt="Разработка сайта: Фабрика Идей" title="Разработка сайта: Фабрика Идей" /></a>-->
        </div>
    </div>
    <!-- End of Copyright -->
</footer>
<!--========== END OF FOOTER==========-->

<!--========== PRELOADER==========-->
<div id="preloader" class="preloader ball-pulse">
    <div class="loader">
        <div class="ball"></div>
    </div>
</div>
<!--========== END OF PRELOADER==========-->
<?=getScripts()?>
<?=getOption('yandex-metrika-code')?>
</body>
</html>