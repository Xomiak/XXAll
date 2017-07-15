<?php if(isset($head)) echo $head; ?>
<?php if(isset($header)) echo $header; ?>
    <div id="wrapper">
    <div id="layout-static">
<?php if(isset($left_sidebar)) echo $left_sidebar; ?>
    <div class="static-content-wrapper">
    <div class="static-content">
        <div class="page-content">

            <div class="page-heading">
                <h1>Медиа менеджер</h1>
                <div class="options">
                    <div class="btn-toolbar">
                        <a href="<?=GENERAL_DOMAIN?>/admin/main/edit/" class="btn btn-default"><i class="fa fa-fw fa-wrench"></i></a>
                    </div>
                </div>
            </div>
            <div class="container-fluid">


                <div data-widget-group="group1">
                    <div class="info">
                        * Все файлы и папки должны быть названы ТОЛЬКО латинскими буквами и без пробелов!
                    </div>

                    <div id="ckfinder-widget"></div>

                </div>


            </div> <!-- .container-fluid -->
        </div> <!-- #page-content -->
    </div>

    <?php
    $adding_scripts = '
<script type="text/javascript" src="'.GENERAL_DOMAIN.'/includes/assets/plugins/fullcalendar/fullcalendar.min.js"></script>   				<!-- FullCalendar -->

<script type="text/javascript" src="'.GENERAL_DOMAIN.'/includes/assets/plugins/wijets/wijets.js"></script>     								<!-- Wijet -->

<script type="text/javascript" src="'.GENERAL_DOMAIN.'/includes/assets/plugins/charts-chartistjs/chartist.min.js"></script>               	<!-- Chartist -->
<script type="text/javascript" src="'.GENERAL_DOMAIN.'/includes/assets/plugins/charts-chartistjs/chartist-plugin-tooltip.js"></script>    	<!-- Chartist -->

<script type="text/javascript" src="'.GENERAL_DOMAIN.'/includes/assets/plugins/form-daterangepicker/moment.min.js"></script>              	<!-- Moment.js for Date Range Picker -->
<script type="text/javascript" src="'.GENERAL_DOMAIN.'/includes/assets/plugins/form-daterangepicker/daterangepicker.js"></script>     				<!-- Date Range Picker -->

<script type="text/javascript" src="'.GENERAL_DOMAIN.'/includes/assets/demo/demo-index.js"></script> 										<!-- Initialize scripts for this page-->

<script>
	//Fix since CKEditor can\'t seem to find it\'s own relative basepath
	CKEDITOR_BASEPATH  =  "'.GENERAL_DOMAIN.'/includes/assets/plugins/form-ckeditor/";
	
</script>
<script type="text/javascript" src="'.GENERAL_DOMAIN.'/includes/assets/plugins/form-ckeditor/ckeditor.js"></script>  	<!-- CKEditor -->

  	<!-- CKFinder -->
';
    ?>
    <!--    <script src="//cdn.ckeditor.com/4.5.10/full-all/ckeditor.js"></script>-->
    <script type="text/javascript" src="<?=GENERAL_DOMAIN?>/includes/assets/plugins/form-ckeditor/ckfinder/ckfinder.js"></script>

    <script>
        $(document).ready(function () {
            CKFinder.widget( 'ckfinder-widget', {
                width: '100%',
                height: 700
            } );
        });
    </script>

<?php
if(isset($footer)) {
    $footer = str_replace('[adding_scripts]', $adding_scripts, $footer);
    echo $footer;
}
?>