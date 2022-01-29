<?php header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST'); 

$array = ["bomb", "get your money mhen"];

echo (json_encode($array));