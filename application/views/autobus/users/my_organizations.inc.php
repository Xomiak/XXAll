<?php
$myArticles = $this->model_articles->getArticlesByLogin(userdata('login'));
?>
<div class="col-md-2 hidden-sm hidden-xs">
    <div class="top-ten-section">
        <h2>Мои организации</h2>
        <ul>
            <?php
            if($myArticles){
                foreach ($myArticles as $item){
                    ?><li><a href="<?=getFullUrl($item)?>?preview"><?=$item['name']?></a></li><?php
                }
            }
            ?>
        </ul>
    </div>
</div>