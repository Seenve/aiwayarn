<?php if (!isset($_SERVER['HTTP_X_PJAX'])) { include 'header.php'; } ?>

<section class="section section-works section_top-space-230 section_first">
    <div class="container">
        <div class="row">
            <div class="col-md-12 section__header-wrap">
                <h1 class="title__section title__h1 title_horizontal-line"><span class="reveal reveal_gray"><?php echo $title_page; ?></span></h1>
                <p class="section__subtitle">Оставьте свои контактные данные, и мы перезвоним чтобы уточнить детали и сообщить Вам стоимость либо позвоните нам:
                    <a href="tel:+<? echo settings()['0']['phone']; ?>"><? echo phone(settings()['0']['phone']); ?></a>
                </p>
            </div>
        </div>
        <div class="row">
            <div class="col-md-8 section__header-wrap">
                <form id="s2" class="ajax-forms">
                    <input type="hidden" name="form" value="Обратная связь">
                    <input name="utm_source" type="hidden" value="<?php echo $_GET['utm_source']; ?>">
                    <input name="utm_term" type="hidden" value="<?php echo $_GET['utm_term']; ?>">
                        <!--<div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="firstName" class="label">Имя *</label>
                                    <input type="text" class="form-control input" id="firstName" required data-error="Пожалуйста, напишите свое имя." autocomplete="off">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="lastName" class="label">Фамилия *</label>
                                    <input type="text" class="form-control input" id="lastName" required data-error="Пожалуйста, напишите свою фамилию." autocomplete="off">
                                </div>
                            </div>
                        </div>-->
                        <div class="row">
                            <div class="col-md-6">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="firstname" class="label">Имя *</label>
                                            <input type="text" class="form-control input" name="firstname" id="firstname" required data-error="Пожалуйста, напишите своё Имя." autocomplete="off">
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="email" class="label">E-mail *</label>
                                            <input type="email" class="form-control input" name="email" id="email" required data-error="Пожалуйста, напишите свой E-mail." autocomplete="off">
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="phone" class="label">Телефон *</label>
                                            <input type="tel" class="form-control input"  name="phone" id="phone" required data-error="Пожалуйста, напишите свой телефон." autocomplete="off">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <select class="form-control select" id="exampleFormControlSelect1">
                                                <option disabled="" selected="">Выберите тип</option>
                                                <option value="1">Сайт-визитка</option>
                                                <option value="2">Сайт-каталог</option>
                                                <option value="3">Интернет-магазин</option>
                                                <option value="4">Адаптивный дизайн</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="message" class="label">Краткое описание</label>
                                            <textarea class="form-control input" id="message" style="min-height: 114px;" required data-error="Пожалуйста, напишите ваше сообщение."></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="btn-block">
                                    <button type="submit" class="btn">Отправить</button>
                                    <div id="result"></div>
                                </div>
                            </div>
                        </div>
                </form>
            </div>
        </div>
    </div>
</section>

