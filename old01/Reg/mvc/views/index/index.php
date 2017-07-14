<?php
if (!empty($_SESSION['success_mess'])) {
    echo "<p class='bg-primary'>{$_SESSION['success_mess']}</p>";
    unset($_SESSION['success_mess']);
}

if (!empty($_SESSION['error_mess'])) {
    echo "<p class='bg-danger'>{$_SESSION['error_mess']}</p>";
    unset($_SESSION['error_mess']);
}
?>
<div id="register_block">
    <div class="switch_auth_link"><a href="#" id="auth_link">Авторизация</a></div>
    <form action="/auth/register/" method="post" enctype="application/x-www-form-urlencoded">
        <input type="email" name="email" class="form-control" placeholder="example@mail.com" maxlength="50"
               required>
        <input type="password" name="password" class="form-control" placeholder="password" maxlength="100"
               required>
        <input type="text" name="name" class="form-control" placeholder="ФИО" maxlength="100">
        <input type="text" name="address" class="form-control" placeholder="Адрес" maxlength="100">
        <input type="tel" name="tel" class="form-control" placeholder="+380xxxxxxxx" maxlength="13">
        <br>
        <button type="submit" class="btn btn-primary">Регистрация</button>
    </form>
</div>

<div id="login_block">
    <div class="switch_auth_link"><a href="#" id="reg_link">Регистрация</a></div>
    <form action="/auth/login/" method="post" enctype="application/x-www-form-urlencoded">
        <input type="email" name="email" class="form-control" placeholder="example@mail.com" maxlength="50"
               required>
        <input type="password" name="password" class="form-control" placeholder="password" maxlength="100"
               required>
        <br>
        <button type="submit" class="btn btn-primary">Log in</button>
    </form>
</div>

<div>
    <div class="last_users_block_link"><a href="#" id="last_users_link">Открыть список последних 5и зарегистрированных пользователя</a></div>
    <div id="last_registers_users">
        <?php
        if(!empty($this->users)) {
            foreach ($this->users as $value) {
                echo "<div><a href='/profile/?id=$value[id]'>$value[email]</a></div>";
            }
        }
        else
            echo "<div>Нет зарегистрированных пользователей</div>";
        ?>
    </div>
</div>