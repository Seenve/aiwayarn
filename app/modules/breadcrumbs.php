<?php  
    $arrBreadcrumbs = recursive_array_parser($_GET);
?>
<section class="breadcrumbs">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <ul>
                    <li>
                        <a href="/" data-pjax="content">Главная</a>
                    </li>
                    <?php
                        $url = '';
                        foreach ($arrBreadcrumbs as $key => $value) {
                            if(strpos($value,'#') === false) {
                                if(preg_match('/[a-zA-Z]/',$value)) {
                                    $url .= '/'.$value;
                                    if(breadcrumbSearch($value, $arrBreadcrumbs[$key-1], $key, $arrBreadcrumbs[0])) {
                                        $_GLOBAL['url'] = $url;
                                        $arrBc = breadcrumbSearch($value, $arrBreadcrumbs[$key-1], $key, $arrBreadcrumbs[0]);
                                        $title_page = $arrBc['title'];
                                        ?>
                                            <li>
                                                <a href="<? echo $url; ?>" data-pjax="content"><? echo $arrBc['title']; ?></a>
                                            </li>
                                        <?
                                    }
                                }
                            }
                        }
                    ?>
                </ul>
            </div>
        </div>
    </div>
</section>