<?php
ob_start();
echo '<?xml version="1.0" encoding="UTF-8"?>';
?>

    <urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
        <url>
            <loc>http://<?=$_SERVER['SERVER_NAME']?>/</loc>
            <lastmod><?php echo date('c', time()); ?></lastmod>
            <changefreq>always</changefreq>
            <priority>1</priority>
        </url>

        <?php
        if(isset($languages)){
            foreach ($languages as $language){
                if($language['code'] != $GLOBALS['default_lang']) {
                    ?>
                    <url>
                        <loc>http://<?= $_SERVER['SERVER_NAME'] ?>/?lang=<?= $language['code'] ?></loc>
                        <lastmod><?php echo date('c', time()); ?></lastmod>
                        <changefreq>always</changefreq>
                        <priority>1</priority>
                    </url>
                    <?php
                }
            }
        }

        if($categories)
        {
            $count = 0;
            while(isset($categories[$count]))
            {
                $category = $categories[$count];
                if($category['robots'] == 'index, follow') {
                    ?>
                    <url>
                        <loc>http://<?= $_SERVER['SERVER_NAME'] ?><?= getFullUrl($category) ?></loc>
                        <lastmod><?php echo date('c', time()); ?></lastmod>
                        <changefreq>always</changefreq>
                        <priority>0.9</priority>
                    </url>
                    <?php
                    if(isset($languages)){
                        foreach ($languages as $language){
                            if($language['code'] != $GLOBALS['default_lang']) {
                                ?>
                                <url>
                                    <loc>http://<?= $_SERVER['SERVER_NAME'] ?><?= getFullUrl($category) ?>?lang=<?=$language['code']?></loc>
                                    <lastmod><?php echo date('c', time()); ?></lastmod>
                                    <changefreq>always</changefreq>
                                    <priority>0.9</priority>
                                </url>
                                <?php
                            }
                        }
                    }
                }
                $count++;
            }
        }

        if($subcategories)
        {
            $count = 0;
            while(isset($subcategories[$count]))
            {
                $category = $subcategories[$count];
                if($category['robots'] == 'index, follow') {
                    ?>
                    <url>
                        <loc>http://<?= $_SERVER['SERVER_NAME'] ?><?= getFullUrl($category) ?></loc>
                        <lastmod><?php echo date('c', time()); ?></lastmod>
                        <changefreq>always</changefreq>
                        <priority>0.8</priority>
                    </url>
                    <?php
                    if(isset($languages)){
                        foreach ($languages as $language){
                            if($language['code'] != $GLOBALS['default_lang']) {
                                ?>
                                <url>
                                    <loc>http://<?= $_SERVER['SERVER_NAME'] ?><?= getFullUrl($category) ?>?lang=<?=$language['code']?></loc>
                                    <lastmod><?php echo date('c', time()); ?></lastmod>
                                    <changefreq>always</changefreq>
                                    <priority>0.8</priority>
                                </url>
                                <?php
                            }
                        }
                    }
                }
                $count++;
            }
        }

        if($pages)
        {
            $count = 0;
            while(isset($pages[$count]))
            {
                $page = $pages[$count];
                if($page['robots'] == 'index, follow') {
                    ?>
                    <url>
                        <loc>http://<?= $_SERVER['SERVER_NAME'] ?>/<?= $page['url'] ?>/</loc>
                        <lastmod><?php echo date('c', time()); ?></lastmod>
                        <changefreq>always</changefreq>
                        <priority>0.9</priority>
                    </url>
                    <?php
                    if(isset($languages)){
                        foreach ($languages as $language){
                            if($language['code'] != $GLOBALS['default_lang']) {
                                ?>
                                <url>
                                    <loc>http://<?= $_SERVER['SERVER_NAME'] ?>/<?= $page['url'] ?>/?lang=<?=$language['code']?></loc>
                                    <lastmod><?php echo date('c', time()); ?></lastmod>
                                    <changefreq>always</changefreq>
                                    <priority>0.9</priority>
                                </url>
                                <?php
                            }
                        }
                    }
                }
                $count++;
            }
        }

        if($articles)
        {
            $count = 0;
            while(isset($articles[$count]))
            {
                $article = $articles[$count];
                if($article['robots'] == 'index, follow') {
                    $category = $this->categories->getCategoryById($article['category_id']);
                    $lastmod = time();
                    $dtarr = explode(' ', $article['date']);
                    if(isset($dtarr[0]) && isset($dtarr[1])){
                        $date = $dtarr[0];
                        $time = $dtarr[1];

                        $darr = explode('-', $date);
                        //vd($darr);
                        $tarr = explode(':', $time);
                        //vd($tarr);
                        if(is_array($darr) && is_array($tarr) && count($darr) == 3 && count($tarr) == 2)
                            $lastmod = mktime($tarr[0],$tarr[1],0,$darr[1],$darr[2],$darr[0]);
                    }

                    ?>
                    <url>
                        <loc>http://<?= $_SERVER['SERVER_NAME'] ?><?= getFullUrl($article) ?></loc>
                        <lastmod><?php echo date('c', $lastmod); ?></lastmod>
                        <changefreq>always</changefreq>
                        <priority>0.8</priority>
                    </url>
                    <?php
                    if(isset($languages)){
                        foreach ($languages as $language){
                            if($language['code'] != $GLOBALS['default_lang']) {
                                ?>
                                <url>
                                    <loc>http://<?= $_SERVER['SERVER_NAME'] ?><?= getFullUrl($article) ?>?lang=<?=$language['code']?></loc>
                                    <lastmod><?php echo date('c', $lastmod); ?></lastmod>
                                    <changefreq>always</changefreq>
                                    <priority>0.8</priority>
                                </url>
                                <?php
                            }
                        }
                    }
                }
                $count++;
            }
        }

        ?>
    </urlset>
<?php
$data = ob_get_clean();
file_put_contents('sitemap.xml', $data);

if(!isset($_GET['cron'])) {
    header("Content-type: text/xml");
    echo $data;
}