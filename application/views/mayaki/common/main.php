<?php loadHelper(TEMPLATE)?>

<?=getHead()?>
<?=getHeader()?>

    <main class="">
        <div class="container-full box-1">


            <div class="swiper-container swiper-main">
                <div class="swiper-wrapper">
                    <?php
                    $mBanners = getModel('banners');
                    $slides = $mBanners->getByType('main_slider');
                    foreach ($slides as $slide){
                        echo '<div class="swiper-slide"><img src="'.$slide['image'].'" alt="'.$slide['name'].'"></div>';
                    }
                    ?>
                </div>
                <!-- Add Arrows -->
            </div>

            <h1>Частная усадьба «Тихая Гавань»
                вблизи Одессы</h1>
            <img src="img/layer2.png"
                 srcset="img/layer2@2x.png 2x,
             img/layer2@3x.png 3x"
                 class="to-bottom" id="to_bottom">

        </div>

        <!--GALLERY BOX-->
        <div class="container-full box-2" id="main_gallery">
            <div class="container-slider">
                <h2>ГАЛЕРЕЯ</h2>
                <!-- Swiper -->
                <div class="swiper-container swiper-gallery">
                    <div class="swiper-wrapper">
                        <div class="swiper-slide"><a href="/gallery/"><img class=" wow bounceInRight" src="/img/layer3.jpg" alt=""></a></div>
                        <div class="swiper-slide"><a href="/gallery/"><img class=" wow bounceInRight" src="/img/layer5.jpg" alt=""></a></div>
                        <div class="swiper-slide"><a href="/gallery/"><img class=" wow bounceInRight" src="/img/layer4.jpg" alt=""></a></div>
                        <div class="swiper-slide"><a href="/gallery/"><img class=" wow bounceInRight" src="/img/layer5.jpg" alt=""></a></div>
                        <div class="swiper-slide"><a href="/gallery/"><img class=" wow bounceInRight" src="/img/layer3.jpg" alt=""></a></div>
                        <div class="swiper-slide"><a href="/gallery/"><img class=" wow bounceInRight" src="/img/layer4.jpg" alt=""></a></div>
                        <div class="swiper-slide"><a href="/gallery/"><img class=" wow bounceInRight" src="/img/layer4.jpg" alt=""></a></div>
                        <div class="swiper-slide"><a href="/gallery/"><img class=" wow bounceInRight" src="/img/layer3.jpg" alt=""></a></div>

                    </div>

                    <!-- Add Arrows -->


                </div>
                <div class="slider-nav slider-button-next main-next"></div>
                <div class="slider-nav slider-button-prev main-prev"></div>

                <a href="/gallery/" class="button go-to-gallery">Вся галерея</a>
            </div>
        </div>

        <!--REVIEWS-->
        <div class="container-full box-3">
            <h2>Отзывы</h2>
            <div class="swiper-container swiper-reviews wow  slideInLeft">
                <div class="swiper-wrapper">
                    <div class="swiper-slide" style="background-image: url(/img/fishing_001.JPG)">
                        <!--<img src="img/fishing_001.JPG" alt="">-->
                        <div class="container-slider">

                            <div class="reviews-item">
                                <h3>Антон<br>
                                    Леонидович</h3>
                                <div class="reviews-desc">
                                    <p class="reviews-data">24 марта 2017</p>
                                    <p>Для отдыха место приемлемое Близко от города дорога хорошая мобилка,
                                        интернет, рядом рынок где можно все купить. Одно пожелание.
                                        Для детей есть где поиграть Песочница, различные игрушки. Мы т
                                        ри дня там были полетели как один день Договорились с друзьями
                                        летом еще поехать</p>
                                </div>

                            </div>
                        </div>

                    </div>
                    <div class="swiper-slide" style="background-image: url(/img/fishing_002.JPG)">
                        <div class="container-slider">

                            <div class="reviews-item">
                                <h3>Антон<br>
                                    Леонидович</h3>
                                <div class="reviews-desc">
                                    <p class="reviews-data">24 марта 2017</p>
                                    <p>Для отдыха место приемлемое Близко от города дорога хорошая мобилка,
                                        интернет, рядом рынок где можно все купить. Одно пожелание.
                                        Для детей есть где поиграть Песочница, различные игрушки. Мы т
                                        ри дня там были полетели как один день Договорились с друзьями
                                        летом еще поехать</p>
                                    <p>ри дня там были полетели как один день Договорились с друзьями
                                        летом еще поехать</p>
                                </div>

                            </div>

                        </div>
                    </div>
                    <div class="swiper-slide" style="background-image: url(/img/fishing_003.JPG)">
                        <div class="container-slider">
                            <div class="reviews-item">
                                <h3>Антон<br>
                                    Леонидович</h3>
                                <div class="reviews-desc">
                                    <p class="reviews-data">24 марта 2017</p>
                                    <p>Для отдыха место приемлемое Близко от города дорога хорошая мобилка,
                                        интернет, рядом рынок где можно все купить. Одно пожелание.
                                        Для детей есть где поиграть Песочница, различные игрушки. Мы т
                                        ри дня там были полетели как один день Договорились с друзьями
                                        летом еще поехать</p>
                                </div>

                            </div>
                        </div>

                    </div>

                </div>

            </div>
            <a href="/reviews/" class="button go-to-gallery">Вся Отзывы</a>
        </div>

        <!--MAP BOX-->
        <div class="container-full box-map">
            <div class="map-title-cont">
                <div class="container"><h2>Карта</h2>
                    <button id="map_burger" class="map-burger"></button>
                </div>
            </div>
            <div class="map-frame-container">
                <div id="main_map"></div>
                <!--<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d22006.706160251855!2d30.255550632731147!3d46.412262157340784!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x40c878c41ef5c9e7%3A0xa2ce8e1f4e203d62!2z0JzQsNGP0LrQuCwg0J7QtNC10YHRgdC60LDRjyDQvtCx0LvQsNGB0YLRjA!5e0!3m2!1sru!2sua!4v1497220361767" width="100%" height="500"  scrolling="no" frameborder="0" style="border:0" allowfullscreen></iframe>-->
            </div>
        </div>
        </div>
    </main>

<?=getFooter()?>
<script src="/libs/swiper/js/swiper.jquery.min.js"></script>
<script src="/js/main_map.js"></script>
<script src="/js/main.js"></script>