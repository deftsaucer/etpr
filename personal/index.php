<?session_start();
if (isset($_COOKIE['auth_token_cookie']) || isset($_SESSION['auth_token_session'])) {
    header('Location: /new/personal/profile');
}?>
<?include $_SERVER['DOCUMENT_ROOT'] . "/new/header.php"?>
    
<?if ($_REQUEST['action'] == 'register'):?>
    <div class="p-5 pt-0 col-lg-3 m-auto">
        <h1 class="fw-bold mb-0 fs-2 py-4">Зарегистрироваться</h1>
        <form class="" action="/new/core/auth/register.php" method="post" id="registerForm">
            <div class="error-message text-danger"></div>
            <div class="form-floating mb-3">
                <input type="text" class="form-control rounded-3" id="floatingNameRegister" name="name" placeholder="ФИО" required>
                <label for="floatingNameRegister">ФИО*</label>
            </div>
            <div class="form-floating mb-3">
                <input type="email" class="form-control rounded-3" id="floatingLoginRegister" name="login" placeholder="name@example.com" required>
                <label for="floatingLoginRegister">E-mail*</label>
            </div>
            <div class="form-floating mb-3">
                <input type="password" class="form-control rounded-3" id="floatingPasswordRegister" name="password" placeholder="Пароль" minlength="8" required>
                <label for="floatingPasswordRegister">Пароль*</label>
                <span class="form-text">Пароль должен быть не меньше 8 символов</span>
            </div>
            <div class="form-floating mb-3">
                <input type="password" class="form-control rounded-3" id="floatingPasswordConfirmRegister" name="password-confirm" placeholder="Повторите пароль" minlength="8" required>
                <label for="floatingPasswordConfirmRegister">Повторите пароль*</label>
                <div class="form-text text-danger" style="display: none;" id="passwordError">Пароли не совпадают</div>
            </div>
            <div class="form-floating mb-3">
                <input type="text" class="form-control rounded-3" id="floatingPhoneRegister" name="phone" placeholder="Телефон">
                <label for="floatingPhoneRegister">Телефон</label>
            </div>
            <div class="form-check mb-3">
                <input class="form-check-input" type="checkbox" value="" id="floatingCheckboxRegister" name="remember" checked>
                <label class="form-check-label" for="floatingCheckboxRegister">Запомнить меня</label>
            </div>
            <button class="w-100 mb-2 btn btn-lg rounded-3 btn-primary" type="submit">Подтвердить</button>
            <hr class="my-3">
            <p>У Вас уже есть аккаунт?</p>
            <a class="w-100 btn btn-lg rounded-3 btn-outline-primary" href="/new/personal/">Войти</a>
        </form>
    </div>
<?else:?>
    <div class="p-5 pt-0 col-lg-3 m-auto">
        <h1 class="fw-bold mb-0 fs-2 py-4">Войти</h1>
        <form class="" action="/new/core/auth/login.php" method="post" id="loginForm">
            <div class="error-message text-danger"><?=($_REQUEST['error'] == 'auth') ? 'Необходимо авторизоваться' : ''?></div>
            <div class="form-floating mb-3">
                <input type="email" class="form-control rounded-3" id="floatingLogin" name="login" placeholder="name@example.com" required>
                <label for="floatingLogin">Логин</label>
            </div>
            <div class="form-floating mb-3">
                <input type="password" class="form-control" id="floatingPassword" name="password" placeholder="Пароль" minlength="8" required>
                <label for="floatingPassword">Пароль</label>
                <button class="btn-toggle-password" type="button" id="togglePassword">
                    <img src="/new/img/eye.svg" alt="SVG Image" width="20" height="20">
                </button>
            </div>
            <div class="form-check mb-3">
                <input class="form-check-input" type="checkbox" value="true" id="floatingCheckbox" name="remember" checked>
                <label class="form-check-label" for="floatingCheckbox">Запомнить меня</label>
            </div>
            <button class="w-100 mb-2 btn btn-lg rounded-3 btn-primary" type="submit">Подтвердить</button>
            <hr class="my-3">
            <p>У Вас еще нет аккаунта?</p>
            <a class="w-100 mb-2 btn btn-lg rounded-3 btn-outline-primary" href="/new/personal/?action=register">Зарегистрироваться</a>
        </form>
    </div>
<?endif;?>
<?include $_SERVER['DOCUMENT_ROOT'] . "/new/footer.php"?>
