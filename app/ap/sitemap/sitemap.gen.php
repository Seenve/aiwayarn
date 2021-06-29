<?php

set_time_limit(0);
include("./sitemap.class.php");
$sitemap = new sitemap();

//игнорировать ссылки с расширениями:
$sitemap->set_ignore(array("javascript:", ".css", ".js", ".ico", ".jpg", ".png", ".jpeg", ".swf", ".gif"));

//ссылка Вашего сайта:
$sitemap->get_links("http://aiwayarn.seenve.ru");

//если нужно вернуть просто массив с данными:
//$arr = $sitemap->get_array();
//echo "<pre>";
//print_r($arr);
//echo "</pre>";

header ("content-type: text/xml");
$map = $sitemap->generate_sitemap();
echo $map;
?>