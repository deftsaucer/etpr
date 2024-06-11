<?session_start();
require_once $_SERVER['DOCUMENT_ROOT'] . '/new/core/classes/user.php';

$user = new User();
$userId = $user->login($_REQUEST['login'], $_REQUEST['password']);

if ($userId) {
    if ($_REQUEST['remember'] == 'true') {
        setcookie('auth_token_cookie', $userId, time() + (3600 * 24 * 30), '/');
    } else {
        $_SESSION['auth_token_session'] = $userId;
    }
    echo json_encode(array('success' => true));
} else {
    header('Content-Type: application/json; charset=utf-8');
    echo json_encode(array('success' => false, 'message' => 'Неверный логин или пароль'));
}
