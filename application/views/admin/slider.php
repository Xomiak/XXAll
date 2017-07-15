<?php if(isset($head)) echo $head; ?>
<?php if(isset($header)) echo $header; ?>

<?php
include(X_PATH."/application/views/admin/common/header.php");
?>
<div id="wrapper">
    <div id="layout-static">
        <?php include(X_PATH."/application/views/admin/common/left_sidebar.php"); ?>
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
                    <div class="container-fluid">

                        <div class="row">
                            <div class="col-md-12">
                                <iframe class="box" width="100%" height="700px"
                                        src="<?=GENERAL_DOMAIN?>/includes/revslider/index.php?c=account&m=login&username=admin&password=123qweasdzxc&from_admin=true"></iframe>
                            </div>
                        </div>
                    </div>
                </div>

            </div> <!-- .container-fluid -->
        </div> <!-- #page-content -->
    </div>
    <div id="result"></div>

<?php
$adding_scripts = "";
if(isset($footer)) {
    $footer = str_replace('[adding_scripts]', $adding_scripts, $footer);
    echo $footer;
}
?>