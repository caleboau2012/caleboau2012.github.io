<?php
/**
 * Created by PhpStorm.
 * User: Mbakwe.Caleb
 * Date: 13-Nov-15
 * Time: 4:16 PM
 */

$file = file_get_contents('file.txt');
//var_dump($file);
//die();

$nos = preg_split("/[\s,]+/", $file);

for($i = 0; $i < sizeof($nos); $i++){
    $nos[$i] = $nos[$i] . ",";
    echo $nos[$i];
}

//var_dump($nos);

