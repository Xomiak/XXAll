<?=getHead($meta)?>
<?=getHeader()?>

    <main class="">
    <div class="container-full page">
    <!--<img src="img/reviews.png"
         srcset="img/reviews@2x.png 2x,
         img/reviews@3x.png 3x"
         class="Layer-1">-->

    <div class="reviews-container">
        <h1 class="main-title"><?=$page['name']?></h1>
        <div class="line-box reviews-box">

        </div>
    </div>
    <div class="container reviews-list">
        <?php
        if($page['content'] == '') $page['content'] = '<string>Страница в стадии разработки!!!</string>';
        ?>
        <?=$page['content']?>
    </div>



    </main>

<?=getFooter()?>