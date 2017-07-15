<?=getHead()?>
<?=getHeader('main')?>
<?php
$mArticles = getModel('articles');
?>
<?=getOption('main_1_hero')?>

    <!--========== MAIN CONTENT ==========-->
    <main id="mainContent">
        <!-- About Us -->
        <?=getOption('about_us')?>
        <!-- End of About Us -->
        <!-- Let's Make Your Brand Successfull Today -->
        <!-- <section class="brand-successfull-today parallax dark">
            <div class="container">
                <h2 class="text-center">Let’s Make Your Brand SuccessFull Today!</h2>
                <p class="button text-center"><a href="#contact" class="btn btn-primary">Contact Us</a></p>
            </div>
        </section> -->
        <!-- End of Let's Make Your Brand Successfull Today -->
        <!-- Services -->
        <!-- <section id="services" class="services parallax light" style="background-image: url('<?=getOption('parallax-bg')?>');">
            <?=getOption('services')?>
        </section> -->
        <!-- End of Services -->
        <!-- Why Choose Us -->
        <?=getOption('why_choose_us')?>
        <!-- End of Why Choose Us -->
        <!-- Team -->
        <section id="team" class="team">
            <div class="container">
                <h2 class="heading text-center">Наша команда</h2>
                <div class="container">
                    <div class="row owl-carousel team-carousel">
                        <!-- class col-md-4 col-sm-4 col-xs-12 -->
                        <?php
                        $team = $mArticles->getArticlesByCategory(23, -1, -1, 1);
                        loadHelper(TEMPLATE);
                        if($team){
                            foreach ($team as $value){
                                echo getTeamBlock($value);
                            }
                        }
                        //vd($team);
                        ?>
                    </div>
                </div>
            </div>
        </section>
        <!-- End of Team -->
        <!-- Fun Facts (CounterUp)-->
        <?=getOption('6_fun_facts')?>
        <!-- End of Fun Facts (CounterUp)-->
        <!-- Work (Portfolio) -->
        <section id="portfolio" class="portfolio">
            <div class="container-fluid">
                <h2 class="heading text-center">Что мы делаем?</h2>
                <div class="grid">
                    <div class="row">
                        <?php
                        $uslugi = $this->model_categories->getCategories(1,'products');
                        //var_dump($uslugi);
                        if($uslugi){
                            foreach ($uslugi as $item){
                                ?>
                                <div class="col-md-3 col-sm-4 col-xs-6 item ">
                                    <?php if($item['image'] != '') { ?>
                                        <img src="<?=cropImage($item['image'],600,600);?>" alt="<?=$item['name']?>" />
                                    <?php } else { ?>
                                        <img src="http://placehold.it/600x600" alt="<?=$item['name']?>" />
                                    <?php } ?>
                                    <a href="<?=getFullUrl($item)?>">
                                        <div class="project-content">
                                            <div class="inner">
                                                <h3 class="text-center"><?=$item['name']?></h3>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                                <?php
                            }
                        }
                        ?>


                    </div>
                </div>
            </div>
        </section>
        <!-- End of Work (Portfolio) -->
        <!-- Blog  -->

        <!-- End of Blog  -->
        <!-- Testimonials -->

        <!-- End of Testimonials -->
        <!-- Pricing -->

        <section id="specials" class="pricing">
            <div class="container">
                <h2 class="heading text-center">Специальные предложения</h2>
                <div class="row">
                    <div class="col-md-3 col-sm-6 col-xs-12">
                        <div class="pricing-box basic-price text-center">
                            <div class="pricing-head">
                                <div class="pricing-plan">BASIC</div>
                                <div class="fees">
                                    <sup>$</sup><span class="value">30</span>/Month
                                </div>
                            </div>
                            <div class="pricing-content">
                                <ul>
                                    <li>Design + HTML5</li>
                                    <li>Responsive/Mobile Ready</li>
                                    <li>One Page Scroll-Down Layout</li>
                                    <li>Bootstrap Framework</li>
                                    <li>Pricing is for 5 Vert</li>
                                    <li>CSS3 & jQuery Powered</li>
                                </ul>
                            </div>
                            <div class="pricing-footer">
                                <a href="#" class="btn btn-primary">Order Now</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-6 col-xs-12">
                        <div class="pricing-box standard-price text-center">
                            <div class="pricing-head">
                                <div class="pricing-plan">STANDARD</div>
                                <div class="fees">
                                    <sup>$</sup><span class="value">50</span>/Month
                                </div>
                            </div>
                            <div class="pricing-content">
                                <ul>
                                    <li>Design + HTML5</li>
                                    <li>Responsive/Mobile Ready</li>
                                    <li>One Page Scroll-Down Layout</li>
                                    <li>Bootstrap Framework</li>
                                    <li>Pricing is for 5 Vert</li>
                                    <li>CSS3 & jQuery Powered</li>
                                </ul>
                            </div>
                            <div class="pricing-footer">
                                <a href="#" class="btn btn-primary">Order Now</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-6 col-xs-12">
                        <div class="pricing-box premium-price text-center">
                            <div class="pricing-head">
                                <div class="pricing-plan">PREMIUM</div>
                                <div class="fees">
                                    <sup>$</sup><span class="value">70</span>/Month
                                </div>
                            </div>
                            <div class="pricing-content">
                                <ul>
                                    <li>Design + HTML5</li>
                                    <li>Responsive/Mobile Ready</li>
                                    <li>One Page Scroll-Down Layout</li>
                                    <li>Bootstrap Framework</li>
                                    <li>Pricing is for 5 Vert</li>
                                    <li>CSS3 & jQuery Powered</li>
                                </ul>
                            </div>
                            <div class="pricing-footer">
                                <a href="#" class="btn btn-primary">Order Now</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-6 col-xs-12">
                        <div class="pricing-box ultimate-price text-center">
                            <div class="pricing-head">
                                <div class="pricing-plan">ULTIMATE</div>
                                <div class="fees">
                                    <sup>$</sup><span class="value">90</span>/Month
                                </div>
                            </div>
                            <div class="pricing-content">
                                <ul>
                                    <li>Design + HTML5</li>
                                    <li>Responsive/Mobile Ready</li>
                                    <li>One Page Scroll-Down Layout</li>
                                    <li>Bootstrap Framework</li>
                                    <li>Pricing is for 5 Vert</li>
                                    <li>CSS3 & jQuery Powered</li>
                                </ul>
                            </div>
                            <div class="pricing-footer">
                                <a href="#" class="btn btn-primary">Order Now</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>


              <div class="clients">
            <div class="container">
                <ul class="owl-carousel clients-carousel">
                    <?php
                    $banners = getBanners('banners');
                    if($banners) {
                        foreach ($banners as $banner) {
                            if($banner['url'] != '') echo '<a target="_blank" rel="nofollow" href="/banner/'.$banner['id'].'/">';
                            ?>
                            <li>
                                <img class="clients-logo" src="<?=$banner['image']?>" alt="<?=$banner['name']?>" title="<?=$banner['name']?>">
                            </li>
                            <?php
                            if($banner['url'] != '') echo '</a>';
                        }
                    }
                    ?>
                </ul>
            </div>
        </div>

        <section id="blog" class="blog">
            <div class="container">
                <h2 class="heading text-center">ПОСЛЕДНИЕ НОВОСТИ</h2>
                <div class="row">
                    <?php
                    //var_dump($news);
                    $news = $mArticles->getArticlesByCategory(1);
                    if($news){
                        foreach ($news as $item){
                            $url = getFullUrl($item);
                            ?>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <div class="blog-post article-height-main">
                                    <div class="post-date"><?=$item['date']?></div>
                                    <h3><a href="<?=$url?>"><?=$item['name']?></a></h3>
                                    <p><?=string_limit_words(strip_tags($item['content']),50)?></p>
                                </div>
                            </div>
                            <?php
                        }
                    }
                    ?>

                </div>
            </div>
        </section>

  


        <section id="testimonials" class="testimonials parallax dark">
            <div class="container">
                <h2 class="heading text-center">Отзывы наших клиентов</h2>
                <ul class="row owl-carousel testimonials-carousel">
                    <?php
                    $reviews = $mArticles->getArticlesByCategory(24);
                    if($reviews){
                        foreach ($reviews as $review){
                            echo getReviewBlock($review);
                        }
                    }
                    ?>


                </ul>
            </div>
        </section>

        <!-- End of Pricing -->
        <!-- Clients -->
        <div class="clients">
            <div class="container">
                <ul class="owl-carousel clients-carousel">
                    <?php
                    $banners = getBanners('clients');
                    if($banners) {
                        foreach ($banners as $banner) {
                            if($banner['url'] != '') echo '<a target="_blank" rel="nofollow" href="/banner/'.$banner['id'].'/">';
                            ?>
                            <li>
                                <img class="clients-logo" src="<?=$banner['image']?>" alt="<?=$banner['name']?>" title="<?=$banner['name']?>">
                            </li>
                            <?php
                            if($banner['url'] != '') echo '</a>';
                        }
                    }
                    ?>
                </ul>
            </div>
        </div>
        <!-- End of Clients -->
        <section id="portfolio" class="portfolio">
            <div class="container-fluid">
                <div class="blog-post">
                    <?=getOption('seo-text-main')?>
                </div>
            </div>
        </section>
        <!-- Contact Us -->
        <section id="contact" class="contact">
            <!-- Google Map -->
            <div class="google-map">
                <div id="map" class="map"></div>
            </div>
            <!-- End of Google Map -->
            <div class="container">
                <div class="row">
                    <div class="col-md-7 col-sm-7 col-xs-12">
                        <div class="contact-form contact-box">
                            <h3>Написать нам</h3>
                            <div class="row">
                                <div class="col-md-6 col-sm-6 col-xs-6">
                                    <div class="form-group">
                                        <input type="text" placeholder="Ваше имя" id="form_name" class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-6 col-sm-6 col-xs-6">
                                    <div class="form-group">
                                        <input type="text" placeholder="Email" id="form_email" class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-6 col-sm-6 col-xs-6">
                                    <div class="form-group">
                                        <input type="text" placeholder="Телефон" id="form_tel" class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-6 col-sm-6 col-xs-6">
                                    <div class="form-group">
                                        <input type="text" placeholder="Тема" id="form_subject" class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-12 col-sm-12 col-xs-12">
                                    <div class="form-group">
                                        <textarea placeholder="Сообщение" id="form_message" class="form-control"></textarea>
                                    </div>
                                </div>
                                <div class="col-md-12 col-sm-12 col-xs-12">
                                    <input type="submit" value="Отправить" id="form_send" class="btn btn-primary">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-5 col-sm-5 col-xs-12">
                        <?=getOption('main_our_contacts')?>
                    </div>
                </div>
            </div>
        </section>
        <!-- End of Contact Us -->
    </main>
    <!--========== END OF MAIN CONTENT==========-->

    <!-- SLIDER ENDS -->
<?=getFooter()?>