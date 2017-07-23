<?=getHead()?>
<?=getHeader()?>

    <!-- LISTING -->
<section id="listings" class="padding">
    <div class="container">
        <div class="row bottom40">
            <div class="col-xs-12">
                <?php
                $name = $category['name'];
                $nameArr = explode(' ', $category['name']);
                if(isset($nameArr[1])){
                    $name = $nameArr[0];
                    $res = str_replace($nameArr[0],'',$name);
                    if($res == '') $res = $nameArr[1];
                    $name .= ' <span class="color_red">'.$res.'</span>';
                }
                ?>
                <h1 class="uppercase"><?=$name?></h1>
                <div class="line_1"></div>
                <div class="line_2"></div>
                <div class="line_3"></div>
                <p class="heading_space">Мы можем предложить Вам лучшие варианты за приемлимую стоимость!</p>
            </div>
        </div>
        <div class="row bottom30">
            <?php
            loadHelper(TEMPLATE);
            if($articles){
                foreach ($articles as $product){
                    echo getOneProductUnderConstruction($product);
                }
            } else echo 'В этом разделе пока пусто...';
            ?>

        </div>

    </div>
</section>

<?=getFooter()?>