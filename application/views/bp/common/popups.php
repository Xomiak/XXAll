<?php if(!userdata('login')){ ?>
    <div style="display: none;" id="login_popup">
        <h2>Авторизация</h2>
        <form class="auth">
            <laber for="login">e-mail:</laber><br>
            <input type="email" required id="login" name="login" placeholder="mymail@gmail.com"><br>
            <laber for="pass">пароль:</laber><br>
            <input type="password" required id="pass" name="pass"><br>
            <button class="auth-button">Войти</button>
        </form>
    </div>

    <div style="display: none;" id="register_popup">
        <h2>Регистрация</h2>
        <form class="auth">
            <laber for="login">e-mail:</laber><br>
            <input type="email" required id="login" name="login" placeholder="mymail@gmail.com"><br>
            <laber for="pass">пароль:</laber><br>
            <input type="password" required id="pass" name="pass"><br>
            <laber for="pass">повтор пароля:</laber><br>
            <input type="password" required id="pass" name="pass"><br>
            <laber for="name">Имя:</laber><br>
            <input type="text" required id="name" name="name" placeholder="Василий"><br>
            <button class="auth-button">Регистрация</button>
        </form>
    </div>
<?php } ?>