<?php include("application/views/head.php"); ?>
<?php include("application/views/header.php"); ?>
    <div class="content">
        <div class="page_content">
            <div class="breadcrump">
                <span><a href="#">Главная</a></span> →
            </div>
            <div class="news_content_post">
                <div class="titlecat"><span>Поиск: <?=userdata('search')?></span></div>
                <div class="sendpost">

		<div id="cse-search-results"></div>
<script type="text/javascript">
  var googleSearchIframeName = "cse-search-results";
  var googleSearchFormName = "cse-search-box";
  var googleSearchFrameWidth = 700;
  var googleSearchDomain = "www.google.com.ua";
  var googleSearchPath = "/cse";
</script>
<script type="text/javascript" src="http://www.google.com/afsonline/show_afs_search.js"></script>

	 </div>
            </div>

        </div>
        <div class="right_sidebar page_sidebar">
            <?php include("application/views/mod/important.mod.php"); ?>
            <br /><br />
            <a href="<?=getOption('link_facebook')?>" target="_blank" rel="nofollow" class="sociala"><div class="socialbutton fbbutton"><div>Следите за новостями </div></div></a>
            <a href="<?=getOption('link_vk')?>" target="_blank" rel="nofollow" class="sociala"><div class="socialbutton vkbutton"><div>Следите за новостями</div></div></a>
        </div>
        <div class="clr"></div>
    </div>
    <?php
    if(userdata('sended') == true)
    {
        alert ('Ваша новость успешно отправлена!');
        unset_userdata('sended');
    }
    ?>
<?php include("application/views/footer.php"); ?>