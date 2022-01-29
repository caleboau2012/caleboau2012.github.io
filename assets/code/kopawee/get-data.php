<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/kopawee/root/databaseHandler.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/kopawee/root/config.php';
//header("Content-type: application/json");

if(isset($_GET['call_no']) && isset ($_GET['password'])){
    $call_no = $_GET['call_no'];
    $pass = $_GET['password'];
    $db = new databaseHandler(config::HOST, config::USERNAME, config::PASSWORD);
    $db->selectDatabase(config::DB_NAME);
    $db->query("SELECT * FROM otondo WHERE call_no = $call_no;");
    $result = $db->getResult();
    $db->closeDb();
    if($result != NULL){
        //print_r($result);
        if($result['password'] == $pass){
            $json = array("response"=>"1","data"=>$result);
            //$json = utf8_encode($json);
            echo json_encode($json);
        }
        else{
            $json = array("response"=>"-1", "error"=>"incorrect password");
            echo json_encode($json);
        }
    }
    else{
        $json = array("response"=>"-1", "error"=>"login failed");
        echo json_encode($json);
    }
}
else{
    $json = array("response"=>"-1", "error"=>"access denied");
    echo json_encode($json);
}
?>
