<?=getHead($meta)?>
<?=getHeader()?>
<?php
loadHelper(TEMPLATE);
?>

<div class="pageheadline">

    <div class="container">
        <div class="row">
            <div class="span6">

                <h1><?= $category['name'] ?></h1>
                <?= getBreadcrumbs() ?>
            </div>

            <div class="span6">

                <ul class="ch-grid1">
                    <li>
                        <div class="ch-item ch-img-1">

                        </div>
                    </li>

                    <li>
                        <div class="ch-item ch-img-2">

                        </div>
                    </li>

                    <li>
                        <div class="ch-item ch-img-3">

                        </div>
                    </li>
                </ul>
            </div>

        </div>
    </div>

</div>


<div class="container">
    <div class="row">
        <div class="row"><!--/one row-->
            <?php
            if($articles){
                foreach ($articles as $article){
                    echo  getCourceItem($article);
                }
            }
            ?>
        </div>
    </div>
</div>

<?=getFooter()?>
