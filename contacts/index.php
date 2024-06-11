<?session_start();?>
<?include $_SERVER['DOCUMENT_ROOT'] . "/new/header.php"?>
<div class="container py-5">
    <h1 class="mb-4">Контакты</h1>

    <div class="row mb-3">
        <div class="col-md-6">
            <p class="fs-5">Здесь вы можете найти всю необходимую информацию для связи с нами. Если у вас есть вопросы, 
                предложения или вы хотите узнать больше о наших услугах, не стесняйтесь обращаться. 
                Мы всегда готовы помочь вам.</p>
            <p class="fw-bold fs-4 mb-2">Телефоны:</p>
            <p class="fs-5 mb-2">+7 (123) 456-7890</p>
            <p class="fs-5 mb-2">+7 (123) 456-7890</p>
            <p class="fw-bold fs-4 mb-2">Email:</p>
            <p class="fs-5 mb-2">info@example.com</p>
            <p class="fw-bold fs-4 mb-2">Адрес:</p>
            <p class="fs-5 mb-2">г. Москва, ул. Пушкина, д.10</p>            
        </div>

        <div class="col-md-10 mx-auto col-lg-6">
            <div id="form-container" class="p-4 p-md-5 border rounded-3 bg-body-tertiary" style="height: 540px;">
                <form class="" id="formFeedback">
                    <h1 class="fw-bold fs-2 mb-4">Обратная связь</h1>
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" id="floatingName" name="name" placeholder="ФИО" required>
                        <label for="floatingName">Ваше имя</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="email" class="form-control" id="floatingEmail" name="email" placeholder="name@example.com" required>
                        <label for="floatingInput">Ваш E-mail</label>
                    </div>
                    <div class="form-floating mb-3">
                        <textarea class="form-control h-100" id="floatingQuestion" rows="6" name="question" placeholder="Вопрос..." required></textarea>
                        <label for="floatingQuestion">Ваш вопрос</label>
                    </div>
                    <input type="hidden" id="hiddenInput" name="formid" value="formFeedback">
                    <button class="w-100 btn btn-lg btn-primary" type="submit">Отправить</button>
                </form>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col">
        <script type="text/javascript" charset="utf-8" async src="https://api-maps.yandex.ru/services/constructor/1.0/js/?um=constructor%3A07567be8cd5cb383ed70eb662c6cf710defc7656ede2b2a001196ef6cd480c67&amp;width=100%25&amp;height=400&amp;lang=ru_RU&amp;scroll=true"></script>        </div>
    </div>
</div>
<?include $_SERVER['DOCUMENT_ROOT'] . "/new/footer.php"?>