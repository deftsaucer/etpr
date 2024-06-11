<?
require_once $_SERVER['DOCUMENT_ROOT'] . "/new/core/settings.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/new/core/functions.php";
$metaTags = getMeta($settings['meta']);?>
<?$currentURL = strtok($_SERVER['REQUEST_URI'], '?');?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="<?=$metaTags['description']?>">
    <meta name="keywords" content="<?=$metaTags['keywords']?>">
    <title><?=$metaTags['title']?> - Tender & IT</title>
    <link href="/new/css/bootstrap.min.css" rel="stylesheet">
    <link href="/new/css/custom.css" rel="stylesheet">
    <script src="/new/js/bootstrap.bundle.min.js"></script>
    <script src="/new/js/jquery-3.7.1.min.js"></script>
    <script src="/new/js/script.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.inputmask/5.0.6/jquery.inputmask.min.js"></script>
    <?=(file_exists($_SERVER['DOCUMENT_ROOT'] . $currentURL . 'script.js')) ? '<script src="' . $currentURL . 'script.js"></script>' : ''?>
</head>

<body class="d-flex flex-column min-vh-100">
    <header class="navbar navbar-expand-lg navbar-light">
        <div class="container">
            <a href="/new/" class="navbar-brand d-flex align-items-center">
                <img src="/new/img/logo.png" alt="Tender&IT Logo" height="50">
                <div class="fs-2 text-dark">Tender&IT</div>
            </a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav justify-content-lg-center col-lg-10">
                    <?=getHeaderNavHtml($settings['navItems'])?>
                </ul>

                <div class="d-inline-flex align-items-center justify-content-end col-lg-2 ">
                    <?if (isset($_COOKIE['auth_token_cookie']) || isset($_SESSION['auth_token_session'])):?>
                        <div class="dropdown">
                            <button type="button" class="btn btn-primary px-3 m-2 dropdown-toogle" data-bs-toggle="dropdown" aria-expanded="false">Личный кабинет</button>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="/new/personal/profile">Перейти в кабинет</a></li>
                                <li><a class="dropdown-item" href="/new/core/auth/logout.php">Выйти</a></li>
                            </ul>
                        </div>
                    <?else:?>
                        <button type="button" class="btn btn-primary px-3 m-2" data-bs-toggle="modal" data-bs-target="#modalSigninFrom" <?=($currentURL == '/new/personal/') ? 'disabled' : ''?>>Войти</button>
                    <?endif?>  
                </div>
            </div>
        </div>
    </header>

    <?if ($currentURL != '/new/personal/'):?>
        <div class="modal fade" id="modalSigninFrom" tabindex="-1" aria-labelledby="modalSigninFrom" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content rounded-4 shadow">
                    <div class="modal-header p-5 pb-4 border-bottom-0">
                        <h1 class="fw-bold mb-0 fs-2">Войти</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body p-5 pt-0">
                        <form class="" action="/new/core/auth/login.php" method="post" id="loginForm">
                            <div class="error-message text-danger"></div>
                            <div class="form-floating mb-3">
                                <input type="email" class="form-control rounded-3" id="floatingLogin" name="login" placeholder="name@example.com" required>
                                <label for="floatingLogin">Логин/E-mail</label>
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
                </div>
            </div>
        </div>
    <?endif;?>