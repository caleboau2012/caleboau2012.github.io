<?php
$username = $_REQUEST['username'];
$password = $_REQUEST['password'];

if(($username == "caleb") && ($password == "password")){
	$data = array("response" => "1", "data" => array("name" => "Mbakwe Caleb", "title" => "Software Engineer", "likes" => "chiks", "is" => "!the boss"));
}
else{
	$data = array("response" => "0");
}

echo json_encode($data)
?>
