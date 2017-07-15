<footer role="contentinfo">
    <div class="clearfix">
        <ul class="list-unstyled list-inline pull-left">
            <li><h6 style="margin: 0;"> &copy;
                    2016 <?= $this->config->item('cms_name') ?> <?= $this->config->item('cms_version') ?></h6></li>
        </ul>
        <button class="pull-right btn btn-link btn-xs hidden-print" id="back-to-top"><i class="fa fa-arrow-up"></i>
        </button>
    </div>
</footer>
</div>
</div>


<!---->
<!--<div class="infobar-wrapper scroll-pane">-->
<!--	<div class="infobar scroll-content">-->
<!---->
<!--		<div id="widgetarea">-->
<!---->
<!--			<div class="widget" id="widget-sparkline">-->
<!--				<div class="widget-heading">-->
<!--					<a href="javascript:;" data-toggle="collapse" data-target="#sparklinestats"><h4>Sparkline Stats</h4></a>-->
<!--				</div>-->
<!--				<div id="sparklinestats" class="collapse in">-->
<!--					<div class="widget-body">-->
<!--						<ul class="sparklinestats">-->
<!--							<li>-->
<!--								<div class="title">Earnings</div>-->
<!--								<div class="stats">$22,500</div>-->
<!--								<div class="sparkline" id="infobar-earningsstats" style="100%"></div>-->
<!--							</li>-->
<!--							<li>-->
<!--								<div class="title">Orders</div>-->
<!--								<div class="stats">4,750</div>-->
<!--								<div class="sparkline" id="infobar-orderstats" style="100%"></div>-->
<!--							</li>-->
<!--						</ul>-->
<!--						<a href="#" class="more">More Sparklines</a>-->
<!--					</div>-->
<!--				</div>-->
<!--			</div>-->
<!---->
<!--			<div class="widget">-->
<!--				<div class="widget-heading">-->
<!--					<a href="javascript:;" data-toggle="collapse" data-target="#recentactivity"><h4>Recent Activity</h4></a>-->
<!--				</div>-->
<!--				<div id="recentactivity" class="collapse in">-->
<!--					<div class="widget-body">-->
<!--						<ul class="recent-activities">-->
<!--							<li>-->
<!--								<div class="avatar">-->
<!--									<img src="http://placehold.it/300&text=Placeholder" class="img-responsive img-circle">-->
<!--								</div>-->
<!--								<div class="content">-->
<!--									<span class="msg"><a href="#" class="person">Jean Alanis</a> invited 3 unconfirmed members</span>-->
<!--									<span class="time">2 mins ago</span>-->
<!---->
<!--								</div>-->
<!--							</li>-->
<!--							<li>-->
<!--								<div class="avatar">-->
<!--									<img src="http://placehold.it/300&text=Placeholder" class="img-responsive img-circle">-->
<!--								</div>-->
<!--								<div class="content">-->
<!--									<span class="msg"><a href="#" class="person">Anthony Ware</a> is now following you</span>-->
<!--									<span class="time">4 hours ago</span>-->
<!---->
<!--								</div>-->
<!--							</li>-->
<!--							<li>-->
<!--								<div class="avatar">-->
<!--									<img src="http://placehold.it/300&text=Placeholder" class="img-responsive img-circle">-->
<!--								</div>-->
<!--								<div class="content">-->
<!--									<span class="msg"><a href="#" class="person">Bruce Ory</a> commented on <a href="#">Dashboard UI</a></span>-->
<!--									<span class="time">16 hours ago</span>-->
<!--								</div>-->
<!--							</li>-->
<!--							<li>-->
<!--								<div class="avatar">-->
<!--									<img src="http://placehold.it/300&text=Placeholder" class="img-responsive img-circle">-->
<!--								</div>-->
<!--								<div class="content">-->
<!--									<span class="msg"><a href="#" class="person">Roxann Hollingworth</a>is now following you</span>-->
<!--									<span class="time">Feb 13, 2015</span>-->
<!--								</div>-->
<!--							</li>-->
<!--						</ul>-->
<!--						<a href="#" class="more">See all activities</a>-->
<!--					</div>-->
<!--				</div>-->
<!--			</div>-->
<!---->
<!--			<div class="widget" >-->
<!--				<div class="widget-heading">-->
<!--					<a href="javascript:;" data-toggle="collapse" data-target="#widget-milestones"><h4>Milestones</h4></a>-->
<!--				</div>-->
<!--				<div id="widget-milestones" class="collapse in">-->
<!--					<div class="widget-body">-->
<!--						<div class="contextual-progress">-->
<!--							<div class="clearfix">-->
<!--								<div class="progress-title">UI Design</div>-->
<!--								<div class="progress-percentage">12/16</div>-->
<!--							</div>-->
<!--							<div class="progress">-->
<!--								<div class="progress-bar progress-bar-lime" style="width: 75%"></div>-->
<!--							</div>-->
<!--						</div>-->
<!--						<div class="contextual-progress">-->
<!--							<div class="clearfix">-->
<!--								<div class="progress-title">UX Design</div>-->
<!--								<div class="progress-percentage">8/24</div>-->
<!--							</div>-->
<!--							<div class="progress">-->
<!--								<div class="progress-bar progress-bar-orange" style="width: 33.3%"></div>-->
<!--							</div>-->
<!--						</div>-->
<!--						<div class="contextual-progress">-->
<!--							<div class="clearfix">-->
<!--								<div class="progress-title">Frontend Development</div>-->
<!--								<div class="progress-percentage">8/40</div>-->
<!--							</div>-->
<!--							<div class="progress">-->
<!--								<div class="progress-bar progress-bar-purple" style="width: 20%"></div>-->
<!--							</div>-->
<!--						</div>-->
<!--						<div class="contextual-progress m0">-->
<!--							<div class="clearfix">-->
<!--								<div class="progress-title">Backend Development</div>-->
<!--								<div class="progress-percentage">24/48</div>-->
<!--							</div>-->
<!--							<div class="progress">-->
<!--								<div class="progress-bar progress-bar-danger" style="width: 50%"></div>-->
<!--							</div>-->
<!--						</div>-->
<!--						<a href="#" class="more">See All</a>-->
<!--					</div>-->
<!--				</div>-->
<!--			</div>-->
<!---->
<!--			<div class="widget">-->
<!--				<div class="widget-heading">-->
<!--					<a href="javascript:;" data-toggle="collapse" data-target="#widget-contact"><h4>Contacts</h4></a>-->
<!--				</div>-->
<!--				<div id="widget-contact" class="collapse in">-->
<!--					<div class="widget-body">-->
<!--						<ul class="contact-list">-->
<!--							<li id="contact-1">-->
<!--								<a href="javascript:;"><img src="http://placehold.it/300&text=Placeholder" alt=""><span>Jeremy Potter</span></a>-->
<!--								<!-- <div class="contact-card contactdetails" data-child-of="contact-1">-->
<!--                                    <div class="avatar">-->
<!--                                        <img src="http://placehold.it/300&text=Placeholder" class="img-responsive img-circle">-->
<!--                                    </div>-->
<!--                                    <span class="contact-name">Jeremy Potter</span>-->
<!--                                    <span class="contact-status">Client Representative</span>-->
<!--                                    <ul class="details">-->
<!--                                        <li><a href="#"><i class="fa fa-envelope-o"></i>&nbsp;p.bateman@gmail.com</a></li>-->
<!--                                        <li><i class="fa fa-phone"></i>&nbsp;+1 234 567 890</li>-->
<!--                                        <li><i class="fa fa-map-marker"></i>&nbsp;Hollywood Hills, California</li>-->
<!--                                    </ul>-->
<!--                                </div> -->
<!--							</li>-->
<!--							<li id="contact-2">-->
<!--								<a href="javascript:;"><img src="http://placehold.it/300&text=Placeholder" alt=""><span>David Tennant</span></a>-->
<!--								<!-- <div class="contact-card contactdetails" data-child-of="contact-2">-->
<!--                                    <div class="avatar">-->
<!--                                        <img src="http://placehold.it/300&text=Placeholder" class="img-responsive img-circle">-->
<!--                                    </div>-->
<!--                                    <span class="contact-name">David Tennant</span>-->
<!--                                    <span class="contact-status">Client Representative</span>-->
<!--                                    <ul class="details">-->
<!--                                        <li><a href="#"><i class="fa fa-envelope-o"></i>&nbsp;p.bateman@gmail.com</a></li>-->
<!--                                        <li><i class="fa fa-phone"></i>&nbsp;+1 234 567 890</li>-->
<!--                                        <li><i class="fa fa-map-marker"></i>&nbsp;Hollywood Hills, California</li>-->
<!--                                    </ul>-->
<!--                                </div> -->
<!--							</li>-->
<!--							<li id="contact-3">-->
<!--								<a href="javascript:;"><img src="http://placehold.it/300&text=Placeholder" alt=""><span>Anna Johansson</span></a>-->
<!--								<!-- <div class="contact-card contactdetails" data-child-of="contact-3">-->
<!--                                    <div class="avatar">-->
<!--                                        <img src="http://placehold.it/300&text=Placeholder" class="img-responsive img-circle">-->
<!--                                    </div>-->
<!--                                    <span class="contact-name">Anna Johansson</span>-->
<!--                                    <span class="contact-status">Client Representative</span>-->
<!--                                    <ul class="details">-->
<!--                                        <li><a href="#"><i class="fa fa-envelope-o"></i>&nbsp;p.bateman@gmail.com</a></li>-->
<!--                                        <li><i class="fa fa-phone"></i>&nbsp;+1 234 567 890</li>-->
<!--                                        <li><i class="fa fa-map-marker"></i>&nbsp;Hollywood Hills, California</li>-->
<!--                                    </ul>-->
<!--                                </div> -->
<!--							</li>-->
<!--							<li id="contact-4">-->
<!--								<a href="javascript:;"><img src="http://placehold.it/300&text=Placeholder" alt=""><span>Alan Doyle</span></a>-->
<!--								<!-- <div class="contact-card contactdetails" data-child-of="contact-4">-->
<!--                                    <div class="avatar">-->
<!--                                        <img src="http://placehold.it/300&text=Placeholder" class="img-responsive img-circle">-->
<!--                                    </div>-->
<!--                                    <span class="contact-name">Alan Doyle</span>-->
<!--                                    <span class="contact-status">Client Representative</span>-->
<!--                                    <ul class="details">-->
<!--                                        <li><a href="#"><i class="fa fa-envelope-o"></i>&nbsp;p.bateman@gmail.com</a></li>-->
<!--                                        <li><i class="fa fa-phone"></i>&nbsp;+1 234 567 890</li>-->
<!--                                        <li><i class="fa fa-map-marker"></i>&nbsp;Hollywood Hills, California</li>-->
<!--                                    </ul>-->
<!--                                </div> -->
<!--							</li>-->
<!--							<li id="contact-5">-->
<!--								<a href="javascript:;"><img src="http://placehold.it/300&text=Placeholder" alt=""><span>Simon Corbett</span></a>-->
<!--								<!-- <div class="contact-card contactdetails" data-child-of="contact-5">-->
<!--                                    <div class="avatar">-->
<!--                                        <img src="http://placehold.it/300&text=Placeholder" class="img-responsive img-circle">-->
<!--                                    </div>-->
<!--                                    <span class="contact-name">Simon Corbett</span>-->
<!--                                    <span class="contact-status">Client Representative</span>-->
<!--                                    <ul class="details">-->
<!--                                        <li><a href="#"><i class="fa fa-envelope-o"></i>&nbsp;p.bateman@gmail.com</a></li>-->
<!--                                        <li><i class="fa fa-phone"></i>&nbsp;+1 234 567 890</li>-->
<!--                                        <li><i class="fa fa-map-marker"></i>&nbsp;Hollywood Hills, California</li>-->
<!--                                    </ul>-->
<!--                                </div> -->
<!--							</li>-->
<!--							<li id="contact-6">-->
<!--								<a href="javascript:;"><img src="http://placehold.it/300&text=Placeholder" alt=""><span>Polly Paton</span></a>-->
<!--								<!-- <div class="contact-card contactdetails" data-child-of="contact-6">-->
<!--                                    <div class="avatar">-->
<!--                                        <img src="http://placehold.it/300&text=Placeholder" class="img-responsive img-circle">-->
<!--                                    </div>-->
<!--                                    <span class="contact-name">Polly Paton</span>-->
<!--                                    <span class="contact-status">Client Representative</span>-->
<!--                                    <ul class="details">-->
<!--                                        <li><a href="#"><i class="fa fa-envelope-o"></i>&nbsp;p.bateman@gmail.com</a></li>-->
<!--                                        <li><i class="fa fa-phone"></i>&nbsp;+1 234 567 890</li>-->
<!--                                        <li><i class="fa fa-map-marker"></i>&nbsp;Hollywood Hills, California</li>-->
<!--                                    </ul>-->
<!--                                </div> -->
<!--							</li>-->
<!--						</ul>-->
<!--						<a href="#" class="more">See All</a>-->
<!--					</div>-->
<!--				</div>-->
<!--			</div>-->
<!--		</div>-->
<!--	</div>-->
<!--</div>-->


<!-- Switcher -->
<div class="demo-options">
    <div class="demo-options-icon"><i class="fa fa-spin fa-fw fa-smile-o"></i></div>
    <div class="demo-heading">Demo Settings</div>

    <div class="demo-body">
        <div class="tabular">
            <div class="tabular-row">
                <div class="tabular-cell">Fixed Header</div>
                <div class="tabular-cell demo-switches"><input class="bootstrap-switch" type="checkbox" checked
                                                               data-size="mini" data-on-color="success"
                                                               data-off-color="default" name="demo-fixedheader"
                                                               data-on-text="I" data-off-text="O"></div>
            </div>
            <div class="tabular-row">
                <div class="tabular-cell">Boxed Layout</div>
                <div class="tabular-cell demo-switches"><input class="bootstrap-switch" type="checkbox" data-size="mini"
                                                               data-on-color="success" data-off-color="default"
                                                               name="demo-boxedlayout" data-on-text="I"
                                                               data-off-text="O"></div>
            </div>
            <div class="tabular-row">
                <div class="tabular-cell">Collapse Leftbar</div>
                <div class="tabular-cell demo-switches"><input class="bootstrap-switch" type="checkbox" data-size="mini"
                                                               data-on-color="success" data-off-color="default"
                                                               name="demo-collapseleftbar" data-on-text="I"
                                                               data-off-text="O"></div>
            </div>
            <div class="tabular-row">
                <div class="tabular-cell">Collapse Rightbar</div>
                <div class="tabular-cell demo-switches"><input class="bootstrap-switch" type="checkbox" checked
                                                               data-size="mini" data-on-color="success"
                                                               data-off-color="default" name="demo-collapserightbar"
                                                               data-on-text="I" data-off-text="O"></div>
            </div>
            <div class="tabular-row hide" id="demo-horizicon">
                <div class="tabular-cell">Horizontal Icons</div>
                <div class="tabular-cell demo-switches"><input class="bootstrap-switch" type="checkbox" checked
                                                               data-size="mini" data-on-color="primary"
                                                               data-off-color="warning" data-on-text="S"
                                                               data-off-text="L" name="demo-horizicons"></div>
            </div>
        </div>

    </div>

    <div class="demo-body">
        <div class="option-title">Header Colors</div>
        <ul id="demo-header-color" class="demo-color-list">
            <li><span class="demo-white"></span></li>
            <li><span class="demo-black"></span></li>
            <li><span class="demo-midnightblue"></span></li>
            <li><span class="demo-primary"></span></li>
            <li><span class="demo-info"></span></li>
            <li><span class="demo-alizarin"></span></li>
            <li><span class="demo-green"></span></li>
            <li><span class="demo-violet"></span></li>
            <li><span class="demo-indigo"></span></li>
        </ul>
    </div>

    <div class="demo-body">
        <div class="option-title">Sidebar Colors</div>
        <ul id="demo-sidebar-color" class="demo-color-list">
            <li><span class="demo-white"></span></li>
            <li><span class="demo-black"></span></li>
            <li><span class="demo-midnightblue"></span></li>
            <li><span class="demo-primary"></span></li>
            <li><span class="demo-info"></span></li>
            <li><span class="demo-alizarin"></span></li>
            <li><span class="demo-green"></span></li>
            <li><span class="demo-violet"></span></li>
            <li><span class="demo-indigo"></span></li>
        </ul>
    </div>

    <div class="demo-body hide" id="demo-boxes">
        <div class="option-title">Boxed Layout Options</div>
        <ul id="demo-boxed-bg" class="demo-color-list">
            <li><span class="pattern-brickwall"></span></li>
            <li><span class="pattern-dark-stripes"></span></li>
            <li><span class="pattern-rockywall"></span></li>
            <li><span class="pattern-subtle-carbon"></span></li>
            <li><span class="pattern-tweed"></span></li>
            <li><span class="pattern-vertical-cloth"></span></li>
            <li><span class="pattern-grey_wash_wall"></span></li>
            <li><span class="pattern-pw_maze_black"></span></li>
            <li><span class="patther-wild_oliva"></span></li>
            <li><span class="pattern-stressed_linen"></span></li>
            <li><span class="pattern-sos"></span></li>
        </ul>
    </div>

</div>
<!-- /Switcher -->
<!-- Load site level scripts -->

<!-- <script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
<script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.9.2/jquery-ui.min.js"></script> -->

<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content alert-success">
            <div class="modal-header notification-info">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h2 id="modal-title" class="modal-title">Modal Title</h2>
                <div id="modal-date" class="modal-date">Modal Date</div>
            </div>

            <div id="modal-body" class="modal-body">
                <p>Modal Body</p>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->


<script type="text/javascript"
        src="<?=GENERAL_DOMAIN?>/includes/assets/js/jqueryui-1.9.2.min.js"></script>                            <!-- Load jQueryUI -->

<script type="text/javascript"
        src="<?=GENERAL_DOMAIN?>/includes/assets/js/bootstrap.min.js"></script>                                <!-- Load Bootstrap -->

<script type="text/javascript"
        src="<?=GENERAL_DOMAIN?>/includes/assets/plugins/easypiechart/jquery.easypiechart.js"></script>        <!-- EasyPieChart-->
<script type="text/javascript"
        src="<?=GENERAL_DOMAIN?>/includes/assets/plugins/sparklines/jquery.sparklines.min.js"></script>        <!-- Sparkline -->
<script type="text/javascript"
        src="<?=GENERAL_DOMAIN?>/includes/assets/plugins/jstree/dist/jstree.min.js"></script>                <!-- jsTree -->

<script type="text/javascript"
        src="<?=GENERAL_DOMAIN?>/includes/assets/plugins/codeprettifier/prettify.js"></script>                <!-- Code Prettifier  -->
<script type="text/javascript"
        src="<?=GENERAL_DOMAIN?>/includes/assets/plugins/bootstrap-switch/bootstrap-switch.js"></script>        <!-- Swith/Toggle Button -->

<script type="text/javascript"
        src="<?=GENERAL_DOMAIN?>/includes/assets/plugins/bootstrap-tabdrop/js/bootstrap-tabdrop.js"></script>  <!-- Bootstrap Tabdrop -->

<script type="text/javascript"
        src="<?=GENERAL_DOMAIN?>/includes/assets/plugins/iCheck/icheck.min.js"></script>                        <!-- iCheck -->

<script type="text/javascript"
        src="<?=GENERAL_DOMAIN?>/includes/assets/js/enquire.min.js"></script>                                    <!-- Enquire for Responsiveness -->

<script type="text/javascript"
        src="<?=GENERAL_DOMAIN?>/includes/assets/plugins/bootbox/bootbox.js"></script>                            <!-- Bootbox -->

<script type="text/javascript"
        src="<?=GENERAL_DOMAIN?>/includes/assets/plugins/nanoScroller/js/jquery.nanoscroller.min.js"></script> <!-- nano scroller -->

<script type="text/javascript"
        src="<?=GENERAL_DOMAIN?>/includes/assets/plugins/jquery-mousewheel/jquery.mousewheel.min.js"></script>    <!-- Mousewheel support needed for jScrollPane -->

<script type="text/javascript" src="<?=GENERAL_DOMAIN?>/includes/assets/js/application.js"></script>

<script>
    $(function () {
        $(".bootstrap-switch").bootstrapSwitch();
        $('.icheck input').iCheck({
            checkboxClass: 'icheckbox_minimal-blue',
            radioClass: 'iradio_minimal-blue'
        });
    });
</script>
<script type="text/javascript" src="<?=GENERAL_DOMAIN?>/includes/assets/demo/demo-switcher.js"></script>

<script type="text/javascript"
        src="<?=GENERAL_DOMAIN?>/includes/assets/plugins/pines-notify/pnotify.min.js"></script>                <!-- PNotify -->

<script type="text/javascript"
        src="<?=GENERAL_DOMAIN?>/js/admin.js"></script>                                                        <!-- Load ADMIN Functions -->
<!-- End loading site level scripts -->

<!-- Load page level scripts-->
[adding_scripts]
<?php
if (isset($adding_scripts)) echo $adding_scripts;
?>


<!-- End loading page level scripts-->
<!--<script type="text/javascript" src="/js/jquery-1.7.2.min.js"></script>-->


</body>
</html>