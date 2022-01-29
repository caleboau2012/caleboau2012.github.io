<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/kopawee/root/databaseHandler.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/kopawee/root/config.php';
//header("Content-type: application/json");

if(isset($_POST['message'])){
    $message = $_POST['message'];

    $db = new databaseHandler(config::HOST, config::USERNAME, config::PASSWORD);
    $db->selectDatabase(config::DB_NAME);

    $query = "INSERT into announcement (announce)
     VALUES ( '". mysql_real_escape_string($message) . "')";
    //echo $query;

    $db->query($query);
    //$result = $db->getResult();
    $db->closeDb();

    if ($db->getQueryStatus()){
        $json = array("response"=>"1");
        echo json_encode($json);
    }
    else{
        $json = array("response"=>"-1", "error"=>$db->getQueryStatus());
        echo json_encode($json);
    }
}
else{
    $json = array("response"=>"-1");
    echo json_encode($json);
}
?>
