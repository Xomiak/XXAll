<!-- Modal -->
<div class="modal contact-page fade booking-form" id="booking-form" tabindex="-1" role="dialog" aria-labelledby="booking-form">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div id="form-block" class="modal-body">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h3>Заказать авто: </h3>
                <form class="contact-form search-form-box" method="post" id="form_order" onsubmit="false">
                    <input type="hidden" name="action" value="order" />
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-grp">
                                <label>Имя <span>*</span></label>
                                <input id="form_name" type="text" name="name" placeholder="Ваше имя" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-grp">
                                <label>Телефон <span>*</span></label>
                                <input id="form_tel" type="text" name="tel" placeholder="Ваш телефон" required>
                            </div>
                        </div>

                        <div class="col-md-12 clearfix">
                            <label>Комментарий <!--span>*</span--></label>
                            <textarea id="form_message" name="message" placeholder="Ваш комментарий"></textarea>
                            <button id="send_order" type="submit" onsubmit="false" class="pull-right thm-btn hvr-sweep-to-top">Отправить</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>