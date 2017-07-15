<?php if(isset($head)) echo $head; ?>
<?php if(isset($header)) echo $header; ?>
<?php
//include("application/views/admin/common/head.php");
//include("application/views/admin/common/header.php");
?>
    <div id="wrapper">
    <div id="layout-static">
<?php if(isset($left_sidebar)) echo $left_sidebar; ?>
    <div class="static-content-wrapper">
        <div class="static-content">
            <div class="page-content">

                <div class="page-heading">
                    <h1>Панель администратора</h1>
                    <div class="options">
                        <div class="btn-toolbar">
                            <a href="/admin/main/edit/" class="btn btn-default"><i class="fa fa-fw fa-wrench"></i></a>
                        </div>
                    </div>
                </div>
                <div class="container-fluid">


                    <div data-widget-group="group1">

                    <div class="row">
                        <h2>Приветствую тебя, о великий <?=$user['name']?> <?=$user['lastname']?>!</h2>
                        <p>Мой Повелитель, я храню для тебя все твои пометки!</p>
                        <div id="result"></div>
                        <textarea class="form-control ckeditor" name="notes" id="my_notes"><?=$user['notes']?></textarea>
                        <button class="btn btn-default btn-block" id="save_notes">Сохранить</button>
                    </div>
                    <div class="row">
                        <div id="ping_result"></div>
                        <input class="form-control" id="inp_url">
                        <button class="btn btn-default btn-block" id="ping_test">PING</button>
                    </div>

                        <div class="row">
                            <div id="editor1"></div>
                            <button class="btn btn-default btn-block" id="test">TEST</button>
                        </div>

                    <script>

                    </script>

<!--                        <div class="row">-->
<!--                            <div class="col-md-3">-->
<!--                                <div class="amazo-tile tile-success">-->
<!--                                    <div class="tile-heading">-->
<!--                                        <div class="title">Revenue</div>-->
<!--                                        <div class="secondary">past 28 days</div>-->
<!--                                    </div>-->
<!--                                    <div class="tile-body">-->
<!--                                        <div class="content">$75,800</div>-->
<!--                                    </div>-->
<!--                                    <div class="tile-footer">-->
<!--                                        <span class="info-text text-right">13.4% <i class="fa fa-level-up"></i></span>-->
<!--                                        <div id="sparkline-revenue" class="sparkline-line"></div>-->
<!--                                    </div>-->
<!--                                </div>-->
<!--                            </div>-->
<!--                            <div class="col-md-3">-->
<!--                                <div class="amazo-tile tile-info" href="#">-->
<!--                                    <div class="tile-heading">-->
<!--                                        <div class="title">Goals</div>-->
<!--                                        <div class="secondary">orders this month</div>-->
<!--                                    </div>-->
<!--                                    <div class="tile-body">-->
<!--                                        <div class="content">3,690</div>-->
<!--                                    </div>-->
<!--                                    <div class="tile-footer">-->
<!--                                        <span class="info-text text-right">82% of 4,500</span>-->
<!--                                        <div class="progress">-->
<!--                                            <div class="progress-bar" style="width: 82%"></div>-->
<!--                                        </div>-->
<!--                                    </div>-->
<!--                                </div>-->
<!--                            </div>-->
<!---->
<!--                            <div class="col-md-3">-->
<!--                                <div class="amazo-tile tile-white">-->
<!--                                    <div class="tile-heading">-->
<!--                                        <div class="title">Items</div>-->
<!--                                        <div class="secondary">past 28 days</div>-->
<!--                                    </div>-->
<!--                                    <div class="tile-body">-->
<!--                                        <span class="content">407</span>-->
<!--                                    </div>-->
<!--                                    <div class="tile-footer text-center">-->
<!--                                        <span class="info-text text-right" style="color: #f04743">13.4% <i-->
<!--                                                class="fa fa-level-down"></i></span>-->
<!--                                        <div id="sparkline-item" class="sparkline-bar"></div>-->
<!--                                    </div>-->
<!--                                </div>-->
<!--                            </div>-->
<!---->
<!---->
<!--                            <div class="col-md-3">-->
<!--                                <div class="amazo-tile tile-white">-->
<!--                                    <div class="tile-heading">-->
<!--                                        <span class="title">Commision</span>-->
<!--                                        <span class="secondary">past 28 days</span>-->
<!--                                    </div>-->
<!--                                    <div class="tile-body">-->
<!--                                        <span class="content">$9,500</span>-->
<!--                                    </div>-->
<!--                                    <div class="tile-footer">-->
<!--                                        <span class="info-text text-right" style="color: #94c355">9.2% <i-->
<!--                                                class="fa fa-level-up"></i></span>-->
<!--                                        <div id="sparkline-commission" class="sparkline"></div>-->
<!--                                    </div>-->
<!--                                </div>-->
<!--                            </div>-->
<!--                        </div>-->

<!--                        <div class="row">-->
<!--                            <div class="col-md-12">-->
<!--                                <div class="panel panel-default demo-dashboard-graph" data-widget=''>-->
<!--                                    <div class="panel-heading">-->
<!--                                        <div class="panel-ctrls button-icon-bg"-->
<!--                                             data-actions-container=""-->
<!--                                             data-action-collapse='{"target": ".panel-body"}'-->
<!--                                             data-action-expand=''-->
<!--                                             data-action-colorpicker=''-->
<!--                                             data-action-refresh='{"type": "circular"}'-->
<!--                                             data-action-close=''-->
<!--                                        >-->
<!--                                        </div>-->
<!--                                        <h2>-->
<!--                                            <ul class="nav nav-tabs" id="chartist-tab">-->
<!--                                                <li><a href="#tab-visitor" data-toggle="tab"><i-->
<!--                                                            class="fa fa-user visible-xs"></i><span class="hidden-xs">Visitor Stats</span></a>-->
<!--                                                </li>-->
<!--                                                <li class="active"><a href="#tab-revenues" data-toggle="tab"><i-->
<!--                                                            class="fa fa-bar-chart-o visible-xs"></i><span-->
<!--                                                            class="hidden-xs">Revenues</span></a></li>-->
<!--                                            </ul>-->
<!--                                        </h2>-->
<!--                                    </div>-->
<!--                                    <div class="panel-editbox" data-widget-controls=""></div>-->
<!--                                    <div class="panel-body">-->
<!--                                        <div class="tab-content">-->
<!--                                            <div class="clearfix mb-md">-->
<!--                                                <button class="btn btn-default pull-left" id="daterangepicker2">-->
<!--                                                    <i class="fa fa-calendar visible-xs"></i>-->
<!--									<span class="hidden-xs" style="text-transform: uppercase;"> - <b class="caret"></b>-->
<!--                                                </button>-->
<!---->
<!--                                                <div class="btn-toolbar pull-right">-->
<!--                                                    <div class="btn-group">-->
<!--                                                        <a href='#' class="btn btn-default dropdown-toggle"-->
<!--                                                           data-toggle='dropdown'><i-->
<!--                                                                class="fa fa-cloud-download visible-xs"></i><span-->
<!--                                                                class="hidden-xs">Export as </span> <span-->
<!--                                                                class="caret"></span></a>-->
<!--                                                        <ul class="dropdown-menu">-->
<!--                                                            <li><a href="#">Text File (*.txt)</a></li>-->
<!--                                                            <li><a href="#">Excel File (*.xlsx)</a></li>-->
<!--                                                            <li><a href="#">PDF File (*.pdf)</a></li>-->
<!--                                                        </ul>-->
<!--                                                    </div>-->
<!--                                                </div>-->
<!--                                            </div>-->
<!--                                            <div id="tab-visitor" class="tab-pane">-->
<!--                                                <div class="demo-chartist" id="chart1"></div>-->
<!--                                            </div>-->
<!--                                            <div id="tab-revenues" class="tab-pane active">-->
<!--                                                <div class="demo-chartist-sales" id="chart2"></div>-->
<!--                                            </div>-->
<!--                                        </div>-->
<!--                                    </div>-->
<!--                                </div>-->
<!--                            </div>-->
<!--                        </div>-->

<!--                        <div class="row">-->
<!--                            <div class="col-sm-4">-->
<!--                                <div class="tile-sparkline">-->
<!--                                    <div class="tile-sparkline-heading clearfix">-->
<!--                                        <div class="pull-left">-->
<!--                                            <h2 class="block">9,172</h2>-->
<!--                                            <span class="tile-sparkline-subheading block">Page Views <span-->
<!--                                                    class="text-muted">This week</span></span class="block">-->
<!--                                        </div>-->
<!--                                        <div class="pull-right">-->
<!--                                            <span class="label label-success">+121%</span>-->
<!--                                        </div>-->
<!--                                    </div>-->
<!--                                    <div class="tile-sparkline-body">-->
<!--                                        <div id="tiles-sparkline-stats-pageviews"></div>-->
<!--                                        <div class="tabular">-->
<!--                                            <div class="tabular-row">-->
<!--                                                <div class="tabular-cell">-->
<!--                                                    <div class="week-day sun">S</div>-->
<!--                                                </div>-->
<!--                                                <div class="tabular-cell">-->
<!--                                                    <div class="week-day mon">M</div>-->
<!--                                                </div>-->
<!--                                                <div class="tabular-cell">-->
<!--                                                    <div class="week-day tue">T</div>-->
<!--                                                </div>-->
<!--                                                <div class="tabular-cell">-->
<!--                                                    <div class="week-day wed">W</div>-->
<!--                                                </div>-->
<!--                                                <div class="tabular-cell">-->
<!--                                                    <div class="week-day thu">T</div>-->
<!--                                                </div>-->
<!--                                                <div class="tabular-cell">-->
<!--                                                    <div class="week-day fri">F</div>-->
<!--                                                </div>-->
<!--                                                <div class="tabular-cell">-->
<!--                                                    <div class="week-day sat">S</div>-->
<!--                                                </div>-->
<!--                                            </div>-->
<!--                                        </div>-->
<!--                                    </div>-->
<!--                                    <div class="tile-sparkline-footer">-->
<!--                                        <a href="#">Go to analytics</a>-->
<!--                                    </div>-->
<!--                                </div>-->
<!--                            </div>-->
<!--                            <div class="col-sm-4">-->
<!--                                <div class="tile-sparkline">-->
<!--                                    <div class="tile-sparkline-heading clearfix">-->
<!--                                        <div class="pull-left">-->
<!--                                            <h2 class="block">$19,501</h2>-->
<!--                                            <span class="tile-sparkline-subheading block">Total Sales <span-->
<!--                                                    class="text-muted">This week</span></span class="block">-->
<!--                                        </div>-->
<!--                                        <div class="pull-right">-->
<!--                                            <span class="label label-danger">-37%</span>-->
<!--                                        </div>-->
<!--                                    </div>-->
<!--                                    <div class="tile-sparkline-body">-->
<!--                                        <div id="tiles-sparkline-stats-totalsales"></div>-->
<!--                                        <div class="tabular">-->
<!--                                            <div class="tabular-row">-->
<!--                                                <div class="tabular-cell">-->
<!--                                                    <div class="week-day sun">S</div>-->
<!--                                                </div>-->
<!--                                                <div class="tabular-cell">-->
<!--                                                    <div class="week-day mon">M</div>-->
<!--                                                </div>-->
<!--                                                <div class="tabular-cell">-->
<!--                                                    <div class="week-day tue">T</div>-->
<!--                                                </div>-->
<!--                                                <div class="tabular-cell">-->
<!--                                                    <div class="week-day wed">W</div>-->
<!--                                                </div>-->
<!--                                                <div class="tabular-cell">-->
<!--                                                    <div class="week-day thu">T</div>-->
<!--                                                </div>-->
<!--                                                <div class="tabular-cell">-->
<!--                                                    <div class="week-day fri">F</div>-->
<!--                                                </div>-->
<!--                                                <div class="tabular-cell">-->
<!--                                                    <div class="week-day sat">S</div>-->
<!--                                                </div>-->
<!--                                            </div>-->
<!--                                        </div>-->
<!--                                    </div>-->
<!--                                    <div class="tile-sparkline-footer">-->
<!--                                        <a href="#">Go to accounts</a>-->
<!--                                    </div>-->
<!--                                </div>-->
<!--                            </div>-->
<!--                            <div class="col-sm-4">-->
<!--                                <div class="widget-weather">-->
<!--                                    <div class="weather-heading">-->
<!--                                        <div class="weather-heading-top">-->
<!--                                            <h4 class="pull-left m-n">Cloudy</h4>-->
<!--                                            <a class="weather-settings pull-right"-->
<!--                                               style="line-height:25px; height: 25px; width: 25px;"><i-->
<!--                                                    class="fa fa-wrench"></i></a>-->
<!--                                        </div><!-- weather-heading-top -->
<!--                                        <div class="weather-heading-bottom">-->
<!--                                            <div class="weather-symbol pull-left"><i class="fa fa-cloud"></i></div>-->
<!--                                            <div class="pull-right">-->
<!--                                                <h1 class="weather-result">41°-->
<!--									<span class="weather-details">-->
<!--										<h4>Today</h4>-->
<!--										<p>Cloudy</p>-->
<!--										<p class="degree-range">42°-34°</p>-->
<!--									</span><!-- weather-details -->
<!--                                                </h1><!-- weather-result -->
<!--                                            </div>-->
<!--                                        </div><!-- weather-heading-bottom -->
<!--                                    </div><!-- weather-heading -->
<!--                                    <div class="weather-body">-->
<!--                                        <div class="col-sm-6">-->
<!--                                            <div class="input-group location-search">-->
<!--						      <span class="input-group-btn">-->
<!--						        <button class="btn btn-default" type="button"><i class="fa fa-search"></i></button>-->
<!--						      </span>-->
<!--                                                <input type="text" class="form-control" placeholder="Location">-->
<!--                                            </div><!-- /input-group -->
<!--                                        </div><!-- /.col-lg-6 -->
<!--                                        <div class="location-name pull-right">-->
<!--                                            <p><span>London,</span><br>United Kindom</p>-->
<!--                                        </div>-->
<!--                                    </div><!-- weather-body -->
<!--                                    <div class="weather-footer">-->
<!--                                        <div class="day-list">-->
<!--                                            <ul>-->
<!--                                                <li>-->
<!--                                                    <p><i class="fa fa-sun-o"></i></p>-->
<!--                                                    <p>Sat</p>-->
<!--                                                </li>-->
<!--                                                <li>-->
<!--                                                    <p><i class="fa fa-cloud"></i></p>-->
<!--                                                    <p>Sun</p>-->
<!--                                                </li>-->
<!--                                                <li>-->
<!--                                                    <p><i class="fa fa-bolt"></i></p>-->
<!--                                                    <p>Mon</p>-->
<!--                                                </li>-->
<!--                                                <li>-->
<!--                                                    <p><i class="fa fa-bolt"></i></p>-->
<!--                                                    <p>Tue</p>-->
<!--                                                </li>-->
<!--                                                <li>-->
<!--                                                    <p><i class="fa fa-cloud"></i></p>-->
<!--                                                    <p>Wed</p>-->
<!--                                                </li>-->
<!--                                                <li>-->
<!--                                                    <p><i class="fa fa-sun-o"></i></p>-->
<!--                                                    <p>Thu</p>-->
<!--                                                </li>-->
<!--                                            </ul>-->
<!--                                        </div>-->
<!--                                    </div><!-- weather-footer -->
<!--                                </div><!-- widget-weather -->
<!--                            </div>-->
<!--                        </div>-->

                        <div class="row">
                            <?php
//                            if(isset($modules['todo_list']) || $modules == false)
                                //adminShowTodoList(userdata('login'));
 //                           if(isset($modules['calendar']) || $modules == false)
                                //adminShowCalendar(userdata('login'));
                            ?>

                            
                        </div>

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
	//CKEDITOR_BASEPATH  =  "/includes/assets/plugins/form-ckeditor/";
	
</script>
<script type="text/javascript" src="'.GENERAL_DOMAIN.'/includes/assets/plugins/form-ckeditor/ckeditor.js"></script>  	<!-- CKEditor -->

  	<!-- CKFinder -->
';
?>
<!--    <script src="//cdn.ckeditor.com/4.5.10/full-all/ckeditor.js"></script>-->
    <script type="text/javascript" src="'.GENERAL_DOMAIN.'/includes/assets/plugins/form-ckeditor/ckfinder/ckfinder.js"></script>
    <script>
        // Note: in this sample we use CKEditor with two extra plugins:
        // - uploadimage to support pasting and dragging images,
        // - image2 (instead of image) to provide images with captions.
        // Additionally, the CSS style for the editing area has been slightly modified to provide responsive images during editing.
        // All these modifications are not required by CKFinder, they just provide better user experience.

    </script>

    <script>
        $(document).ready(function () {
            if ( typeof CKEDITOR !== 'undefined' ) {
                CKEDITOR.addCss( 'img {max-width:100%; height: auto;}' );
                var editor = CKEDITOR.replace( 'my_notes', {
                    extraPlugins: 'uploadimage,image2,codemirror',
                    removePlugins: 'image',
                    height:350
                } );
                CKFinder.setupCKEditor( editor );
            } else {
                document.getElementById( 'editor1' ).innerHTML = '<div class="tip-a tip-a-alert">This sample requires working Internet connection to load CKEditor from CDN.</div>'
            }
    </script>

<?php
if(isset($footer)) {
    $footer = str_replace('[adding_scripts]', $adding_scripts, $footer);
    echo $footer;
}
?>