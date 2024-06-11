<?require_once $_SERVER['DOCUMENT_ROOT'] . '/new/core/db_conn.php';

class User
{
    private $db;

    public function __construct()
    {
        $this->db = Database::getInstance()->getConnection();
    }

    public function login($login, $password) {
        $result = self::isUserExists($login, $this->db);
        if (!$result) {
            return false;
        } 
        $user = $result->fetch_assoc();
        if (password_verify($password, $user['password'])) {
            return $user['id'];
        }
        return false;
    }

    public function register($name, $login, $password, $phone = "")
    {
        if (self::isUserExists($login, $this->db)) {
            return 'user-exists';
        }

        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $query = 'INSERT INTO Users (fio, login, password, phone) VALUES (?, ?, ?, ?)';
        $stmt = $this->db->prepare($query);
        $stmt->bind_param("ssss", $name, $login, $hashedPassword, $phone);
        if ($stmt->execute()) {
            return $stmt->insert_id;
        }
        return false;
    }

    public static function isUserExists($login, $db) {
        $query = 'SELECT id, login, password FROM Users WHERE login = ?';
        $stmt = $db->prepare($query);
        $stmt->bind_param('s', $login);   
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows == 1) {
            return $result;
        }
        return false;
    }

    public function getUserData($id) {
        $query = 'SELECT * FROM Users WHERE id = ?';
        $stmt = $this->db->prepare($query);
        $stmt->bind_param('s', $id);   
        $stmt->execute();
        $result = $stmt->get_result()->fetch_assoc();
        
        return $result;
    }

    public function updateUserData($post, $id) {
        $arUser = $this->getUserData($id);
        $_SESSION['update_result'] = 'fail';
        $fields = ['fio', 'phone', 'password'];
        $updatedFields = [];

        foreach($fields as $field) {
            if (isset($post[$field]) && !empty($post[$field])) {
                if ($field == 'password') {
                    if ($post['password'] != $post['password-confirm']) {
                        $_SESSION['update_message'] = 'Пароли не совпадают';
                        return false;
                    }
                    if (!password_verify($post['password'], $arUser['password'])) {
                        $updatedFields[] = 'password = ?';
                        $updatedData[] = password_hash($post[$field], PASSWORD_DEFAULT);
                    }
                } 
                elseif ( $post[$field] != $arUser[$field]) {
                    $updatedFields[] = $field . ' = ?';
                    $updatedData[] = $post[$field];
                }   
            }
        }
        if (empty($updatedFields)) {
            $_SESSION['update_result'] = 'success';
            $_SESSION['update_message'] = 'Нет обновленных полей';
            return false;
        }

        $updatedData[] = $id;
        $query = 'UPDATE Users SET ' . implode(', ', $updatedFields) . ' WHERE id = ?';
        $stmt = $this->db->prepare($query);
        $stmt->bind_param(str_repeat('s', count($updatedData)), ...$updatedData);
        if ($stmt->execute()) {
            $_SESSION['update_result'] = 'success';
            $_SESSION['update_message'] = 'Данные успешно обновлены';
            return true;
        } else {
            $_SESSION['update_message'] = 'Ошибка обновления данных';
            return false;
        }
    }
    
}
?>