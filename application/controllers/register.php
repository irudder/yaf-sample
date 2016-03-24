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
        //验证
        if($_POST['username']=='' || $_POST['password']=='' || $_POST['realname']==''|| $_POST['idcard']=='' ){
            $arr['code'] = -400;
            $arr['msg']  = "非法操作，请正确填写。";
        }else{
            $m['uname'] = filterStr($_POST['username']);
            $user = new UserModel();
            $udata = $user->checksameuser($m['uname']);
            if($udata){
                $arr['code'] = -2;
                $arr['msg']  = "该用户已注册，请直接登录";
                echo json_encode($arr);
                exit;
            }
            
            $m['pwd'] = md5(filterStr($_POST['password']));
            $m['realname'] = filterStr($_POST['realname']);
            $m['idcard'] = filterStr($_POST['idcard']);
            $m['regtime'] = time();
            $m['regip'] = $_SERVER["REMOTE_ADDR"];
            $m['lasttime'] = $m['regtime'];
            $m['lastip'] = $m['regip'];
            
            if($user->insertuserinfo($m)){
                $arr['code'] = 1;
                $arr['msg']  = "注册成功";
                
                $udata = $user->checkuserinfo($m['uname'],$m['pwd']);
                //var_dump($udata);exit;
                /**注册免登陆**/
                $this->setSession('uname',$udata['uname']);
                $this->setSession('uid',$udata['id']);
                $this->setcookie("uid", $udata['id'], 3600*24*7);
                //加密的token用作比较是否修改密码
                $token_key = md5($udata['id'].'token');
                $token_val = md5($udata['id'].''.$udata['pwd']);
                $this->setcookie($token_key, $token_val, 3600*24*7);
                $this->setmem($token_key, $token_val);
                //记录登录ip以及时间
                $this->setmem($udata['id'].'lasttime',$udata['lasttime']);
                $this->setmem($udata['id'].'lastip',$udata['lastip']);
                
            }else{
                $arr['code'] = -1;
                $arr['msg']  = "注册失败，请稍候再试";
            }            
        }
        echo json_encode($arr);
        exit;
    }
}