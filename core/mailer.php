<?php

switch($_REQUEST['formid']) {
    case 'formFeedback':
        $subject = 'Новый вопрос в форме';
        $message = 
            'Имя: ' . $_REQUEST['name'] . "\n\n" . 
            'E-mail: ' . $_REQUEST['email'] . "\n\n" .
            'Вопрос: ' . $_REQUEST['question'];

        ob_start();?>
        <div class="text-center" role="alert">
            <div>
                <img src="/new/img/check-circle.svg" alt="SVG Image" width="50" height="50">
            </div>
            <p class="fs-4 mb-0">Ваш вопрос успешно отправлен!</p>
        </div>
        <?$successHtml = ob_get_clean();
        break;
    case 'formOrder':
        $subject = 'Новый запрос на товар';
        $message = 
            'Имя: ' . $_REQUEST['name'] . "\n\n" . 
            'E-mail: ' . $_REQUEST['email'] . "\n\n" .
            'ID товара: ' . $_REQUEST['productId'] . "\n\n" .
            'Комментарий: ' . $_REQUEST['comment'];

        ob_start();?>
        <div class="text-center" role="alert">
            <div>
                <img src="/new/img/check-circle.svg" alt="SVG Image" width="50" height="50">
            </div>
            <p class="fs-4 mb-0">Ваша заявка успешно отправлена!</p>
        </div>
        <?$successHtml = ob_get_clean();
        break;
}

$to = 'serzh.trushnikov.02@mail.ru';
$headers = 
    'From: info@tenderit.ru' . "\r\n" .
    'Reply-To: info@tenderit.ru' . "\r\n" .
    'X-Mailer: PHP/' . phpversion();

ob_start();?>
<div class="text-center alert alert-danger" role="alert">
    <p class="fs-4 mb-0">Ошибка отправки. Пожалуйста, попробуйте позже.</p>
</div>
<?$errorHtml = ob_get_clean();

$result = mail($to, $subject, $message, $headers);

if ($result) {
    echo $successHtml;
} else {
    echo $errorHtml;
}
exit();
?>
