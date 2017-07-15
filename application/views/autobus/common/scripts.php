<script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
!-- Latest compiled and minified JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>

<script>

    function sendMailArray(arr) {
        $.ajax({
            /* адрес файла-обработчика запроса */
            url: '/ajax/send_mail/',
            /* метод отправки данных */
            method: 'POST',
            async: false,
            contentType: false,            /* данные, которые мы передаем в файл-обработчик */
            processData: false,
            data: arr,

        }).done(function (data) {
            console.log("data: " + data);
            //alert(data);
        });
    }

    $(document).ready(function () {
        $("#send_order").click(function () {
            //var data = $('#form_order').serializeArray();
            //data = JSON.stringify(data);
            //alert(data);
            var name = $("#form_name").val();
            var tel = $("#form_tel").val();
            var message = $("#form_message").val();

            $.ajax({
                /* адрес файла-обработчика запроса */
                url: '/ajax/send_mail/',
                /* метод отправки данных */
                method: 'POST',
                async: false,
                data: {
                    "to": 'admin_email',
                    "name": name,
                    "tel": tel,
                    "message": message
                },

            }).done(function (data) {
                console.log("data: " + data);
                if(data == 'sended')
                    $("#form-block").html("<h2>Ваш заказ успешно отправлен!</h2>Ожидайте, с Вами свяжутся.");
                else alert('Ошибка отправки');
                //alert(data);
            });
            //sendMailArray(data);
            return false;
        })
    });
</script>

<script src="http://maps.google.com/maps/api/js"></script>
<script src="/assets/gmap.js"></script>
<script src="/assets/validate.js"></script>

<!-- Revolution slider JS -->
<script src="/assets/revolution/js/jquery.themepunch.tools.min.js"></script>
<script src="/assets/revolution/js/jquery.themepunch.revolution.min.js"></script>
<script src="/assets/revolution/js/extensions/revolution.extension.actions.min.js"></script>
<script src="/assets/revolution/js/extensions/revolution.extension.carousel.min.js"></script>
<script src="/assets/revolution/js/extensions/revolution.extension.kenburn.min.js"></script>
<script src="/assets/revolution/js/extensions/revolution.extension.layeranimation.min.js"></script>
<script src="/assets/revolution/js/extensions/revolution.extension.migration.min.js"></script>
<script src="/assets/revolution/js/extensions/revolution.extension.navigation.min.js"></script>
<script src="/assets/revolution/js/extensions/revolution.extension.parallax.min.js"></script>
<script src="/assets/revolution/js/extensions/revolution.extension.slideanims.min.js"></script>
<script src="/assets/revolution/js/extensions/revolution.extension.video.min.js"></script>

<script src="/assets/owl.carousel-2/owl.carousel.min.js"></script>

<!-- jQuery ui js -->
<script src="/assets/jquery-ui-1.11.4/jquery-ui.js"></script>


<!-- mixit up -->
<script src="/assets/jquery.mixitup.min.js"></script>
<!-- fancy box -->
<script src="/assets/fancyapps-fancyBox/source/jquery.fancybox.pack.js"></script>



<!-- custom.js -->

<script src="/js/map-script.js"></script>
<script src="/js/default-map-script.js"></script>
<script src="/js/custom.js"></script>