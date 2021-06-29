<?php 
	if (!isset($_SERVER['HTTP_X_PJAX'])) { 
		/*$og_url = $_SERVER['REQUEST_URI'];
		if(gallery_arr('portfolio', $row_page['id'], '1')['0']['image']) {
			$og_image = settings()['0']['url'].$uploads_middle.gallery_arr('portfolio', $row_page['id'], '1')['0']['image'];
		}*/
		include 'header.php'; 
	}
?>

<?php include $path.'/../modules/breadcrumbs.php'; ?>

<?php include $path.'/../modules/about.php'; ?>

<section class="declaration c--bg-gray">
    <div class="container">
        <div class="row">
            <div class="col-lg-5">
                <div class="declaration__inner">
                    <h2 class="declaration__title">Декларации соответствия</h2>
                    <p class="declaration__text">
                        <b>Компания—производитель “ReinMaster” гарантирует, что поставляемая им продукция соответствует требованиям нормативных документов и удостоверяет это с помощью сертификатов соответствия предоставляемых по запросу покупателя.</b>
                    </p>
                    
                    <p class="declaration__text">
                        Проверить подлинность декларации о соответствии таможенного союза (ЕАС) можно в едином реестре зарегистрированных деклараций о соответствии Таможенного союза. Декларация о соответствии имеет юридическую силу наравне с сертификатом соответствия и действует на всей территории РФ.
                    </p>
                </div>
            </div>

            <div class="offset-lg-1 col-lg-6">
                <div class="declaration__list-sert">
                    <div class="declaration__item-sert">
                        <img src="/images/main/about_company/declaration-1.jpg" alt="">
                    </div>
                    <div class="declaration__item-sert">
                        <img src="/images/main/about_company/declaration-2.jpg" alt="">
                    </div>
                    <div class="declaration__item-sert">
                        <img src="/images/main/about_company/declaration-3.jpg" alt="">
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="prod">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <h2>Наше производство</h2>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12 prod__content">
                <p>Самая большая ценность нашей компании, это наши сотрудники. <br>Опытные, квалифицированные специалисты которым по плечу любая задача, даже самая нетривиальная.</p>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-8">
                <picture class="prod__first">
                    <img src="/images/main/about_company/1.jpg" alt="">
                </picture>
            </div>
            <div class="col-lg-4">
                <div class="row">
                    <div class="col-lg-12">
                        <picture>
                            <img src="/images/main/about_company/2.jpg" alt="">
                        </picture>
                    </div>
                    <div class="col-lg-12">
                        <picture>
                            <img src="/images/main/about_company/3.jpg" alt="">
                        </picture>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>


<?php include $path.'/../modules/contact-feed.php'; ?>

