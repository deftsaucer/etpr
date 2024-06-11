<?session_start();?>
<?include $_SERVER['DOCUMENT_ROOT'] . "/new/header.php"?>
<!-- intro -->
<div class="container px-4 py-5 my-5 text-center">
    <img class="d-block mx-auto mb-4" src="/new/img/logo.png" alt="" width="80">
    <h1 class="display-5 fw-bold text-body-emphasis">Добро пожаловать на Tender & IT!</h1>
    <div class="col-lg-6 mx-auto">
        <p class="lead mb-4">Мы — современная компания в сфере электронных закупок в Сибирском регионе, специализирующаяся на обучении, консультациях и сопровождении по тендерам и аукционам.</p>
        <div class="d-grid gap-2 d-sm-flex justify-content-sm-center">
            <a href="/new/services/" class="btn btn-primary btn-lg px-4 gap-3">Посмотреть услуги</a>
            <a href="#feedbackBlock" class="btn btn-outline-primary btn-lg px-4">Связаться с нами</a>
        </div>
    </div>
</div>

<!-- services block -->
<div class="container px-4 py-1" id="hanging-icons">
    <h2 class="pb-2 border-bottom">Что мы предлагаем</h2>
    <div class="row g-4 py-3 row-cols-1 row-cols-lg-2">
        <div class="col d-flex align-items-start">
            <img class="m-2" src="/new/img/briefcase.svg" alt="SVG Image" width="24" height="24">
            <div class="d-flex flex-column justify-content-between h-100">
                <h3 class="fs-2 text-body-emphasis">Сопровождение в закупках</h3>
                <p>Получите полное сопровождение на всех этапах участия в электронных торгах и тендерах.
                    Мы поможем установить и настроить ЭЦП, подготовим и подадим заявки на аукционы.
                    Наши тендерные менеджеры найдут подходящие торги и обеспечат успешное участие вашей компании.</p>  
                <div class="col col-md-6 mt-auto">
                    <a href="/new/services/" class="btn btn-primary mt-auto w-100">
                        Посмотреть услуги
                    </a>
                </div>
            </div>
        </div>
        <div class="col d-flex align-items-start">
            <img class="m-2" src="/new/img/book.svg" alt="SVG Image" width="24" height="24">
            <div class="d-flex flex-column justify-content-between h-100">
                <h3 class="fs-2 text-body-emphasis">Обучение</h3>
                <p> Мы предлагаем широкий спектр программ и консультаций по электронным закупкам, помогая освоить все аспекты
                    участия в тендерах и аукционах. Наши специалисты готовы обучить вас использованию электронных площадок,
                    подготовке и подаче заявок, а также повысить эффективность участия вашей компании в электронных закупках</p>
                <div class="col col-md-6 mt-auto">
                    <a href="/new/education/" class="btn btn-primary mt-auto w-100">
                        Посмотреть программы обучения
                    </a>
                </div>
            </div>
        </div>
        <div class="col d-flex align-items-start">
            <img class="m-2" src="/new/img/bag.svg" alt="SVG Image" width="24" height="24">
            <div class="d-flex flex-column justify-content-between h-100">
                <h3 class="fs-2 text-body-emphasis">Товары</h3>
                <p>Познакомьтесь с нашим ассортиментом товаров для безопасного и эффективного участия в электронных торгах.
                    Мы предлагаем высококачественные носители информации и программное обеспечение КриптоПро,
                    обеспечивающее надежную защиту данных и безопасность вашей компании в цифровом пространстве.</p>
                <div class="col col-md-6 mt-auto">
                    <a href="/new/catalog/" class="btn btn-primary mt-auto w-100">
                        Перейти к товарам
                    </a>
                </div>
            </div>
        </div>
        <div class="col d-flex align-items-start">
            <img class="m-2" src="/new/img/code-slash.svg" alt="SVG Image" width="24" height="24">
            <div class="d-flex flex-column justify-content-between h-100">
                <h3 class="fs-2 text-body-emphasis">Разработка веб-сайтов и программ</h3>
                <p>Доверьте нам создание вашего веб-сайта и индивидуальных программных решений для вашего бизнеса.
                    Наша команда профессионалов поможет вам воплотить в жизнь уникальные и эффективные веб-сайты,
                    а также разработает программы, соответствующие вашим потребностям и целям.</p>
                <div class="col col-md-6 mt-auto">
                    <a href="/new/development/" class="btn btn-primary mt-auto w-100">
                        Посмотреть наши работы
                    </a>
                </div>
                
            </div>
        </div>
    </div>
</div>

<div class="container col-xl-11 col-xxl-10 px-4 py-1" id="feedbackBlock">
    <div class="row align-items-center g-lg-5 my-5">
        <div class="col-lg-7 text-center text-lg-start">
            <h1 class="display-4 fw-bold lh-1 text-body-emphasis mb-3">Есть вопросы?<br>Напишите нам!</h1>
            <p class="col-lg-10 fs-5">Вы можете задать любые вопросы по интересующей вас информации.
                Наши эксперты с удовольствием помогут вам и дадут ответы на все ваши запросы.
                Мы готовы быть на связи и оказать вам необходимую поддержку.</p>
        </div>
        <div class="col-md-10 mx-auto col-lg-5 ">
            <div id="form-container" class="p-4 p-md-5 border rounded-3 bg-body-tertiary" style="height: 540px;">
                <form class="" id="formFeedback">
                    <h1 class="fw-bold fs-2 mb-4">Задать вопрос</h1>
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
</div>
<?include $_SERVER['DOCUMENT_ROOT'] . "/new/footer.php"?>
