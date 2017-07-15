<?php
$CI = & get_instance();
$CI->load->model('Model_pages','pages');
$page = $CI->pages->getPageByUrl('err404');
$page = translatePage($page);
$page['name'] = $page['title'] = $heading;
$keywords = $description = $title = $page['title'];
$robots = "noindex, follow";
include("application/views/head.php");
include("application/views/header.php");
?>
<div class="content-404">
	<div class="container">
	<div id="container">
		<h1><?php echo $heading; ?></h1>
		<?php echo $message; ?>
	</div>
<?php include("application/views/footer.php"); ?>