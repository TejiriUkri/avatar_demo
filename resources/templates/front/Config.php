<?php
ob_start();
session_start();


defined("DS") ? null : define("DS", DIRECTORY_SEPARATOR); 
defined("TEMPLATE_FRONT") ? null : define("TEMPLATE_FRONT", __DIR__ . DS . "templates/front"); 
defined("TEMPLATE_BACK") ? null : define("TEMPLATE_BACK", __DIR__ . DS . "templates/back");
defined("UPLOAD_DIRECTORY") ? null : define("UPLOAD_DIRECTORY", __DIR__ . DS . "upload");


$db['db_host'] = "localhost";
$db['db_user'] = "root";
$db['db_pass'] = "";
$db['db_name'] = "avatar";

foreach($db as $key => $value){
    
    define(strtoupper($key),$value);
}


$connection = mysqli_connect(DB_HOST,DB_USER,DB_PASS,DB_NAME); 


