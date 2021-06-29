<?
    $url1 = isset($_GET['catalog']) ? $_GET['catalog'] : '';
    $category = val_string($category);
    $category2 = isset($_GET[$url1]) ? $_GET[$url1] : '';
    $category2 = val_string($category2);
    $category3 = isset($_GET[$category2]) ? $_GET[$category2] : '';
    $category3 = val_string($category3);

    if(authuser()) {
        $user_uid = authuser();
    } else {
        $user_uid = guest();
    }

    $city_products = $GLOBALS['city'];
    $city_products = 1;

    ?>

    <?php if (!isset($_SERVER['HTTP_X_PJAX'])) { include 'header.php'; } ?>

    <?php include 'modules/breadcrumbs.php'; ?>

    <?

    if($url1) {
        if($product = checkProduct($city_products, $url1, 1)) {
            include 'modules/product.php';
        } else {
            if($category = checkCategory($city_products, $url1, 0)) {
                if($category2) {
                    if($product = checkProduct($city_products, $category2, $category['id'])) {
                        include 'modules/product.php';
                    } else {
                        if($category = checkCategory($city_products, $category2, $category['id'])) {
                            if($category3) {
                                if($product = checkProduct($city_products, $category3, $category['id'])) {
                                    include 'modules/product.php';
                                } else {
                                    header("HTTP/1.0 404 Not Found");
                                    include 'modules/404.php';
                                    exit();
                                }
                            } else {
                                include 'modules/catalog.php';
                            }
                        } else {
                            header("HTTP/1.0 404 Not Found");
                            include 'modules/404.php';
                            exit();
                        }
                    }
                } else {
                    include 'modules/catalog.php';
                }
            } else {
                echo '11';
                header("HTTP/1.0 404 Not Found");
                include 'modules/404.php';
                exit();
            }
        }
    } else {
        include 'modules/catalog.php';
    }
?>