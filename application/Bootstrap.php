<?php

class Bootstrap extends Yaf_Bootstrap_Abstract{
    public function _init()
    {
        yaf_Loader::import(APP_PATH.'/application/functions/function.php');//公用函数
        //Yaf_Loader::import(APP_PATH.'/application/logic/logic.php');//逻辑层
    }
    public function _initConfig()
    {
        //$config = Yaf_Application::app()->getConfig();
        //hc($router);
    }
}
