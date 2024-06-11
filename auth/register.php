<?session_start();
require_once $_SERVER['DOCUMENT_ROOT'] . '/new/core/classes/user.php';

$user = new User();
$userId = $user->register($_REQUEST['name'], $_REQUEST['login'], $_REQUEST['password'], $_REQUEST['phone']);

if (is_int($userId)) {
    if ($_REQUEST['remember'] == 'true') {
        setcookie('auth_token_cookie', $userId, time() + (3600 * 24 * 30), '/');
    } else {
        $_SESSION['auth_token_session'] = $userId;
    }
    echo json_encode(array('success' => true));
} elseif ($userId == 'user-exists') {
    header('Content-Type: application/json; charset=utf-8');
    echo json_encode(array('success' => false, 'message' => 'Пользователь с такой почтой уже существует'));
} else {
    header('Content-Type: application/json; charset=utf-8');
    echo json_encode(array('success' => false, 'message' => 'Ошибка регистрации'));
}