<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/new/core/classes/tender.php';

session_start();

$data = $_REQUEST['action'] == 'autoSave' ? $_SESSION['tenderData'] : $_POST;

if ($data) {
    $tender = new Tender();
    $result = $tender->insertTenderData($data);
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