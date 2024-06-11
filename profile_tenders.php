<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/new/core/classes/parser.php';

if ($_REQUEST['form-type'] == 'auto') {
    $tenderData = Parser::parseTenderData($_REQUEST['number']);
    if ($tenderData) {
        $_SESSION['tenderData'] = $tenderData;
        ob_start();?>
        <table class="table table-bordered table-hover">
            <thead class="thead-light text-center">
                <tr>
                    <th scope="col" class="align-middle">Номер закупки</th>
                    <th scope="col" class="align-middle">Закон</th>
                    <th scope="col" class="align-middle">Метод</th>
                    <th scope="col" class="align-middle">Статус</th>
                    <th scope="col" class="align-middle">Объект</th>
                    <th scope="col" class="align-middle">Заказчик</th>
                    <th scope="col" class="align-middle">Цена</th>
                    <th scope="col" class="align-middle">Дата публикации</th>
                    <th scope="col" class="align-middle">Дата окончания</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="align-middle"><?=$tenderData['number']?></td>
                    <td class="align-middle"><?=$tenderData['law']?></td>
                    <td class="align-middle"><?=$tenderData['method']?></td>
                    <td class="align-middle"><?=$tenderData['status']?></td>
                    <td class="align-middle"><?=$tenderData['object']?></td>
                    <td class="align-middle"><?=$tenderData['customer']?></td>
                    <td class="align-middle"><?=str_replace(' ', '&nbsp;', $tenderData['price'])?></td>
                    <td class="align-middle"><?=$tenderData['post_date']?></td>
                    <td class="align-middle"><?=$tenderData['end_date']?></td>
                </tr>
            </tbody>
        </table>
        <button type="button" class="btn btn-primary" id="saveButton">Сохранить</button>
        <?$html = ob_get_clean();
        echo $html;   
    } else {
        ob_start();?>
        <div class="alert alert-danger">Не удалось найти закупку по указанному номеру. Попробуйте еще раз или <a href="#" id="manualLink">введите данные вручную</a></div>
        <script>
            $('#manualLink').on('click', function(e) {
                e.preventDefault();
                $('#add-manual-tab').tab('show');
            });
        </script>
        <?$html = ob_get_clean();
        echo $html; 
    }
} elseif ($_REQUEST['form-type'] == 'manual') {
    print_r('manual');
}