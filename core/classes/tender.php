<?require_once $_SERVER['DOCUMENT_ROOT'] . '/new/core/db_conn.php';

class Tender
{
    private $db;

    public function __construct()
    {
        $this->db = Database::getInstance()->getConnection();
    }

    public function getTenderList()
    {
        $userId = $this->getUserId();

        if ($userId == 0) {
            return [];
        }

        $query = "
            SELECT t.id, t.number, t.method, t.law, t.object, t.customer, t.price, t.post_date, t.end_date 
            FROM Tenders t
            JOIN ManagersTenders mt ON t.id = mt.tender_id
            WHERE mt.user_id = ?
        ";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param('i', $userId);
        $stmt->execute();
        $result = $stmt->get_result();

        $tenders = [];
        while ($row = $result->fetch_assoc()) {
            $tenders[] = [
                'id' => $row['id'],
                'number' => $row['number'],
                'method' => $row['method'],
                'law' => $row['law'],
                'object' => $row['object'],
                'customer' => $row['customer'],
                'price' => $row['price'],
                'post_date' => self::formatDateFromDb($row['post_date']),
                'end_date' => self::formatDateFromDb($row['end_date'])
            ];
        }
        
        return $tenders;
    }

    public function insertTenderData($data)
    {
        $result = [];

        if (empty($data)) {
            $result['success'] = false;
            $result['message'] = 'Отсутствуют данные для записи.';
            return $result;
        }

        $userId = $this->getUserId();

        if ($this->isTenderExists($data['number'])) {
            $tenderId = $this->getTenderIdByNumber($data['number']);
            if (!$this->isManagerTenderExists($userId, $tenderId)) {
                $this->addManagerTender($userId, $tenderId);
                $result['success'] = true;
                $result['message'] = 'Запись уже есть в базе данных и была добавлена в ваш список тендеров.';
            } else {
                $result['success'] = false;
                $result['message'] = 'Эта запись уже существует в вашем списке тендеров.';
            }
            return $result;
        } else {
            $query = "INSERT INTO Tenders (number, method, law, object, customer, price, post_date, end_date) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
            $stmt = $this->db->prepare($query);
            $stmt->bind_param(
                "ssssssss", 
                $data['number'], 
                $data['method'], 
                $data['law'], 
                $data['object'], 
                $data['customer'], 
                $data['price'], 
                self::formatDateToDb($data['post_date']), 
                self::formatDateToDb($data['end_date'])
            );
            if ($stmt->execute()) {
                $tenderId = $this->db->insert_id;
                $this->addManagerTender($userId, $tenderId);
                $result['success'] = true;
                $result['message'] = 'Данные успешно сохранены.';
                return $result;
            } else {
                $result['success'] = false;
                $result['message'] = 'Ошибка сохранения. Попробуйте снова.';
                return $result;
            }
        }
    }

    public static function formatDateToDb($date) 
    {
        $date = (new DateTime($date))->format('Y-m-d');
        return $date;
    }

    public static function formatDateFromDb($date) 
    {
        $date = (new DateTime($date))->format('d.m.Y');
        return $date;
    }

    public function isTenderExists($number) {
        $query = 'SELECT id, number FROM Tenders WHERE number = ?';
        $stmt = $this->db->prepare($query);
        $stmt->bind_param('s', $number);   
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows == 1) {
            return true;
        }
        return false;
    }

    public function isManagerTenderExists($userId, $tenderId) {
        $query = 'SELECT * FROM ManagersTenders WHERE user_id = ? AND tender_id = ?';
        $stmt = $this->db->prepare($query);
        $stmt->bind_param('ii', $userId, $tenderId);   
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows == 1) {
            return true;
        }
        return false;
    }

    public function getTenderIdByNumber($number) {
        $query = 'SELECT id FROM Tenders WHERE number = ?';
        $stmt = $this->db->prepare($query);
        $stmt->bind_param('s', $number);   
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows == 1) {
            $row = $result->fetch_assoc();
            return $row['id'];
        }
        return false;
    }

    private function addManagerTender($userId, $tenderId) {
        $query = 'INSERT INTO ManagersTenders (user_id, tender_id) VALUES (?, ?)';
        $stmt = $this->db->prepare($query);
        $stmt->bind_param('ii', $userId, $tenderId);
        $stmt->execute();
    }

    public function getUserId() {
        if (isset($_SESSION['auth_token_session'])) {
            return $_SESSION['auth_token_session'];
        }
        if (isset($_COOKIE['auth_token_cookie'])) {
            return $_COOKIE['auth_token_cookie'];
        }
        return 0;
    }
}
?>
