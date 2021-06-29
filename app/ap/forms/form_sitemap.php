<?php
	if(isset($_POST['sitemap_generate'])) {
		if($uid) {
			if(user($uid)['admin'] >= 2) {
				
		    require_once("sitemap/common.inc.php");

		    $dir = dirname(dirname(dirname(__FILE__)));//document root path
		    $tmp_dir = dirname(dirname(dirname(__FILE__)));//temp path
		    $base_url = settings()['0']['url'];//url with sitemaps (http://mysite.ru/sitemap.xml)
		    $gzip = false;
		    $config = array('path' => $dir, 'tmp_dir'=>$tmp_dir, 'base_url'=>$base_url, 'gzip'=>$gzip, 'gzip_level'=>9);

		    $builder = new SitemapBuilder($config);

		    $time = time();
		        
		    $builder->start();
		    //$builder->addUrl(array('loc'=>$base_url,'lastmod'=>$time,'priority'=>1.0,'changefreq'=>'weekly'));
		    //$builder->addUrl(array('loc'=>$base_url."news",'lastmod'=>$time,'priority'=>1.0,'changefreq'=>'weekly'));

		    /*foreach (pagesArr() as $key => $value) {
		        if(empty($value['children'])) {
		        	if($value['name']) {
		        		$builder->addUrl(array('loc'=>$base_url.$value['name'],'lastmod'=>$time,'priority'=>'0.8','changefreq'=>'weekly'));
		        	} else {
		        		$builder->addUrl(array('loc'=>$base_url.$value['name'],'lastmod'=>$time,'priority'=>'1.0','changefreq'=>'weekly'));
		        	}
		        } else {
		            foreach ($value['children'] as $key2 => $value2) {
		                $builder->addUrl(array('loc'=>$base_url.$value['name'].'/'.$value2['name'],'lastmod'=>$time,'priority'=>'0.64','changefreq'=>'weekly'));
		            }
		        }
		    }*/

function seoProduct($id, $show = '') {
    $i = 0;
    $array = array();
    if($show == 1) {
        $query = mysqli_query($GLOBALS['db'], "SELECT `id`, `name`, `title`, `category` FROM `products` WHERE `category` = '$id' AND `show` = '1'");
    } else {
        $query = mysqli_query($GLOBALS['db'], "SELECT `id`, `name`, `title`, `category` FROM `products` WHERE `category` = '$id'");
    }
    while($row = mysqli_fetch_assoc($query)){
        $array[] = $row;
        $i++;
    }
    return $array;
}

function seoCatalog($id, $show = '') {
    $i = 0;
    $array = array();
    if($show == 1) {
        $query = mysqli_query($GLOBALS['db'], "SELECT `id`, `name`, `title`, `include` FROM `products_category` WHERE `parent_id` = '$id' AND `show` = '1'");
    } else {
        $query = mysqli_query($GLOBALS['db'], "SELECT `id`, `name`, `title`, `include` FROM `products_category` WHERE `parent_id` = '$id'");
    }
    while($row = mysqli_fetch_assoc($query)){
        $array[] = $row;
        $array[$i]['children'] = seoCatalog($row['id'], $show);
        $array[$i]['products'] = seoProduct($row['id'], $show);
        $i++;
    }
    return $array;
}
function seoPages($page, $show) {
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
function seoArr($inc = 0, $show = 0) {
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
                $array[$i]['children'] = seoCatalog($show);
            } else {
                $array[] = $row;
                $array[$i]['children'] = seoPages($row['name'], $show);
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

function checkArr($arr = null, $name, $dap, $builder, $base_url) {
    foreach ($arr as $key => $value) {
        if($value['id']) {
            if(!empty($value['children'])) {
                $url = $name.'/'.$value['name'];
                $dap_str = str_replace(',', '.', $dap);
                $builder->addUrl(array('loc'=>$base_url.$url,'lastmod'=>$time,'priority'=>$dap_str,'changefreq'=>'weekly'));
                checkArr($value['children'], $url, $dap-0.1, $builder, $base_url);
            } else {
                $url = $name.'/'.$value['name'];
                $dap_str = str_replace(',', '.', $dap);
                $builder->addUrl(array('loc'=>$base_url.$url,'lastmod'=>$time,'priority'=>$dap_str,'changefreq'=>'weekly'));
            }

            foreach ($value['products'] as $key => $value2) {
            	$dap_str = str_replace(',', '.', $dap-0.1);
                $url2 = $url.'/'.$value2['name'];
                $builder->addUrl(array('loc'=>$base_url.$url2,'lastmod'=>$time,'priority'=>$dap_str,'changefreq'=>'weekly'));
            }

        }
    }
}

foreach (seoArr() as $key => $value) {
    $dap = '1.0';
    if($value['id']) {
        if(!empty($value['children'])) {
            $url = '/'.$value['name'];
            $builder->addUrl(array('loc'=>$base_url.$url,'lastmod'=>$time,'priority'=>$dap_str,'changefreq'=>'weekly'));
            checkArr($value['children'], $url, 1.0, $builder, $base_url);
        } else {
            $url = '/'.$value['name'];
            $builder->addUrl(array('loc'=>$base_url.$url,'lastmod'=>$time,'priority'=>$dap_str,'changefreq'=>'weekly'));
        }
    }
}

            /*function menu_showNested($arr, $name, $dap, $builder, $base_url) {
                foreach ($arr as $key => $value) {

                    if($value['id']) {
                        if($key == 0) {
                            $dap = $dap-0.1;
                        }
                        if(empty($value['children'])) {
                            $url = $name.'/'.$value['name'];
                            $dap_str = str_replace(',', '.', $dap);
                            $builder->addUrl(array('loc'=>$base_url.$url,'lastmod'=>$time,'priority'=>$dap_str,'changefreq'=>'weekly'));
                        } else {
                            $url = $name.'/'.$value['name'];
                            $dap_str = str_replace(',', '.', $dap);
                            $builder->addUrl(array('loc'=>$base_url.$url,'lastmod'=>$time,'priority'=>$dap_str,'changefreq'=>'weekly'));
                            menu_showNested($value['children'], $url, $dap, $builder, $base_url);
                        }
                    }
                }
            }
            
            foreach (pagesArr(0, 1) as $key => $value) {
                $dap = '1.0';
                if($value['id']) {
                    if(empty($value['children'])) {
                        $url = '/'.$value['name'];
                        $builder->addUrl(array('loc'=>$base_url.$url,'lastmod'=>$time,'priority'=>$dap,'changefreq'=>'weekly'));
                    } else {
                        $url = '/'.$value['name'];
                        $builder->addUrl(array('loc'=>$base_url.$url,'lastmod'=>$time,'priority'=>$dap,'changefreq'=>'weekly'));
                        menu_showNested($value['children'], $url, 1.0, $builder, $base_url);
                    }
                }
            }*/

		    $builder->commit();

				mysqli_query($GLOBALS['db'], "UPDATE `settings` SET `sitemap` = current_timestamp() WHERE `id`='1'");
				$message = 'Генерация прошла успешно';
				echo json_encode(array(
					'result' => true,
					'title' => 'Выполнено',
					'type' => 'success',
					'redirect' => false,
					'reload' => true,
					'scroll' => 1,
					'notify' => true,
					'message' => $message,
				));

			} else {
				echo admin_error();
			}
		} else {
			echo auth_error();
		}
	}

?>