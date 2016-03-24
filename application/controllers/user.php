<?php
header("Content-type:text/html;char-set=utf-8");
class UserController extends BasicController
{
    public function init()
    {
        parent::init();
       // $this->test();
        $this->flag();
        $uid = $this->getSession("uid");
        if($uid)
        {
            $this->getView()->assign('title','首页');
            $this->getView()->assign('user',$this->getSession('uname'));
        }else{
            echo "请先登录";
            $this->gotourl($t=2,$url='login');
            exit;
        }
    }
    public function indexAction() 
    {
        $uname = $this->getSession("uname");
        $user = new userModel();
        $udata = $user->checksameuser($uname);
        //获取上次登录的时间以及ip
        $udata['lasttime'] = $this->getmem($udata['id'].'lasttime');
        $udata['lastip'] = $this->getmem($udata['id'].'lastip');
        //var_dump($udata);exit;
        $this->getView()->assign("userdata", $udata); 
    }
    
    public function logoutAction()
    {        
        $uid = $this->getSession("uid");
        $token_key = md5($uid.'token');
        $this->clearCookie($token_key);
        $this->clearCookie('uid');
        $this->unsetSession('uname');
        $this->unsetSession("uid");
        echo "已退出";
        $this->gotourl($t=1,$url='index.php');
        return false;
    }
    //修改密码
    public function updatapwdAction()
    {
        $this->getView()->assign('title','修改密码');
        if($_POST['pwd']){
            $pwd = filterStr($_POST['pwd']);
            
            $user = new UserModel();
            $uid = $this->getSession("uid");
            if(!$user->updatauserinfo($uid, md5($pwd)))
            {
                echo "密码修改失败";
                $this->gotourl($t=1,$url='user/updatapwd');
                return false;
            }
            //更新cookie中的token与memcache中的token
            $token_key = md5($uid.'token');
            $token_val = md5($uid.''.$pwd);
            $this->setcookie($token_key, $token_val, 3600*24*7);
            $this->replacemem($token_key, $token_val);
            echo "密码修改成功";
            $this->gotourl($t=1,$url='user/updatapwd');
            return false;
        }
    }
}