<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/new/core/classes/tender.php';

session_start();

$tender = new Tender();
$managersTenders = $tender->getTenderList();

if ($managersTenders && !empty($managersTenders)) {
    ob_start();?>

    <table class="table table-bordered table-hover">
        <thead class="thead-light text-center">
            <tr>
                <th scope="col" class="align-middle">Номер закупки</th>
                <th scope="col" class="align-middle">Закон</th>
                <th scope="col" class="align-middle">Способ определения поставщика</th>
                <th scope="col" class="align-middle">Объект закупки</th>
                <th scope="col" class="align-middle">Заказчик</th>
                <th scope="col" class="align-middle">Цена</th>
                <th scope="col" class="align-middle">Дата публикации</th>
                <th scope="col" class="align-middle">Дата окончания</th>
            </tr>
        </thead>
        <tbody>
            <?foreach ($managersTenders as $tender):?>
                <tr>
                    <td class="align-middle"><?=$tender['number']?></td>
                    <td class="align-middle"><?=$tender['law']?></td>
                    <td class="align-middle"><?=$tender['method']?></td>
                    <td class="align-middle"><?=$tender['object']?></td>
                    <td class="align-middle"><?=$tender['customer']?></td>
                    <td class="align-middle"><?=str_replace(' ', '&nbsp;', $tender['price'])?></td>
                    <td class="align-middle"><?=$tender['post_date']?></td>
                    <td class="align-middle"><?=$tender['end_date']?></td>
                </tr>
            <?endforeach;?>
        </tbody>
    </table>
    <?$html = ob_get_clean();
    echo $html;   
} else {
    ob_start();?>

    <div class="alert alert-danger">У вас нет добавленных данных о тендерах</div>
    
    <?$html = ob_get_clean();
    echo $html; 
}
