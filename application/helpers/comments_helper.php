<?php if (!defined('BASEPATH'))
    exit('No direct script access allowed');
//$CI = & get_instance();

function getComment($comment, $user = false, $replyTo = true, $dontReplyButton = false)
{
    ob_start();
    ?>
    <li>
        <div class="comment-box">
            <img alt="<?= $user['name'] ?>"
                 src="<?= ($user['avatar'] != '') ? $user['avatar'] : "/img/no_ava.png" ?>">
            <div class="comment-content">
                <h4><?= $user['name'] ?>
                    <?php if($replyTo) { ?>
                    <a onclick="reply_to(<?=$comment['id']?>)" class="reply-to" comment_id="<?=$comment['id']?>" href="#add_comment"><i
                                class="fa fa-comment-o"></i><span>Ответить</span></a>
                    <?php }?>
                    <?php if($dontReplyButton) { ?>
                        <a onclick="cancel_reply()" class="cancel-reply" comment_id="<?=$comment['id']?>" href="#add_comment"><i
                                    class="fa fa-ban"></i><span>Передумал отвечать</span></a>
                    <?php }?>
                </h4>
                <span><i class="fa fa-clock-o"></i><?= getWordDateTime($comment['date'] . ' ' . $comment['time']) ?></span>
                <p><?= strip_tags($comment['comment'], '<p>') ?></p>
            </div>
        </div>
        <?php
        $model = getModel('comments');
        $subcomments = $model->getCommentsToArticle($comment['article_id'], 1, $comment['id']);
        if($subcomments){
            $modelUsers = getModel('users');
            echo '<ul class="depth">';
            foreach ($subcomments as $subcomment){
                $replyUser = $modelUsers->getUserById($subcomment['user_id']);
                if($replyUser) {
                    echo getComment($subcomment, $replyUser);
                }
            }
            echo '</ul>';
        }
        ?>
    </li>
    <?php
    $html = ob_get_contents();
    ob_clean();
    return $html;
}

function getArticleComments($article_id)
{
    $model = getModel('comments');
    $comments = $model->getCommentsToArticle($article_id, 1);
    ob_start();
    ?>
    <div class="comment-area-box">
        <div class="title-section">
            <h1><span>Комментарии</span></h1>
        </div>
        <ul class="comment-tree">
            <?php
            if ($comments) {
                $modelUsers = getModel('users');
                foreach ($comments as $comment) {
                    $user = $modelUsers->getUserById($comment['user_id']);
                    //vdd($user);
                    if (!$user) $user = array('image' => '', 'name' => 'Удалённый пользователь');
                    if ($user) {
                        echo getComment($comment, $user);
                    }
                }
            } else echo '<li><div class="comment-box">Тут ещё никто не писал...</div></li>';
            ?>

        </ul>
    </div>
    <?php
    $html = ob_get_contents();
    ob_clean();
    return $html;
}

function getNewCommentBlock($article_id)
{
    ob_start();
    ?>
    <a name="add_comment"></a>
    <div class="contact-form-box">
        <div class="title-section">
            <h1><span>Оставить комментарий</span> <span class="email-not-published">Комментарий появится на сайте сразу после модерации.</span>
            </h1>
        </div>
        <div id="comment-block">
            <?php if (userdata('login') != false) { ?>
                <?=getNewCommentForm($article_id)?>
            <?php } else { ?>
                <label for="comment">Сначала авторизируйтесь через любую из систем:</label>
                <?= getUserAuthorize() ?>
            <?php } ?>
        </div>
        <script>
            function get_comment_form() {
                $.ajax({
                    url: '/ajax/get_block/comment_block/',
                    type: 'POST',
                    async: false,
                    data: {'article_id': <?=$article_id?>},
                    success: function(data){
                        $("#comment-block").html(data);
                    },
                    error: function () {
                        alert("get comment block error!");
                    }
                });
            }
        </script>
    </div>
    <?php
    $html = ob_get_contents();
    ob_clean();
    return $html;
}

function getNewCommentForm($article_id)
{
    ob_start();
    if(isAdminLogin()){
        echo '<div id="result></div>';
    }
    ?>
    <form id="comment-form" onsubmit="return false">
        <div id="reply-to"></div>
        <label for="comment">Комментарий *</label>

        <input type="hidden" id="reply_to" name="reply_to" value="0">
        <textarea id="comment" name="comment" article_id="<?= $article_id ?>"></textarea>
        <button onclick="send_comment()" id="submit-contact" article_id="<?= $article_id ?>">
            Отправить комментарий
        </button>
        <?php if(isAdminLogin()) { ?>
        <a onclick="logout()" id="logout">Выход</a>
        <?php } ?>
        <script>
            function cancel_reply(){
                $('#reply-to').html('');
                $("#reply_to").val(0);
            }

            function reply_to(comment_id) {
                $("#reply_to").val(comment_id);
                $.ajax({
                    url: '/ajax/comment/reply_to/',
                    type: 'POST',
                    async: false,
                    data: {
                        'comment_id': comment_id
                    },
                    success: function (data) {
                        if(data != 'error'){
                            $('#reply-to').html(data);
                        }
                    }
                });
            }

            function send_comment() {
                var text = $("#comment").val();
                var reply_to = $("#reply_to").val();
                $("#result").html(text);
                console.log('Sending comment');
                if(text != ''){
                    $.ajax({
                        url: '/ajax/comment/add/',
                        type: 'POST',
                        async: false,
                        data: {
                            'text': text,
                            'reply_to': reply_to,
                            'article_id': <?= $article_id ?>
                        },
                        success: function (data) {
                            console.log('sended: ' + data);
                            //alert(data);
                            $("#comment-block").html(data);
                        }
                    });
                } else alert('Ну напишите хоть пару слов!');
            }



            function logout() {
                alert("logout");
                $.ajax({
                    url: '/ajax/login/',
                    type: 'GET',
                    async: false,
                    data: {'logout': true},
                    success: function (data) {
                        console.log('logout: ' + data);
                        alert(data);
                    }
                });
            }
        </script>
    </form>
    <?php
    $html = ob_get_contents();
    ob_clean();
    return $html;
}