<?php
class IndexController extends BasicController
{
    public function indexAction() 
    {
        $this->flag();
        
        if($this->getSession('uname')){
            $this->getView()->assign("content", "Hello <b>".$this->getSession('uname')."</b>, this is index,<a href='index.php/user'>to username!</a>");
        }else{
            $this->getView()->assign("content", "Hello, this is index,<a href='index.php/login'>to login!</a>");
        }
    }
    public function loginAction() 
    {
        echo 1;exit;
        $this->getView()->assign("content", "Hello World~");
    }
}