<?php
class ErrorController extends Yaf_Controller_Abstract 
{
    public function errorAction($exception)
    {
        if($exception->getCode()) {
            echo 404, ":", $exception->getMessage();
            exit;
        }
    }
}