<footer class="footer">
    <div class="container">
        <div class="row">
            <div class="footerheadline">
                <h4>Отзывы</h4>
            </div>
        </div>
        <div class="row">
            <div class="span4">
                <div class="testimonial">
                    <p class="testimonialbg">
                        "<?= getOption("otzyv-1") ?> "
                    </p>
                    <p class="testimonialname"><?= getOption("avtor-otzyva-1") ?></p>
                </div>
            </div>
            <div class="span4">
                <div class="testimonial">
                    <p class="testimonialbg">
                        "<?= getOption("otzyv-3") ?> "
                    </p>
                    <p class="testimonialname"><?= getOption("avtor-otzyva-3") ?></p>
                </div>
            </div>
            <div class="span4">
                <div class="testimonial">
                    <p class="testimonialbg">
                    "<?= getOption("otzyv-2") ?> "
                    </p>
                    <p class="testimonialname"><?= getOption("avtor-otzyva-2") ?></p>
                </div>
            </div>
        </div>
    </div>
</footer>

<div class="bottom">
    <div class="container">
        <div class="row">
            <section class="icons span4">
                <a href="//fabrika-umh.com" target="_blank">
                    <div class="item">
                        <div><i class="icontwitter"></i></div>
                    </div>
                </a>
            </section>


            <section class="span4 copyright">
                <p>&copy; 2011 - <?=date("Y")?> <a
                            href="/"><?=$GLOBALS['site_name']?></a> All rights reserved.</p>

            </section>


            <section class="span4">
                <a href="javascript:scrollToTop()" title="top of page">
                    <div class="topofpage"></div>
                </a>
            </section>

        </div>
    </div>


</div>

<?=getScripts()?>


</body>
</html>