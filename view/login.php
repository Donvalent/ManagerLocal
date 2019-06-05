<!-- Header -->
<?php  include_once(ROOT . '/view/layouts/header.html'); ?>

<!-- Main -->
<form action="#" method="post">
    <div class="col-lg-2 col-md-2 col-sm-12 form-group text-center">
        <label for="loginField">Логин</label>
        <input type="text" name="login" id="loginField">
    </div>
    <div class="col-lg-2 col-md-2 col-sm-12 form-group text-center">
        <label for="passwordField">Пароль</label>
        <input type="password" name="password" id="passwordField">
    </div>
    <div class="col-lg-2 col-md-2 col-sm-12 form-group text-center">
        <button class="btn btn-primary" type="submit" name="submit">Добавить</button>
    </div>
</form>

<!-- Footer -->
<?php  include_once(ROOT . '/view/layouts/footer.html'); ?>