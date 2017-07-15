<header class="stricky">
    <div class="container">
        <div class="logo pull-left">
            <a href="/">
                <img src="<?=$GLOBALS['logo']?>" alt="<?=$GLOBALS['site_name']?>">
            </a>
        </div>
        <nav class="mainmenu-holder pull-right">
            <div class="nav-header">
                <ul class="navigation list-inline">
                    <?php
                    loadHelper('menu');
                    $menus = getMenu('top');
                    if($menus){
                        foreach ($menus as $menu){
                            ?>
                            <li>
                                <a href="<?=$menu['url']?>"><?=$menu['name']?></a>
                            </li>
                            <?php
                        }
                    }
                    ?>

                </ul>
            </div>
        </nav>
    </div>
</header>