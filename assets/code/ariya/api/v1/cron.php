<?php
//Act like a Browser to avoid 403 error
ini_set('user_agent','Mozilla/4.0 (compatible; MSIE 6.0)');
//set character set to UTF-8 to avoid annoying characters
header('Content-Type: text/html; charset=utf-8');

require_once '../include/DbHandler.php';
$db = new DbHandler();
$db->elapsedDatetime();
$db->sendTwentyFourHourReminders();


//$bid_date = strtotime('2015-07-02 16:28:22');
//$end_date = $bid_date + 172800;
//$now_date = time();
//if ($now_date>=$end_date) {
//    echo "future".($now_date-$end_date);
//} else {
//    echo "past";
//}
//echo "ZHELLO";
//echo "</br>";
//echo "Started: ".$bid_date;
//echo "</br>";
//echo "Should end: ".$end_date;
//echo "</br>";
//echo "Now: ".$now_date;
//echo "TEST";
//echo "</br>";
//echo "Started text: ".date("Y-m-d H:i:s", $bid_date);
//echo "</br>";
//echo "Should end text: ".date("Y-m-d H:i:s", $end_date);
//echo "</br>";
//echo "Now text: ".date("Y-m-d H:i:s", $now_date);

?>