<?php
	require_once 'databaseHandler.php';
	require_once 'config.php';
	
	if (!isset($_GET['eng_w']))
		die();
	
	$db = new databaseHandler(config::HOST, config::USERNAME, config::PASSWORD);
	
	$eng_w = mysql_real_escape_string($_GET['eng_w'], $db->getCon());
	$eng_m = mysql_real_escape_string($_GET['eng_m'], $db->getCon());
	$yor_w = mysql_real_escape_string($_GET['yor_w'], $db->getCon());
	$yor_m = mysql_real_escape_string($_GET['yor_m'], $db->getCon());
	$igbo_w = mysql_real_escape_string($_GET['igbo_w'], $db->getCon());
	$igbo_m = mysql_real_escape_string($_GET['igbo_m'], $db->getCon());
	$h_w = mysql_real_escape_string($_GET['h_w'], $db->getCon());
	$h_m = mysql_real_escape_string($_GET['h_m'], $db->getCon());
	
    $db->selectDatabase(config::DB_NAME);
	$query = "INSERT into submissions (english_word, english_meaning, yoruba_word, yoruba_meaning, igbo_word, igbo_meaning, hausa_word, hausa_meaning) VALUES ('$eng_w', '$eng_m', '$yor_w', '$yor_m', '$igbo_w', '$igbo_m', '$h_w', '$h_m')";
    $db->query($query);
    echo "yes";
    $db->closeDb();
	
?>