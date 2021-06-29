<section class="about <? if($page !== 'o-kompanii') { echo 'c--bg-gray'; } else { echo 'hide-button'; } ?>">
    <div class="container-fluid container-md">
        <h5 class="about__title">О компании</h5>
        <div class="row">
            <div class="col-lg-5">
                <div class="about-left">
                    <div class="about-left__text">
                        <h4 class="about-left__benefits">Reinmaster - компания, уже 20 лет производящая профессиональное оборудование для полного цикла обслуживания!</h4>
                        <p>Reinmaster производит весь спектр профессионального оборудования для прачечных и химчисток. Наше оборудование славится низкой ценой и достойным уровнем качества.</p>
                    </div>
                    <a href="/o-kompanii" data-pjax="content" class="about-left__btn btn btn-transparent_blue btn-size_m">Подробнее о нас <svg width="8" height="12" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M4.68 5.997l-4.488 4.49A.65.65 0 000 10.95c0 .176.068.34.192.464l.393.393a.651.651 0 00.464.192c.176 0 .34-.068.464-.192l5.345-5.345a.65.65 0 00.192-.465.651.651 0 00-.192-.466L1.518.192A.651.651 0 001.054 0 .651.651 0 00.59.192L.197.585a.657.657 0 000 .928L4.68 5.997z" fill="#007AFF"></path></svg></a>
                </div>
            </div>

            <!--<div class="col-lg-7">
                <div class="about-right">
                    <h5 class="about-right__title">Наша команда</h5>
                    <div class="row">
                        <div class="about-right__content-m">
                            <div class="about-right__specialist-contacts">
                                <p class="about-right__name">Перов Владислав Сергеевич</p> 
                                <p class="about-right__mail">коммерческий директор</p>
                                <a class="about-right__link" href="mailto:ckt.nsk@gmail.com">ckt.nsk@gmail.com</a>
                                <a class="about-right__link about-right__phone" href="tel:+7(383)274-32-32">8(383)274-32-32</a>
                            </div>
                            <div class="about-right__block-img">
                                <img src="/images/main/about_company/men.png" alt="Наш специалист">
                            </div>
                        </div>
                    </div>
                </div>
            </div>-->
            <div class="col-lg-7">
                <div class="circle">
                    <div class="circle__text">
                        <div class="circle__list about-list">
                            <p class="about-list__name">Перов Владислав Сергеевич</p> 
                            <p class="about-list__name2">коммерческий директор</p>
                            <a class="about-list__email" href="mailto:ckt.nsk@gmail.com">ckt.nsk@gmail.com</a>
                            <a class="about-list__phone" href="tel:+7(383)274-32-32">8(383)274-32-32</a>
                        </div>
                    </div>
                    <div class="circle__photo">
                        <img src="/images/main/about_company/men.png" alt="Наш специалист">
                    </div>
                    <div class="circle__touch"></div>
                </div>
            </div>





        </div>
        <div class="row">
            <div class="col-12">
                <div class="about-list row">

                    <?
                        $query_about = mysqli_query($GLOBALS['db'], "SELECT * FROM `about` ORDER BY regdate DESC");
                        $i = 0;
                        while($row_about = mysqli_fetch_array($query_about)) {
                            $i++;
                            if($row_about['site']) {
                                ?>
                                    <div class="about-item col-12 col-lg-6 col-xl-3">
                                        <h5 class="about-item__title"><?php echo $row_about['title']; ?></h5>
                                        <p class="about-item__text"><?php echo htmlspecialchars_decode($row_about['content']); ?></p>
                                        <a class="about-item__link link link--blue" href="<?php echo $row_about['site']; ?>">Узнать подробнее <svg width="8" height="12" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M4.68 5.997l-4.488 4.49A.65.65 0 000 10.95c0 .176.068.34.192.464l.393.393a.651.651 0 00.464.192c.176 0 .34-.068.464-.192l5.345-5.345a.65.65 0 00.192-.465.651.651 0 00-.192-.466L1.518.192A.651.651 0 001.054 0 .651.651 0 00.59.192L.197.585a.657.657 0 000 .928L4.68 5.997z" fill="#007AFF"></path></svg></a>
                                    </div>
                                <?
                            } else {
                                ?>
                                    <div class="about-item col-12 col-lg-6 col-xl-3">
                                        <h5 class="about-item__title"><?php echo $row_about['title']; ?></h5>
                                        <p class="about-item__text"><?php echo htmlspecialchars_decode($row_about['content']); ?></p>
                                    </div>
                                <?
                            }
                        }
                    ?>

                    <a href="/o-kompanii" class="about-list__btn btn btn-transparent_blue btn-size_m" data-pjax="content">Подробнее о нас <svg width="8" height="12" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M4.68 5.997l-4.488 4.49A.65.65 0 000 10.95c0 .176.068.34.192.464l.393.393a.651.651 0 00.464.192c.176 0 .34-.068.464-.192l5.345-5.345a.65.65 0 00.192-.465.651.651 0 00-.192-.466L1.518.192A.651.651 0 001.054 0 .651.651 0 00.59.192L.197.585a.657.657 0 000 .928L4.68 5.997z" fill="#007AFF"></path></svg></a>
                </div>
            </div>
        </div>
    </div>
</section>