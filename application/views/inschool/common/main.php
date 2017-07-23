<?=getHead()?>
<?=getHeader()?>
<?php
loadHelper(TEMPLATE);
?>

    <section class="sequence-theme-wrapper">
        <div class="sequence-theme">
            <div id="sequence">


                <img class="sequence-prev" src="images/prev.png" alt="Previous Frame"/>
                <img class="sequence-next" src="images/next.png" alt="Next Frame"/>

                <ul class="sequence-canvas">
                    <li class="animate-in">
                            <?=getOption("slajd-1")?>

                        <section class="button1 buttonslider">
                            <a href="<?=getOption("ssylka-slajda-1")?>">Подробнее</a>
                        </section>
                        <img class="model" src="<?= getOption("kartinka-slajda-1") ?>" alt="Model 1"/>
                    </li>
                    <li>
                        <?=getOption("slajd-2")?>

                        <section class="button1 buttonslider">
                            <a href="<?=getOption("ssylka-slajda-2")?>">Подробнее</a>
                        </section>
                        <img class="model" src="<?= getOption("kartinka-slajda-2") ?>" alt="Model 1"/>
                    </li>
                    <li>
                        <?=getOption("slajd-3")?>

                        <section class="button1 buttonslider">
                            <a href="<?=getOption("ssylka-slajda-3")?>">Подробнее</a>
                        </section>

                        <img class="model" src="<?= getOption("kartinka-slajda-3") ?>" alt="Model 1"/>
                    </li>
                </ul>


                <div class="sequence-pagination">
                    <div class="paginationslider"></div>
                    <div class="paginationslider"></div>
                    <div class="paginationslider"></div>
                </div>

            </div>
        </div>
    </section>

    <div class="underslider">
        <?= getOption("fraza-pod-slajderom")?>
    </div>

    <div class="container">
        <div class="row">

            <?php
            $mArticles = getModel('articles');
            $articles = $mArticles->getArticlesByCategory(3, 6, 0, 1);
            if($articles){
                foreach ($articles as $article)
                    echo getFirstCources($article);
            }
            ?>

        </div>

        <div class="row">
            <div class="span6">
                <div class="columnheadline">
                    <h3><span>Последние новости</span></h3>
                </div>
             <?php
             $mArticles = getModel('articles');
             $articles = $mArticles->getArticlesByCategory(1, 3, 0, 1);
             foreach ($articles as $article){
                    echo getFirstNews($article);
             }

            ?>

            </div>


            <div class="span6">


                <div class="columnheadline">
                    <h3><span>Информация</span></h3>
                </div>


                <div class="accordion1" id="accordion2">


                    <div class="accordion-group">
                        <div class="accordion-heading">
                            <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapse1">
                                О Нас
                            </a>
                        </div>
                        <div id="collapse1" class="accordion-body collapse in">
                            <div class="accordion-inner1">
                            <?=getOption("o-nas")?>
                            </div>
                        </div>
                    </div>


                    <div class="accordion-group">
                        <div class="accordion-heading">
                            <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapse2">
                                Время работы
                            </a>
                        </div>
                        <div id="collapse2" class="accordion-body collapse">
                            <div class="accordion-inner1">
                                <?=getOption("vremja-raboty")?>
                            </div>
                        </div>
                    </div>


                    <div class="accordion-group">
                        <div class="accordion-heading">
                            <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapse3">
                                Телефоны
                            </a>
                        </div>
                        <div id="collapse3" class="accordion-body collapse">
                            <div class="accordion-inner1">
                                <?=getOption("telefony")?>
                            </div>
                        </div>
                    </div>

                    <div class="accordion-group">
                        <div class="accordion-heading">
                            <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapse4">
                                Форма обратной связи
                            </a>
                        </div>
                        <div id="collapse4" class="accordion-body collapse">
                            <div class="accordion-inner1">
                                <?=getOption("forma-obratnoj-svjazi")?>
                            </div>
                        </div>
                    </div>

                </div>


            </div><!--/span6 end-->

        </div>
    </div>
<?=getFooter()?>