<?=getHead($meta)?>
<?=getHeader()?>
<?php
loadHelper(TEMPLATE);
?>
    <section id="testimonials" class="testimonials parallax dark">
        <div class="container">
            <h2 class="heading text-center">Отзывы наших клиентов</h2>
            <ul class="row">
                <?php
                if($articles){
                    foreach ($articles as $review){
                        echo getReviewBlock($review, '');
                    }
                }
                ?>


            </ul>
        </div>
    </section>

<?=getFooter()?>