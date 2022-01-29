<?php
$host = "http://localhost/ariya/";

function getUrlContent($url){
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; .NET CLR 1.1.4322)');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
    curl_setopt($ch, CURLOPT_TIMEOUT, 5);
    $data = curl_exec($ch);
    $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);
    return ($httpcode>=200 && $httpcode<300) ? $data : false;
}

$data = getUrlContent($host . "api/v1/listing");

$listing = json_decode($data, true);

//echo($data);

foreach($listing['properties'] as $property){
//    echo($property);
//    http://localhost/ariya/listing/1/A-property

    $name = str_replace(" ", "-", $property['name']);

    echo("<a href='" . $host . "listing/" . $property['property_id'] . "/" . $name . "'>" . $property['name'] ."</a>");
}