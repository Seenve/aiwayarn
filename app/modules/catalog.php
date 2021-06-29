<?php 

    $req_url = ((!empty($_SERVER['HTTPS'])) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
    $req_url = explode('?', $url);
    $req_url = $url[0];


    $categoryId = $category['id'];

    $pagenum = isset($_GET['_num']) ? $_GET['_num'] : '';
    $pagenum = val_string($pagenum);
    $getSort = isset($_GET['_sort']) ? $_GET['_sort'] : '';
    $getSort = preg_replace("/[^0-9]/", '', $getSort);

    $arrGet = array();
    if(!$arrGet['_sort']) {
        $arrGet['_sort'] = 0;
    }

    $url_page_ext = $_SERVER['REQUEST_URI'];
    foreach ($_GET as $key => $value) {
        if(strpos($key,'_') === false) {} else {
            //echo '<p>'.$value.'</p>';
            if($key == '_num' || $value == '#content') {

            } else {
                $arrGet[$key] = $value;
            }
        }
    }
    $url_page = $GLOBALS['url'].'?'.http_build_query($arrGet).'&_num=';

    if(!$getSort) $getSort = 0;
    $arr_sort[0] = 'По дате';
    $arr_sort[1] = 'Сначала дешевле';
    $arr_sort[2] = 'Сначала дороже';
    //$arr_sort[3] = 'По алфавиту';

    if ($getSort == 1) {
        $sort_txt = 'ORDER BY `price` ASC';
    } else if ($getSort == 2) {
        $sort_txt = 'ORDER BY `price` DESC';
    } else if ($getSort == 3) {
        $sort_txt = 'ORDER BY `name` ASC';
    } else {
        $sort_txt = 'ORDER BY `regdate` DESC';
    }
?>

<section class="catalog">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="catalog__head">
                    <div class="category">
                        <?php 
                            if($category['title']) {
                                ?>
                                    <h3>Каталог</h3>
                                    <h1><?php echo $category['title']; ?></h1>
                                <?
                            } else {
                                ?>
                                    <h1>Каталог товаров</h1>
                                <?
                            }
                        ?>
                    </div>
                    <div class="sort">
                        <form action="<?php echo $GLOBALS['url']; ?>" class="selector" data-pjax="content">
                            <input type="hidden" name="_sort" value="1" class="selector__value">
                            <?php
                                foreach ($_GET as $key => $value) {
                                    if(strpos($key,'_') === false) {} else {
                                        //echo '<p>'.$value.'</p>';
                                        if($key == '_num') {
                                            ?>
                                                <input type="hidden" name="_num" value="<?php echo $value; ?>">
                                            <?
                                        }
                                    }
                                }
                            ?>
                            <div><p>Сортировать:</p><span><? echo $arr_sort[$getSort]; ?></span></div>
                            <ul>
                                <?php
                                    foreach ($arr_sort as $key => $value) {
                                        ?>
                                            <li data-id="<?php echo $key; ?>"><?php echo $value; ?></li>
                                        <?
                                    }
                                ?>
                            </ul>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-4 col-xl-3">
                <div class="catalog__menu">

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

                </div>
            </div>
            <div class="col-lg-8 col-xl-9">
                <div class="row">
                    <?php

                        $page = htmlspecialchars($_GET['page']);
                        // Переменная хранит число сообщений выводимых на станице  
                        $num = 18;  

                        if($categoryId) {
                            $posts = productsCountCategory($categoryId);
                        } else {
                            $posts = productsCount();
                        }

                        //$posts = mysqli_num_rows($result01s);  
                        // Находим общее число страниц  
                        $total = intval(($posts - 1) / $num) + 1;  
                        // Определяем начало сообщений для текущей страницы  
                        $pagenum = intval($pagenum);  
                        // Если значение $pagenum меньше единицы или отрицательно  
                        // переходим на первую страницу  
                        // А если слишком большое, то переходим на последнюю  
                        if(empty($pagenum) or $pagenum < 0) $pagenum = 1;  
                          if($pagenum > $total) $pagenum = $total;  
                        // Вычисляем начиная к какого номера  
                        // следует выводить сообщения  
                        $start = $pagenum * $num - $num;  

                        $postrow = array();

                        if($categoryId) {
                            $filter = $sort_txt.' LIMIT '.$start.', '.$num;

                            $categoryArr[] = $categoryId;
                            foreach (productsCategoryParent($categoryId) as $key => $value) {
                                $categoryArr[] = $value['id'];
                            }
                            foreach (products($categoryArr, $filter) as $key => $value) {
                                $postrow[] = $value;
                            }
                        } else {
                            $filter = $sort_txt.' LIMIT '.$start.', '.$num;
                            foreach (products(null, $filter) as $key => $value) {
                                $postrow[] = $value;
                            }
                        }

                        if($posts > 0){  
                            for($in = 0; $in < $num; $in++) {  
                                $idstr = $postrow[$in]['id'];
                                if($idstr > 0) {
                                    $productArr = $postrow[$in];
                                    include $path.'/../modules/catalog_product.php';
                                }
                            }
                        } else {
                            echo '<div class="card-row"><article class="card-row__title">В данной категории нет товаров</article></div>';
                        }
                    ?>     
                </div>   
            </div>
        </div>
    </div>
</section>



<section class="catalog-pages">
    <div class="container">
        <div class="row">
            <div class="col-lg-6">
                <?php include $path.'/../modules/pagination.php'; ?>
            </div>
            <div class="col-lg-6">
                <div class="catalog-pages__info">
                    <p>В нашей продукции <? echo productsCount(); ?> <? echo ending($posts, 'товар', 'товара', 'товаров'); ?></p>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <?php
                    if(strlen(htmlspecialchars_decode($row_pages['content'])) > 1) {
                        ?>
                            <div class="catalog-pages__content">
                                <?php echo htmlspecialchars_decode($row_pages['content']); ?>
                            </div>
                        <?
                    }
                ?>
            </div>
        </div>
    </div>
</section>

<?php //include $path.'/../modules/special.php'; ?>

<script>
    /*if (screen.width > 768) {
        (function(){  // анонимная функция (function(){ })(), чтобы переменные "a" и "b" не стали глобальными
            var a = document.querySelector('.header-fix'), b = null;  // селектор блока, который нужно закрепить
            window.addEventListener('scroll', Ascroll, false);
            document.body.addEventListener('scroll', Ascroll, false);  // если у html и body высота равна 100%
            function Ascroll() {
              if (b == null) {  // добавить потомка-обёртку, чтобы убрать зависимость с соседями
                var Sa = getComputedStyle(a, ''), s = '';
                for (var i = 0; i < Sa.length; i++) {  // перечислить стили CSS, которые нужно скопировать с родителя
                  if (Sa[i].indexOf('overflow') == 0 || Sa[i].indexOf('padding') == 0 || Sa[i].indexOf('border') == 0 || Sa[i].indexOf('outline') == 0 || Sa[i].indexOf('box-shadow') == 0 || Sa[i].indexOf('background') == 0) {
                    s += Sa[i] + ': ' +Sa.getPropertyValue(Sa[i]) + '; '
                  }
                }
                b = document.createElement('div');  // создать потомка
                b.style.cssText = s + ' box-sizing: border-box; width: ' + a.offsetWidth + 'px;';
                a.insertBefore(b, a.firstChild);  // поместить потомка в цепляющийся блок первым
                var l = a.childNodes.length;
                for (var i = 1; i < l; i++) {  // переместить во вновь созданного потомка всех остальных потомков (итого: создан потомок-обёртка, внутри которого по прежнему работают скрипты)
                  b.appendChild(a.childNodes[1]);
                }
                a.style.height = b.getBoundingClientRect().height + 'px';  // если под скользящим элементом есть другие блоки, можно своё значение
                a.style.padding = '0';
                a.style.border = '0';  // если элементу присвоен padding или border
              }
              if (a.getBoundingClientRect().top <= 0) { // elem.getBoundingClientRect() возвращает в px координаты элемента относительно верхнего левого угла области просмотра окна браузера
                b.className = 'sticky';
              } else {
                b.className = '';
              }
              window.addEventListener('resize', function() {
                a.children[0].style.width = getComputedStyle(a, '').width
              }, false);  // если изменить размер окна браузера, измениться ширина элемента
            }
        })();
    }*/
</script>


