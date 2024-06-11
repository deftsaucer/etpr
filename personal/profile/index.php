<?session_start();

if (!isset($_COOKIE['auth_token_cookie']) && !isset($_SESSION['auth_token_session'])) {
    header('Location: /new/personal/?error=auth');
} else {
    $userId = (isset($_COOKIE['auth_token_cookie'])) ? $_COOKIE['auth_token_cookie'] : $_SESSION['auth_token_session'];
}

require_once $_SERVER['DOCUMENT_ROOT'] . '/new/core/classes/user.php';

// update profile 
$user = new User();

if (isset($_POST) && !empty($_POST)) {
    $user->updateUserData($_POST, $userId);
    header("Location: " . $_SERVER['REQUEST_URI']);
    exit();
}

$arUser = $user->getUserData($userId);

include $_SERVER['DOCUMENT_ROOT'] . "/new/header.php";?>

<div class="container py-5">
    <h1 class="mb-4">Личный кабинет</h1>
    <div class="row">
        <div class="col-md-2">
            <div class="nav flex-column nav-pills me-3" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                <button class="nav-link active" id="v-pills-profile-tab" data-bs-toggle="pill" data-bs-target="#v-pills-profile" type="button" role="tab" aria-controls="v-pills-profile" aria-selected="true">Профиль</button>
                <button class="nav-link" id="v-pills-tenders-add-tab" data-bs-toggle="pill" data-bs-target="#v-pills-tenders-add" type="button" role="tab" aria-controls="v-pills-tenders-add" aria-selected="false">Добавить тендер</button>
                <button class="nav-link" id="v-pills-tenders-list-tab" data-bs-toggle="pill" data-bs-target="#v-pills-tenders-list" type="button" role="tab" aria-controls="v-pills-tenders-list" aria-selected="false">Список тендеров</button>
                <button class="nav-link" id="v-pills-calls-tab" data-bs-toggle="pill" data-bs-target="#v-pills-calls" type="button" role="tab" aria-controls="v-pills-calls" aria-selected="false">Учет звонков</button>
            </div>
        </div>
        <div class="col-md-9">
            <div class="tab-content" id="v-pills-tabContent">

                <!-- PROFILE -->
                <div class="tab-pane fade show active" id="v-pills-profile" role="tabpanel" aria-labelledby="v-pills-profile-tab">
                    <h2 class="mb-4">Профиль</h2>
                    <div class="alert <?=($_SESSION['update_result'] == 'success') ? 'alert-success' : 'alert-danger';?>" id="updateSuccess" role="alert" 
                        style="<?=(!isset($_SESSION['update_result'])) ? 'display: none' : ''?>">
                        <?=$_SESSION['update_message']?>
                    </div>
                    <form id="profileForm" method="POST" action="">
                        <div class="mb-3">
                            <label for="username" class="form-label">ФИО</label>
                            <input type="text" class="form-control" id="fio" name="fio" value="<?=$arUser['fio']?>">
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">E-mail</label>
                            <input type="email" class="form-control" id="login" name="login" value="<?=$arUser['login']?>" readonly>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Телефон</label>
                            <input type="text" class="form-control" id="phone" name="phone" value="<?=$arUser['phone']?>">
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Пароль</label>
                            <input type="password" class="form-control" id="password" name="password" minlength="8" autocomplete="new-password">
                        </div>
                        <div class="mb-3">
                            <label for="password-confirm" class="form-label">Повторите пароль</label>
                            <input type="password" class="form-control" id="password-confirm" name="password-confirm" minlength="8">
                            <div class="form-text text-danger" style="display: none;" id="passwordError">Пароли не совпадают</div>
                        </div>
                        <button type="submit" class="btn btn-primary">Сохранить изменения</button>
                    </form>
                </div>

                <!-- ADD TENDER -->
                <div class="tab-pane fade" id="v-pills-tenders-add" role="tabpanel" aria-labelledby="v-pills-tenders-add-tab">
                    <h2 class="mb-4">Добавить тендер</h2>
                    <ul class="nav nav-tabs mb-4" id="myTab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="add-auto-tab" data-bs-toggle="tab" data-bs-target="#add-auto" type="button" role="tab" aria-controls="add-auto" aria-selected="true">По номеру закупки</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="add-manual-tab" data-bs-toggle="tab" data-bs-target="#add-manual" type="button" role="tab" aria-controls="add-manual" aria-selected="false">Вручную</button>
                        </li>
                    </ul>
                    
                    <!-- AUTO ADD -->
                    <div class="tab-content" id="myTabContent">
                        <div class="tab-pane fade show active" id="add-auto" role="tabpanel" aria-labelledby="add-auto-tab">
                            <form id="addTenderAutoForm" method="POST">
                                <div class="mb-3">
                                    <label for="tenderNumber" class="form-label">Введите номер закупки</label>
                                    <div class="d-flex">
                                        <input type="text" class="form-control me-2 w-25 md-w-75" id="tenderNumber" name="number">
                                        <button type="submit" class="btn btn-primary">Найти</button>
                                    </div>
                                </div>
                            </form>
                            <div class="loading-spinner" id="loadingSpinner"></div>
                            <div id="tenderResult"></div>
                        </div>

                        <!-- MANUAL ADD -->
                        <div class="tab-pane fade" id="add-manual" role="tabpanel" aria-labelledby="add-manual-tab">
                            <form id="addTenderManualForm" method="POST">
                                <div class="mb-3">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <label for="manualTenderNumber" class="form-label">Введите номер закупки</label>
                                            <input type="text" class="form-control" id="manualTenderNumber" name="number" minlength="11" required>
                                        </div>
                                        <div class="col-md-6">
                                            <label for="manualTenderLaw" class="form-label">Закон</label>
                                            <input type="text" class="form-control" id="manualTenderLaw" name="law" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label for="manualTenderMethod" class="form-label">Способ определения поставщика</label>
                                    <input type="text" class="form-control" id="manualTenderMethod" name="method" required>
                                </div>
                                <div class="mb-3">
                                    <label for="manualTenderObject" class="form-label">Объект закупки</label>
                                    <input type="text" class="form-control" id="manualTenderObject" name="object" required>
                                </div>
                                <div class="mb-3">
                                    <label for="manualTenderCustomer" class="form-label">Заказчик</label>
                                    <input type="text" class="form-control" id="manualTenderCustomer" name="customer" required>
                                </div>
                                <div class="mb-3">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <label for="manualTenderPrice" class="form-label">Цена</label>
                                            <input type="text" class="form-control" id="manualTenderPrice" name="price" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <label for="manualTenderPostDate" class="form-label">Дата публикации</label>
                                            <input type="date" class="form-control" id="manualTenderPostDate" name="post_date" required>
                                        </div>
                                        <div class="col-md-6">
                                            <label for="manualTenderEndDate" class="form-label">Дата окончания</label>
                                            <input type="date" class="form-control" id="manualTenderEndDate" name="end_date" required>
                                        </div>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-primary mb-3">Сохранить</button>
                            </form>
                            <div id="manualResult"></div>
                        </div>
                    </div>
                </div>
                
                <!-- TENDER LIST -->
                <div class="tab-pane fade" id="v-pills-tenders-list" role="tabpanel" aria-labelledby="v-pills-tenders-list-tab">
                    <h2 class="mb-4">Список тендеров</h2>
                    <div class="mb-3">
                        <button id="updateTenderList" class="btn btn-primary">Обновить</button>
                    </div>
                    <div id="tenderListResult"></div>
                </div>

                <!-- CALLS -->
                <div class="tab-pane fade" id="v-pills-calls" role="tabpanel" aria-labelledby="v-pills-calls-tab">
                    <h2 class="mb-4">Учет звонков</h2>
                    <ul class="nav nav-tabs mb-4" id="callsTab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="call-add-tab" data-bs-toggle="tab" data-bs-target="#call-add" type="button" role="tab" aria-controls="call-add" aria-selected="true">Добавить звонок</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="calls-list-tab" data-bs-toggle="tab" data-bs-target="#calls-list" type="button" role="tab" aria-controls="calls-list" aria-selected="false">Список звонков</button>
                        </li>
                    </ul>
                    <div class="tab-content" id="myTabCalls">
                        <div class="tab-pane fade show active" id="call-add" role="tabpanel" aria-labelledby="call-add-tab">
                            <form id="addCall" method="POST">
                                <div class="mb-3">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <label for="callCompany" class="form-label">Название компании</label>
                                            <input type="text" class="form-control" id="callCompany" name="company" required>
                                        </div>
                                        <div class="col-md-6">
                                            <label for="callDatetime" class="form-label">Дата и время звонка</label>
                                            <input type="datetime-local" class="form-control" id="callDatetime" name="datetime" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label for="callDescription" class="form-label">Комментарий</label>
                                    <textarea class="form-control" id="callDescription" name="description" rows="5"></textarea>
                                </div>
                                
                                <button type="submit" class="btn btn-primary mb-3">Сохранить</button>
                            </form>
                            <div id="addCallResult"></div>
                        </div>
                        <div class="tab-pane fade" id="calls-list" role="tabpanel" aria-labelledby="calls-list-tab">
                            <div class="mb-3">
                                <button id="updateCallsList" class="btn btn-primary">Обновить</button>
                            </div>
                            <div id="callsListResult"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?unset($_SESSION['update_result'])?>
<?unset($_SESSION['update_message'])?>
<?include $_SERVER['DOCUMENT_ROOT'] . "/new/footer.php";?>