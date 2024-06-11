<?session_start();?>
<?require_once $_SERVER['DOCUMENT_ROOT'] . "/new/header.php"?>
<?require_once $_SERVER['DOCUMENT_ROOT'] . '/new/core/functions.php';?>

<div class="p-3 text-center bg-body-tertiary">
    <div class="container py-5">
        <h1 class="text-body-emphasis">Товары</h1>
        <p class="col-lg-8 mx-auto lead">
            Широкий выбор носителей информации и программного обеспечения КриптоПро для безопасных решений вашего бизнеса. 
            Инновационные технологии для надежного хранения данных и защиты информации.
        </p>
    </div>
</div>
<div class="container mt-5">
    <?$arCatalog = getCatalogElements();?>
    <?foreach ($arCatalog['sections'] as $arSection):?>
        <h2 class="mb-4 pb-2 border-bottom"><?=$arSection['name'];?></h2>
        <div class="row">
            <?foreach ($arCatalog['elements'] as $arElement):?>
                <?if ($arElement['category_id'] == $arSection['id']):?>
                    <div class="col-lg-3 col-md-6 mb-4">
                        <div class="card h-100">
                            <img src="/new/img/<?=$arElement['image']?>" class="card-img-top" alt="image">
                            <div class="card-body">
                                <h5 class="card-title"><?=$arElement['name']?></h5>
                                <p class="card-text"><?=$arElement['description']?></p>
                                <a href="#" class="btn btn-primary btn-order" data-bs-toggle="modal" data-bs-target="#modalOrderFrom" data-product-id="<?=$arElement['id']?>" data-product-name="<?=$arElement['name']?>">Заказать</a>
                            </div>
                        </div>
                    </div>
                <?endif;?>
            <?endforeach;?>  
        </div>
    <?endforeach;?>
</div>

<div class="modal fade" id="modalOrderFrom" tabindex="-1" aria-labelledby="modalOrderFrom" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content rounded-4 shadow">
            <div class="modal-header p-5 pb-0 border-bottom-0">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-5 pt-0" id="form-container">
                <form class="" id="formOrder">
                    <h1 class="fw-bold fs-2 mb-2">Заказать товар</h1>
                    <div class="fw-bold fs-5 mb-2" id="productName"></div>
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" id="floatingName" name="name" placeholder="ФИО" required>
                        <label for="floatingName">Ваше имя*</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="email" class="form-control" id="floatingEmail" name="email" placeholder="name@example.com" required>
                        <label for="floatingInput">Ваш E-mail*</label>
                    </div>
                    <div class="form-floating mb-3">
                        <textarea class="form-control h-100" id="floatingQuestion" rows="4" name="question" placeholder="Комментарий"></textarea>
                        <label for="floatingQuestion">Комментарий</label>
                    </div>
                    <input type="hidden" id="hiddenInput" name="formid" value="formOrder">
                    <input type="hidden" id="productId" name="productid" value="">
                    <button class="w-100 btn btn-lg btn-primary" type="submit">Отправить</button>
                </form>
            </div>
        </div>
    </div>
</div>
<?include $_SERVER['DOCUMENT_ROOT'] . "/new/footer.php"?>