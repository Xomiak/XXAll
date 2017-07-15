<?php
if (isset($_POST['btn_submit'])) {
    // отправка сообщения
    $message = 'Имя: ' . post('name') . '<br />
Телефон: <a href="tel:' . post('tel') . '">' . post('tel') . '</a><br/>
e-mail: ' . post('email') . '<br/>
Тема: ' . post('subject') . '<br/>
Сообщение: ' . post('message');
    $to = getOption('admin_email');
    loadHelper('mail');
    mail_send($to, 'Форма с сайта', $message);
    redirect('/contacts/?sended=true#send-form');
    echo '<h2>Ваше сообщение успешно отправлено!</h2>';
    die();
} elseif(isset($_GET['sended']) && $_GET['sended'] == true){
    echo '<h2>Ваше сообщение успешно отправлено!</h2>';
    die();
}
?>
<?php
loadHelper(TEMPLATE);
if(!isset($meta))
    $meta = false;
?>
<?=getHead($meta)?>
<?= getHeader() ?>

<section class="inner-banner"<?php if($page['image'] != '') echo ' style="background: #000 url('.$page['image'].') center center no-repeat; background-size: cover;"';?>>
    <div class="container text-center">
        <h1><span><?= $page['name'] ?></span></h1>
    </div>
</section>

<a name="send-form"></a>
<section class="contact-page section-padding">
    <div class="container">
        <div class="google-map" id="contact-page-google-map" data-map-lat="40.650002" data-map-lng="-73.949997"
             data-icon-path="img/resources/map-
			pin-2.png" data-map-title="Awesome Place" data-map-zoom="11"></div>
        <?php if (isset($_GET['sended']) && $_GET['sended'] == true) { ?>
            <h2>Ваше сообщение успешно отправлено!</h2>
        <?php } else { ?>
            <div id="contact-form">
                <form class="contact-form" method="post">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-grp">
                                <label>ФИО <span>*</span></label>
                                <input required type="text" name="name" placeholder="Enter your name">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-grp">
                                <label>Email <span>*</span></label>
                                <input required type="text" name="email" placeholder="Enter your email">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-grp">
                                <label>Телефон <span>*</span></label>
                                <input required type="text" name="tel" placeholder="Введите телефон">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-grp">
                                <label>Тема <span>*</span></label>
                                <input required type="text" name="subject" placeholder="Введите тему">
                            </div>
                        </div>
                        <div class="col-md-12 clearfix">
                            <label>Сообщение <span>*</span></label>
                            <textarea required name="message" placeholder="Введите Ваше сообщение"></textarea>
                            <button type="submit" name="btn_submit" class="pull-right thm-btn hvr-sweep-to-top">
                                ОТПРАВИТЬ
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        <?php } ?>
    </div>
</section>

<?= getFooter() ?>
