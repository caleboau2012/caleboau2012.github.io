<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/kopawee/root/databaseHandler.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/kopawee/root/config.php';
//header("Content-type: application/json");

if(isset($_GET['call_no']) && isset ($_GET['password'])){
    $call_no = $_GET['call_no'];
    $code = $_GET['code'];
    $pass = $_GET['password'];
    $batch = $_GET['batch'];
    $state = $_GET['state'];
    $request = $_GET['request'];
    $request_state = $_GET['state_request'];

    $db = new databaseHandler(config::HOST, config::USERNAME, config::PASSWORD);
    $db->selectDatabase(config::DB_NAME);

    $query = "INSERT into otondo (call_no, code, password, batch, state, request, request_state)
     VALUES ( $call_no, $code, '". mysql_real_escape_string($pass) . "', $batch, '"
        . mysql_real_escape_string($state) . "', $request, '". mysql_real_escape_string($request_state) . "')";

    $db->query($query);
    //$result = $db->getResult();
    $db->closeDb();

    if ($db->getQueryStatus()){
        $json = array("response"=>"1", "data"=> "The user has been registered");
        echo json_encode($json);
    }
        else{
        $json = array("response"=>"-1", "error"=>$db->getQueryStatus());
        echo json_encode($json);
    }
}
else{
    $json = array("response"=>"-1", "error"=>"access denied");
    echo json_encode($json);
}
?>
