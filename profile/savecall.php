<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/new/core/functions.php';

session_start();

$data = $_POST;
$data['datetime'] = (new DateTime($data['datetime']))->format('Y-m-d H:i:s');

if ($data) {
    $result = insertCall($data);
    if ($result['success']) {
        ob_start();?>
        <div class="alert alert-success"><?=$result['message']?></div>
        <?$html = ob_get_clean();
        echo $html; 
    } else {
        ob_start();?>
        <div class="alert alert-danger"><?=$result['message']?></div>
        <?$html = ob_get_clean();
        echo $html; 
    }
} else {
    ob_start();?>
    <div class="alert alert-danger">Ошибка добавления данных</div>
    <?$html = ob_get_clean();
    echo $html; 
}