<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/new/core/functions.php';

session_start();


$managerCalls = getCallsList();

if ($managerCalls && !empty($managerCalls)) {
    ob_start();?>

    <table class="table table-bordered table-hover">
        <thead class="thead-light text-center">
            <tr>
                <th scope="col" class="align-middle">Компания</th>
                <th scope="col" class="align-middle">Дата и время</th>
                <th scope="col" class="align-middle">Комментарий</th>
            </tr>
        </thead>
        <tbody>
            <?foreach ($managerCalls as $call):?>
                <tr>
                    <td class="align-middle"><?=$call['company']?></td>
                    <td class="align-middle"><?=(new DateTime($call['datetime']))->format('d.m.Y H:i');?></td>
                    <td class="align-middle"><?=$call['description']?></td>
                </tr>
            <?endforeach;?>
        </tbody>
    </table>
    <?$html = ob_get_clean();
    echo $html;   
} else {
    ob_start();?>

    <div class="alert alert-danger">У вас нет добавленных данных о звонках</div>
    
    <?$html = ob_get_clean();
    echo $html; 
}
