<?
	include '../ap/bd.php';

    $modId = isset($_GET['modId']) ? $_GET['modId'] : '';
    $productId = isset($_GET['productId']) ? $_GET['productId'] : '';
    $cityId = isset($_GET['cityId']) ? $_GET['cityId'] : '';

    $product = products_id($productId);
    $productMods = product_mods($cityId, $product['uid']);
    $stockArr = stock($product, $productMods);
    $modId = val_string($modId);
    if($modId) {
        $modArr = products_mod($cityId, $modId);
        if(count($modArr) > 0) {
            $stockArr = stock($modArr, null);
        } else {
            $modId = 0;
        }
    } else {
        $modId = 0;
    }

    include '../modules/product_block_price.php';

?>
