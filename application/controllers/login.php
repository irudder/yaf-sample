<?php
class LoginController extends BasicController 
{
    public function init()
    {
        parent::init();
        $this->flag();
        return false;
    }
    
    public function indexAction() 
    {//默认Action
        $uid = getSession('uid');
        $token_key = md5($uid.'token');
        $token_c = getCookie($token_key);
        $token_m = getmem($token_key);
        if(getSession('uname') && $token_c===$token_m)
        {
            echo "已登录~";;
            gotourl($t=0,$url='user');
            return false;
        }        
        $this->getView();
   }
   public function checkloginAction()
   {
        $data['uname'] = filterStr($_POST['uname']);
        $data['pwd'] = filterStr($_POST['password']);
        //var_dump($data);
        $login = new logic\userLogicController;
        $login = $login->login($data);
        echo $login;
        exit;
   }
}