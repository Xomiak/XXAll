<?php if(isset($head)) echo $head; ?>

    <!--[if lt IE 10]>
    <script type="text/javascript" src="/includes/assets/js/media.match.min.js"></script>
    <script type="text/javascript" src="/includes/assets/js/placeholder.min.js"></script>
    <![endif]-->

    <link type="text/css" hhref="/includes/assets/fonts/font-awesome/css/font-awesome.min.css" rel="stylesheet">        <!-- Font Awesome -->
    <link type="text/css" href="/includes/assets/css/styles.css" rel="stylesheet">                                     <!-- Core CSS with all styles -->

    <link type="text/css" href="/includes/assets/plugins/jstree/dist/themes/avenger/style.min.css" rel="stylesheet">    <!-- jsTree -->
    <link type="text/css" href="/includes/assets/plugins/codeprettifier/prettify.css" rel="stylesheet">                <!-- Code Prettifier -->
    <link type="text/css" href="/includes/assets/plugins/iCheck/skins/minimal/blue.css" rel="stylesheet">              <!-- iCheck -->

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries. Placeholdr.js enables the placeholder attribute -->
    <!--[if lt IE 9]>
    <link type="text/css" href="/includes/assets/css/ie8.css" rel="stylesheet">
    <script type="text/javascript" src="http://cdnjs.cloudflare.com/ajax/libs/respond.js/1.1.0/respond.min.js"></script>
    <script type="text/javascript" src="/includes/assets/plugins/charts-flot/excanvas.min.js"></script>
    <script type="text/javascript" src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->

    <!-- The following CSS are included as plugins and can be removed if unused-->

    <link type="text/css" href="/includes/assets/plugins/form-nestable/jquery.nestable.css" rel="stylesheet">
<?php if(isset($header)) echo $header; ?>
    <div id="wrapper">
    <div id="layout-static">
        <?php if(isset($left_sidebar)) echo $left_sidebar; ?>
    <div class="static-content-wrapper">
    <div class="static-content">
        <div class="page-content">
            <ol class="breadcrumb">

                <li><a href="/">Главная</a></li>
                <li class="active"><a href="<?= $_SERVER['REQUEST_URI'] ?>"><?= $title ?></a></li>

            </ol>
            <div class="page-heading">
                <h1><?= $title ?></h1>
                <div class="options">
                    <div class="btn-toolbar">
                        <a href="#" class="btn btn-default"><i class="fa fa-fw fa-wrench"></i></a>
                    </div>
                </div>
            </div>
            <?php include(X_PATH.'/application/views/admin/'.$type.'/menu.inc.php'); ?>
            <div class="container-fluid">
                <?php
                if($mp){
                    foreach ($mp as $item){
                        $menu = $this->mp->getMenuByPosition($item['position'],-1,true);
                        ?>
                        <div class="row">
                            <textarea style="display: none" placeholder="Debug Textarea" id="nestable_list_3_output" style="width:100%" rows="3" class="form-group"></textarea>
                            <div class="col-md-12">
                                <div class="panel panel-primary">
                                    <div class="panel-heading"><h2><?=$item['name']?></h2></div>
                                    <div class="panel-body">
                                        <div class="dd" id="nestable_list_3">
                                            <ol class="dd-list">
                                                <?php
                                                $adminMenusTree = new AdminElementsTree('menu');
                                                echo $adminMenusTree->createTreeForMenusPageNew($menu, 0, '', 1, false);
                                                ?>

                                            </ol>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php
                    }
                }
                ?>




            </div> <!-- .container-fluid -->
        </div> <!-- #page-content -->
    </div>
    <div id="result"></div>
        <?php
        $adding_scripts = '';
        if(isset($footer)) {
            $footer = str_replace('[adding_scripts]', $adding_scripts, $footer);
            echo $footer;
        }
        ?>
