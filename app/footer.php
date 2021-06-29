</main><!-- #main -->

<footer class="footer">
    <div class="container">
        <div class="row">
            <div class="col-lg-2 col-md-6 col-sm-6">
                <p class="footer__title">Каталог</p>
                <ul class="footer__menu">
                    <li>
                        <a href="/catalog" data-pjax="content">Все товары</a>
                    </li>
                    <li>
                        <a href="/" data-pjax="content">Топ продаж</a>
                    </li>
                    <li>
                        <a href="/akcii-i-predlozheniya" data-pjax="content">Распродажа</a>
                    </li>
                </ul>
            </div>

            <div class="col-lg-3 col-md-6 col-sm-6">
                <p class="footer__title">Личный кабинет</p>
                <ul class="footer__menu">
                    <li>
                        <a href="/mne-nravit-sya" data-pjax="content">Нравится</a>
                    </li>
                    <li>
                        <a href="/cart" data-pjax="content">Корзина</a>
                    </li>
                    <li>
                        <a href="/profile" data-pjax="content">Мой профиль</a>
                    </li>
                    <li>
                        <a href="/news" data-pjax="content">Новости</a>
                    </li>
                </ul>
            </div>

            <div class="col-lg-4 col-md-6 col-sm-6">
                <p class="footer__title">Важная информация</p>
                <ul class="footer__menu">
                    <li><a href="/politika-konfidencial-nosti" data-pjax="content">Политика конфиденциальности</a></li>
                    <li><a href="/pol-zovatel-skoe-soglashenie" data-pjax="content">Пользовательское соглашение</a></li>
                    <li><a href="/usloviya-obmena-i-vozvrata" data-pjax="content">Условия обмена и возврата</a></li>
                    <li><a href="/opisanie-processa-platezhey" data-pjax="content">Описание процесса платежeй</a></li>
                </ul>
            </div>

            <div class="col-lg-3 col-md-6 col-sm-6">
                <p class="footer__title">Контакты</p>
                <ul class="footer__list">
                    <li><i class="fas fa-phone"></i><a href="tel:<?php echo phone(settings_id($city_products)[0]['phone']); ?>"><?php echo phone(settings_id($city_products)[0]['phone']); ?></a></li>
                    <li><i class="fas fa-envelope"></i><a href="mailto:<?php echo settings_id($city_products)[0]['email']; ?>"><?php echo settings_id($city_products)[0]['email']; ?></a></li>
                    <li><i class="fas fa-map-marker-alt"></i><a href="/contacts" data-pjax="content"><?php echo settings_id($city_products)[0]['address']; ?></a></li>
                    <li class="footer__socials">
                        <a href="<?php echo settings_id($city_products)[0]['soc_4']; ?>"><i class="fab fa-vk"></i></a>
                        <a href="<?php echo settings_id($city_products)[0]['soc_3']; ?>"><i class="fab fa-facebook"></i></a>
                        <a href="<?php echo settings_id($city_products)[0]['soc_2']; ?>"><i class="fab fa-instagram"></i></a>
                    </li>
                    <li>
                        <!--<a class="list-contact__btn btn-transparent_blue btn-size_m" href="#">Обратная связь</a>-->
                    </li>
                </ul>
            </div>

        </div>
        <div class="row footer__pays">
            <div class="col-lg-4 col-md-8 col-sm-6 col-4">
                <a href="/" class="footer__logo" data-pjax="content">
                    <img src="/assets/img/logo_white.svg" alt="AiwaYarn Studio">
                </a>
            </div>
            <div class="col-lg-8 col-md-4 col-sm-6 col-8">
                <div class="footer__right">
                    <div class="pays">
                        <!-- <i title="Cash" class="cacsh"></i> -->
                        <i title="MasterCard" class="mastercard"></i>
                        <i title="Visa" class="visa"></i>
                        <i title="WebMoney" class="webmoney"></i>
                        <i title="Qiwi" class="qiwi"></i>
                        <i title="Sberbank" class="sbrf"></i>
                        <!-- <i title="Alfa" class="alfa"></i> -->
                        <i title="Mir" class="mir"></i>
                        <!-- <i title="Jcb" class="jcb"></i> -->
                        <!-- <i title="PayPal" class="paypal"></i> -->
                        <!--<i title="Maestro" class="maestro"></i>-->
                        <i title="Yoomoney" class="yoomoney"></i>
                        <!-- <i title="Yookassa" class="yookassa"></i> -->
                        <!--<i title="Belkart" class="belkart"></i>
                        <i title="Halva" class="halva"></i>
                        <i title="Tinkoff" class="tinkoff"></i> -->                     
                    </div>
                </div>
            </div>
        </div>
        <div class="row footer__copy">
            <div class="col-lg-8">
                <small>© 2021 «AIWA YARN». Все права защищены. Копирование информации с сайта, полное или частичное запрещено.</small>
            </div>
              <div class="col-lg-4">
                <div class="footer__right">
                    <a href="https://seenve.ru"><small>Создание сайтое &mdash; Seenve</small></a>
                </div>
            </div>
        </div>
    </div>
</footer>

    <div class="default-form modal buy-product " style="display: none;">
        <div class="wrapper">
            <form class="modal--shadow ajax" method="POST" data-action="/api/form-contact.php">
                <input type="hidden" name="form" value="Покупка товара">
                <input type="hidden" name="message" value="" id="product_info">
                <div class="default-form__header">
                    <div class="close">
                        <span></span>
                        <span></span>
                    </div>
                </div>
    
                <div class="default-form__body">
                    <h5 class="default-form__title">Заказать товар</h5>
    
                    <div class="default-form__block-form">
                        <input type="text" placeholder="Ваше имя" name="firstname" class="modal__input default-form__input">
                        <input type="tel" placeholder="Ваш телефон" name="phone" class="modal__input default-form__input">
                        <button type="submit" class="btn btn-orange btn-size_full">Отправить заявку о заказе</button>
                    </div>
    
                </div>
    
                <div class="default-form__footer">
                    <div class="default-form__private checkbox-private">
                        <label for="modalCheckbox" class="checkbox__label">
                            <div class="checkbox__group">
                                <input type="checkbox" class="checkbox__input" id="modalCheckbox" hidden checked />
                                <span class="checkbox__checked"></span>
                            </div>
                        </label>
                        <div class="checkbox-private__text-block">
                            <span class="checkbox-private__text">Я принимаю политику обработки </span>
                            <a class="checkbox-private__link vis-modal-p" href="#"> персональных данных</a>
                        </div>
                    </div>
                </div>
                <div class="modal__success">
                    <h5>
                        Спасибо!<br>
                        Ваша заявка принята. <br><br>
                        Наш менеджер свяжется с вами в самое ближайшее время!
                    </h5>       
                    <a href="/" type="submit" class="btn btn-orange btn-size_full" data-pjax="content">Вернуться на Главную страницу</a>
                    <small>Данное окно закроется через 10 секунд</small>
                </div>
            </form>
        </div>
    </div>

    <div class="default-form modal footer-modal" style="display: none;">
        <div class="wrapper">
            <form class="modal--shadow ajax" method="POST" data-action="/api/form-contact.php">
                <input type="hidden" name="form" value="Обратный звонок">
                <div class="default-form__header">
                    <div class="close">
                        <span></span>
                        <span></span>
                    </div>
                </div>
    
                <div class="default-form__body">
                    <h5 class="default-form__title">Заказать обратный звонок</h5>
    
                    <div class="default-form__block-form">
                        <input type="text" placeholder="Ваше имя" name="firstname" class="modal__input default-form__input">
                        <input type="tel" placeholder="Ваш телефон" name="phone" class="modal__input default-form__input">
                        <button type="submit" class="btn btn-orange btn-size_full">Перезвоните мне пожалуйста</button>
                    </div>
    
                </div>
    
                <div class="default-form__footer">
                    <div class="default-form__private checkbox-private">
                        <label for="modalCheckbox" class="checkbox__label">
                            <div class="checkbox__group">
                                <input type="checkbox" class="checkbox__input" id="modalCheckbox" hidden checked />
                                <span class="checkbox__checked"></span>
                            </div>
                        </label>
                        <div class="checkbox-private__text-block">
                            <span class="checkbox-private__text">Я принимаю политику обработки </span>
                            <a class="checkbox-private__link vis-modal-p" href="#"> персональных данных</a>
                        </div>
                    </div>
                </div>
                <div class="modal__success">
                    <h5>
                        Спасибо!<br>
                        Ваша заявка принята. <br><br>
                        Наш менеджер свяжется с вами в самое ближайшее время!
                    </h5>       
                    <a href="/" type="submit" class="btn btn-orange btn-size_full" data-pjax="content">Вернуться на Главную страницу</a>
                    <small>Данное окно закроется через 10 секунд</small>
                </div>
            </form>
        </div>
    </div>

    <div class="political modal" style="display: none;">
        <div class="wrapper">
            <div class="political-modal notic-thank modal--shadow">
                <div class="notic-thank__header">
                    <div class="close">
                        <span></span>
                        <span></span>
                    </div>
                </div> 
                <div class="political-modal__body notic-thank__body">

                </div>
                <div class="notic-thank__footer">
                    <span class="countdown"></span>
                </div>
            </div>
        </div>
    </div>

    <script type="text/javascript" src="/assets/js/libs/jquery.min.js"></script>
    <script type="text/javascript" src="/assets/js/libs/swiper.min.js"></script>
    <script src="/assets/js/jquery.pjax.js"></script>
    <script type="text/javascript" src="/assets/js/libs/jquery.fancybox.min.js"></script>
    <script type="text/javascript" src="/assets/js/libs/jquery.maskedinput.min.js"></script>
    <script type="text/javascript" src="/assets/js/app.min.js?v=<? echo $version; ?>"></script>

</body>
</html>