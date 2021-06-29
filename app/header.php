<!DOCTYPE html>
<html lang="ru">
<head>
    <title><?php echo meta($arrGet, $ajax)['title']; ?></title>
    <meta charset="utf-8">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">

    <meta name="title" content="<?php echo meta($arrGet, $ajax)['title']; ?>">
    <meta name="description" content="<?php echo meta($arrGet, $ajax)['description']; ?>">
    <meta name="keywords" content="<?php echo meta($arrGet, $ajax)['keywords']; ?>">
    <meta name="author" lang="ru" content="Seenve Studio">
    <meta name="copyright" content="seenve.ru">
    <meta name="Reply-to" Content="admin@seenve.ru">

    <meta property="og:type" content="website">
    <meta property="og:site_name" content="<?php echo settings()['0']['site_name']; ?>">
    <meta property="og:title" content="<?php echo meta($arrGet, $ajax)['title_page']; ?>">
    <meta property="og:url" content="<?php echo meta($arrGet, $ajax)['url']; ?>">
    <meta property="og:description" content="<?php echo meta($arrGet, $ajax)['description']; ?>">
    <meta property="og:locale" content="ru_RU">
    <meta property="og:image" content="<?php echo meta($arrGet, $ajax)['imageUrl']; ?>">
    <meta property="og:image:secure_url" content="<?php echo meta($arrGet, $ajax)['imageUrl']; ?>">
    <meta property="og:image:type" content="image/jpeg">

    <link rel="canonical" href="<?php echo meta($arrGet, $ajax)['url']; ?>/">

    <link rel="preload" as="style" href="/assets/css/library/fontawesome.min.css?v=2.0">

    <link rel="stylesheet" href="/assets/css/library/swiper.min.css">
    <link rel="stylesheet" href="/assets/css/library/nprogress.css">
    <link rel="stylesheet" href="/assets/css/library/jquery.fancybox.min.css">
    <link rel="stylesheet" href="/assets/css/library/animate.css">
    <link rel="stylesheet" href="/assets/fonts/OpenSans/stylesheet.css">
    <link rel="stylesheet" href="/assets/fonts/Montserrat/stylesheet.css">
    <link rel="stylesheet" href="/assets/css/library/fontawesome.min.css?v=2.0">
    <link rel="stylesheet" href="/assets/css/index.css?v=<? echo $version; ?>">

    <link rel="shortcut icon" type="image/png" href="<?php echo settings()['0']['url']; ?>/assets/icons/icon_16x16.png" sizes="16x16">
    <link rel="shortcut icon" type="image/png" href="<?php echo settings()['0']['url']; ?>/assets/icons/icon_32x32.png" sizes="32x32">
    <link rel="shortcut icon" type="image/png" href="<?php echo settings()['0']['url']; ?>/assets/icons/icon_128x128.png" sizes="128x128">
    <link rel="shortcut icon" type="image/x-icon" href="<?php echo settings()['0']['url']; ?>/assets/icons/favicon.ico">

    <link rel="apple-touch-icon" sizes="57x57" href="<?php echo settings()['0']['url']; ?>/assets/icons/apple-touch-icon-57x57.png">
    <link rel="apple-touch-icon" sizes="72x72" href="<?php echo settings()['0']['url']; ?>/assets/icons/apple-touch-icon-72x72.png">
    <link rel="apple-touch-icon" sizes="76x76" href="<?php echo settings()['0']['url']; ?>/assets/icons/apple-touch-icon-76x76.png">
    <link rel="apple-touch-icon" sizes="114x114" href="<?php echo settings()['0']['url']; ?>/assets/icons/apple-touch-icon-114x114.png">
    <link rel="apple-touch-icon" sizes="120x120" href="<?php echo settings()['0']['url']; ?>/assets/icons/apple-touch-icon-120x120.png">
    <link rel="apple-touch-icon" sizes="144x144" href="<?php echo settings()['0']['url']; ?>/assets/icons/apple-touch-icon-144x144.png">
    <link rel="apple-touch-icon" sizes="152x152" href="<?php echo settings()['0']['url']; ?>/assets/icons/apple-touch-icon-152x152.png">
    <link rel="apple-touch-icon" sizes="180x180" href="<?php echo settings()['0']['url']; ?>/assets/icons/apple-touch-icon-180x180.png">
    <link rel="apple-touch-icon" sizes="167x167" href="<?php echo settings()['0']['url']; ?>/assets/icons/apple-touch-icon-167x167.png">

    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

    <script src="https://maps.api.2gis.ru/2.0/loader.js?pkg=basic&skin=dark&lazy=true"></script>

    <!-- Yandex.Metrika counter -->
    <script type="text/javascript" >
       (function(m,e,t,r,i,k,a){m[i]=m[i]||function(){(m[i].a=m[i].a||[]).push(arguments)};
       m[i].l=1*new Date();k=e.createElement(t),a=e.getElementsByTagName(t)[0],k.async=1,k.src=r,a.parentNode.insertBefore(k,a)})
       (window, document, "script", "https://mc.yandex.ru/metrika/tag.js", "ym");

       ym(73356055, "init", {
            clickmap:true,
            trackLinks:true,
            accurateTrackBounce:true,
            webvisor:true
       });
    </script>
    <noscript><div><img src="https://mc.yandex.ru/watch/73356055" style="position:absolute; left:-9999px;" alt="" /></div></noscript>
    <!-- /Yandex.Metrika counter -->

    <!-- Facebook Pixel Code -->
    <script>
    !function(f,b,e,v,n,t,s)
    {if(f.fbq)return;n=f.fbq=function(){n.callMethod?
    n.callMethod.apply(n,arguments):n.queue.push(arguments)};
    if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
    n.queue=[];t=b.createElement(e);t.async=!0;
    t.src=v;s=b.getElementsByTagName(e)[0];
    s.parentNode.insertBefore(t,s)}(window, document,'script',
    'https://connect.facebook.net/en_US/fbevents.js');
    fbq('init', '784696088836178');
    fbq('track', 'PageView');
    </script>
    <noscript><img height="1" width="1" style="display:none"
    src="https://www.facebook.com/tr?id=784696088836178&ev=PageView&noscript=1"
    /></noscript>
    <!-- End Facebook Pixel Code -->

</head>

<body>

    <?php //var_dump(meta($_GET)); ?>

    <div data-uuid="<?php echo $uuid; ?>" style="display: none;"></div>
    <div data-ip="<?php echo $_SERVER['REMOTE_ADDR']; ?>" style="display: none;"></div>

    <div id="notify"></div>

    <div class="overlay">
        
    </div>

    <div class="search active2">
        <div class="search__overlay"></div>
        <form action="/search" data-pjax="content">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="search__groups">     
                            <div class="search__group">
                                <input type="text" name="q" placeholder="Поиск" class="search__input">
                            </div>
                            <div class="search__group loading-icon loading-x1">
                                <div class="close">
                                    <span></span>
                                    <span></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row search__result">
                    <?php 
                        foreach (products() as $key => $value) {
                            $productArr = $value;
                            $productArr['column'] = 3;
                            //echo json_encode($productsArr);
                            //include 'modules/catalog_product.php';
                        }
                    ?>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="search__center">
                            <div class="search__btn">
                                <button class="btn btn-purple btn-size_full" type="submit">Показать всё</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <header class="header">
        <nav>
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <ul>
                            <li class="parent">
                                <a href="/catalog" data-pjax="content">Каталог товаров</a>
                                <div class="toggle active"><svg width="8" height="12" xmlns="http://www.w3.org/2000/svg"><path d="M4.68 5.997l-4.488 4.49A.65.65 0 000 10.95c0 .176.068.34.192.464l.393.393a.651.651 0 00.464.192c.176 0 .34-.068.464-.192l5.345-5.345a.65.65 0 00.192-.465.651.651 0 00-.192-.466L1.518.192A.651.651 0 001.054 0 .651.651 0 00.59.192L.197.585a.657.657 0 000 .928L4.68 5.997z"></path></svg></div>
                                <?php
                                
                                    $result = mysqli_query($GLOBALS['db'], "SELECT * FROM `products_category` WHERE `parent_id` = '0' AND `city_id` = '$city_products' AND `show` = '1' ORDER BY `rang`");
                                    $numRows = mysqli_num_rows($result);

                                        echo '<ul class="active">';
                                        
                                            while($row = mysqli_fetch_array($result)) {
                                                echo '<li data-id="'.$row['id'].'">';
                                                echo '<a href="/catalog/'.$row['name'].'" data-pjax="content"><span class="section-sb-label">'.$row['title'].'<span class="count">'.productsCountCategory($row['id']).'</span></a><div class="toggle"><svg width="8" height="12" xmlns="http://www.w3.org/2000/svg"><path d="M4.68 5.997l-4.488 4.49A.65.65 0 000 10.95c0 .176.068.34.192.464l.393.393a.651.651 0 00.464.192c.176 0 .34-.068.464-.192l5.345-5.345a.65.65 0 00.192-.465.651.651 0 00-.192-.466L1.518.192A.651.651 0 001.054 0 .651.651 0 00.59.192L.197.585a.657.657 0 000 .928L4.68 5.997z"></path></svg></div>';
                                                
                                                menu_showNested_catalog($row['id'], $row['name']);
                                                
                                                echo '</li>';
                                            }
                                            
                                        echo '</ul>';
                                ?>
                            </li>
                            <li><a href="/akcii-i-predlozheniya" data-pjax="content">Акции и распродажи</a></li>
                            <li><a href="/news" data-pjax="content">Новости</a></li>
                            <li><a href="/voprosy-i-otvety" data-pjax="content">Вопросы и ответы</a></li>
                            <li><a href="/otzyvy" data-pjax="content">Отзывы</a></li>
                            <li><a href="/oplata-i-dostavka" data-pjax="content">Оплата и доставка</a></li>
                            <li><a href="/contacts" data-pjax="content">Контакты</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </nav>
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="header__head">
                        <div class="header__logo">
                            <a href="/" data-pjax="content"><img src="/assets/img/logo.svg" alt="AiwaYarn Studio"></a>
                            <div class="header__desc">
                                Интернет-магазин пряжи<br>
                                и товаров для рукоделия
                            </div>
                        </div>
                        <div class="header__contacts">
                            <div class="header__address">
                                <!--<span>г. Новосибирск</span>-->
                                <a href="/contacts" data-pjax="content" class="header__location link--black"> 
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16" aria-hidden="true"><path d="M36.973,545.2c-0.005.026,0,.051-0.007,0.076l-0.007.023a1.944,1.944,0,0,1-.174.567L32.969,558.3A0.991,0.991,0,0,1,32,559v0H31v-0.013a0.98,0.98,0,0,1-.952-0.607l-1.847-6.6L21.594,549.9a1,1,0,0,1-.585-0.9H21v-1h0.017a0.987,0.987,0,0,1,.715-0.984l12.415-3.806a1.971,1.971,0,0,1,.552-0.169l0.047-.014a0.777,0.777,0,0,1,.118-0.008c0.046,0,.089-0.019.136-0.019,0.013,0,.023.007,0.036,0.007a0.96,0.96,0,0,1,.292.056,1.973,1.973,0,0,1,1.654,1.755,0.954,0.954,0,0,1,.013.13C37,544.966,37,544.982,37,545A1.882,1.882,0,0,1,36.973,545.2Zm-13.175,3.3,4.882,1.391,2.606-2.606a0.988,0.988,0,0,1,1.414,0,1.026,1.026,0,0,1,0,1.436l-2.593,2.594,1.386,4.949,3.43-11.174Z" transform="translate(-21 -543)"></path></svg>
                                    <?php echo settings_id($city_products)[0]['address']; ?>
                                </a>
                            </div>
                            <div class="header__contact">
                                <a href="tel: <?php echo phone(settings_id($city_products)[0]['phone']); ?>" class="header__phone link--black"> 
                                    <svg class="" width="18.031" height="18" viewBox="0 0 18.031 17.969" aria-hidden="true"><path d="M673.56,155.153c-4.179-4.179-6.507-7.88-2.45-12.3l0,0a3,3,0,0,1,4.242,0l1.87,2.55a3.423,3.423,0,0,1,.258,3.821l-0.006-.007c-0.744.7-.722,0.693,0.044,1.459l0.777,0.873c0.744,0.788.759,0.788,1.458,0.044l-0.009-.01a3.153,3.153,0,0,1,3.777.264l2.619,1.889a3,3,0,0,1,0,4.243C681.722,162.038,677.739,159.331,673.56,155.153Zm11.17,1.414a1,1,0,0,0,0-1.414l-2.618-1.89a1.4,1.4,0,0,0-.926-0.241l0.009,0.009c-1.791,1.835-2.453,1.746-4.375-.132l-1.05-1.194c-1.835-1.878-1.518-2.087.272-3.922l0,0a1.342,1.342,0,0,0-.227-0.962l-1.87-2.549a1,1,0,0,0-1.414,0l-0.008-.009c-2.7,3.017-.924,6.1,2.453,9.477s6.748,5.54,9.765,2.837Z" transform="translate(-669 -142)"></path></svg>
                                    <?php echo phone(settings_id($city_products)[0]['phone']); ?>
                                </a>
                                <!--<small>В рабочие дни, с 10:00 по 22:30</small>-->
                            </div>
                        </div>
                        <div class="icons">
                            <div class="icons__search open-search">
                                <svg xmlns="http://www.w3.org/2000/svg" width="17" height="17" viewBox="0 0 17 17" aria-hidden="true"><path d="M16.709,16.719a1,1,0,0,1-1.412,0l-3.256-3.287A7.475,7.475,0,1,1,15,7.5a7.433,7.433,0,0,1-1.549,4.518l3.258,3.289A1,1,0,0,1,16.709,16.719ZM7.5,2A5.5,5.5,0,1,0,13,7.5,5.5,5.5,0,0,0,7.5,2Z"></path></svg>
                            </div>
                            <a href="/profile" class="icons__user" data-pjax="content">
                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 18 18" aria-hidden="true"><path d="M909,961a9,9,0,1,1,9-9A9,9,0,0,1,909,961Zm2.571-2.5a6.825,6.825,0,0,0-5.126,0A6.825,6.825,0,0,0,911.571,958.5ZM909,945a6.973,6.973,0,0,0-4.556,12.275,8.787,8.787,0,0,1,9.114,0A6.973,6.973,0,0,0,909,945Zm0,10a4,4,0,1,1,4-4A4,4,0,0,1,909,955Zm0-6a2,2,0,1,0,2,2A2,2,0,0,0,909,949Z" transform="translate(-900 -943)"></path></svg>
                            </a>
                            <a href="/mne-nravit-sya" class="icons__favorite" data-pjax="content">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="16" viewBox="0 0 20 16" aria-hidden="true"><path d="M682.741,81.962L682.75,82l-0.157.142a5.508,5.508,0,0,1-1.009.911L675,89h-2l-6.5-5.9a5.507,5.507,0,0,1-1.188-1.078l-0.057-.052,0-.013A5.484,5.484,0,1,1,674,75.35,5.485,5.485,0,1,1,682.741,81.962ZM678.5,75a3.487,3.487,0,0,0-3.446,3H675a1,1,0,0,1-2,0h-0.054a3.491,3.491,0,1,0-5.924,2.971L667,81l7,6,7-6-0.023-.028A3.5,3.5,0,0,0,678.5,75Z" transform="translate(-664 -73)"></path></svg>
                                <span class="count"><? if($like_count = like_count($user_uid)) { echo $like_count; } ?></span>
                            </a>
                            <a href="/cart" class="icons__cart" data-pjax="content">
                                <svg xmlns="http://www.w3.org/2000/svg" width="19" height="16" viewBox="0 0 19 16" aria-hidden="true"><path d="M956.047,952.005l-0.939,1.009-11.394-.008-0.952-1-0.953-6h-2.857a0.862,0.862,0,0,1-.952-1,1.025,1.025,0,0,1,1.164-1h2.327c0.3,0,.6.006,0.6,0.006a1.208,1.208,0,0,1,1.336.918L943.817,947h12.23L957,948v1Zm-11.916-3,0.349,2h10.007l0.593-2Zm1.863,5a3,3,0,1,1-3,3A3,3,0,0,1,945.994,954.005ZM946,958a1,1,0,1,0-1-1A1,1,0,0,0,946,958Zm7.011-4a3,3,0,1,1-3,3A3,3,0,0,1,953.011,954.005ZM953,958a1,1,0,1,0-1-1A1,1,0,0,0,953,958Z" transform="translate(-938 -944)"></path></svg>
                                <span class="count"><? 
                                    $cartArr = cart_count($user_uid);
                                    if($cartArr['result']) { echo $cartArr['nums']; } 
                                ?></span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <div class="header-fix" id="navbar">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="header-fix__head">
                        <div class="header-fix__logo">
                            <a href="/" data-pjax="content"><img src="/assets/img/logo.svg" alt="AiwaYarn Studio"></a>
                        </div>
                        <ul class="header-fix__menu">
                            <li class="header-fix__menu-catalog">
                                <a href="/catalog" data-pjax="content">Каталог</a>
                                <?php

                                    $result = mysqli_query($GLOBALS['db'], "SELECT * FROM `products_category` WHERE `parent_id` = '0' AND `city_id` = '$city_products' AND `show` = '1' ORDER BY `rang`");
                                    $numRows = mysqli_num_rows($result);

                                        echo '<ul>';
                                        
                                            while($row = mysqli_fetch_array($result)) {
                                                echo '<li data-id="'.$row['id'].'">';
                                                echo '<a href="/catalog/'.$row['name'].'" data-pjax="content"><span class="section-sb-label">'.$row['title'].' <span class="count">'.productsCountCategory($row['id']).'</span></span></a>';
                                                
                                                menu_showNested_catalog($row['id'], $row['name']);
                                                
                                                echo '</li>';
                                            }
                                            
                                        echo '</ul>';
                                ?>
                            </li>
                            <li><a href="/akcii-i-predlozheniya" data-pjax="content">Акции и предложения</a></li>
                            <li><a href="/news" data-pjax="content">Новости</a></li>
                            <li><a href="/voprosy-i-otvety" data-pjax="content">Вопросы и ответы</a></li>
                            <li><a href="/otzyvy" data-pjax="content">Отзывы</a></li>
                            <li><a href="/oplata-i-dostavka" data-pjax="content">Оплата и доставка</a></li>
                            <li><a href="/contacts" data-pjax="content">Контакты</a></li>
                        </ul>
                        <div class="icons">
                            <a href="tel:<?php echo phone(settings_id($city_products)[0]['phone']); ?>" class="icons__phone" data-pjax="content">
                                <svg width="18.031" height="17.969" viewBox="0 0 18.031 17.969"><path class="cls-1" d="M673.56,155.153c-4.179-4.179-6.507-7.88-2.45-12.3l0,0a3,3,0,0,1,4.242,0l1.87,2.55a3.423,3.423,0,0,1,.258,3.821l-0.006-.007c-0.744.7-.722,0.693,0.044,1.459l0.777,0.873c0.744,0.788.759,0.788,1.458,0.044l-0.009-.01a3.153,3.153,0,0,1,3.777.264l2.619,1.889a3,3,0,0,1,0,4.243C681.722,162.038,677.739,159.331,673.56,155.153Zm11.17,1.414a1,1,0,0,0,0-1.414l-2.618-1.89a1.4,1.4,0,0,0-.926-0.241l0.009,0.009c-1.791,1.835-2.453,1.746-4.375-.132l-1.05-1.194c-1.835-1.878-1.518-2.087.272-3.922l0,0a1.342,1.342,0,0,0-.227-0.962l-1.87-2.549a1,1,0,0,0-1.414,0l-0.008-.009c-2.7,3.017-.924,6.1,2.453,9.477s6.748,5.54,9.765,2.837Z" transform="translate(-669 -142)"></path></svg>
                            </a>
                            <div class="icons__search open-search">
                                <svg xmlns="http://www.w3.org/2000/svg" width="17" height="17" viewBox="0 0 17 17" aria-hidden="true"><path d="M16.709,16.719a1,1,0,0,1-1.412,0l-3.256-3.287A7.475,7.475,0,1,1,15,7.5a7.433,7.433,0,0,1-1.549,4.518l3.258,3.289A1,1,0,0,1,16.709,16.719ZM7.5,2A5.5,5.5,0,1,0,13,7.5,5.5,5.5,0,0,0,7.5,2Z"></path></svg>
                            </div>
                            <a href="/profile" class="icons__user" data-pjax="content">
                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 18 18" aria-hidden="true"><path d="M909,961a9,9,0,1,1,9-9A9,9,0,0,1,909,961Zm2.571-2.5a6.825,6.825,0,0,0-5.126,0A6.825,6.825,0,0,0,911.571,958.5ZM909,945a6.973,6.973,0,0,0-4.556,12.275,8.787,8.787,0,0,1,9.114,0A6.973,6.973,0,0,0,909,945Zm0,10a4,4,0,1,1,4-4A4,4,0,0,1,909,955Zm0-6a2,2,0,1,0,2,2A2,2,0,0,0,909,949Z" transform="translate(-900 -943)"></path></svg>
                            </a>
                            <a href="/mne-nravit-sya" class="icons__favorite" data-pjax="content">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="16" viewBox="0 0 20 16" aria-hidden="true"><path d="M682.741,81.962L682.75,82l-0.157.142a5.508,5.508,0,0,1-1.009.911L675,89h-2l-6.5-5.9a5.507,5.507,0,0,1-1.188-1.078l-0.057-.052,0-.013A5.484,5.484,0,1,1,674,75.35,5.485,5.485,0,1,1,682.741,81.962ZM678.5,75a3.487,3.487,0,0,0-3.446,3H675a1,1,0,0,1-2,0h-0.054a3.491,3.491,0,1,0-5.924,2.971L667,81l7,6,7-6-0.023-.028A3.5,3.5,0,0,0,678.5,75Z" transform="translate(-664 -73)"></path></svg>
                                <span class="count"><? if($like_count = like_count($user_uid)) { echo $like_count; } ?></span>
                            </a>
                            <a href="/cart" class="icons__cart" data-pjax="content">
                                <svg xmlns="http://www.w3.org/2000/svg" width="19" height="16" viewBox="0 0 19 16" aria-hidden="true"><path d="M956.047,952.005l-0.939,1.009-11.394-.008-0.952-1-0.953-6h-2.857a0.862,0.862,0,0,1-.952-1,1.025,1.025,0,0,1,1.164-1h2.327c0.3,0,.6.006,0.6,0.006a1.208,1.208,0,0,1,1.336.918L943.817,947h12.23L957,948v1Zm-11.916-3,0.349,2h10.007l0.593-2Zm1.863,5a3,3,0,1,1-3,3A3,3,0,0,1,945.994,954.005ZM946,958a1,1,0,1,0-1-1A1,1,0,0,0,946,958Zm7.011-4a3,3,0,1,1-3,3A3,3,0,0,1,953.011,954.005ZM953,958a1,1,0,1,0-1-1A1,1,0,0,0,953,958Z" transform="translate(-938 -944)"></path></svg>
                                <span class="count"><? 
                                    $cartArr = cart_count($user_uid);
                                    if($cartArr['result']) { echo $cartArr['nums']; } 
                                ?></span>
                            </a>
                            <a href="#" class="icons__menu nav-toogle">
                                <span></span>
                                <span></span>
                                <span></span>
                                <span></span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <main id="content" class="site-main">
