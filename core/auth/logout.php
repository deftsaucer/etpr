<?session_start();

if (isset($_COOKIE['auth_token_cookie'])) {
    setcookie('auth_token_cookie', "", time() - 3600, '/');
}
if (isset($_SESSION['auth_token_session'])) {
    unset($_SESSION['auth_token_session']);
}

header('Location: /new');