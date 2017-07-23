<?php
header("HTTP/1.1 404 Not Found");
header("Status: 404 Not Found");
?>

<?php
include("application/views/head.php");
include("application/views/header.php");
$this->lang->load('404err', $current_lang);
?>
<!-- START 404 -->



<!-- END 404 -->

<?php include("application/views/footer.php"); ?>
