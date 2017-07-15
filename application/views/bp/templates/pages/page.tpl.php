<?=getHead($meta)?>
<?=getHeader()?>

    <!--========== HERO (BANNER) ==========-->
    <section id="welcome" class="parallax banner image-banner">
        <?php if($page['image'] != '') { ?>
            <img src="http://placehold.it/1920x360" alt="<?=$page['name']?>">
        <?php } else { ?>
        <img src="http://placehold.it/1920x360" alt="<?=$page['name']?>">
        <?php } ?>
        <h1 class="page-title"><?=$page['name']?></h1>
    </section>
    <!--========== END OF HERO (BANNER) ==========-->

    <!--========== MAIN CONTENT ==========-->
    <main id="mainContent">
        <!-- Blog Single Page -->
        <div class="blog-page">
            <div class="container">
                <div class="row">
                    <?php showBreadCrumbs() ?>
                </div>
                <div class="row">
                    <div class="col-md-8 col-sm-7 col-xs-12">
                        <div class="blog-post">
                            <?=$page['content']?>
                        </div>
                        <div class="blog-share text-center">
                            <ul>
                                <li>Share On:</li>
                                <li><a href="#"><i class="fa fa-facebook"></i></a></li>
                                <li><a href="#"><i class="fa fa-twitter"></i></a></li>
                                <li><a href="#"><i class="fa fa-google-plus"></i></a></li>
                                <li><a href="#"><i class="fa fa-pinterest-p"></i></a></li>
                                <li><a href="#"><i class="fa fa-instagram"></i></a></li>
                            </ul>
                        </div>
                        <div class="author-box">
                            <div class="author-img">
                                <img src="http://placehold.it/60x60" alt="">
                            </div>
                            <div class="author-info">
                                <h5>Christopher Robins</h5>
                                <p>CEO of <a href="#">XYZTheme</a></p>
                                <p>Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. </p>
                            </div>
                        </div>
                        <div class="comments">
                            <h2>4 Comments</h2>
                            <ul class="comment-list">
                                <li>
                                    <div class="comment-body">
                                        <div class="comment-avatar">
                                            <img src="http://placehold.it/60x60" alt="">
                                        </div>
                                        <div class="comment-content">
                                            <h3>Joeby Ragpa</h3>
                                            <div class="comment-date">May 6, 2016 at 12:48PM</div>
                                            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
                                            <p class="text-right"><a href="#" class="btn-reply">Reply</a></p>
                                        </div>
                                    </div>
                                    <ul class="comment-reply">
                                        <li>
                                            <div class="comment-body">
                                                <div class="comment-avatar">
                                                    <img src="http://placehold.it/60x60" alt="">
                                                </div>
                                                <div class="comment-content">
                                                    <h3>Alexander Samokhin</h3>
                                                    <div class="comment-date">May 6, 2016 at 12:48PM</div>
                                                    <p>Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
                                                    <p class="text-right"><a href="#" class="btn-reply">Reply</a></p>
                                                </div>
                                            </div>
                                        </li>
                                    </ul>
                                </li>
                                <li>
                                    <div class="comment-body">
                                        <div class="comment-avatar">
                                            <img src="http://placehold.it/60x60" alt="">
                                        </div>
                                        <div class="comment-content">
                                            <h3>John Smith</h3>
                                            <div class="comment-date">May 6, 2016 at 12:48PM</div>
                                            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
                                            <p class="text-right"><a href="#" class="btn-reply">Reply</a></p>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        </div>
                        <div class="comment-form">
                            <h2>Leave A Reply</h2>
                            <ul>
                                <li>
                                    <input type="text" placeholder="Name">
                                </li>
                                <li>
                                    <input type="text" placeholder="Email">
                                </li>
                                <li>
                                    <input type="text" placeholder="Website">
                                </li>
                                <li>
                                    <textarea placeholder="Your Comment"></textarea>
                                </li>
                                <li>
                                    <input type="submit" value="Post Comment" class="btn btn-primary">
                                </li>
                            </ul>
                        </div>
                    </div>
                    <?=getBlock('right')?>
                </div>
            </div>
        </div>
        <!-- End of Blog Single Page -->
    </main>
    <!--========== END OF MAIN CONTENT==========-->

<?=getFooter()?>