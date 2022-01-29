<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/kopawee/root/databaseHandler.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/kopawee/root/config.php';
//header("Content-type: application/json");

$db = new databaseHandler(config::HOST, config::USERNAME, config::PASSWORD);
$db->selectDatabase(config::DB_NAME);
$query = "SELECT announce FROM announcement ORDER BY ID DESC LIMIT 1;";

$db->query($query);
$result = $db->getResult();
$db->closeDb();

//echo $query;
//var_dump($db->getQueryStatus());

if($result != NULL){
    //print_r($result);
    $json = array("response"=>"1","data"=>$result['announce']);
    //$json = utf8_encode($json);
    echo json_encode($json);
}
else{
    $json = array("response"=>"-1");
    echo json_encode($json);
}

?>
