<div id="comments_result"></div>
<?php
$this->load->helper('comments_helper');
if(userdata('login') != false){
    ?>
    <div class="add-new-comment">
        <p>Добавить комментарий:</p>
        <textarea required="" id="comment-<?=$article['id']?>"></textarea><br /><div id="comment-error"></div>
        <input type="button" article_id="<?=$article['id']?>" id="send-comment" value="Сказать">
    </div>
    <?php
}else{
    ?>
    <div class="authorize">
        <div class="comments-authorize">Для того, чтобы оставить свой комментарий, Вам необходимо представиться:</div>
        <script src="//ulogin.ru/js/ulogin.js"></script>
        <div id="uLogin05b61546" data-ulogin="display=panel;fields=first_name,last_name,email;optional=phone,city,country,photo_big,photo,nickname,bdate,sex;verify=1;providers=google,vkontakte,odnoklassniki,facebook,mailru,yandex,twitter,livejournal,openid,lastfm,linkedin,youtube,googleplus,instagram,uid,wargaming,webmoney;hidden=liveid,soundcloud,steam,flickr,foursquare,tumblr,vimeo;redirect_uri=%2F%2F<?=$_SERVER['SERVER_NAME']?>%2Flogin%2F"></div>
    </div>
    <?php
}
?>
<div id="all-comments">
<?=getArticleComments($article['id'])?>
</div>
