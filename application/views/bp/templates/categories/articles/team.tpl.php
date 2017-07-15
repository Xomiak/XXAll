<?=getHead($meta)?>
<?=getHeader()?>

    <section id="team" class="team">
        <div class="container">
            <h2 class="heading text-center">Наша команда</h2>
            <div class="container">
                <div class="row ">

                    <!-- class col-md-4 col-sm-4 col-xs-12 -->
                    <?php

                    loadHelper(TEMPLATE);
                    if($articles){
                        foreach ($articles as $value){
                            echo getTeamBlock($value,'col-md-4 col-sm-4 col-xs-12');
                        }
                    }
                    //vd($team);
                    ?>
                </div>
            </div>
        </div>
    </section>

<?=getFooter()?>