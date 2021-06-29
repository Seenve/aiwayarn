<?
    $currentPage = isset($_GET[$page]) ? $_GET[$page] : '';
    $currentPage = val_string($currentPage);
    if (authuser()) {
        $account = authuser();
        $userId = user($account)['id'];
        if($currentPage == 'messages') {
?>
<div class="pageTitleArea animated">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="pageTitle">
                    <div class="h2"><b id="day">Привет</b>, <?php echo user(authuser())['firstname']; ?></div>
                    <ul class="pageIndicate">
                        <li><a href="/" data-pjax="content">Главная</a></li>
                        <li><a href="/<?php echo $page; ?>" data-pjax="content">Личный кабинет</a></li>
                        <li><a href="/<?php echo $page; ?>/<?php echo $_GET[$page]; ?>" data-pjax="content">Сообщения</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="dashboardArea secPdngB animated">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="boardMenu">
                    <ul>
                        <li><a data-pjax="content" href="/<?php echo $page; ?>">Мой аккаунт</a></li>
                        <li><a data-pjax="content" href="/<?php echo $page; ?>/services">Мои услуги</a></li>
                        <li class="active"><a data-pjax="content" href="/<?php echo $page; ?>/messages">Сообщения</a></li>
                        <li><a data-pjax="content" href="/<?php echo $page; ?>/pays">История платежей</a></li>
                        <li><a data-pjax="content" href="/<?php echo $page; ?>/payday">История затрат</a></li>
                        <?php if(user($account)['admin'] >= 1) { ?> <li><a href="/admin" data-pjax="content">AP</a></li> <? } ?>
                        <li class="logout-btn"><a href="#" id="logout">Выйти <i class="fa fa-sign-out"></i></a></li>
                    </ul>
                </div>
            </div>
            <div class="col-md-12 animated">
                <h6>Данный раздел в данный момент недоступен</h6>
            </div>
        </div>
    </div>
</div>
<?
        } else if($currentPage == 'payday') {
?>
<div class="pageTitleArea animated">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="pageTitle">
                    <div class="h2"><b id="day">Привет</b>, <?php echo user(authuser())['firstname']; ?></div>
                    <ul class="pageIndicate">
                        <li><a href="/" data-pjax="content">Главная</a></li>
                        <li><a href="/<?php echo $page; ?>" data-pjax="content">Личный кабинет</a></li>
                        <li><a href="/<?php echo $page; ?>/<?php echo $_GET[$page]; ?>" data-pjax="content">История затрат</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="dashboardArea secPdngB animated">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="boardMenu">
                    <ul>
                        <li><a data-pjax="content" href="/<?php echo $page; ?>">Мой аккаунт</a></li>
                        <li><a data-pjax="content" href="/<?php echo $page; ?>/services">Мои услуги</a></li>
                        <li><a data-pjax="content" href="/<?php echo $page; ?>/messages">Сообщения</a></li>
                        <li><a data-pjax="content" href="/<?php echo $page; ?>/pays">История платежей</a></li>
                        <li class="active"><a data-pjax="content" href="/<?php echo $page; ?>/payday">История затрат</a></li>
                        <?php if(user($account)['admin'] >= 1) { ?> <li><a href="/admin" data-pjax="content">AP</a></li> <? } ?>
                        <li class="logout-btn"><a href="#" id="logout">Выйти <i class="fa fa-sign-out"></i></a></li>
                    </ul>
                </div>
            </div>
            <div class="col-md-12 animated">
<?php
    $arrP = array();
    $pagenum = isset($_GET[$currentPage]) ? $_GET[$currentPage] : '';
    $pagenum = val_string($pagenum);
    $url_page = '/'.$page.'/'. $currentPage.'/';
    $pagenum = preg_replace("/[^0-9]/", '', $pagenum);
    $num = 10;  
    $posts = count(payday($userId));  
    $total = intval(($posts - 1) / $num) + 1;  
    $pagenum = intval($pagenum);  
    if(empty($pagenum) or $pagenum < 0) $pagenum = 1;  
    if($pagenum > $total) $pagenum = $total;  
    $start = $pagenum * $num - $num;  
    $arr = payday($userId, $start, $num);

    if($posts > 0){  
        echo '
                <div class="pays">
                    <div class="head">
                        <div>Дата</div>
                        <div>Описание</div>
                        <div>Тип</div>
                        <div>Сумма</div>
                    </div>
        ';
        for($in = 0; $in < $num; $in++)  
        {  
            $idstr = isset($arr[$in]['id']) ? $arr[$in]['id'] : 0;
            if($idstr > 0) {
                $time = strtotime($arr[$in]['regdate']);    
?>
                    <div>
                        <div><div class="mob">Дата</div><?php echo date('d.m.Y в H:i', $time); ?></div>
                        <div><div class="mob">Описание</div>Услуга: <b><?php echo service_id($arr[$in]['service_id'])['login']; ?></b></div>
                        <div><div class="mob">Тип</div><?php echo select_arr(service_id($arr[$in]['service_id'])['name'], $hosting_arr); ?></div>
                        <div class="money minus"><div class="mob">Сумма</div>-<?php echo $arr[$in]['money']; ?><i class="fa fa-rub"></i></div>
                    </div>
<?php
            }
        }
    echo '</div>';
    } else {
        echo 'Нет данных';
    }
?>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 col-xs-12">
                <?php  
                    $pervpage = '';
                    $nextpage = '';
                    $pagenum1left = '';
                    $pagenum2left = '';
                    $pagenum1right = '';
                    $pagenum2right = '';
                    // Проверяем нужны ли стрелки назад  
                    if ($pagenum != 1) $pervpage = '<li><a data-pjax=content href='.$url_page.'1><i class="fa fa-angle-double-left" aria-hidden="true"></i></a></li>  
                                                   <li><a data-pjax=content href='.$url_page.''. ($pagenum - 1) .'><i class="fa fa-angle-left" aria-hidden="true"></i></a></li>';  
                    // Проверяем нужны ли стрелки вперед  
                    if ($pagenum != $total) $nextpage = ' <li><a data-pjax=content href='.$url_page.''. ($pagenum + 1) .'><i class="fa fa-angle-right" aria-hidden="true"></i></a></li>  
                                                       <li><a data-pjax=content href='.$url_page.''.$total. '><i class="fa fa-angle-double-right" aria-hidden="true"></i></a></li>';  

                    // Находим две ближайшие станицы с обоих краев, если они есть  
                    if($pagenum - 2 > 0) $pagenum2left = '<li><a data-pjax=content href='.$url_page.''. ($pagenum - 2) .'>'. ($pagenum - 2) .'</a></li>';  
                    if($pagenum - 1 > 0) $pagenum1left = '<li><a data-pjax=content href='.$url_page.''. ($pagenum - 1) .'>'. ($pagenum - 1) .'</a></li>';  
                    if($pagenum + 2 <= $total) $pagenum2right = '<li><a data-pjax=content href='.$url_page.''. ($pagenum + 2) .'>'. ($pagenum + 2) .'</a></li>';  
                    if($pagenum + 1 <= $total) $pagenum1right = '<li><a data-pjax=content href='.$url_page.''. ($pagenum + 1) .'>'. ($pagenum + 1) .'</a></li>'; 

                    // Вывод меню  
                    if($num < $posts) {
                        ?>
                        <div class="pagination animated">
                            <ul>
                                <?
                                echo '<div class="page-menu">'.$pervpage.$pagenum2left.$pagenum1left.'<li class="active"><a href="#" onclick="return false;">'.$pagenum.'</a></li>'.$pagenum1right.$pagenum2right.$nextpage.'</div>';  
                                ?>
                            </ul>
                        </div>
                        <?
                    }
                ?>
            </div>
        </div>
    </div>
</div>
<?
        } else if($currentPage == 'pays') {
?>
<div class="pageTitleArea animated">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="pageTitle">
                    <div class="h2"><b id="day">Привет</b>, <?php echo user(authuser())['firstname']; ?></div>
                    <ul class="pageIndicate">
                        <li><a href="/" data-pjax="content">Главная</a></li>
                        <li><a href="/<?php echo $page; ?>" data-pjax="content">Личный кабинет</a></li>
                        <li><a href="/<?php echo $page; ?>/<?php echo $_GET[$page]; ?>" data-pjax="content">История платежей</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="dashboardArea secPdngB animated">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="boardMenu">
                    <ul>
                        <li><a data-pjax="content" href="/<?php echo $page; ?>">Мой аккаунт</a></li>
                        <li><a data-pjax="content" href="/<?php echo $page; ?>/services">Мои услуги</a></li>
                        <li><a data-pjax="content" href="/<?php echo $page; ?>/messages">Сообщения</a></li>
                        <li class="active"><a data-pjax="content" href="/<?php echo $page; ?>/pays">История платежей</a></li>
                        <li><a data-pjax="content" href="/<?php echo $page; ?>/payday">История затрат</a></li>
                        <?php if(user($account)['admin'] >= 1) { ?> <li><a href="/admin" data-pjax="content">AP</a></li> <? } ?>
                        <li class="logout-btn"><a href="#" id="logout">Выйти <i class="fa fa-sign-out"></i></a></li>
                    </ul>
                </div>
            </div>
            <div class="col-md-12  animated">
<?php
    $arr = array();
    $pagenum = isset($_GET[$currentPage]) ? $_GET[$currentPage] : '';
    $pagenum = val_string($pagenum);
    $url_page = '/'.$page.'/'.$currentPage.'/';
    //$url_page = '/?page=news&num=';
    $pagenum = preg_replace("/[^0-9]/", '', $pagenum);
    $num = 10;  
    $posts = count(pays($userId));  
    $total = intval(($posts - 1) / $num) + 1;  
    $pagenum = intval($pagenum);  
    if(empty($pagenum) or $pagenum < 0) $pagenum = 1;  
    if($pagenum > $total) $pagenum = $total;  
    $start = $pagenum * $num - $num;  
    $arr = pays($userId, $start, $num);
    #$arr = array_reverse($arr, true);

    if($posts > 0){  
        echo '
                <div class="pays">
                    <div class="head">
                        <div>Дата</div>
                        <div>Описание</div>
                        <div>Сумма</div>
                        <div>Статус</div>
                    </div>
        ';
        for($in = 0; $in < $num; $in++)  
        {  
            //$idstr = $arr[$in]['id'];
            $idstr = isset($arr[$in]['id']) ? $arr[$in]['id'] : 0;
            if($idstr > 0) {
                $time = strtotime($arr[$in]['regdate']);
?>
                    <div>
                        <div><div class="mob">Дата</div><?php echo date('d.m.Y в H:i', $time); ?></div>
                        <div><div class="mob">Описание</div>№ платежа: <b><?php echo $arr[$in]['id']; ?></b></div>
                        <div class="money"><div class="mob">Сумма</div>+<?php echo $arr[$in]['money']; ?><i class="fa fa-rub"></i></div>
                        <div><div class="mob">Статус</div>
                        <?php
                                if($arr[$in]['pay']) {
                                    echo '<span class="success">Зачислено</span>';
                                } else {
                                    if($time+1440 > $timeNow) {
                                        echo '<span>В ожидании...</span>';
                                    } else {
                                        echo '<span class="error">Отменен</span>';
                                    }
                                }
                        ?>
                        </div>
                    </div>
<?php
            }
        }
    echo '</div>';
    } else {
        echo 'Нет данных';
    }
?>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 col-xs-12">
                <?php  
                    $pervpage = '';
                    $nextpage = '';
                    $pagenum1left = '';
                    $pagenum2left = '';
                    $pagenum1right = '';
                    $pagenum2right = '';

                    // Проверяем нужны ли стрелки назад  
                    if ($pagenum != 1) $pervpage = '<li><a data-pjax=content href='.$url_page.'1><i class="fa fa-angle-double-left" aria-hidden="true"></i></a></li>  
                                                   <li><a data-pjax=content href='.$url_page.''. ($pagenum - 1) .'><i class="fa fa-angle-left" aria-hidden="true"></i></a></li>';  
                    // Проверяем нужны ли стрелки вперед  
                    if ($pagenum != $total) $nextpage = ' <li><a data-pjax=content href='.$url_page.''. ($pagenum + 1) .'><i class="fa fa-angle-right" aria-hidden="true"></i></a></li>  
                                                       <li><a data-pjax=content href='.$url_page.''.$total. '><i class="fa fa-angle-double-right" aria-hidden="true"></i></a></li>';  

                    // Находим две ближайшие станицы с обоих краев, если они есть  
                    if($pagenum - 2 > 0) $pagenum2left = '<li><a data-pjax=content href='.$url_page.''. ($pagenum - 2) .'>'. ($pagenum - 2) .'</a></li>';  
                    if($pagenum - 1 > 0) $pagenum1left = '<li><a data-pjax=content href='.$url_page.''. ($pagenum - 1) .'>'. ($pagenum - 1) .'</a></li>';  
                    if($pagenum + 2 <= $total) $pagenum2right = '<li><a data-pjax=content href='.$url_page.''. ($pagenum + 2) .'>'. ($pagenum + 2) .'</a></li>';  
                    if($pagenum + 1 <= $total) $pagenum1right = '<li><a data-pjax=content href='.$url_page.''. ($pagenum + 1) .'>'. ($pagenum + 1) .'</a></li>'; 

                    // Вывод меню  
                    if($num < $posts) {
                        ?>
                        <div class="pagination animated">
                            <ul>
                                <?
                                echo '<div class="page-menu">'.$pervpage.$pagenum2left.$pagenum1left.'<li class="active"><a href="#" onclick="return false;">'.$pagenum.'</a></li>'.$pagenum1right.$pagenum2right.$nextpage.'</div>';  
                                ?>
                            </ul>
                        </div>
                        <?
                    }
                ?>
            </div>
        </div>
    </div>
    </div>
</div>
<?
        } else if($currentPage == 'services') {
?>
<div class="pageTitleArea animated">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="pageTitle">
                    <div class="h2"><b id="day">Привет</b>, <?php echo user(authuser())['firstname']; ?></div>
                    <ul class="pageIndicate">
                        <li><a href="/" data-pjax="content">Главная</a></li>
                        <li><a href="/<?php echo $page; ?>" data-pjax="content">Личный кабинет</a></li>
                        <li><a href="/<?php echo $page; ?>/<?php echo $_GET[$page]; ?>" data-pjax="content">Мои услуги</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="dashboardArea secPdngB animated">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="boardMenu">
                    <ul>
                        <li><a data-pjax="content" href="/<?php echo $page; ?>">Мой аккаунт</a></li>
                        <li class="active"><a data-pjax="content" href="/<?php echo $page; ?>/services">Мои услуги</a></li>
                        <li><a data-pjax="content" href="/<?php echo $page; ?>/messages">Сообщения</a></li>
                        <li><a data-pjax="content" href="/<?php echo $page; ?>/pays">История платежей</a></li>
                        <li><a data-pjax="content" href="/<?php echo $page; ?>/payday">История затрат</a></li>
                        <?php if(user($account)['admin'] >= 1) { ?> <li><a href="/admin" data-pjax="content">AP</a></li> <? } ?>
                        <li class="logout-btn"><a href="#" id="logout">Выйти <i class="fa fa-sign-out"></i></a></li>
                    </ul>
                </div>
            </div>
            <div class="col-md-12  animated">
<?php $arrService = service($userId); ?>
<div class="boardTitle">
    <div class="bill">Веб хостинг</div>
</div>
<ul class="regDomains">
<?
        $i = 0;
        foreach ($arrService as $key => $value) {
            if($value['name'] == 'webhosting') {
                $rate_id = $value['rate'];
                $i++;
?>
                    <li>
                        <div class="domainName"><?php echo $value['login']; ?> <?php if($value['job']) {echo '<span class="active"><i class="fa fa-circle" aria-hidden="true"></i></span>';} else {echo '<span><i class="fa fa-circle" aria-hidden="true"></i></span>';} ?></div>
                        <ul class="editDomain">
                            <li><a data-pjax="content" class="hov" href="/webhosting">Тариф «<?php echo rate($rate_id)['0']['name']; ?>»</a> <?php echo rate($rate_id)['0']['money']*30; ?> руб/мес</li>
                            <li><a href="#ap<?php echo $key; ?>" class="bt open_window">Панель управления</a></li>
                            <li><a href="#edit<?php echo $key; ?>" class="bt open_window">Редактировать</a></li>
                            <li><a href="#del<?php echo $key; ?>" class="bt open_window">Удалить</a></li>
                        </ul>
                    </li>
                    <div id="ap<?php echo $key; ?>" class="window window-add">
                        <div class="window_head">
                            <div class="window_title">Панель управления</div>
                        </div>
                        <div class="window_close">
                            <i class="fa fa-times-circle" aria-hidden="true"></i>
                        </div>
                        <div class="window_content max-width">
                            <div class="account-info max-width">
                                <div class="str">
                                    <div>Аккаунт</div>
                                    <div class="text"><?php echo $value['login']; ?></div>
                                </div>
                                <div class="str">
                                    <div>Пароль</div>
                                    <div class="text"><?php echo $value['password']; ?></div>
                                </div>
                            </div>
                            <p><small>Доступ к FTP можно настроить в панели управления</small></p>
                            <br>
                            <p>
                                <a href="https://<?php echo $value['server']; ?>:8083/login" target="_blank" class="hov">Перейти в панель управления</a>
                            </p>
                        </div>
                    </div>
                    <div id="edit<?php echo $key; ?>" class="window window-add">
                        <div class="window_head">
                            <div class="window_title">Редактировать [<?php echo $value['login']; ?>]</div>
                        </div>
                        <div class="window_close">
                            <i class="fa fa-times-circle" aria-hidden="true"></i>
                        </div>
                        <div class="window_content max-width">
                            <form class="ajax" action="/engine/forms.php">
                                <input type="hidden" name="editservice" value="1">
                                <input type="hidden" name="login" value="<?php echo $value['login']; ?>">
                                <label for="">Изменить пароль аккаунта</label>
                                <div class="pass">
                                    <input type="password" name="password" class="pass-control input" autocomplete="off">
                                    <div class="pass-hide" data-tooltip="Показать/скрыть пароль"><i class="fa fa-eye-slash"></i></div>
                                    <div class="pass-gen js-active" data-tooltip="Сгенерировать пароль"><i class="fa fa-key"></i></div>
                                </div>
                                <div class="result"></div>
                                <div class="result_success"></div>
                                <div class="result_error"></div>
                                <button type="submit" class="btn">Изменить</button>
                                <?php
                                    /*if($value['job']) {
                                ?>
                                <h6 class="margin-top">Статус услуги</h6>
                                <form class="ajax" action="/engine/forms.php">
                                    <input type="hidden" name="offservice" value="1">
                                    <input type="hidden" name="login" value="<?php echo $value['login']; ?>">
                                    <p class="no-margin"><small>Активна</small></p>
                                    <button type="submit" class="btn btn-danger">Отключить</button>
                                </form>
                                <?
                                    } else {
                                ?>
                                <h6 class="margin-top">Статус услуги</h6>
                                <form class="ajax" action="/engine/forms.php">
                                    <input type="hidden" name="onservice" value="1">
                                    <input type="hidden" name="login" value="<?php echo $value['login']; ?>">
                                    <p class="no-margin"><small>Отключена</small></p>
                                    <button type="submit" class="btn btn-success">Включить</button>
                                </form>
                                <?
                                    }*/
                                ?>
                            </form>
                        </div>
                    </div>
                    <div id="del<?php echo $key; ?>" class="window window-add">
                        <div class="window_head">
                            <div class="window_title">Удалить [<?php echo $value['login']; ?>]</div>
                        </div>
                        <div class="window_close">
                            <i class="fa fa-times-circle" aria-hidden="true"></i>
                        </div>
                        <div class="window_content max-width">
                            <form class="ajax" action="/engine/forms.php">
                                <input type="hidden" name="delservice" value="1">
                                <input type="hidden" name="login" value="<?php echo $value['login']; ?>">
                                <p>Вы действительно хотите удалить данную услугу? После удаления, все данные с услуги будут удалены.</p>
                                <div class="result"></div>
                                <div class="result_success"></div>
                                <div class="result_error"></div>
                                <button type="submit" class="btn btn-danger">Удалить</button>
                            </form>
                        </div>
                    </div>
<?
            }
        }
?>
</ul>
<?
    if(!$i) {
?> 
    <a data-pjax="content" href="/webhosting" class="button">Добавить</a>
<?
    }
?>

<div class="boardTitle">
    <div class="bill">Отправка смс</div>
</div>
<ul class="regDomains">
<?
        $i = 0;
        foreach ($arrService as $key => $value) {
            if($value['name'] == 'sms') {
                $rate_id = $value['rate'];
                $i++;
?>
                    <li>
                        <div class="domainName"><?php echo $value['login']; ?> <?php if($value['job']) {echo '<span class="active"><i class="fa fa-circle" aria-hidden="true"></i></span>';} else {echo '<span><i class="fa fa-circle" aria-hidden="true"></i></span>';} ?></div>
                        <ul class="editDomain">
                            <?php
                                if(rate($rate_id)['0']['money'] == 0) {
                                    ?>
                                        <li><a data-pjax="content" class="hov" href="/sms">Тариф «<?php echo rate($rate_id)['0']['name']; ?>»</a> 2 руб/смс</li>
                                    <?
                                } else {
                                    ?>
                                        <li><a data-pjax="content" class="hov" href="/sms">Тариф «<?php echo rate($rate_id)['0']['name']; ?>»</a> <?php echo rate($rate_id)['0']['money']*30; ?> руб/мес</li>
                                    <?
                                }
                            ?>
                            <li><a href="#ap<?php echo $key; ?>" class="bt open_window">Информация</a></li>
                            <li><a href="#info<?php echo $key; ?>" class="bt open_window">История</a></li>
                            <li><a href="#del<?php echo $key; ?>" class="bt open_window">Удалить</a></li>
                        </ul>
                    </li>
                    <div id="ap<?php echo $key; ?>" class="window window-add">
                        <div class="window_head">
                            <div class="window_title">Информация</div>
                        </div>
                        <div class="window_close">
                            <i class="fa fa-times-circle" aria-hidden="true"></i>
                        </div>
                        <div class="window_content max-width">
                            <div class="account-info max-width">
                                <div class="str">
                                    <div>Название услуги</div>
                                    <div class="text"><?php echo $value['login']; ?></div>
                                </div>
                                <div class="str">
                                    <div>Ключ</div>
                                    <div class="text"><?php echo $value['password']; ?></div>
                                </div>
                            </div>
                            <br>
                            <p>
                                <a href="/sms-documentation" target="_blank" class="hov">Документация по настройке</a>
                            </p>
                        </div>
                    </div>
                    <div id="info<?php echo $key; ?>" class="window window-add">
                        <div class="window_head">
                            <div class="window_title">История смс [<?php echo $value['login']; ?>]</div>
                        </div>
                        <div class="window_close">
                            <i class="fa fa-times-circle" aria-hidden="true"></i>
                        </div>
                        <div class="window_content max-width">
                            <?php 
                                foreach (sms_messages($value['password'], 0, 10) as $key_sms => $value_sms) {
                            ?>
                            <div class="account-info mb-3 max-width">
                                <div class="str">
                                    <div>Телефон</div>
                                    <div class="text"><? echo $value_sms['phone']; ?></div>
                                </div>
                                <div class="str no">
                                    <div>Сообщение:</div>
                                </div>
                                <textarea disabled><? echo $value_sms['message']; ?></textarea>
                                <div class="str">
                                    <div>Отправлено</div>
                                    <div class="text"><? echo date('d.m.Y в H:i', strtotime($value_sms['regdate'])); ?></div>
                                </div>
                            </div>
                            <hr>
                            <?
                                }
                            ?>
                        </div>
                    </div>
                    <div id="del<?php echo $key; ?>" class="window window-add">
                        <div class="window_head">
                            <div class="window_title">Удалить [<?php echo $value['login']; ?>]</div>
                        </div>
                        <div class="window_close">
                            <i class="fa fa-times-circle" aria-hidden="true"></i>
                        </div>
                        <div class="window_content max-width">
                            <form class="ajax" action="/engine/forms.php">
                                <input type="hidden" name="delservice" value="1">
                                <input type="hidden" name="login" value="<?php echo $value['login']; ?>">
                                <p>Вы действительно хотите удалить данную услугу? После удаления, все данные с услуги будут удалены.</p>
                                <div class="result"></div>
                                <div class="result_success"></div>
                                <div class="result_error"></div>
                                <button type="submit" class="btn btn-danger">Удалить</button>
                            </form>
                        </div>
                    </div>
<?
            }
        }
?>
</ul>

<?
    if(!$i) {
?> 
    <a data-pjax="content" href="/sms" class="button">Добавить</a>
<?
    }
?>
            </div>
        </div>
    </div>
</div>
<div class="sectionBar"></div>

<?
        } else {
?>
<div class="pageTitleArea animated">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="pageTitle">
                    <div class="h2"><b id="day">Привет</b>, <?php echo user($account)['firstname']; ?></div>
                    <ul class="pageIndicate">
                        <li><a href="/" data-pjax="content">Главная</a></li>
                        <li><a href="/<?php echo $page; ?>" data-pjax="content">Личный кабинет</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="dashboardArea secPdngB animated">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="boardMenu">
                    <ul>
                        <li class="active"><a data-pjax="content" href="/<?php echo $page; ?>">Мой аккаунт</a></li>
                        <li><a data-pjax="content" href="/<?php echo $page; ?>/services">Мои услуги</a></li>
                        <li><a data-pjax="content" href="/<?php echo $page; ?>/messages">Сообщения</a></li>
                        <li><a data-pjax="content" href="/<?php echo $page; ?>/pays">История платежей</a></li>
                        <li><a data-pjax="content" href="/<?php echo $page; ?>/payday">История затрат</a></li>
                        <?php if(user($account)['admin'] >= 1) { ?> <li><a href="/admin" data-pjax="content">AP</a></li> <? } ?>
                        <li class="logout-btn"><a href="#" id="logout">Выйти <i class="fa fa-sign-out"></i></a></li>
                    </ul>
                </div>
            </div>
            <div class="col-md-12">
                <div class="info">
                    <p class="balans"><b>Баланс <?php echo user($account)['money']; ?> &#8381;</b><a data-pjax="content" class="payBtn" href="/pay">пополнить</a></p>
                    <?php 
                        if(lostmoney($account)['result'] == true){
                            if(lostmoney($account)['user_money'] > lostmoney($account)['rate_money']) {
                                echo '<p>'.lostmoney($account)['message'].'</p>';
                            } else {
                                echo '<p><div class="warning">Ваш баланс отрицательный, во избежании приостановки услуг пополните баланс.</div></p>';
                            }
                        }
                    ?>
                </div>
                <div class="boardTitle">
                    <div class="bill">О пользователе:</div>
                </div>
                <div class="row">
                    <div class="col-lg-4 animated">
                        <div class="account-info mb-3 max-width">
                            <div class="str">
                                <div>Имя</div>
                                <div class="text"><?php echo user($account)['firstname']; ?></div>
                            </div>
                            <div class="str">
                                <div>Фамилия</div>
                                <div class="text"><?php echo user($account)['lastname']; ?></div>
                            </div>
                            <div class="str">
                                <div>Эл. почта</div>
                                <div class="text"><?php echo user($account)['email']; ?></div>
                            </div>
                            <div class="str">
                                <div>Телефон</div>
                                <div class="text"><?php echo phone(user($account)['phone']); ?></div>
                            </div>
                        </div>
                        <?php 
                            if(user($account)['phone_verify'] == 1) {} else {
                                ?>
                                    <div class="info info-bg phone_verify">Ваш телефон не проверен, <a href="#phone_verify" class="open_window">пройдите проверку</a></div>
                                    <div id="phone_verify" class="window window-add">
                                        <div class="window_head">
                                            <div class="window_title">Проверка телефона</div>
                                        </div>
                                        <div class="window_close">
                                            <i class="fa fa-times-circle" aria-hidden="true"></i>
                                        </div>
                                        <div class="window_content max-width">
                                            <form class="form_phone_verify" action="/engine/forms.php">
                                                <p class="send_display">Введите свой номер телефона, для подтверждения.</p>
                                                <input type="hidden" name="phone_verify_send" value="1">
                                                <input type="hidden" name="send" value="0">
                                                <label for="" class="send_display">Телефон</label>
                                                <input type="phone" name="phone" class="input send_display" autocomplete="off" placeholder="+7 (9__) ___-__-__">
                                                <div class="result font-default"></div>
                                                <div class="result_success"></div>
                                                <div class="result_error"></div>
                                                <button type="submit" class="btn">Выслать код</button>
                                            </form>
                                        </div>
                                    </div>
                                <?
                            }
                        ?>
                    </div>
                </div>

                <div class="boardTitle">
                    <div class="bill">Изменить пароль:</div>
                </div>
                <form class="accountForm ajax" action="/engine/forms.php">
                    <input type="hidden" name="changepassword" value="1">
                    <div class="row">
                        <div class="col-lg-4 animated">
                            <div class="checkoutWrep">
                                <div class="row">
                                    <div class="col-md-12">
                                        <span class="inputTitle">Придумайте новый пароль:</span>
                                        <div class="pass">
                                            <input type="password" name="password" class="pass-control" autocomplete="off">
                                            <div class="pass-hide" data-tooltip="Показать/скрыть пароль"><i class="fa fa-eye-slash"></i></div>
                                            <div class="pass-gen js-active" data-tooltip="Сгенерировать пароль"><i class="fa fa-key"></i></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="result"></div>
                            <div class="result_success"></div>
                            <div class="result_error"></div>
                            <div class="submitBtn">
                                <button type="submit" class="btn">Изменить</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="sectionBar"></div>

<?
        }
    } else {
?>
<div class="pageTitleArea animated">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="pageTitle">
                    <div class="h2"><?php echo $title_page; ?></div>
                    <ul class="pageIndicate">
                        <li><a data-pjax="content" href="/">Главная</a></li>
                        <li><a data-pjax="content" href="/<?php echo $page; ?>"><?php echo $title_page; ?></a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="dashboardArea animated">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="checkTitle">Уже есть аккаунт? <a href="#" id="auth-open">Авторизуйтесь</a></div>
            </div>
        </div>
    </div>
</div>
<script language="JavaScript"> 
    if($.support.pjax) {
        $.pjax({
            url: '/', 
            container: '#content',
            "push":true,
            "replace": false,
            "timeout":10000,
            "scrollTo":false,
        });
    } else {
        window.location.href = "/";
    }
</script>
<?  
    }
?>
<script>
    function rand_pass() {
        var resultrr       = '';
        var words        = '0123456789qwertyuiopasdfghjklzxcvbnmQWERTYUIOPASDFGHJKLZXCVBNM';
        var max_position = words.length - 1;
            for( i = 0; i < 10; ++i ) {
                position = Math.floor ( Math.random() * max_position );
                resultrr = resultrr + words.substring(position, position + 1);
            }
        return resultrr;
    }
</script>