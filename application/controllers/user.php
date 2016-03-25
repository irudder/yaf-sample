<?php
header("Content-type:text/html;char-set=utf-8");
class UserController extends BasicController
{
    public function init()
    {
        parent::init();
        $logic = new logic\LogicController;
       // $this->test();
        $this->flag();
        $uid = getSession("uid");
        if($uid)
        {
            $this->getView()->assign('title','首页');
            $this->getView()->assign('user',getSession('uname'));
        }else{
            echo "请先登录";
            gotourl($t=2,$url='login');
            exit;
        }
    }
    public function indexAction() 
    {
        $uname = getSession("uname");
        $user = new userModel();
        $udata = $user->checksameuser($uname);
        //获取上次登录的时间以及ip
        $udata['lasttime'] = getmem($udata['id'].'lasttime');
        $udata['lastip'] = getmem($udata['id'].'lastip');
        //var_dump($udata);exit;
        $this->getView()->assign("userdata", $udata); 
    }
    
    public function logoutAction()
    {        
        $uid = getSession("uid");
        $token_key = md5($uid.'token');
        clearCookie($token_key);
        clearCookie('uid');
        unsetSession('uname');
        unsetSession("uid");
        echo "已退出";
        gotourl($t=1,$url='index.php');
        return false;
    }
    //修改密码
    public function updatapwdAction()
    {
        $this->getView()->assign('title','修改密码');
        if($_POST['pwd']){
            $uppwd = new logic\LogicController;
            $res = $uppwd->updatapwd(filterStr($_POST['pwd']),getSession("uid"));
            $res = '['.$res.']';
            $res = json_decode($res);
            echo $res[0]->msg;
            gotourl($t=1,$url='user/updatapwd');
            exit;
            /*
            $pwd = filterStr($_POST['pwd']);
            
            $user = new UserModel();
            $uid = getSession("uid");
            if(!$user->updatauserinfo($uid, md5($pwd)))
            {
                echo "密码修改失败";
                gotourl($t=1,$url='user/updatapwd');
                return false;
            }
            //更新cookie中的token与memcache中的token
            $token_key = md5($uid.'token');
            $token_val = md5($uid.''.$pwd);
            putCookie($token_key, $token_val, 3600*24*7);
            replacemem($token_key, $token_val);
            echo "密码修改成功";
            gotourl($t=1,$url='user/updatapwd');
            return false;
            */
        }
    }
}