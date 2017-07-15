<?php include("application/views/head.php"); ?>
<?php include("application/views/header.php"); ?>
<div class="container">
<div class="contant">

    <h1>Карта сайта</h1>
    <p class="sitemap"><a href="/"><?= $this->lang->line('header_breadcrumbs_main') ?></a></p>
<?php
if($categories)
{
    $count = 0;
    while(isset($categories[$count]))
    {
        $category = $categories[$count];
        
        echo '<p class="sitemap_category" style="padding:0;"><a href="/'.$category['url'].'/">'.getLangText($category['name']).'</a></p>';
        
        $articles = $this->articles->getArticlesByCategory($category['id']);
        $acount = count($articles);
        for($i = 0; $i < $acount; $i++)
        {
            $article = $articles[$i];
            
            echo '<p class="sitemap_article"><a href="/'.$category['url'].'/'.$article['url'].'/">'.getLangText($article['name']).'</a></p>';
        }
        
        $count++;
    }
}
?>

	<!--p class="sitemap"></p>
    <p class="sitemap" style="padding-bottom: 0px !important;"><a href="/gallery/">Фотогалерея</a></p-->
    <?php
/*if($gallery)
{
    $count = 0;
    while(isset($gallery[$count]))
    {
        $category = $gallery[$count];
        
        echo '<p class="article_sitemap"><a href="/gallery/'.$category['url'].'/">'.$category['name'].'</a>';
        
        $count++;
    }
}*/
?>
    <p class="sitemap"></p>
<?php
if($pages)
{
    $count = 0;
    while(isset($pages[$count]))
    {
        $page = $pages[$count];
        if($page['url'] !== 'err404')
        {
            ?>
            <p class="sitemap_static_page" style="padding-bottom: 0px !important;"><a href="/<?=$page['url']?>/"><?=getLangText($page['name'])?></a></p>
            <?php
        }
        $count++;
    }
}
?>
    
    
</div>
	
</div>
<?php include("application/views/footer.php"); ?>