<?=getHead($meta)?>
<?=getHeader()?>

<!-- Contact Us -->
<section id="contact" class="contact">
    <!-- Google Map -->
    <div class="google-map">
        <div id="map" class="map"></div>
    </div>
    <!-- End of Google Map -->
    <div class="container">
        <div class="row">
            <div class="col-md-7 col-sm-7 col-xs-12">
                <div class="contact-form contact-box">
                    <h3>Написать нам</h3>
                    <div class="row">
                        <div class="col-md-6 col-sm-6 col-xs-6">
                            <div class="form-group">
                                <input type="text" placeholder="Ваше имя" id="form_name" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-6 col-xs-6">
                            <div class="form-group">
                                <input type="text" placeholder="Email" id="form_email" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-6 col-xs-6">
                            <div class="form-group">
                                <input type="text" placeholder="Телефон" id="form_tel" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-6 col-xs-6">
                            <div class="form-group">
                                <input type="text" placeholder="Тема" id="form_subject" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <div class="form-group">
                                <textarea placeholder="Сообщение" id="form_message" class="form-control"></textarea>
                            </div>
                        </div>
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <input type="submit" value="Отправить" id="form_send" class="btn btn-primary">
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-5 col-sm-5 col-xs-12">
                <?=getOption('main_our_contacts')?>
            </div>
        </div>
    </div>
</section>
<!-- End of Contact Us -->

<?=getFooter()?>
