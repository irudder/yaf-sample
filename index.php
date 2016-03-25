<?php
header("Content-type:text/html;char-set=utf-8");
define("APP_PATH",  realpath(dirname(__FILE__))); 
$app  = new Yaf_Application(APP_PATH . "/conf/application.ini");
error_reporting(E_ALL ^E_NOTICE);
$app->bootstrap()->run();
