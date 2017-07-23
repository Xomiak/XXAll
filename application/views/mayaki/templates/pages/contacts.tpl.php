<?php
if(isset($_POST['btn_submit'])){
    // отправка сообщения
    $message = 'Имя: '.post('name').'<br />
Телефон: <a href="tel:'.post('tel').'">'.post('tel').'</a><br/>
e-mail: '.post('email').'<br/>
Сообщение: '.post('message');
    $to = getOption('admin_email');
    loadHelper('mail');
    mail_send($to, 'Форма с сайта', $message);
    redirect('/contacts/?sended=true#send-form');
}
?>
<?=getHead($meta)?>
<?=getHeader()?>

<main class="">

    <div class="container-full contacts">
        <div class="map-frame-container">
            <div id="contacts_map"></div>
        </div>
        <div class="contact-container wow fadeInUp">
            <h1 class="main-title">контакты</h1>
            <div class="line-box contacts-box">
                <?=$page['content']?>
            </div>
        </div>
    </div>

</main>

<?=getFooter()?>
<script src="/js/contacts_map.js"></script>