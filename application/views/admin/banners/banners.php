<?php if(isset($head)) echo $head; ?>

<!--[if lt IE 10]>
<script type="text/javascript" src="/includes/assets/js/media.match.min.js"></script>
<script type="text/javascript" src="/includes/assets/js/placeholder.min.js"></script>
<![endif]-->

<link type="text/css" hhref="/includes/assets/fonts/font-awesome/css/font-awesome.min.css"
      rel="stylesheet">        <!-- Font Awesome -->
<link type="text/css" href="/includes/assets/css/styles.css"
      rel="stylesheet">                                     <!-- Core CSS with all styles -->

<link type="text/css" href="/includes/assets/plugins/jstree/dist/themes/avenger/style.min.css"
      rel="stylesheet">    <!-- jsTree -->
<link type="text/css" href="/includes/assets/plugins/codeprettifier/prettify.css"
      rel="stylesheet">                <!-- Code Prettifier -->
<link type="text/css" href="/includes/assets/plugins/iCheck/skins/minimal/blue.css"
      rel="stylesheet">              <!-- iCheck -->

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
                        <div class="row">
                            <textarea style="display: none" placeholder="Debug Textarea" id="nestable_list_3_output"
                                      style="width:100%" rows="3" class="form-group"></textarea>
                            <div class="col-md-12">
                                <?php
                                if (isset($banner_positions) && is_array($banner_positions)) {
                                    foreach ($banner_positions as $position) {
                                        $banners = $position['banners'];

                                        ?>
                                        <div class="panel panel-primary">
                                            <div class="panel-heading"><h2><?= $position['name'] ?></h2></div>
                                            <div class="panel-body">
                                                <div class="dd" id="nestable_list_3">
                                                    <ol class="dd-list">
                                                        <?php
                                                        if ($banners){
                                                        foreach ($banners as $item){
                                                        ?>

                                                        <li id="tr-<?= $item['id'] ?>" class="dd-item dd3-item banners"
                                                            data-id="<?= $item['id'] ?>">
                                                            <div class="dd-handle dd3-handle"></div>
                                                            <div class="dd3-content">
                                                                <table class="table-banners">
                                                                    <tr>
                                                                        <td style="text-align: center">
                                                                            <img class="row-active"
                                                                                 src="<?=GENERAL_DOMAIN?>/img/admin/active-<?= $item['active'] ?>.png"
                                                                                 type="banners"
                                                                                 row_id="<?= $item['id'] ?>"
                                                                                 status="<?= $item['active'] ?>"
                                                                                 id="row-active-<?= $item['id'] ?>"
                                                                                 title="<?= ($item['active'] == 0 ? 'Активировать' : 'Деактивировать'); ?>"/>
                                                                        </td>
                                                                        <td class="td-banner-name">
                                                                            <a href="/admin/banners/edit/<?= $item['id'] ?>/">
                                                                                <div class="item-name"<?php if($item['format'] != NULL) echo ' style="background-color:'.$item['format'].';padding:5px; width: 80%; text-align: center;color:white"'; ?>>
                                                                                    <?= getLangText($item['name']) ?>
                                                                                </div>
                                                                            </a>
                                                                        </td>
                                                                        <td class="td-banner-image">
                                                                            <div class="item-image">
                                                                                <a  data-toggle="modal" href="#myModal_<?=$item['id']?>">
                                                                                <img src="<?= $item['image'] ?>"
                                                                                     title="URL: <?= $item['url'] ?>"/>
                                                                                </a>
                                                                            </div>
                                                                        </td>
                                                                        <td class="td-banner-actions">
                                                                            <div class="actions" style="float: right">

                                                                                <!--span class="element-num">(<?= $item['num'] ?>)</span-->
                                                                                <span class="nestable-action">
                            <a class="btn btn-default btn-xs btn-label"
                               href="/admin/banners/edit/<?= $item['id'] ?>/"><i
                                        class="fa fa-pencil"></i>
                                Редактировать</a>
                                </span>
                                                                                <span class="nestable-action">
                            <a id="del-<?= $item['id'] ?>" class="row-del btn btn-danger btn-xs btn-label" href="#"
                               type="banners" row_id="<?= $item['id'] ?>">
                                <i class="fa fa-trash-o"></i>Удалить
                            </a>
                                </span>
                                                                            </div>
                                                                        </td>
                                                                    </tr>
                                                                </table>
                                                            </div>
                                                            <!-- Modal -->
                                                            <div class="modal fade" id="myModal_<?=$item['id']?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                                                <div class="modal-dialog">
                                                                    <div class="modal-content">
                                                                        <div class="modal-header">
                                                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                                                            <h2 class="modal-title"><?=$item['name']?></h2>
                                                                        </div>
                                                                        <div class="modal-body">
                                                                            <img src="<?=GENERAL_DOMAIN?><?=$item['image']?>" style="max-width: 70%" /><br />
                                                                            URL: <a href="<?=$item['url']?>" target="_blank"><?=$item['url']?></a>
                                                                    </div><!-- /.modal-content -->
                                                                        <div class="modal-footer">
                                                                            <a href="/admin/banners/edit/<?=$item['id']?>/"><button type="button" class="btn btn-default">Редактировать</button></a>
                                                                                <a href="/admin/banners/del/<?=$item['id']?>/"><button type="button" class="btn btn-primary">Удалить</button></a>
                                                                        </div>
                                                                </div><!-- /.modal-dialog -->
                                                            </div><!-- /.modal -->
                                                        </li>

                                                            <?php
                                                            }
                                                            }
                                                            ?>
                                                    </ol>
                                                </div>
                                            </div>
                                        </div>
                                        <?php
                                    }
                                }
                                ?>
                            </div>
                        </div>


                    </div> <!-- .container-fluid -->
                </div> <!-- #page-content -->
            </div>
            <div id="result"></div>

            <?php
            $adding_scripts = '
<script type="text/javascript" src="/includes/assets/plugins/form-nestable/jquery.nestable.min.js"></script>
<script>
$(document).ready(function () {
//функция обновления позиций меню
    var updateOutput = function(e)
    {
    console.log(updateOutput);
        var list   = e.length ? e : $(e.target),
            output = list.data(\'output\');
        if (window.JSON) {            
            var jsonLine = window.JSON.stringify(list.nestable(\'serialize\'));
            console.log(jsonLine);
            $("#nestable_list_3_output").val(jsonLine);
            saveMenuPositions(jsonLine,"top");            
            //output.val(window.JSON.stringify(list.nestable(\'serialize\')));//, null, 2));
        } else {
            output.val(\'JSON browser support required for this demo.\');
        }
    };

    $(\'#nestable_list_3\').nestable({group: 1}).on(\'change\', updateOutput);
});
</script>
';
            if(isset($footer)) {
                $footer = str_replace('[adding_scripts]', $adding_scripts, $footer);
                echo $footer;
            }
            ?>

