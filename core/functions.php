<?
function getHeaderNavHtml($navItems)
{
    $navHtml = '';
    foreach ($navItems as $navItem) {
        $navItemHtml = ($_SERVER['REQUEST_URI'] == $navItem['linkUrl'])
            ? '<span class="nav-link px-2 link-secondary">' . $navItem['linkText'] . '</span>'
            : '<a href="' . $navItem['linkUrl'] . '" class="nav-link nav-link-header px-2 text-primary">' . $navItem['linkText'] . '</a>';

        $navHtml .= '<li class="nav-item">' . $navItemHtml . '</li>';
    }
    return $navHtml;
}

function getMeta($metaItems)
{
    $meta = [];
    foreach ($metaItems as $metaItem) {
        if ($_SERVER['REQUEST_URI'] == $metaItem['linkUrl']) {
            $meta['description'] = $metaItem['description'];
            $meta['keywords'] = $metaItem['keywords'];
            $meta['title'] = $metaItem['title'];
            break;
        }
    }
    return $meta;
}

function getCatalogElements()
{
    require_once $_SERVER['DOCUMENT_ROOT'] . '/new/core/db_conn.php';

    $connection = Database::getInstance()->getConnection();
    $arSections = [];
    $arElements = [];
    $result = [];

    $query = 'SELECT id, name FROM Categories';
    $stmt = $connection->prepare($query);
    if ($stmt) {
        $stmt->execute();
        $arSections = [];
        $rsSections = $stmt->get_result();
        while ($arSection = $rsSections->fetch_assoc()) {
            $arSections[] = $arSection;
        }

        $result['sections'] = $arSections;
    }
    
    $query = 'SELECT g.id, g.name, g.description, g.image, gc.category_id FROM Goods as g
              JOIN GoodsInCategories as gc ON gc.good_id = g.id;';
    $stmt = $connection->prepare($query);
    if ($stmt) {
        $stmt->execute();

        $arElements = [];
        $rsElements = $stmt->get_result();
        while ($arElement = $rsElements->fetch_assoc()) {
            $arElements[] = $arElement;
        }
        
        $result['elements'] = $arElements;
    }

    return $result;
}

function insertCall($data)
{
    require_once $_SERVER['DOCUMENT_ROOT'] . '/new/core/db_conn.php';

    if (isset($_SESSION['auth_token_session'])) {
        $manager = $_SESSION['auth_token_session'];
    }
    elseif (isset($_COOKIE['auth_token_cookie'])) {
        $manager = $_COOKIE['auth_token_cookie'];
    }

    $connection = Database::getInstance()->getConnection();
    $query = "INSERT INTO Calls (company, manager, datetime, description) VALUES (?, ?, ?, ?)";
    $stmt = $connection->prepare($query);
    $stmt->bind_param('siss', $data['company'], $manager, $data['datetime'], $data['description']);
    if ($stmt->execute()) {
        $result['success'] = true;
        $result['message'] = 'Данные успешно сохранены.';
        return $result;
    } else {
        $result['success'] = false;
        $result['message'] = 'Ошибка сохранения. Попробуйте снова.';
        return $result;
    }
}

function getCallsList()
{
    require_once $_SERVER['DOCUMENT_ROOT'] . '/new/core/db_conn.php';

    if (isset($_SESSION['auth_token_session'])) {
        $manager = $_SESSION['auth_token_session'];
    }
    elseif (isset($_COOKIE['auth_token_cookie'])) {
        $manager = $_COOKIE['auth_token_cookie'];
    }

    $connection = Database::getInstance()->getConnection();
    $query = "SELECT * FROM Calls WHERE manager = ?";
    $stmt = $connection->prepare($query);
    $stmt->bind_param('i', $manager);
    $stmt->execute();
    $result = $stmt->get_result();

    $arCalls = [];
    while ($row = $result->fetch_assoc()) {
        $arCalls[] = [
            'company' => $row['company'],
            'datetime' => $row['datetime'],
            'description' => $row['description'],
        ];
    }
    
    return $arCalls;
}