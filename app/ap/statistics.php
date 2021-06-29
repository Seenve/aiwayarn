<?php
//$visitor_ip = $_SERVER['REMOTE_ADDR'];
if (!empty($_SERVER['HTTP_CLIENT_IP']))
{
	$visitor_ip=$_SERVER['HTTP_CLIENT_IP'];
}
elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))
{
	$visitor_ip=$_SERVER['HTTP_X_FORWARDED_FOR'];
}
else
{
	$visitor_ip=$_SERVER['REMOTE_ADDR'];
}
$day = date("d");
$date = date("Y-m-d");

$res = mysqli_query($GLOBALS['db'], "SELECT `id` FROM `visits` WHERE `date`='$date'");

if (mysqli_num_rows($res) == 0)
{
    mysqli_query($GLOBALS['db'], "DELETE FROM `ips`");
    mysqli_query($GLOBALS['db'], "INSERT INTO `ips` SET `ip_address`='$visitor_ip'");
	
    $res_count = mysqli_query($GLOBALS['db'], "INSERT INTO `visits` SET `date`='$date',`day`='$day', `hosts`=1,`views`=1");
}
else
{
    $current_ip = mysql_query($GLOBALS['db'], "SELECT `ip_id` FROM `ips` WHERE `ip_address`='$visitor_ip'");

    if (mysqli_num_rows($current_ip) !== 0)
    {
        mysqli_query($GLOBALS['db'], "UPDATE `visits` SET `views`=`views`+1 WHERE `date`='$date'");
    }
    else
    {
        mysqli_query($GLOBALS['db'], "INSERT INTO `ips` SET `ip_address`='$visitor_ip'");
        mysqli_query($GLOBALS['db'], "UPDATE `visits` SET `hosts`=`hosts`+1,`views`=`views`+1 WHERE `date`='$date'");
    }
}
?>