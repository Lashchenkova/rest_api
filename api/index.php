<?php

function __autoload($class_name)
{
    $filename = "lib/{$class_name}.php";
    if(file_exists($filename)){
        require_once($filename);
    } else {
        throw new Exception('Failed to load' . $class_name);
    }
}

header('Content-type: text/json');

Database::getInstance();//connection to database

$api = new API($_SERVER['REQUEST_METHOD'], $_SERVER['REQUEST_URI']);
$api->rest();
