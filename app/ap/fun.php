<?
    function makeUUID() {
        return sprintf('%04x%04x-%04x-%04x-%04x-%04x%04x%04x',

        // 32 bits for "time_low"
        mt_rand(0, 0xffff), mt_rand(0, 0xffff),

        // 16 bits for "time_mid"
        mt_rand(0, 0xffff),

        // 16 bits for "time_hi_and_version",
        // four most significant bits holds version number 4
        mt_rand(0, 0x0fff) | 0x4000,

        // 16 bits, 8 bits for "clk_seq_hi_res",
        // 8 bits for "clk_seq_low",
        // two most significant bits holds zero and one for variant DCE1.1
        mt_rand(0, 0x3fff) | 0x8000,

        // 48 bits for "node"
        mt_rand(0, 0xffff), mt_rand(0, 0xffff), mt_rand(0, 0xffff)
        );
    }

    function phone($phone, $type = false) {
        if($type) {
            $result = preg_replace(
                '/^(\d)(\d{3})(\d{3})(\d{2})(\d{2})$/',
                '8 (\2) \3-\4-\5',
            (string)$phone);
        } else {
            $result = preg_replace(
                '/^(\d)(\d{3})(\d{3})(\d{2})(\d{2})$/',
                '+\1 (\2) \3-\4-\5',
            (string)$phone);
        }
        return $result;
    }

    function phoneDecode($phone) {
        return preg_replace("/[^0-9]/", '', $phone);
    }

    function generate_code($number) {
        $arr = array('A','B','C','D','E','F',
                     'G','H','I','J','K','L',
                     'M','N','O','P','R','S',
                     'T','U','V','X','Y','Z',
                     '1','2','3','4','5','6',
                     '7','8','9','0');
        // Генерируем пароль
        $pass = "";
        for($i = 0; $i < $number; $i++)
        {
          // Вычисляем случайный индекс массива
          $index = rand(0, count($arr) - 1);
          $pass .= $arr[$index];
        }
        return $pass;
    }
    function generate_number($number) {
        $arr = array('1','2','3','4','5','6',
                     '7','8','9','0');
        // Генерируем пароль
        $pass = "";
        for($i = 0; $i < $number; $i++)
        {
          // Вычисляем случайный индекс массива
          $index = rand(0, count($arr) - 1);
          $pass .= $arr[$index];
        }
        return $pass;
    }

   function generate_password($number) {
        $arr = array('a','b','c','d','e','f',
                     'g','h','i','j','k','l',
                     'm','n','o','p','r','s',
                     't','u','v','x','y','z',
                     'A','B','C','D','E','F',
                     'G','H','I','J','K','L',
                     'M','N','O','P','R','S',
                     'T','U','V','X','Y','Z',
                     '1','2','3','4','5','6',
                     '7','8','9','0');
        // Генерируем пароль
        $pass = "";
        for($i = 0; $i < $number; $i++)
        {
          // Вычисляем случайный индекс массива
          $index = rand(0, count($arr) - 1);
          $pass .= $arr[$index];
        }
        return $pass;
    }
    function price($number = 0) {
        $result = '';
        if (strpos($number, '.') !== false) {
            $result = number_format($number, 2, '.', ' '); 
        } else {
            $result = number_format($number, 0, '.', ' '); 
        }
        $result = $result.' ₽';
        return $result;
    }
    function translit($str){
        $tr = array(
            "А"=>"A","Б"=>"B","В"=>"V","Г"=>"G",
            "Д"=>"D","Е"=>"E","Ж"=>"J","З"=>"Z","И"=>"I",
            "Й"=>"Y","К"=>"K","Л"=>"L","М"=>"M","Н"=>"N",
            "О"=>"O","П"=>"P","Р"=>"R","С"=>"S","Т"=>"T",
            "У"=>"U","Ф"=>"F","Х"=>"H","Ц"=>"TS","Ч"=>"CH",
            "Ш"=>"SH","Щ"=>"SCH","Ъ"=>"","Ы"=>"YI","Ь"=>"",
            "Э"=>"E","Ю"=>"YU","Я"=>"YA","а"=>"a","б"=>"b",
            "в"=>"v","г"=>"g","д"=>"d","е"=>"e","ж"=>"j",
            "з"=>"z","и"=>"i","й"=>"y","к"=>"k","л"=>"l",
            "м"=>"m","н"=>"n","о"=>"o","п"=>"p","р"=>"r",
            "с"=>"s","т"=>"t","у"=>"u","ф"=>"f","х"=>"h",
            "ц"=>"ts","ч"=>"ch","ш"=>"sh","щ"=>"sch","ъ"=>"y",
            "ы"=>"yi","ь"=>"'","э"=>"e","ю"=>"yu","я"=>"ya",
            "."=>"_"," "=>"_","?"=>"_","/"=>"_","\\"=>"_",
            "*"=>"_",":"=>"_","*"=>"_","\""=>"_","<"=>"_",
            ">"=>"_","|"=>"_"
        );
        return strtr($str,$tr);
    }

    function authuser() {
        $login = isset($_SESSION['useruid']) ? $_SESSION['useruid'] : '';
        $login = val_string($login);
        $query_username = mysqli_query($GLOBALS['db'], "SELECT * FROM `accounts` WHERE `uid`='$login'");
        if(mysqli_num_rows($query_username) > 0) {
            $row_username = mysqli_fetch_assoc($query_username);
            if($row_username['hash'] !== 0) {
                $cok1 = $row_username['hash'];
                $cok2 = isset($_SESSION['userhash']) ? $_SESSION['userhash'] : '';
                $cok2 = val_string($cok2);
                if($cok2 == $cok1) {
                    return $login;
                } else {
                    return false;
                }
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    function guest() {
        $uid = $_SESSION['useruid'];
        return $uid;
    }

    function rec($text) {
        $ex = explode(' ', $text);
        $str_count = array();
        for ($i = 0; $i < count($ex); $i++) {
            $str_count[$ex[$i]]['count'] = 0;
            for ($j = 0; $j < count($ex); $j++) {
                if ($ex[$i] == $ex[$j]) {
                    $str_count[$ex[$i]]['count']++;
                }
            }
        }
        
        return $str_count;
    }

    function nums($type) {
        $query = mysqli_query($GLOBALS['db'], "SELECT (`id`) FROM `$type`");
        return mysqli_num_rows($query);
    }

    function gallery_arr($type, $uid) {
        $query_isl = mysqli_query($GLOBALS['db'], "SELECT * FROM `gallery` WHERE `uid`='$uid' AND `type` = '$type' ORDER BY main DESC");
        $array_of_row = array();
        while($row_isl = mysqli_fetch_assoc($query_isl)){
            $array_of_row[] = $row_isl; 
        }
        return $array_of_row;
    }

    function gallery_image($name) {
        $filename = $path.'uploads/'.$name;
        $result = false;
        if(file_exists($filename)) {
            $result = true;
        }

        return $result;
    }

    //echo gallery('products', $productArr['id'], 0, 1, 'small', $productArr['title'], false, true);
    // тип, id, limit, limit, размер, title, отключен, png

    function gallery($type, $id, $numTo, $numFor, $widthImage, $title, $hide = false, $png = false) {
        $html = '';
        $query = mysqli_query($GLOBALS['db'], "SELECT * FROM `gallery` WHERE `uid`='$id' AND `type` = '$type' ORDER BY main DESC LIMIT $numTo, $numFor");
        if(mysqli_num_rows($query) > 0) {
            while($row = mysqli_fetch_assoc($query)){
                $imageName = $row['image'];
                $explode = explode(".", $imageName);
                $img = $explode[0];

                /*$url_jpg = '/uploads/images/jpeg/';
                $url_webp = '/uploads/images/webp/';
                $url_png = '/uploads/images/png/';

                if($widthImage == 'full') {
                    $image = $imageName.'-1920x1080';
                } else if($widthImage == 'middle') {
                    $image = $imageName.'-768x512';
                } else if($widthImage == 'small') {
                    $image = $imageName.'-300x200';
                } else {
                    $image = $imageName.'-100x100';
                }

                $html.= '
                    <picture>
                        <source srcset="'.$url_webp.$image.'.webp" type="image/webp">
                        <img srcset="'.$url_jpg.$image.'.jpeg" alt="'.$alt.'"> 
                    </picture>
                ';*/

                $html.= galleryImage($img, $widthImage, $title);
            }
            return $html;
        } else {
            if(!$hide) {
                $html = '
                    <picture>
                        <img srcset="/ap/assets/images/no-image.svg"> 
                    </picture>
                ';
            }
        }
        return $html;
    }

    /*
        $user_agent = $_SERVER["HTTP_USER_AGENT"];
        if (strpos($user_agent, "Firefox") !== false) $browser = "Firefox";
        elseif (strpos($user_agent, "Opera") !== false) $browser = "Opera";
        elseif (strpos($user_agent, "Chrome") !== false) $browser = "Chrome";
        elseif (strpos($user_agent, "MSIE") !== false) $browser = "Internet Explorer";
        elseif (strpos($user_agent, "Safari") !== false) $browser = "Safari";
        else $browser = "Неизвестный";
        echo "Ваш браузер: $browser";
    */

    function galleryImage($imageName, $imageSize = '', $title = '', $type = false) {

        $user_agent = $_SERVER["HTTP_USER_AGENT"];

        $url_jpg = '/uploads/images/jpeg/';
        $url_webp = '/uploads/images/webp/';
        $url_png = '/uploads/images/png/';

        if($imageSize == 'full') {
            $image = $imageName.'-1920x1080';
        } else if($imageSize == 'middle') {
            $image = $imageName.'-768x512';
        } else if($imageSize == 'small') {
            if (strpos($user_agent, "Safari") !== false) {
                $image = $imageName.'-768x512';
            } else {
                $image = $imageName.'-300x200';
            }
        } else if($imageSize == 'default') {
            $image = $imageName.'-448x256';
            if(!file_exists('.'.$url_jpg.$image.'.jpeg')) {
                $image = $imageName.'-300x200';
            }
        } else {
            $image = $imageName.'-100x100';
        }

        $result = '
            <picture>
                <source srcset="'.$url_webp.$image.'.webp" type="image/webp">
                <img srcset="'.$url_jpg.$image.'.jpeg" alt="'.$title.'"> 
            </picture>
        ';
        return $result;
    }

    function page_cat($name) {
        $array = array();
        $query = mysqli_query($GLOBALS['db'], "SELECT `id`, `name`, `include` FROM `pages` WHERE `name` = '$name' AND `show` = '1'");
        if(mysqli_num_rows($query) > 0) {
            $row = mysqli_fetch_assoc($query);
            if(!$row['include'] == 1) {
                $array['result'] = true;
                $array['info'] = $row;
            }
        } else {
            $array['result'] = false;
        }
        return $array;
    }

    function products_category($name) {
        $array = array();
        $query = mysqli_query($GLOBALS['db'], "SELECT `id`, `name`, `include` FROM `products_category` WHERE `name` = '$name' AND `show` = '1'");
        if(mysqli_num_rows($query) > 0) {
            $row = mysqli_fetch_assoc($query);
            if(!$row['include'] == 1) {
                $array['result'] = true;
                $array['info'] = $row;
            }
        } else {
            $array['result'] = false;
        }
        return $array;
    }

    function numberEnd($number, $value, $suffix) {
        //ключи массива suffix
        $keys = array(2, 0, 1, 1, 1, 2);
        //берем 2 последние цифры
        $mod = $number % 100;
        //определяем ключ окончания
        $suffix_key = $mod > 4 && $mod < 21 ? 2 : $keys[min($mod%10, 5)];
        return $value . $suffix[$suffix_key];
    }

    function convert_size($size) { 
        $filesizename = array(" мб", " гб", " тб"); 
        $size = round($size/pow(1024, ($i = floor(log($size, 1024)))), 2) . $filesizename[$i]; 
        return $size; 
    }

    function rus2translit($string) {
        $converter = array(
            'а' => 'a',   'б' => 'b',   'в' => 'v',
            'г' => 'g',   'д' => 'd',   'е' => 'e',
            'ё' => 'e',   'ж' => 'zh',  'з' => 'z',
            'и' => 'i',   'й' => 'y',   'к' => 'k',
            'л' => 'l',   'м' => 'm',   'н' => 'n',
            'о' => 'o',   'п' => 'p',   'р' => 'r',
            'с' => 's',   'т' => 't',   'у' => 'u',
            'ф' => 'f',   'х' => 'h',   'ц' => 'c',
            'ч' => 'ch',  'ш' => 'sh',  'щ' => 'sch',
            'ь' => '\'',  'ы' => 'y',   'ъ' => '\'',
            'э' => 'e',   'ю' => 'yu',  'я' => 'ya',
            
            'А' => 'A',   'Б' => 'B',   'В' => 'V',
            'Г' => 'G',   'Д' => 'D',   'Е' => 'E',
            'Ё' => 'E',   'Ж' => 'Zh',  'З' => 'Z',
            'И' => 'I',   'Й' => 'Y',   'К' => 'K',
            'Л' => 'L',   'М' => 'M',   'Н' => 'N',
            'О' => 'O',   'П' => 'P',   'Р' => 'R',
            'С' => 'S',   'Т' => 'T',   'У' => 'U',
            'Ф' => 'F',   'Х' => 'H',   'Ц' => 'C',
            'Ч' => 'Ch',  'Ш' => 'Sh',  'Щ' => 'Sch',
            'Ь' => '\'',  'Ы' => 'Y',   'Ъ' => '\'',
            'Э' => 'E',   'Ю' => 'Yu',  'Я' => 'Ya',
        );
        return strtr($string, $converter);
    }
    function str2url($str) {
        $str = rus2translit($str);
        $str = strtolower($str);
        $str = preg_replace('~[^-a-z0-9_]+~u', '-', $str);
        $str = trim($str, "-");
        return $str;
    }

    function settings($id = null) {
        $array_of_row = array();
        if($id) {
            $query = mysqli_query($GLOBALS['db'], "SELECT * FROM `settings` WHERE `id`='$id'");
            $row = mysqli_fetch_assoc($query);
            $array_of_row[] = $row; 
        } else {
            $query_sl = mysqli_query($GLOBALS['db'], "SELECT * FROM `settings`");
            while($row_sl = mysqli_fetch_assoc($query_sl)){
                $array_of_row[] = $row_sl; 
            }
        }
        return $array_of_row;

    }

    function settings_id($id) {
        $query = mysqli_query($GLOBALS['db'], "SELECT * FROM `settings` WHERE `id`='$id'");
        $array_of_row = array();
        $row = mysqli_fetch_assoc($query);
        $array_of_row[] = $row; 
        return $array_of_row;
    }

    function user($uid) {
        $arr_sl = array();
        $query_sl = mysqli_query($GLOBALS['db'], "SELECT * FROM `accounts` WHERE `uid`='$uid'");
        if(mysqli_num_rows($query_sl) > 0) {
            $rowsl = mysqli_fetch_array($query_sl);
            $arr_sl['result'] = true;
            $arr_sl['id'] = $rowsl['id'];
            $arr_sl['firstname'] = $rowsl['firstname'];
            $arr_sl['lastname'] = $rowsl['lastname'];
            $arr_sl['phone'] = $rowsl['phone'];
            $arr_sl['money'] = $rowsl['money'];
            $arr_sl['email'] = $rowsl['email'];
            $arr_sl['city'] = $rowsl['city'];
            $arr_sl['post'] = $rowsl['post'];
            $arr_sl['address'] = $rowsl['address'];
            $arr_sl['verify'] = $rowsl['verify'];
            $arr_sl['admin'] = $rowsl['admin'];
            $arr_sl['regdate'] = strtotime($rowsl['regdate']);
        } else {
            $arr_sl['result'] = false;
        }
        return $arr_sl;
    }

    function userInfo($id) {
        $arr_sl = array();
        $query_sl = mysqli_query($GLOBALS['db'], "SELECT * FROM `accounts` WHERE `id` = '$id'");
        if(mysqli_num_rows($query_sl) > 0) {
            $rowsl = mysqli_fetch_array($query_sl);
            $arr_sl['result'] = true;
            $arr_sl['id'] = $rowsl['id'];
            $arr_sl['firstname'] = $rowsl['firstname'];
            $arr_sl['lastname'] = $rowsl['lastname'];
            $arr_sl['phone'] = $rowsl['phone'];
            $arr_sl['money'] = $rowsl['money'];
            $arr_sl['email'] = $rowsl['email'];
            $arr_sl['verify'] = $rowsl['verify'];
        } else {
            $arr_sl['result'] = false;
        }
        return $arr_sl;
    }

    function page($page) {
        $query = mysqli_query($GLOBALS['db'], "SELECT * FROM `pages` WHERE `name`='$page'");
        $array_of_row = array();
        $row = mysqli_fetch_array($query);
        $array_of_row[] = $row; 
        return $array_of_row;
    }

    function pages() {
        $query = mysqli_query($GLOBALS['db'], "SELECT * FROM `pages`");
        $array_of_row = array();
        while($row = mysqli_fetch_assoc($query)){
            $array_of_row[] = $row; 
        }
        return $array_of_row;
    }

    function menuArr() {
        $i = 0;
        $query = mysqli_query($GLOBALS['db'], "SELECT `id`, `name`, `title` FROM `pages`");
        while($row = mysqli_fetch_assoc($query)){
            $array[$i]['id'] = $row['id']; 
            $array[$i]['name'] = $row['name']; 
            $array[$i]['title'] = $row['title']; 
            $array[$i]['menu'] = 1; 
            $page = $row['name'];
            $array2 = array();
            $query2 = mysqli_query($GLOBALS['db'], "SELECT `id`, `name`, `title` FROM `$page`");
            $i2 = 0;
            while($row2 = mysqli_fetch_assoc($query2)){
                $array2[$i2]['id'] = $row2['id'];
                $array2[$i2]['name'] = $row2['name']; 
                $array2[$i2]['title'] = $row2['title']; 
                $array2[$i2]['menu'] = 0; 
                $i2++;
            }
            $i2 = 0;
            $array[$i]['children'] = $array2;
            $i++;
        }
        $i = 0;
        $array['0']['title'] = 'Главная';
        return $array;
    }

    function category_inset($id, $show) {
        $i = 0;
        $array = array();
        if($show == 1) {
            $query = mysqli_query($GLOBALS['db'], "SELECT `id`, `name`, `title`, `include` FROM `pages` WHERE `category` = '$id' AND `show` = '1'");
        } else {
            $query = mysqli_query($GLOBALS['db'], "SELECT `id`, `name`, `title`, `include` FROM `pages` WHERE `category` = '$id'");
        }
        while($row = mysqli_fetch_assoc($query)){
            if($row['include'] == 1) {

            } else {
                $array[] = $row;
                $array[$i]['children'] = category_inset($row['id'], $show);
            }
            $i++;
        }
        return $array;
    }

    function category_inset_include_catalog($id, $show = '') {
        $i = 0;
        $array = array();
        if($show == 1) {
            $query = mysqli_query($GLOBALS['db'], "SELECT `id`, `name`, `title`, `include` FROM `products_category` WHERE `parent_id` = '$id' AND `show` = '1'");
        } else {
            $query = mysqli_query($GLOBALS['db'], "SELECT `id`, `name`, `title`, `include` FROM `products_category` WHERE `parent_id` = '$id'");
        }
        while($row = mysqli_fetch_assoc($query)){
            $array[] = $row;
            $array[$i]['children'] = category_inset_include_catalog($row['id'], $show);
            $i++;
        }
        return $array;
    }
    function category_inset_include($page, $show) {
        $i = 0;
        $array = array();
        if($show == 1) {
            $query = mysqli_query($GLOBALS['db'], "SELECT `id`, `name`, `title` FROM `$page` WHERE `show` = '1'");
        } else {
            $query = mysqli_query($GLOBALS['db'], "SELECT `id`, `name`, `title` FROM `$page`");
        }
        while($row = mysqli_fetch_assoc($query)){
            $array[] = $row;
            $i++;
        }
        $array[$i]['children'] = $array;
        return $array;
    }
    function pagesArr($inc = 0, $show = 0) {
        $array = array();
        if($show == 1) {
            $query = mysqli_query($GLOBALS['db'], "SELECT `id`, `name`, `title`, `include` FROM `pages` WHERE `category` = '0' AND `show` = '1'");
        } else {
            $query = mysqli_query($GLOBALS['db'], "SELECT `id`, `name`, `title`, `include` FROM `pages` WHERE `category` = '0'");
        }
        $i = 0;
        while($row = mysqli_fetch_assoc($query)){
            if($row['include'] == 1) {
                if($row['name'] == 'catalog') {
                    $array[] = $row;
                    $array[$i]['children'] = category_inset_include_catalog($show);
                } else {
                    $array[] = $row;
                    $array[$i]['children'] = category_inset_include($row['name'], $show);
                }
            } else {
                $array[] = $row;
                $array[$i]['children'] = category_inset($row['id'], $show);
            }
            $i++;
        }
        $array['0']['title'] = 'Главная';
        return $array;
    }

    function categoryArr() {
        $array = array();
        $i = 0;
        $array[$i]['title'] = 'По умолчанию'; 
        $array[$i]['id'] = 0; 
        $query = mysqli_query($GLOBALS['db'], "SELECT * FROM `pages` WHERE `include` = '0'");
        while($row = mysqli_fetch_assoc($query)){
            $array[] = $row; 
            $i++;
        }
        return $array;
    }

    function inPage($page, $id) {
        $query = mysqli_query($GLOBALS['db'], "SELECT * FROM `$page` WHERE `id`='$id'");
        $array_of_row = array();
        $row = mysqli_fetch_array($query);
        $array_of_row[] = $row; 
        return $array_of_row;
    }

    function title($page, $inTitle = false) {
        $name_page = page($page)['0']['title'];
        $main_title = settings()['0']['title'];
        if($inTitle) {
            $title = $inTitle.' &mdash; '.$main_title;
        } else {
            if($name_page) {
                $title = $name_page.' &mdash; '.$main_title;
            } else {
                $title = $main_title;
            }
        }
        return $title;
    }

    function meta($arr, $ajax = false) {
        $arrTitle = array();

        $arrBreadcrumbs = recursive_array_parser($arr);
        $arrTitle['title_main'] = settings()['0']['description'];

        $url = '';
        if(count($arrBreadcrumbs) > 0) {
            foreach ($arrBreadcrumbs as $key => $value) {
                if(strpos($value,'#') === false) {
                    if(preg_match('/[a-zA-Z]/',$value)) {
                        $url .= '/'.$value;
                        if(breadcrumbSearch($value, $arrBreadcrumbs[$key-1], $key, $arrBreadcrumbs[0])) {
                            $GLOBALS['url'] = $url;
                            $arrBc = breadcrumbSearch($value, $arrBreadcrumbs[$key-1], $key, $arrBreadcrumbs[0]);
                        }
                    }
                }
            }
        } else {
            $arrBc = breadcrumbSearch('', '', 0, 0);
        }

        $arrTitle['title_page'] = $arrBc['title'];
        if($ajax) {
            $arrTitle['title'] = $arrTitle['title_main'].' — '.$arrBc['title'];
        } else {
            if($arrBc['table'] == 'pages' && $arrBc['id'] == 1) {
                $arrTitle['title'] = $arrTitle['title_main'];
            } else {
                $arrTitle['title'] = $arrBc['title'].' &mdash; '.$arrTitle['title_main'];
            }
        }
        $arrTitle['description'] = $arrBc['description'];
        $arrTitle['keywords'] = $arrBc['keywords'];
        //$arrTitle['url'] = ((!empty($_SERVER['HTTPS'])) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'].$url;
        $arrTitle['url'] = 'https://' . $_SERVER['HTTP_HOST'].$url;
        $imageArr = gallery_arr($arrBc['table'], $arrBc['id']);
        if(count($imageArr)) {
            $arrTitle['imageUrl'] = 'https://' . $_SERVER['HTTP_HOST'].'/uploads/images/jpeg/'.$imageArr[0]['image'].'-768x512.jpeg';
        } else {
            //$arrTitle['imageUrl'] = '/assets/img/logo.svg';
        }

        return $arrTitle;
    }

    function description($page, $description) {
        $result = $description;
        if(!$description) {
            $result = settings()['0']['description'];
        }
        return $result;
    }

    function keywords($page, $keywords) {
        if($keywords) {
            $result = $keywords;
        } else {
            $result = settings()['0']['keywords'];
        }
        return $result;
    }

    function url($page, $str) {
        if($str) {
            $result = settings()['0']['url'].$str;
        } else {
            $result = settings()['0']['url'].'/';
        }
        return $result;
    }

    function image($page, $str) {
        if($str) {
            $result = $str;
        } else {
            $result = settings()['0']['url'].settings()['0']['og_image'];
        }
        return $result;
    }

    function day_number_name($int) {  
        $expr = 0;
        settype($int, "integer");  
        $count = $int % 100;  
        if ($count >= 5 && $count <= 20) {  
            $result = $int." дней".$expr['2'];  
        } else {  
            $count = $count % 10;  
            if ($count == 1) {  
                $result = $int." день".$expr['0'];  
            } elseif ($count >= 2 && $count <= 4) {  
                $result = $int." дня".$expr['1'];  
            } else {  
                $result = $int." дней".$expr['2'];  
            }  
        }  
        return $result;  
    }

    function select_arr($number, $arr) {
        if (!empty( $arr[$number])) {
          return $arr[$number];
        } else {
          return false;
        }
    }

    //защита
    function val_string($str) {
        $res = mysqli_real_escape_string($GLOBALS['db'], htmlspecialchars($str));
        return $res;
    }

    function showDate($time) { // Определяем количество и тип единицы измерения
        $time = time() - $time;
        if ($time < 60) {
            return 'меньше минуты назад';
        } elseif ($time < 3600) {
            return dimension((int)($time/60), 'i');
        } elseif ($time < 86400) {
            return dimension((int)($time/3600), 'G');
        } elseif ($time < 2592000) {
            return dimension((int)($time/86400), 'j');
        } elseif ($time < 31104000) {
            return dimension((int)($time/2592000), 'n');
        } elseif ($time >= 31104000) {
            return dimension((int)($time/31104000), 'Y');
        }
    }
    function dimension($time, $type) { // Определяем склонение единицы измерения
        $dimension = array(
            'n' => array('месяцев', 'месяц', 'месяца', 'месяц'),
            'j' => array('дней', 'день', 'дня'),
            'G' => array('часов', 'час', 'часа'),
            'i' => array('минут', 'минуту', 'минуты'),
            'Y' => array('лет', 'год', 'года')
        );
        
        if ($time >= 5 && $time <= 20)
            $n = 0;
        else if ($time == 1 || $time % 10 == 1)
            $n = 1;
        else if (($time <= 4 && $time >= 1) || ($time % 10 <= 4 && $time % 10 >= 1))
            $n = 2;
        else
            $n = 0;
        return $time.' '.$dimension[$type][$n]. ' назад';

    }

    function ending($number, $one, $two, $five) {
        $number = $number % 100;

        if ( ($number > 4 && $number < 21) || $number == 0 ) {
            $ending = $five;
        } else {
            $last_digit = substr($number, -1);

            if ( $last_digit > 1 && $last_digit < 5 )
                $ending = $two;
            elseif ( $last_digit == 1 )
                $ending = $one;
            else
                $ending = $five;
        }

        return $ending;
    }

    function recursive_array_parser($arr) {
        $out = array();
        $sub = null;
        foreach($arr as $item) {
            if($item[0] == '*') { // We've hit a special item!
                if(!is_array($sub)) { // We're not currently accumulating a sub-array, let's make one!
                    $sub = array();
                }
                $sub[] = substr($item, 1); // Add it to the sub-array without the '*'
            } else {
                if(is_array($sub)) { 
                    // Whoops, we have an active subarray, but this thing didn't start with '*'. End that sub-array
                    $out[] = recursive_array_parser($sub);
                    $sub = null;
                }
                // Take the item
                $out[] = $item;
            }
        }

        if(is_array($sub)) { // We ended in an active sub-array. Add it.
            $out[] = recursive_array_parser($sub);
            $sub = null;
        }

        return $out;
    }

    function searchTitle($table, $searchName) {
        $arr = array();
        $result = mysqli_query($GLOBALS['db'], "SELECT `id`,`title`,`description`,`keywords` FROM `$table` WHERE `name` = '$searchName'");
        $row = mysqli_fetch_array($result);
        $arr['id'] = $row['id'];
        $arr['title'] = $row['title'];
        $arr['description'] = $row['description'];
        $arr['keywords'] = $row['keywords'];
        $arr['table'] = $table;
        $arr['searchName'] = $searchName;
        return $arr;
    }

    function breadcrumbSearch($searchName, $table, $key, $mainName){
        $arr = array();
        //echo $searchName.','.$table.','.$key.','.$mainName.'=';
        if(!$table) {
            $table = 'pages';
        } else if($table == 'catalog' && $mainName == 'catalog') {
            $table = 'products_category';
        } else if($table && $searchName && $mainName == 'catalog' && $key == 2) {
            $table = 'products_category';
        } else if($mainName == 'catalog') {
            $table = 'products';
        }

        return searchTitle($table, $searchName);
    }


    /*function numberText($time, $type) {
        $dimension = array(
            'n' => array('месяцев', 'месяц', 'месяца', 'месяц'),
            'j' => array('дней', 'день', 'дня'),
            'G' => array('часов', 'час', 'часа'),
            'i' => array('минут', 'минуту', 'минуты'),
            'Y' => array('лет', 'год', 'года')
        );
        
        if ($time >= 5 && $time <= 20)
            $n = 0;
        else if ($time == 1 || $time % 10 == 1)
            $n = 1;
        else if (($time <= 4 && $time >= 1) || ($time % 10 <= 4 && $time % 10 >= 1))
            $n = 2;
        else
            $n = 0;
        return $time.' '.$dimension[$type][$n];
    }*/

    function mergeByKey($array,$key){
      $tmp_array = array();
      foreach ( $array as $k => $row ) {
        $merged = false;
        foreach ($tmp_array as $k2 => $tmp_row){
           if ($row[$key] == $tmp_row[$key]){
              foreach ( $row as $k3 => $value ) {
                if ($k3 == $key) continue;
                $tmp_array[$k2][$k3][] = $value;
                $merged = true;
              }
           }
           if ($merged) break;
        }
        if (!$merged) {
           $new_row = array();
           foreach ( $row as $k4 => $value ) {
             if ($k4 == $key) $new_row[$k4] = $value;
             else $new_row[$k4] = array($value);
           }
           $tmp_array[] = $new_row;
        }
      }
      foreach ( $tmp_array as $t => $row ) {
        foreach ( $row as $t2 => $value ) {
          if ( count($value) == 1 && $t2 != $key ) $tmp_array[$t][$t2] = $value[0];
        }
      }
      return $tmp_array;
    }

    function youtubeId($url) {
        if(strripos($url, "youtube.com"))
        {
            parse_str(parse_url($url, PHP_URL_QUERY), $you);
            $youtube_id = $you["v"];
        }
        elseif(strripos($url, "youtu.be"))
        {
            $you_mass = explode("/", $url);
            $youtube_id = $you_mass[count($you_mass) - 1];
        }
        
        if(!empty($youtube_id))
            return $youtube_id;
    }

     function watermark_image($target, $wtrmrk_file, $newcopy) {
        $watermark = imagecreatefrompng($wtrmrk_file);
        imagealphablending($watermark, false);
        imagesavealpha($watermark, true);
        $img = imagecreatefromjpeg($target);
        $img_w = imagesx($img);
        $img_h = imagesy($img);
        $wtrmrk_w = imagesx($watermark);
        $wtrmrk_h = imagesy($watermark);
        $dst_x = ($img_w / 2) - ($wtrmrk_w / 2); // For centering the watermark on any image
        $dst_y = ($img_h / 2) - ($wtrmrk_h / 2); // For centering the watermark on any image
        imagecopy($img, $watermark, $dst_x, $dst_y, 0, 0, $wtrmrk_w, $wtrmrk_h);
        imagejpeg($img, $newcopy, 100);
        imagedestroy($img);
        imagedestroy($watermark);
    }

?>