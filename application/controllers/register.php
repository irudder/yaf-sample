<?php
class RegisterController extends BasicController 
{
    public function init()
    {
        parent::init();
    }
    public function indexAction() 
    {
        
    }
    public function doregAction() 
    {
        $data['uname'] = filterStr($_POST['username']);
        $data['pwd'] = filterStr($_POST['password']);
        $data['realname'] = filterStr($_POST['realname']);
        $data['idcard'] = filterStr($_POST['idcard']);
        $reg = new logic\userLogicController;
        $res = $reg->reg($data);
        echo $res;
        exit;
        
    }
}